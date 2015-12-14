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
 * ProductProperty
 */
class ProductProperty extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';

    /**
     * @var int
     */
    protected $formElementType = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue>
     */
    protected $propertyValues;

    /**
     * ProductProperty constructor.
     */
    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     */
    public function initStorageObjects()
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
     * @return int
     */
    public function getFormElementType()
    {
        return $this->formElementType;
    }

    /**
     * @param int $formElementType
     */
    public function setFormElementType($formElementType)
    {
        $this->formElementType = $formElementType;
    }

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue $propertyValue
     */
    public function addPropertyValue(\S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue $propertyValue)
    {
        if ($propertyValue instanceof \S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue) {
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
        \S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue $propertyValueToRemove
    ) {
        if ($propertyValueToRemove instanceof \S3b0\ProjectRegistration\Domain\Model\ProductPropertyValue && $this->propertyValues instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage && $this->propertyValues->contains($propertyValueToRemove)) {
            $this->propertyValues->detach($propertyValueToRemove);
        }
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getPropertyValues()
    {
        if ($this->propertyValues instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
            return $this->propertyValues;
        } else {
            return new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        }
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $propertyValues
     */
    public function setPropertyValues(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $propertyValues = null)
    {
        $this->propertyValues = $propertyValues;
    }

    /**
     * @return string
     */
    public function getJsCallerId()
    {
        return "prf-property-{$this->uid}";
    }

    /**
     * @return string
     */
    public function getJsFormTypeIdentifier()
    {
        switch ($this->formElementType) {
            case 1:
                return 'prf-form-type-select';
            default:
                return 'prf-form-type-radio';
        }
    }

}
