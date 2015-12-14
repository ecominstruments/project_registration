<?php
return [
    'ctrl'      => [
        'title'         => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project',
        'label'         => 'title',
        'tstamp'        => 'tstamp',
        'crdate'        => 'crdate',
        'cruser_id'     => 'cruser_id',
        'dividers2tabs' => true,
        'delete'        => 'deleted',
        'enablecolumns' => ['disabled' => 'hidden'],
        'searchFields'  => 'title,date_of_request,application,quantity,estimated_purchase_date,registration_notes,internal_note,denial_note,approved,registrant,end_user,product',
        'iconfile'      => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('project_registration') . 'Resources/Public/Icons/tx_projectregistration_domain_model_project.gif'
    ],
    'interface' => ['showRecordFieldList' => 'hidden, title, date_of_request, application, quantity, estimated_purchase_date, registration_notes, internal_note, denial_note, approved, registrant, end_user, product, property_values'],
    'types'     => ['1' => ['showitem' => 'hidden;;1, title, date_of_request, application, quantity, estimated_purchase_date, registration_notes, internal_note, denial_note, approved, registrant, end_user, product, property_values']],
    'palettes'  => ['1' => ['showitem' => '']],
    'columns'   => [
        'hidden'                  => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config'  => ['type' => 'check']
        ],
        'title'                   => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.title',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ]
        ],
        'date_of_request'         => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.date_of_request',
            'config'  => [
                'dbType'   => 'datetime',
                'type'     => 'input',
                'size'     => 12,
                'eval'     => 'datetime,required',
                'checkbox' => 0,
                'default'  => '0000-00-00 00:00:00'
            ]
        ],
        'application'             => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.application',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ]
        ],
        'quantity'                => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.quantity',
            'config'  => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int,required'
            ]
        ],
        'estimated_purchase_date' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.estimated_purchase_date',
            'config'  => [
                'dbType'   => 'date',
                'type'     => 'input',
                'size'     => 7,
                'eval'     => 'date,required',
                'checkbox' => 0,
                'default'  => '0000-00-00'
            ]
        ],
        'registration_notes'      => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.registration_notes',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'internal_note'           => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.internal_note',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'denial_note'             => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.denial_note',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'approved'                => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.approved',
            'config'  => [
                'type'    => 'check',
                'default' => 0
            ]
        ],
        'registrant'              => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.registrant',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_projectregistration_domain_model_person',
                'minitems'      => 0,
                'maxitems'      => 1
            ]
        ],
        'end_user'                => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.end_user',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_projectregistration_domain_model_person',
                'minitems'      => 0,
                'maxitems'      => 1
            ]
        ],
        'product'                 => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.product',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_projectregistration_domain_model_product',
                'items'         => [
                    ['', '0']
                ],
                'minitems'      => 1
            ]
        ],
        'property_values'          => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_productproperty.property_values',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_projectregistration_domain_model_productpropertyvalue',
                'size'          => 10,
                'autoSizeMax'   => 30,
                'maxitems'      => 9999,
                'multiple'      => 0
            ]
        ]
    ]
];