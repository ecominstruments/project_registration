<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project',
		'label' => 'date_of_request',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => array(

		),
		'searchFields' => 'date_of_request,application,quantity,estimated_purchase_date,registration_notes,internal_note,denial_note,approved,registrant,end_user,products,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('project_registration') . 'Resources/Public/Icons/tx_projectregistration_domain_model_project.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'date_of_request, application, quantity, estimated_purchase_date, registration_notes, internal_note, denial_note, approved, registrant, end_user, products',
	),
	'types' => array(
		'1' => array('showitem' => 'date_of_request, application, quantity, estimated_purchase_date, registration_notes, internal_note, denial_note, approved, registrant, end_user, products, '),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'date_of_request' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.date_of_request',
			'config' => array(
				'dbType' => 'datetime',
				'type' => 'input',
				'size' => 12,
				'eval' => 'datetime,required',
				'checkbox' => 0,
				'default' => '0000-00-00 00:00:00'
			),
		),
		'application' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.application',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'quantity' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.quantity',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			)
		),
		'estimated_purchase_date' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.estimated_purchase_date',
			'config' => array(
				'dbType' => 'date',
				'type' => 'input',
				'size' => 7,
				'eval' => 'date,required',
				'checkbox' => 0,
				'default' => '0000-00-00'
			),
		),
		'registration_notes' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.registration_notes',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'internal_note' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.internal_note',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'denial_note' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.denial_note',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'approved' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.approved',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'registrant' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.registrant',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_projectregistration_domain_model_person',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'end_user' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.end_user',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_projectregistration_domain_model_person',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'products' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang_db.xlf:tx_projectregistration_domain_model_project.products',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_projectregistration_domain_model_product',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		
	),
);