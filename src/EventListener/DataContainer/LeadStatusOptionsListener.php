<?php

/**
 * Plenta Jobs Basic Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2024-2025, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://github.com/plenta/
 */

namespace Plenta\LeadsStatusBundle\EventListener\DataContainer;

use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;

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
