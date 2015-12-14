<?php
return [
    'ctrl'      => [
        'title'         => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_product',
        'label'         => 'title',
        'tstamp'        => 'tstamp',
        'crdate'        => 'crdate',
        'cruser_id'     => 'cruser_id',
        'dividers2tabs' => true,
        'sortby'        => 'sorting',
        'enablecolumns' => [],
        'searchFields'  => 'title,properties',
        'iconfile'      => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('project_registration') . 'Resources/Public/Icons/tx_projectregistration_domain_model_product.gif'
    ],
    'interface' => ['showRecordFieldList' => 'title, properties'],
    'types'     => ['1' => ['showitem' => 'title, properties']],
    'palettes'  => ['1' => ['showitem' => '']],
    'columns'   => [
        'title'      => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_product.title',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required,uniqueInPid'
            ]
        ],
        'properties' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_product.properties',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectCheckBox',
                'foreign_table' => 'tx_projectregistration_domain_model_productproperty',
                'MM'            => 'tx_projectregistration_product_property_mm',
                'size'          => 10,
                'autoSizeMax'   => 30,
                'maxitems'      => 9999,
                'multiple'      => 0
            ]
        ]
    ]
];