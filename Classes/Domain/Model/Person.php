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
 * Person
 */
class Person extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name = '';

	/**
	 * company
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $company = '';

	/**
	 * email
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $email = '';

	/**
	 * phone
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $phone = '';

	/**
	 * city
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $city = '';

	/**
	 * site
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $site = '';

	/**
	 * country
	 *
	 * @var \Ecom\EcomToolbox\Domain\Model\Region
	 * @lazy
	 */
	protected $country = NULL;

	/**
	 * state
	 *
	 * @var \Ecom\EcomToolbox\Domain\Model\State
	 * @lazy
	 */
	protected $state = NULL;

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the company
	 *
	 * @return string $company
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * Sets the company
	 *
	 * @param string $company
	 * @return void
	 */
	public function setCompany($company) {
		$this->company = $company;
	}

	/**
	 * Returns the email
	 *
	 * @return string $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets the email
	 *
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns the phone
	 *
	 * @return string $phone
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Sets the phone
	 *
	 * @param string $phone
	 * @return void
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * Returns the city
	 *
	 * @return string $city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Sets the city
	 *
	 * @param string $city
	 * @return void
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * Returns the site
	 *
	 * @return string $site
	 */
	public function getSite() {
		return $this->site;
	}

	/**
	 * Sets the site
	 *
	 * @param string $site
	 * @return void
	 */
	public function setSite($site) {
		$this->site = $site;
	}

	/**
	 * Returns the country
	 *
	 * @return \Ecom\EcomToolbox\Domain\Model\Region $country
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Sets the country
	 *
	 * @param \Ecom\EcomToolbox\Domain\Model\Region $country
	 * @return void
	 */
	public function setCountry(\Ecom\EcomToolbox\Domain\Model\Region $country) {
		$this->country = $country;
	}

	/**
	 * Returns the state
	 *
	 * @return \Ecom\EcomToolbox\Domain\Model\State $state
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * Sets the state
	 *
	 * @param \Ecom\EcomToolbox\Domain\Model\State $state
	 * @return void
	 */
	public function setState(\Ecom\EcomToolbox\Domain\Model\State $state) {
		$this->state = $state;
	}

}