<?php

use Contao\DC_Table;
use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;


$GLOBALS['TL_DCA']['tl_lead']['config']['notEditable'] = false;

$GLOBALS['TL_DCA']['tl_lead']['list']['label']['fields'][] = 'status';

$GLOBALS['TL_DCA']['tl_lead']['list']['global_operations']['lead_status'] = [
    'href' => 'table=tl_lead_status',
    'class' => 'header_css_import',
];

$GLOBALS['TL_DCA']['tl_lead']['list']['operations']['edit'] = [
    'href' => 'act=edit',
    'icon' => 'edit.svg',
];

$GLOBALS['TL_DCA']['tl_lead']['palettes']['default'] = '{status_legend},status';

$GLOBALS['TL_DCA']['tl_lead']['fields']['status'] = [
    'inputType' => 'select',
    'filter' => true,
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50', 'includeBlankOption' => true],
    'sql' => "varchar(255) NOT NULL default ''"
];
