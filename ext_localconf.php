<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'S3b0.' . $_EXTKEY,
    'Registration',
    ['Project' => 'new, create, confirmation'],
    // non-cacheable actions
    ['Project' => 'create']
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'S3b0.' . $_EXTKEY,
    'Administration',
    [
        'Project' => 'list, show, new, create, edit, update, delete, confirmation, accept, reject, addInternalNote, addDenialNote',
        'Person' => 'show'
    ],
    // non-cacheable actions
    [
        'Project' => 'create, update, delete, confirmation, accept, reject',
        'Person' => ''
    ]
);
