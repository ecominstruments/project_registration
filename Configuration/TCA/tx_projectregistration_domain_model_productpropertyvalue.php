<?php
return [
    'ctrl'      => [
        'title'           => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_productpropertyvalue',
        'label'           => 'title',
        'label_alt'       => 'property',
        'label_alt_force' => true,
        'tstamp'          => 'tstamp',
        'crdate'          => 'crdate',
        'cruser_id'       => 'cruser_id',
        'dividers2tabs'   => true,
        'enablecolumns'   => [],
        'searchFields'    => 'title,property',
        'iconfile'        => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('project_registration') . 'Resources/Public/Icons/tx_projectregistration_domain_model_productpropertyvalue.gif'
    ],
    'interface' => ['showRecordFieldList' => 'title, property'],
    'types'     => ['1' => ['showitem' => 'title, property']],
    'palettes'  => ['1' => ['showitem' => '']],
    'columns'   => [
        'title'    => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_productpropertyvalue.title',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ]
        ],
        'property' => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_productproperty',
            'config'  => [
                'type'          => 'select',
                'readOnly'      => 1,
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_projectregistration_domain_model_productproperty',
                'items'         => [['', '0']],
                'minitems'      => 1
            ]
        ]
    ]
];