<?php
namespace S3b0\ProjectRegistration\Domain\Model;

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
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Project
 */
class Project extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /** date format for \DateTime properties */
    const DATE_FORMAT = 'Y-m-d';

    /**
     * @var bool
     */
    protected $hidden = false;

    /**
     * @var bool
     */
    protected $deleted = false;

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
     * @var \DateTime
     */
    protected $dateOfExpiry = null;

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $application = '';

    /**
     * @var string
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
     * @var int
     * @validate NotEmpty
     */
    protected $addressee = 0;

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
     * @return boolean
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @param boolean $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return !$this->hidden;
    }

    /**
     * @return string
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
     * @return \DateTime
     */
    public function getDateOfRequest()
    {
        return $this->dateOfRequest;
    }

    /**
     * @param \DateTime $dateOfRequest
     */
    public function setDateOfRequest(\DateTime $dateOfRequest = null)
    {
        if ($dateOfRequest instanceof \DateTime) {
            $this->dateOfRequest = $dateOfRequest;
        }
    }

    /**
     * @return \DateTime
     */
    public function getDateOfExpiry()
    {
        return $this->dateOfExpiry;
    }

    /**
     * @return void
     */
    public function setDateOfExpiry()
    {
        if ($this->dateOfRequest instanceof \DateTime) {
            $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['project_registration']);
            $this->dateOfExpiry = new \DateTime(date("Y-m-d H:i:s", ($this->dateOfRequest->getTimestamp() + ((int)$settings['daysToExpire'] * 86400))));
        }
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return !($this->isGoingToExpire() || $this->isExpired());
    }

    /**
     * @return boolean
     */
    public function isGoingToExpire()
    {
        $check    = false;
        $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['project_registration']);

        if ($this->isExpired() === false && $this->dateOfExpiry instanceof \DateTime) {
            $check = $this->dateOfExpiry->diff(new \DateTime())->days <= $settings['warnXDaysBeforeExpireDate'];
        }

        return $check;
    }

    /**
     * @return integer
     */
    public function getDaysToExpiry()
    {
        if ($this->isExpired() === false && $this->dateOfExpiry instanceof \DateTime) {
            return (int)$this->dateOfExpiry->diff(new \DateTime())->days;
        }

        return 0;
    }

    /**
     * @return boolean
     */
    public function isExpired()
    {
        $check = false;

        if ($this->dateOfExpiry instanceof \DateTime) {
            $check = new \DateTime() > $this->dateOfExpiry;
        }

        return $check;
    }

    /**
     * @return string
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
     * @return \DateTime
     */
    public function getEstimatedPurchaseDate()
    {
        return $this->estimatedPurchaseDate;
    }

    /**
     * @param \DateTime $estimatedPurchaseDate
     */
    public function setEstimatedPurchaseDate(\DateTime $estimatedPurchaseDate = null)
    {
        if ($estimatedPurchaseDate instanceof \DateTime) {
            $this->estimatedPurchaseDate = $estimatedPurchaseDate;
        }
    }

    /**
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
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
     * @return int
     */
    public function getAddressee()
    {
        return $this->addressee;
    }

    /**
     * @param int $addressee
     */
    public function setAddressee($addressee)
    {
        $this->addressee = $addressee;
    }

    /**
     * @return bool
     */
    public function isApproved()
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
    public function isAccepted()
    {
        return $this->isVisible() && $this->approved;
    }

    /**
     * @return bool
     */
    public function isRejected()
    {
        return $this->isVisible() && !$this->approved;
    }

    /**
     * @return string
     */
    public function getFontAwesomeStatus()
    {
        if ($this->isVisible()) {
            if ($this->approved) {
                return '<i class="fa fa-check-circle-o text-success fa-lg fa-fw" title="' . LocalizationUtility::translate('state_1', 'project_registration') . '"></i>';
            } else {
                return '<i class="fa fa-times-circle-o text-danger fa-lg fa-fw" title="' . LocalizationUtility::translate('state_0', 'project_registration') . '"></i>';
            }
        } else {
            return '';
        }
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
    public function setRegistrant(\S3b0\ProjectRegistration\Domain\Model\Person $registrant = null)
    {
        if ($registrant instanceof \S3b0\ProjectRegistration\Domain\Model\Person) {
            $this->registrant = $registrant;
        }
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
    public function setEndUser(\S3b0\ProjectRegistration\Domain\Model\Person $endUser = null)
    {
        if ($endUser instanceof \S3b0\ProjectRegistration\Domain\Model\Person) {
            $this->endUser = $endUser;
        }
    }

    /**
     * @return \S3b0\ProjectRegistration\Domain\Model\Product
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
        if ($propertyValue instanceof \S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue && !$this->propertyValues->contains($propertyValue)) {
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
        if ($this->propertyValues instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage && $propertyValueToRemove instanceof \S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue && $this->propertyValues->contains($propertyValueToRemove)) {
            $this->propertyValues->detach($propertyValueToRemove);
        }
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue>
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

    /**
     * @param ProductProperty $property
     *
     * @return \ArrayObject|null
     */
    public function getPropertyValuesByProperty(\S3b0\ProjectRegistration\Domain\Model\ProductProperty $property)
    {
        $return = null;

        if ($this->propertyValues instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
            $return = new \ArrayObject();
            /** @var \S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue $propertyValue */
            foreach ($this->propertyValues as $propertyValue) {
                if ($propertyValue->getProperty() === $property) {
                    $return->append($propertyValue->getTitle());
                }
            }
        }

        return $return;
    }

    /**
     * Returns this object as an array
     *
     * @return array The object
     */
    public function toArray() {
        $array = array();
        $vars = get_object_vars($this);
        foreach ($vars as $property => $value) {
            $array[$property] = $value;
        }
        return $array;
    }

}
