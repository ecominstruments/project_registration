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
        'Project' => 'list, show, new, create, update, delete, confirmation, accept, reject, gainedProject, addInternalNote, addDenialNote, extendExpiry, exportCSV, resendRequestMail',
        'Person' => 'show'
    ],
    // non-cacheable actions
    [
        'Project' => 'create, update, delete, confirmation, accept, reject, gainedProject, exportCSV, resendRequestMail',
        'Person' => ''
    ]
);

$TYPO3_CONF_VARS['SC_OPTIONS']['scheduler']['tasks']['S3b0\ProjectRegistration\Scheduler\InfoMail\Task'] = [
    'extension' => 'project_registration',
    'title' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang.xlf:task.infoMail.name',
    'description' => 'LLL:EXT:project_registration/Resources/Private/Language/locallang.xlf:task.infoMail.description',
    'additionalFields' => 'S3b0\ProjectRegistration\Scheduler\InfoMail\AdditionalFieldProvider'
];