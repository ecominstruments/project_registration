<?php

namespace S3b0\ProjectRegistration\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Sebastian Iffland <sebastian.iffland@ecom-ex.com>, ecom instruments GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \S3b0\ProjectRegistration\Domain\Model\Product.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Sebastian Iffland <sebastian.iffland@ecom-ex.com>
 */
class ProductTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \S3b0\ProjectRegistration\Domain\Model\Product
	 */
	protected $subject = NULL;

	public function setUp() {
		$this->subject = new \S3b0\ProjectRegistration\Domain\Model\Product();
	}

	public function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() {
		$this->subject->setTitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'title',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPropertiesReturnsInitialValueFor() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getProperties()
		);
	}

	/**
	 * @test
	 */
	public function setPropertiesForObjectStorageContainingSetsProperties() {
		$property = new ();
		$objectStorageHoldingExactlyOneProperties = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneProperties->attach($property);
		$this->subject->setProperties($objectStorageHoldingExactlyOneProperties);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneProperties,
			'properties',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addPropertyToObjectStorageHoldingProperties() {
		$property = new ();
		$propertiesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$propertiesObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($property));
		$this->inject($this->subject, 'properties', $propertiesObjectStorageMock);

		$this->subject->addProperty($property);
	}

	/**
	 * @test
	 */
	public function removePropertyFromObjectStorageHoldingProperties() {
		$property = new ();
		$propertiesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$propertiesObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($property));
		$this->inject($this->subject, 'properties', $propertiesObjectStorageMock);

		$this->subject->removeProperty($property);

	}
}
