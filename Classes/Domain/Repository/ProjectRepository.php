<?php
namespace S3b0\ProjectRegistration\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015-2016 Sebastian Iffland <Sebastian.Iffland@ecom-ex.com>, ecom instruments GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The repository for Projects
 */
class ProjectRepository extends \S3b0\ProjectRegistration\Domain\Repository\AbstractRepository
{

    /**
     * @var array
     */
    protected $defaultOrderings = [
        'date_of_expiry' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    ];

    /**
     * Set repository wide settings
     */
    public function initializeObject()
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface $querySettings */
        $querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface::class);
        $querySettings->setRespectStoragePage(false); // Disable storage pid
        $querySettings->setIgnoreEnableFields(true);
        $querySettings->setEnableFieldsToBeIgnored(['disabled']); // Disable hidden field
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * Returns all objects of this repository.
     *
     * @param bool $expired
     * @param bool $won
     * @param bool $lost
     * @param bool $deleted
     *
     * @return array
     */
    public function findAll($expired = false, $won = false, $lost = false, $deleted = false)
    {
        $query = $this->createQuery();

        $query->setQuerySettings($query->getQuerySettings()->setIncludeDeleted($deleted));

        $records = $query->execute()->toArray();
        self::excludeByProperties($records, [
            'expired' => $expired,
            'won'     => $won,
            'lost'    => $lost
        ]);

        return $records;
    }

    /**
     * Remove records off the array, by various properties.
     * Property getters MUST provide booleans as return values!
     *
     * @param array $records
     * @param array $properties
     */
    private static function excludeByProperties(array &$records, array $properties = [])
    {
        if (sizeof($properties)) {
            /** @var \S3b0\ProjectRegistration\Domain\Model\Project $record */
            foreach ($records as $k => $record) {
                $unset = false;
                foreach ($properties as $property => $check) {
                    $caller = 'is' . GeneralUtility::underscoredToUpperCamelCase($property);
                    if (method_exists($record, $caller) === false) {
                        $caller = 'get' . GeneralUtility::underscoredToUpperCamelCase($property);
                    }
                    if ($check === false && method_exists($record, $caller)) {
                        if (call_user_func([$record, $caller])) {
                            $unset = $unset || call_user_func([$record, $caller]);
                        }
                    }
                }
                if ($unset) {
                    unset($records[$k]);
                }
            }
        }
    }

    /**
     * Finds an object matching the given identifier.
     *
     * @param int $uid
     *
     * @return \S3b0\ProjectRegistration\Domain\Model\Project
     */
    public function findByUid($uid)
    {
        $query = $this->createQuery();
        $query->setQuerySettings($query->getQuerySettings()->setIncludeDeleted(true));

        return $query->matching(
            $query->equals('uid', $uid)
        )->execute()->getFirst();
    }

    /**
     * @return array
     */
    public function findDeletable()
    {
        $query = $this->createQuery();

        $projects = [];
        if ($all = $query->execute()) {
            /** @var \S3b0\ProjectRegistration\Domain\Model\Project $project */
            foreach ($all as $project) {
                if ($project->isExpired() || $project->isRejected()) {
                    $projects[] = $project;
                }
            }
        }

        return $projects;
    }

}
