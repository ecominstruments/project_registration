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
 * Test case for class \S3b0\ProjectRegistration\Domain\Model\Project.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Sebastian Iffland <sebastian.iffland@ecom-ex.com>
 */
class ProjectTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \S3b0\ProjectRegistration\Domain\Model\Project
	 */
	protected $subject = NULL;

	public function setUp() {
		$this->subject = new \S3b0\ProjectRegistration\Domain\Model\Project();
	}

	public function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getDateOfRequestReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getDateOfRequest()
		);
	}

	/**
	 * @test
	 */
	public function setDateOfRequestForDateTimeSetsDateOfRequest() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setDateOfRequest($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'dateOfRequest',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getApplicationReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getApplication()
		);
	}

	/**
	 * @test
	 */
	public function setApplicationForStringSetsApplication() {
		$this->subject->setApplication('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'application',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getQuantityReturnsInitialValueForInt() {	}

	/**
	 * @test
	 */
	public function setQuantityForIntSetsQuantity() {	}

	/**
	 * @test
	 */
	public function getEstimatedPurchaseDateReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getEstimatedPurchaseDate()
		);
	}

	/**
	 * @test
	 */
	public function setEstimatedPurchaseDateForDateTimeSetsEstimatedPurchaseDate() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setEstimatedPurchaseDate($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'estimatedPurchaseDate',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getRegistrationNotesReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getRegistrationNotes()
		);
	}

	/**
	 * @test
	 */
	public function setRegistrationNotesForStringSetsRegistrationNotes() {
		$this->subject->setRegistrationNotes('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'registrationNotes',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getInternalNoteReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getInternalNote()
		);
	}

	/**
	 * @test
	 */
	public function setInternalNoteForStringSetsInternalNote() {
		$this->subject->setInternalNote('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'internalNote',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDenialNoteReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getDenialNote()
		);
	}

	/**
	 * @test
	 */
	public function setDenialNoteForStringSetsDenialNote() {
		$this->subject->setDenialNote('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'denialNote',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getApprovedReturnsInitialValueForBool() {
		$this->assertSame(
			FALSE,
			$this->subject->getApproved()
		);
	}

	/**
	 * @test
	 */
	public function setApprovedForBoolSetsApproved() {
		$this->subject->setApproved(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'approved',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getRegistrantReturnsInitialValueForPerson() {
		$this->assertEquals(
			NULL,
			$this->subject->getRegistrant()
		);
	}

	/**
	 * @test
	 */
	public function setRegistrantForPersonSetsRegistrant() {
		$registrantFixture = new \S3b0\ProjectRegistration\Domain\Model\Person();
		$this->subject->setRegistrant($registrantFixture);

		$this->assertAttributeEquals(
			$registrantFixture,
			'registrant',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEndUserReturnsInitialValueForPerson() {
		$this->assertEquals(
			NULL,
			$this->subject->getEndUser()
		);
	}

	/**
	 * @test
	 */
	public function setEndUserForPersonSetsEndUser() {
		$endUserFixture = new \S3b0\ProjectRegistration\Domain\Model\Person();
		$this->subject->setEndUser($endUserFixture);

		$this->assertAttributeEquals(
			$endUserFixture,
			'endUser',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getProductsReturnsInitialValueForProduct() {
		$this->assertEquals(
			NULL,
			$this->subject->getProducts()
		);
	}

	/**
	 * @test
	 */
	public function setProductsForProductSetsProducts() {
		$productsFixture = new \S3b0\ProjectRegistration\Domain\Model\Product();
		$this->subject->setProducts($productsFixture);

		$this->assertAttributeEquals(
			$productsFixture,
			'products',
			$this->subject
		);
	}
}
