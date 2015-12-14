<?php
    $extensionClassesPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath( 'project_registration' ) . 'Classes/';

    return [
        'S3b0\ProjectRegistration\Domain\Model\Dto\ProjectPersonsDto' => $extensionClassesPath . 'Domain/Model/Dto/ProjectPersonsDto.php'
    ];