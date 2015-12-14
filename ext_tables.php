<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'S3b0.' . $_EXTKEY,
    'Registration',
    'Project Registration'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'S3b0.' . $_EXTKEY,
    'Administration',
    'Project Registration - Administration'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Private/TypoScript/Main', 'Project Registration');

/** Allow tables on standard pages */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_projectregistration_domain_model_product');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_projectregistration_domain_model_productproperty');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_projectregistration_domain_model_productpropertyvalue');