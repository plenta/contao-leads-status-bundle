<?php

namespace Plenta\LeadsStatusBundle\EventListener\DataContainer;

use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsCallback(table: 'tl_lead', target: 'config.onload')]
class LeadStatusOnLoadListener
{
    public function __construct(
        private readonly Connection $connection,
        private readonly RequestStack $requestStack)
    {
    }

    public function __invoke(DataContainer $dc = null): void
    {
        if (null === $dc || !$dc->id || 'edit' !== $this->requestStack->getCurrentRequest()->query->get('act')) {
            $leads = $this->connection
                ->createQueryBuilder()
                ->select('id')
                ->from('tl_lead')
                ->where('status=:status')
                ->setParameter('status', "")
                ->fetchAllAssociative()
            ;

            $statusId = $this->getDefaultStatus();

            if (!empty($leads) && null !== $statusId) {
                foreach ($leads as $lead) {
                    $this->connection->update('tl_lead',
                            ['status' => $statusId],
                            ['id' => $lead['id']]
                        );
                }
            }
        }

        return;
    }

    public function getDefaultStatus(): ?int
    {
        $status = $this->connection
            ->createQueryBuilder()
            ->select('id')
            ->from('tl_lead_status')
            ->where('defaultValue=:defaultValue')
            ->setParameter('defaultValue', 1)
            ->fetchAssociative()
        ;

        if (false !== $status) {
            return $status['id'];
        }

        return null;
    }
}