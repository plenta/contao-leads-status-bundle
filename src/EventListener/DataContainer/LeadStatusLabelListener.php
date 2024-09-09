<?php

namespace Plenta\LeadsStatusBundle\EventListener\DataContainer;

use Doctrine\DBAL\Connection;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Terminal42\LeadsBundle\EventListener\DataContainer\LeadLabelListener;

#[AsCallback('tl_lead', 'list.label.label', priority: 1)]
class LeadStatusLabelListener
{
    public function __construct(
        private readonly Connection $connection,
        private readonly LeadLabelListener $leadLabelListener)
    {
    }

    public function __invoke(array $row, string $label): string
    {
        $status = $this->connection
            ->createQueryBuilder()
            ->select('status')
            ->from('tl_lead')
            ->where('id=:id')
            ->setParameter('id', $row['id'])
            ->fetchAssociative()
        ;

        $result = $this->leadLabelListener->__invoke($row, $label);

        return '['.$status['status'].'] '.$result;
    }
}