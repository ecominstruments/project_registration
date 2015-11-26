<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'S3b0.' . $_EXTKEY,
	'Registration',
	array(
		'Project' => 'new, create, confirmation',
		
	),
	// non-cacheable actions
	array(
		'Project' => 'create',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'S3b0.' . $_EXTKEY,
	'Administration',
	array(
		'Project' => 'list, show, new, create, edit, update, delete, confirmation, approve, addInternalNote, addDenialNote',
		'Person' => 'show',
		
	),
	// non-cacheable actions
	array(
		'Project' => 'create, update, delete, ',
		'Person' => '',
		
	)
);
