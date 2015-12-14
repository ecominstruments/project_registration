<?php
namespace S3b0\ProjectRegistration\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Sebastian Iffland <sebastian.iffland@ecom-ex.com>, ecom instruments GmbH
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
 * Project
 */
class Project extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /** date format for \DateTime properties */
    const DATE_FORMAT = 'Y-m-d';

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';

    /**
     * @var \DateTime
     */
    protected $dateOfRequest = null;

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $application = '';

    /**
     * @var int
     * @validate NotEmpty
     */
    protected $quantity = '';

    /**
     * @var \DateTime
     * @validate NotEmpty
     */
    protected $estimatedPurchaseDate = null;

    /**
     * @var string
     */
    protected $registrationNotes = '';

    /**
     * @var string
     */
    protected $internalNote = '';

    /**
     * @var string
     */
    protected $denialNote = '';

    /**
     * @var bool
     */
    protected $approved = false;

    /**
     * @var \S3b0\ProjectRegistration\Domain\Model\Person
     */
    protected $registrant = null;

    /**
     * @var \S3b0\ProjectRegistration\Domain\Model\Person
     */
    protected $endUser = null;

    /**
     * @var \S3b0\ProjectRegistration\Domain\Model\Product
     */
    protected $product = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue>
     */
    protected $propertyValues = null;

    /**
     * Project constructor.
     */
    public function __construct()
    {
        $this->dateOfRequest = new \DateTime();
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     */
    protected function initStorageObjects()
    {
        $this->propertyValues = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime $dateOfRequest
     */
    public function getDateOfRequest()
    {
        return $this->dateOfRequest;
    }

    /**
     * @param \DateTime $dateOfRequest
     */
    public function setDateOfRequest(\DateTime $dateOfRequest)
    {
        $this->dateOfRequest = $dateOfRequest;
    }

    /**
     * @return string $application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param string $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }

    /**
     * @return \DateTime $estimatedPurchaseDate
     */
    public function getEstimatedPurchaseDate()
    {
        return $this->estimatedPurchaseDate;
    }

    /**
     * @param \DateTime $estimatedPurchaseDate
     */
    public function setEstimatedPurchaseDate(\DateTime $estimatedPurchaseDate)
    {
        $this->estimatedPurchaseDate = $estimatedPurchaseDate;
    }

    /**
     * @return string $registrationNotes
     */
    public function getRegistrationNotes()
    {
        return $this->registrationNotes;
    }

    /**
     * @param string $registrationNotes
     */
    public function setRegistrationNotes($registrationNotes)
    {
        $this->registrationNotes = $registrationNotes;
    }

    /**
     * @return int quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string $internalNote
     */
    public function getInternalNote()
    {
        return $this->internalNote;
    }

    /**
     * @param string $internalNote
     */
    public function setInternalNote($internalNote)
    {
        $this->internalNote = $internalNote;
    }

    /**
     * @return string $denialNote
     */
    public function getDenialNote()
    {
        return $this->denialNote;
    }

    /**
     * @param string $denialNote
     */
    public function setDenialNote($denialNote)
    {
        $this->denialNote = $denialNote;
    }

    /**
     * @return bool $approved
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * @param bool $approved
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return $this->approved;
    }

    /**
     * @return \S3b0\ProjectRegistration\Domain\Model\Person $registrant
     */
    public function getRegistrant()
    {
        return $this->registrant;
    }

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\Person $registrant
     */
    public function setRegistrant(\S3b0\ProjectRegistration\Domain\Model\Person $registrant = null)
    {
        if ($registrant instanceof \S3b0\ProjectRegistration\Domain\Model\Person) {
            $this->registrant = $registrant;
        }
    }

    /**
     * @return \S3b0\ProjectRegistration\Domain\Model\Person $endUser
     */
    public function getEndUser()
    {
        return $this->endUser;
    }

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\Person $endUser
     */
    public function setEndUser(\S3b0\ProjectRegistration\Domain\Model\Person $endUser = null)
    {
        if ($endUser instanceof \S3b0\ProjectRegistration\Domain\Model\Person) {
            $this->endUser = $endUser;
        }
    }

    /**
     * @return \S3b0\ProjectRegistration\Domain\Model\Product product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\Product $product
     */
    public function setProduct(\S3b0\ProjectRegistration\Domain\Model\Product $product = null)
    {
        if ($product instanceof \S3b0\ProjectRegistration\Domain\Model\Product) {
            $this->product = $product;
        }
    }

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue $propertyValue
     */
    public function addPropertyValue(\S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue $propertyValue = null)
    {
        if ($propertyValue instanceof \S3b0\ProjectRegistration\Domain\Model\ProductValues && !$this->propertyValues->contains($propertyValue)) {
            if (!$this->propertyValues instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
                $this->propertyValues = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            }
            if (!$this->propertyValues->contains($propertyValue)) {
                $this->propertyValues->attach($propertyValue);
            }
        }
    }

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue $propertyValueToRemove
     */
    public function removePropertyValue(
        \S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue $propertyValueToRemove = null
    ) {
        if ($propertyValueToRemove instanceof \S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue && $this->propertyValues instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage && $this->propertyValues->contains($propertyValueToRemove)) {
            $this->propertyValues->detach($propertyValueToRemove);
        }
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue> $propertyValues
     */
    public function getPropertyValues()
    {
        return $this->propertyValues;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue> $propertyValues
     */
    public function setPropertyValues(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $propertyValues = null)
    {
        if ($propertyValues instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
            $this->propertyValues = $propertyValues;
        }
    }

}
