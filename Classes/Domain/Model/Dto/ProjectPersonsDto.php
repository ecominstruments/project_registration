<?php
namespace S3b0\ProjectRegistration\Domain\Model\Dto;

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

/**
 * Class ProjectPersonsDto
 * @package S3b0\ProjectRegistration\Domain\Dto
 */
class ProjectPersonsDto
{

    /**
     * @var \S3b0\ProjectRegistration\Domain\Model\Project
     */
    protected $project;

    /**
     * @var \S3b0\ProjectRegistration\Domain\Model\Person
     */
    protected $registrant;

    /**
     * @var \S3b0\ProjectRegistration\Domain\Model\Person
     */
    protected $endUser;

    /**
     * @var array
     */
    protected $propertyValues;

    /**
     * ProjectPersonsDto constructor.
     *
     * @param \S3b0\ProjectRegistration\Domain\Model\Project $project
     * @param \S3b0\ProjectRegistration\Domain\Model\Person  $registrant
     * @param \S3b0\ProjectRegistration\Domain\Model\Person  $endUser
     */
    public function __construct(
        \S3b0\ProjectRegistration\Domain\Model\Project $project,
        \S3b0\ProjectRegistration\Domain\Model\Person $registrant,
        \S3b0\ProjectRegistration\Domain\Model\Person $endUser
    ) {
        $this->project = $project;
        $this->registrant = $registrant;
        $this->endUser = $endUser;
        $this->propertyValues = [];
    }

    /**
     * @return \S3b0\ProjectRegistration\Domain\Model\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\Project $project
     */
    public function setProject(\S3b0\ProjectRegistration\Domain\Model\Project $project = null)
    {
        $this->project = $project;
    }

    /**
     * @return \S3b0\ProjectRegistration\Domain\Model\Person
     */
    public function getRegistrant()
    {
        return $this->registrant;
    }

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\Person $registrant
     */
    public function setRegistrant(\S3b0\ProjectRegistration\Domain\Model\Person $registrant)
    {
        $this->registrant = $registrant;
    }

    /**
     * @return \S3b0\ProjectRegistration\Domain\Model\Person
     */
    public function getEndUser()
    {
        return $this->endUser;
    }

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\Person $endUser
     */
    public function setEndUser(\S3b0\ProjectRegistration\Domain\Model\Person $endUser)
    {
        $this->endUser = $endUser;
    }

    /**
     * @return array
     */
    public function getPropertyValues()
    {
        return $this->propertyValues;
    }

    /**
     * @param array $propertyValues
     */
    public function setPropertyValues(array $propertyValues = [])
    {
        $this->propertyValues = $propertyValues;
    }

}
