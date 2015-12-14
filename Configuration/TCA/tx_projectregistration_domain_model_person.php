<?php
return [
    'ctrl'      => [
        'title'         => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_person',
        'label'         => 'name',
        'hideTable'     => true,
        'readOnly'      => true,
        'rootLevel'     => 1,
        'dividers2tabs' => true,
        'searchFields'  => 'username,name,first_name,last_name,middle_name,address,phone,fax,email,title,zip,city,country,company',
        'iconfile'      => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('project_registration') . 'Resources/Public/Icons/tx_projectregistration_domain_model_person.gif'
    ],
    'interface' => ['showRecordFieldList' => 'username,name,first_name,middle_name,last_name,title,company,address,zip,city,country,email,www,phone,fax'],
    'types'     => [
        '1' => ['showitem' => 'username, fe_user, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:fe_users.tabs.personelData, company, --palette--;;1, name, --palette--;;2, address, zip, city, country, state, phone, fax, email, www']
    ],
    'palettes'  => [
        '1' => ['showitem' => 'title'],
        '2' => ['showitem' => 'first_name, --linebreak--, middle_name, --linebreak--, last_name']
    ],
    'columns'   => [
        'username'    => [
            'label'  => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:fe_users.username',
            'config' => [
                'type'         => 'input',
                'size'         => '20',
                'max'          => '255',
                'eval'         => 'nospace,trim,lower,uniqueInPid',
                'autocomplete' => false
            ]
        ],
        'name'        => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ]
        ],
        'first_name'  => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.first_name',
            'config' => [
                'type' => 'input',
                'size' => '25',
                'eval' => 'trim',
                'max'  => '50'
            ]
        ],
        'middle_name' => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.middle_name',
            'config' => [
                'type' => 'input',
                'size' => '25',
                'eval' => 'trim',
                'max'  => '50'
            ]
        ],
        'last_name'   => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.last_name',
            'config' => [
                'type' => 'input',
                'size' => '25',
                'eval' => 'trim',
                'max'  => '50'
            ]
        ],
        'address'     => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.address',
            'config' => [
                'type' => 'text',
                'cols' => '20',
                'rows' => '3'
            ]
        ],
        'phone'       => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.phone',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ]
        ],
        'fax'         => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.fax',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max'  => '20'
            ]
        ],
        'email'       => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ]
        ],
        'title'       => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.title_person',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max'  => '40'
            ]
        ],
        'zip'         => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.zip',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => '10',
                'max'  => '10'
            ]
        ],
        'city'        => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ]
        ],
        'site'        => [
            'label'  => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_person.site',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ]
        ],
        'country'     => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.country',
            'config' => [
                'type'                => 'select',
                'foreign_table'       => 'tx_ecomtoolbox_domain_model_region',
                'foreign_table_where' => 'AND type=0 ORDER BY title ASC',
                'items'               => [
                    ['', '0']
                ],
                'minitems'            => 1
            ]
        ],
        'state'       => [
            'displayCond' => 'FIELD:country:REQ:TRUE',
            'label'       => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_person.state',
            'config'      => [
                'type'                => 'select',
                'foreign_table'       => 'tx_ecomtoolbox_domain_model_state',
                'foreign_table_where' => 'AND country=###REC_FIELD_country### ORDER BY title ASC',
                'items'               => [
                    ['', '0']
                ]
            ]
        ],
        'www'         => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.www',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => '20',
                'max'  => '80'
            ]
        ],
        'company'     => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.company',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ]
        ],
        'fe_user'     => [
            'label'  => 'FE-User',
            'config' => [
                'type'                => 'select',
                'foreign_table'       => 'fe_users',
                'foreign_table_where' => 'ORDER BY username ASC',
                'items'               => [
                    ['', '0']
                ]
            ]
        ]
    ]
];