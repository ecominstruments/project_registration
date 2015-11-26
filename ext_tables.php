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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Project Registration');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_projectregistration_domain_model_project', 'EXT:project_registration/Resources/Private/Language/locallang_csh_tx_projectregistration_domain_model_project.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_projectregistration_domain_model_project');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_projectregistration_domain_model_product', 'EXT:project_registration/Resources/Private/Language/locallang_csh_tx_projectregistration_domain_model_product.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_projectregistration_domain_model_product');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_projectregistration_domain_model_productproperty', 'EXT:project_registration/Resources/Private/Language/locallang_csh_tx_projectregistration_domain_model_productproperty.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_projectregistration_domain_model_productproperty');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_projectregistration_domain_model_productpropertyvalue', 'EXT:project_registration/Resources/Private/Language/locallang_csh_tx_projectregistration_domain_model_productpropertyvalue.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_projectregistration_domain_model_productpropertyvalue');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_projectregistration_domain_model_person', 'EXT:project_registration/Resources/Private/Language/locallang_csh_tx_projectregistration_domain_model_person.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_projectregistration_domain_model_person');
