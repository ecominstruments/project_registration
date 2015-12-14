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
 * Product
 */
class Product extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\ProjectRegistration\Domain\Model\ProductProperty>
     */
    protected $properties = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     */
    protected function initStorageObjects()
    {
        $this->properties = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * @param \S3b0\ProjectRegistration\Domain\Model\ProductProperty $property
     */
    public function addProperty(\S3b0\ProjectRegistration\Domain\Model\ProductProperty $property = null)
    {
        if ($property instanceof \S3b0\ProjectRegistration\Domain\Model\ProductProperty) {
            if (!$this->properties instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
                $this->properties = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            }
            if (!$this->properties->contains($property)) {
                $this->properties->attach($property);
            }
        }
    }

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\ProductProperty $propertyToRemove The ProductProperty to be removed
     */
    public function removeProperty(\S3b0\ProjectRegistration\Domain\Model\ProductProperty $propertyToRemove = null)
    {
        if ($propertyToRemove instanceof \S3b0\ProjectRegistration\Domain\Model\ProductProperty && $this->properties instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage && $this->properties->contains($propertyToRemove)) {
            $this->properties->detach($propertyToRemove);
        }
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\ProjectRegistration\Domain\Model\ProductProperty> properties
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\ProjectRegistration\Domain\Model\ProductProperty> $properties
     */
    public function setProperties(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $properties = null)
    {
        if ($properties instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
            $this->properties = $properties;
        }
    }

    /**
     * @return string
     */
    public function getPropertiesList()
    {
        if ($this->properties instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage && $this->properties->count()) {
            $jsCallerIds = [];
            /** @var \S3b0\ProjectRegistration\Domain\Model\ProductProperty $property */
            foreach ($this->properties as $property) {
                $jsCallerIds[] = $property->getJsCallerId();
            }
            return '#' . implode(',#', $jsCallerIds);
        } else {
            return '';
        }
    }

}
