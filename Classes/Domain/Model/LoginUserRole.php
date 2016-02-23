<?php
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Sebastian Iffland <Sebastian.Iffland@ecom-ex.com>, ecom instruments GmbH
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


namespace S3b0\ProjectRegistration\Domain\Model;


class LoginUserRole
{

    const INVESTIGATOR  = 1;
    const ADMINISTRATOR = 2;

    /**
     * @var int
     */
    protected $role = 0;

    public function __construct($role = 0)
    {
        $this->setRole((int)$role);
    }

    /**
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return bool
     */
    public function isNotAuthorized()
    {
        return $this->role !== self::INVESTIGATOR && $this->role !== self::ADMINISTRATOR;
    }

    /**
     * @return bool
     */
    public function isInvestigator()
    {
        return $this->role === self::INVESTIGATOR;
    }

    /**
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->role === self::ADMINISTRATOR;
    }

    /**
     * @return boolean
     */
    public function isHasInvestigatorRights()
    {
        return $this->role === self::INVESTIGATOR || $this->role === self::ADMINISTRATOR;
    }

    /**
     * @return boolean
     */
    public function isHasAdministratorRights()
    {
        return $this->role === self::ADMINISTRATOR;
    }

}