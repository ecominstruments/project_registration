<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'S3b0.' . $_EXTKEY,
    'Registration',
    ['Project' => 'new, create, submitted'],
    // non-cacheable actions
    ['Project' => 'create, submitted']
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'S3b0.' . $_EXTKEY,
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
