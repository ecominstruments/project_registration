<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'S3b0.ProjectRegistration',
    'Registration',
    ['Project' => 'new, create, submitted'],
    // non-cacheable actions
    ['Project' => 'create, submitted']
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'S3b0.ProjectRegistration',
    'Administration',
    [
        'Project' => 'list, show, new, create, delete, confirmation, accept, reject, addInternalNote, addDenialNote, exportCSV',
        'Person' => 'show'
    ],
    // non-cacheable actions
    [
        'Project' => 'create, delete, confirmation, accept, reject, exportCSV',
        'Person' => ''
    ]
);

$TYPO3_CONF_VARS['SC_OPTIONS']['scheduler']['tasks']['S3b0\ProjectRegistration\Scheduler\Task'] = array(
    'extension' => 'project_registration',
    'title' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang.xlf:task.name',
    'description' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang.xlf:task.description',
    'additionalFields' => 'S3b0\ProjectRegistration\Scheduler\AdditionalFieldProvider'
);