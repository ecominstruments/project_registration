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
class Project extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * dateOfRequest
	 *
	 * @var \DateTime
	 * @validate NotEmpty
	 */
	protected $dateOfRequest = NULL;

	/**
	 * application
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $application = '';

	/**
	 * quantity
	 *
	 * @var int
	 * @validate NotEmpty
	 */
	protected $quantity = '';

	/**
	 * estimatedPurchaseDate
	 *
	 * @var \DateTime
	 * @validate NotEmpty
	 */
	protected $estimatedPurchaseDate = NULL;

	/**
	 * registrationNotes
	 *
	 * @var string
	 */
	protected $registrationNotes = '';

	/**
	 * internalNote
	 *
	 * @var string
	 */
	protected $internalNote = '';

	/**
	 * denialNote
	 *
	 * @var string
	 */
	protected $denialNote = '';

	/**
	 * approved
	 *
	 * @var bool
	 */
	protected $approved = FALSE;

	/**
	 * registrant
	 *
	 * @var \S3b0\ProjectRegistration\Domain\Model\Person
	 */
	protected $registrant = NULL;

	/**
	 * endUser
	 *
	 * @var \S3b0\ProjectRegistration\Domain\Model\Person
	 */
	protected $endUser = NULL;

	/**
	 * products
	 *
	 * @var \S3b0\ProjectRegistration\Domain\Model\Product
	 */
	protected $products = NULL;

	/**
	 * Returns the dateOfRequest
	 *
	 * @return \DateTime $dateOfRequest
	 */
	public function getDateOfRequest() {
		return $this->dateOfRequest;
	}

	/**
	 * Sets the dateOfRequest
	 *
	 * @param \DateTime $dateOfRequest
	 * @return void
	 */
	public function setDateOfRequest(\DateTime $dateOfRequest) {
		$this->dateOfRequest = $dateOfRequest;
	}

	/**
	 * Returns the application
	 *
	 * @return string $application
	 */
	public function getApplication() {
		return $this->application;
	}

	/**
	 * Sets the application
	 *
	 * @param string $application
	 * @return void
	 */
	public function setApplication($application) {
		$this->application = $application;
	}

	/**
	 * Returns the estimatedPurchaseDate
	 *
	 * @return \DateTime $estimatedPurchaseDate
	 */
	public function getEstimatedPurchaseDate() {
		return $this->estimatedPurchaseDate;
	}

	/**
	 * Sets the estimatedPurchaseDate
	 *
	 * @param \DateTime $estimatedPurchaseDate
	 * @return void
	 */
	public function setEstimatedPurchaseDate(\DateTime $estimatedPurchaseDate) {
		$this->estimatedPurchaseDate = $estimatedPurchaseDate;
	}

	/**
	 * Returns the registrationNotes
	 *
	 * @return string $registrationNotes
	 */
	public function getRegistrationNotes() {
		return $this->registrationNotes;
	}

	/**
	 * Sets the registrationNotes
	 *
	 * @param string $registrationNotes
	 * @return void
	 */
	public function setRegistrationNotes($registrationNotes) {
		$this->registrationNotes = $registrationNotes;
	}

	/**
	 * Returns the quantity
	 *
	 * @return int quantity
	 */
	public function getQuantity() {
		return $this->quantity;
	}

	/**
	 * Sets the quantity
	 *
	 * @param string $quantity
	 * @return void
	 */
	public function setQuantity($quantity) {
		$this->quantity = $quantity;
	}

	/**
	 * Returns the registrant
	 *
	 * @return \S3b0\ProjectRegistration\Domain\Model\Person $registrant
	 */
	public function getRegistrant() {
		return $this->registrant;
	}

	/**
	 * Sets the registrant
	 *
	 * @param \S3b0\ProjectRegistration\Domain\Model\Person $registrant
	 * @return void
	 */
	public function setRegistrant(\S3b0\ProjectRegistration\Domain\Model\Person $registrant) {
		$this->registrant = $registrant;
	}

	/**
	 * Returns the endUser
	 *
	 * @return \S3b0\ProjectRegistration\Domain\Model\Person $endUser
	 */
	public function getEndUser() {
		return $this->endUser;
	}

	/**
	 * Sets the endUser
	 *
	 * @param \S3b0\ProjectRegistration\Domain\Model\Person $endUser
	 * @return void
	 */
	public function setEndUser(\S3b0\ProjectRegistration\Domain\Model\Person $endUser) {
		$this->endUser = $endUser;
	}

	/**
	 * Returns the internalNote
	 *
	 * @return string $internalNote
	 */
	public function getInternalNote() {
		return $this->internalNote;
	}

	/**
	 * Sets the internalNote
	 *
	 * @param string $internalNote
	 * @return void
	 */
	public function setInternalNote($internalNote) {
		$this->internalNote = $internalNote;
	}

	/**
	 * Returns the denialNote
	 *
	 * @return string $denialNote
	 */
	public function getDenialNote() {
		return $this->denialNote;
	}

	/**
	 * Sets the denialNote
	 *
	 * @param string $denialNote
	 * @return void
	 */
	public function setDenialNote($denialNote) {
		$this->denialNote = $denialNote;
	}

	/**
	 * Returns the approved
	 *
	 * @return bool $approved
	 */
	public function getApproved() {
		return $this->approved;
	}

	/**
	 * Sets the approved
	 *
	 * @param bool $approved
	 * @return void
	 */
	public function setApproved($approved) {
		$this->approved = $approved;
	}

	/**
	 * Returns the boolean state of approved
	 *
	 * @return bool
	 */
	public function isApproved() {
		return $this->approved;
	}

	/**
	 * Returns the products
	 *
	 * @return \S3b0\ProjectRegistration\Domain\Model\Product products
	 */
	public function getProducts() {
		return $this->products;
	}

	/**
	 * Sets the products
	 *
	 * @param string $products
	 * @return void
	 */
	public function setProducts($products) {
		$this->products = $products;
	}

}