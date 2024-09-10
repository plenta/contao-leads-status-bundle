<?php

namespace Plenta\LeadsStatusBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use ErdmannFreunde\ContactBundle\Contao\Model\ContactCategoryModel;
use ErdmannFreunde\ContactBundle\Contao\Model\ContactModel;

#[AsCallback(table: 'tl_lead', target: 'fields.status.options')]
class LeadStatusOptionsListener
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function __invoke(DataContainer $dc): array
    {
        $state = $this->connection
            ->createQueryBuilder()
            ->select('id', 'name')
            ->from('tl_lead_status')
            ->fetchAllAssociative()
        ;

        if (is_array($state)) {
            $arrOptions = [];
            foreach ($state as $status) {
                $arrOptions[$status['id']] = $status['name'];
            }

            return $arrOptions;
        }

        return [];
    }
}
