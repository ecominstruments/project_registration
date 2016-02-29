<?php
namespace S3b0\ProjectRegistration\Domain\Repository;

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
 * The repository for Persons
 */
class PersonRepository extends \S3b0\ProjectRegistration\Domain\Repository\AbstractRepository
{

    /**
     * @param \S3b0\ProjectRegistration\Domain\Model\Person $person
     *
     * @return bool|\S3b0\ProjectRegistration\Domain\Model\Person
     */
    public function findOneByMandatoryFields(\S3b0\ProjectRegistration\Domain\Model\Person $person)
    {
        $query = $this->createQuery();

        $result = $query->matching(
            $query->logicalAnd([
                $query->equals('name', $person->getName()),
                $query->equals('company', $person->getCompany()),
                $query->equals('email', $person->getEmail()),
                $query->equals('phone', $person->getPhone()),
                $query->equals('city', ''),
                $query->equals('site', ''),
                $query->equals('country', '0'),
                $query->equals('state', '0')
            ])
        )->execute()->getFirst();

        return $result instanceof \S3b0\ProjectRegistration\Domain\Model\Person ? $result : false;
    }

}
