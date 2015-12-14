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
 * ProductPropertyValue
 */
class ProductPropertyValue extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';

    /**
     * @var \S3b0\ProjectRegistration\Domain\Model\ProductProperty
     * @validate NotEmpty
     */
    protected $property;

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
     * @return \S3b0\ProjectRegistration\Domain\Model\ProductProperty
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\ProductProperty $property
     */
    public function setProperty(\S3b0\ProjectRegistration\Domain\Model\ProductProperty $property = null)
    {
        $this->property = $property;
    }

    public function getJsCallerId()
    {
        if ($this->property->getFormElementType() === 0) {
            return "prf-property-value-{$this->property->getUid()}-{$this->uid}";
        }
        if ($this->property->getFormElementType() === 1) {
            return "prf-property-value-{$this->property->getUid()}";
        }

        return '';
    }

}
