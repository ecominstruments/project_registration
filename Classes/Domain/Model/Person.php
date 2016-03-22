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

/**
 * Person
 */
class Person extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $firstName = '';

    /**
     * @var string
     */
    protected $middleName = '';

    /**
     * @var string
     */
    protected $lastName = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $company = '';

    /**
     * @var string
     */
    protected $address = '';

    /**
     * @var string
     */
    protected $email = '';

    /**
     * @var string
     */
    protected $www = '';

    /**
     * @var string
     */
    protected $phone = '';

    /**
     * @var string
     */
    protected $fax = '';

    /**
     * @var string
     */
    protected $zip = '';

    /**
     * @var string
     */
    protected $city = '';

    /**
     * @var string
     */
    protected $site = '';

    /**
     * @var \Ecom\EcomToolbox\Domain\Model\Region
     */
    protected $country = null;

    /**
     * @var \Ecom\EcomToolbox\Domain\Model\State
     */
    protected $state = null;

    /**
     * @var \Ecom\EcomToolbox\Domain\Model\User
     */
    protected $feUser = null;

    /**
     * Person constructor.
     *
     * @param \Ecom\EcomToolbox\Domain\Model\User|null $user
     */
    public function __construct(\Ecom\EcomToolbox\Domain\Model\User $user = null)
    {
        if ($user instanceof \Ecom\EcomToolbox\Domain\Model\User) {
            $this->name = $user->getName();
            $this->firstName = $user->getFirstName();
            $this->middleName = $user->getMiddleName();
            $this->lastName = $user->getLastName();
            $this->title = $user->getTitle();
            $this->company = $user->getCompany();
            $this->address = $user->getAddress();
            $this->email = $user->getEmail();
            $this->www = $user->getWww();
            $this->phone = $user->getTelephone();
            $this->fax = $user->getFax();
            $this->zip = $user->getZip();
            $this->city = $user->getCity();
            $this->country = $user->getEcomToolboxCountry();
            $this->state = $user->getEcomToolboxState();
            $this->feUser = $user;
        }
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
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
     * @return string $company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getWww()
    {
        return $this->www;
    }

    /**
     * @param string $www
     */
    public function setWww($www)
    {
        $this->www = $www;
    }

    /**
     * @return string $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string $site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param string $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * @return \Ecom\EcomToolbox\Domain\Model\Region $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param \Ecom\EcomToolbox\Domain\Model\Region $country
     */
    public function setCountry(\Ecom\EcomToolbox\Domain\Model\Region $country = null)
    {
        $this->country = $country;
    }

    /**
     * @return \Ecom\EcomToolbox\Domain\Model\State $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param \Ecom\EcomToolbox\Domain\Model\State $state
     */
    public function setState(\Ecom\EcomToolbox\Domain\Model\State $state = null)
    {
        $this->state = $state;
    }

    /**
     * @return \Ecom\EcomToolbox\Domain\Model\User
     */
    public function getFeUser()
    {
        return $this->feUser;
    }

    /**
     * @param \Ecom\EcomToolbox\Domain\Model\User $feUser
     */
    public function setFeUser(\Ecom\EcomToolbox\Domain\Model\User $feUser = null)
    {
        $this->feUser = $feUser;
    }

    /**
     * @return bool
     */
    public function isLoginUser()
    {
        return $this->feUser instanceof \Ecom\EcomToolbox\Domain\Model\User;
    }

    /**
     * @return bool
     */
    public function isNoLoginUser()
    {
        return !$this->isLoginUser();
    }

    /**
     * @return array|null
     */
    public function getFeUserGroups()
    {
        return $this->feUser instanceof \Ecom\EcomToolbox\Domain\Model\User ? $this->feUser->getFeUserGroups() : null;
    }

    /**
     * @return bool
     */
    public function hasUpdatedFeRecord()
    {
        $update = false;
        if ($this->feUser instanceof \Ecom\EcomToolbox\Domain\Model\User) {
            $properties = [
                'name' => 'name',
                'firstName' => 'firstName',
                'middleName' => 'middleName',
                'lastName' => 'lastName',
                'title' => 'title',
                'company' => 'company',
                'address' => 'address',
                'email' => 'email',
                'www' => 'www',
                'fax' => 'fax',
                'zip' => 'zip',
                'city' => 'city',
                'phone' => 'telephone',
                'country' => 'ecomToolboxCountry',
                'state' => 'ecomToolboxState'
            ];
            foreach ($properties as $propertyLocal => $propertyForeign) {
                if ($this->{$propertyLocal} != $this->feUser->_getProperty($propertyForeign)) {
                    $this->_setProperty($propertyLocal, $this->feUser->_getProperty($propertyForeign));
                    $update = true;
                }
            }
        }

        return $update;
    }

}
