<?php
return [
    'ctrl'      => [
        'title'         => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_productproperty',
        'label'         => 'title',
        'tstamp'        => 'tstamp',
        'crdate'        => 'crdate',
        'cruser_id'     => 'cruser_id',
        'dividers2tabs' => true,
        'sortby'        => 'sorting',
        'enablecolumns' => [],
        'searchFields'  => 'title,form_element_type,property_values',
        'iconfile'      => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('project_registration') . 'Resources/Public/Icons/tx_projectregistration_domain_model_productproperty.gif'
    ],
    'interface' => ['showRecordFieldList' => 'title, form_element_type, property_values'],
    'types'     => ['1' => ['showitem' => 'title, form_element_type, property_values']],
    'palettes'  => ['1' => ['showitem' => '']],
    'columns'   => [
        'title'             => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_productproperty.title',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ]
        ],
        'form_element_type' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_productproperty.form_element_type',
            'config'  => [
                'type'  => 'radio',
                'items' => [
                    ['radio', 0],
                    ['select', 1]
                ]
            ]
        ],
        'property_values'   => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_productproperty.property_values',
            'config'  => [
                'type'           => 'inline',
                'foreign_table'  => 'tx_projectregistration_domain_model_productpropertyvalue',
                'foreign_field'  => 'property',
                'foreign_sortby' => 'sorting',
                'maxitems'       => 9999,
                'appearance'     => [
                    'collapseAll'                     => 1,
                    'expandSingle'                    => 1,
                    'levelLinksPosition'              => 'bottom',
                    'showAllLocalizationLink'         => 0,
                    'showPossibleLocalizationRecords' => 0,
                    'showSynchronizationLink'         => 0,
                    'useSortable'                     => 1
                ],
                'behaviour'      => [
                    'enableCascadingDelete' => 1
                ]
            ]
        ]
    ]
];