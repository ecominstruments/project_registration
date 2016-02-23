<?php
namespace S3b0\ProjectRegistration\Controller;

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
 * RepositoryInjectionController
 */
class RepositoryInjectionController extends \Ecom\EcomToolbox\Controller\ActionController
{

    /**
     * @var \S3b0\ProjectRegistration\Domain\Repository\ProjectRepository
     * @inject
     */
    protected $projectRepository = null;

    /**
     * @var \S3b0\ProjectRegistration\Domain\Repository\PersonRepository
     * @inject
     */
    protected $personRepository = null;

    /**
     * @var \S3b0\ProjectRegistration\Domain\Repository\ProductRepository
     * @inject
     */
    protected $productRepository = null;

    /**
     * @var \S3b0\ProjectRegistration\Domain\Repository\ProductPropertyRepository
     * @inject
     */
    protected $productPropertyRepository = null;

    /**
     * @var \S3b0\ProjectRegistration\Domain\Repository\ProductPropertyValueRepository
     * @inject
     */
    protected $productPropertyValueRepository = null;

    /**
     * @var \Ecom\EcomToolbox\Domain\Repository\RegionRepository
     * @inject
     */
    protected $regionRepository = null;

    /**
     * @var \Ecom\EcomToolbox\Domain\Repository\StateRepository
     * @inject
     */
    protected $stateRepository = null;

    /**
     * @var \Ecom\EcomToolbox\Domain\Repository\UserRepository
     * @inject
     */
    protected $frontendUserRepository = null;

}