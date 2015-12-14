<?php
namespace S3b0\ProjectRegistration\Controller;

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
use S3b0\ProjectRegistration\Domain\Model;

/**
 * ProjectController
 */
class ProjectController extends RepositoryInjectionController
{

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $projects = $this->projectRepository->findAll();
        $this->view->assign('projects', $projects);
    }

    /**
     * action show
     *
     * @param \S3b0\ProjectRegistration\Domain\Model\Project $project
     *
     * @return void
     */
    public function showAction(Model\Project $project)
    {
        $this->view->assign('project', $project);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        $newProject = new Model\Project();
        $newRegistrant = new Model\Person();
        $newEndUser = new Model\Person();
        $addressees = $this->getAddressees();
        $this->view->assign('debug', $this->projectRepository->findByUid(1));
        if ($this->getTypoScriptFrontendController()->loginUser) {
            $feUser = $this->frontendUserRepository->findByUid($this->getTypoScriptFrontendController()->fe_user->user[ $this->getTypoScriptFrontendController()->fe_user->userid_column ]);
            $newRegistrant = $this->personRepository->findOneByFeUser($feUser) ?: new Model\Person($feUser);
        }

        ksort($addressees);
        $this->view->assignMultiple([
            'dto'                      => new Model\Dto\ProjectPersonsDto($newProject, $newRegistrant, $newEndUser),
            'feUser'                   => $this->getTypoScriptFrontendController()->loginUser,
            'products'                 => $this->productRepository->findAll(),
            'countries'                => $this->regionRepository->findByType(0),
            'states'                   => $this->stateRepository->findAll(),
            'addressees'               => $addressees,
            'projectProductProperties' => $this->productPropertyRepository->findAll()
        ]);
    }

    /**
     * Initializes the controller before invoking create method.
     *
     * @return void
     */
    protected function initializeCreateAction()
    {
        if ($dto = $this->request->getArgument('dto')) {
            $dto[ 'project' ][ 'estimatedPurchaseDate' ] = date(\DateTime::W3C,
                strtotime($dto[ 'project' ][ 'estimatedPurchaseDate' ]));
            $this->request->setArgument('dto', $dto);
        }
    }

    /**
     * action create
     *
     * @param \S3b0\ProjectRegistration\Domain\Model\Dto\ProjectPersonsDto $dto
     * @param int                                                          $addressee
     * @ignorevalidation $dto
     *
     * @return void
     */
    public function createAction(
        Model\Dto\ProjectPersonsDto $dto,
        $addressee = 0
    ) {
        // Add endUser to personRepository
        $this->personRepository->add($dto->getEndUser());
        // Add registrant to personRepository (if not existing feUser reference)
        if ($dto->getRegistrant()
                ->getFeUser() instanceof \Ecom\EcomToolbox\Domain\Model\User
        ) {
            $registrant = $this->personRepository->findOneByFeUser($dto->getRegistrant()
                ->getFeUser());
            if ($registrant instanceof Model\Person) {
                $dto->setRegistrant($registrant);
            } else {
                $dto->setRegistrant(new Model\Person($dto->getRegistrant()
                    ->getFeUser()));
                $this->personRepository->add($dto->getRegistrant());
            }
        } else {
            $this->personRepository->add($dto->getRegistrant());
        }
        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $persistenceManager */
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $persistenceManager->persistAll();
        // Add property values
        $propertyValues = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        if (is_array($dto->getPropertyValues()) && count($dto->getPropertyValues())) {
            foreach ($dto->getPropertyValues() as $propertyValue) {
                if (($value = $this->productPropertyValueRepository->findByUid($propertyValue)) instanceof Model\ProductPropertyValue) {
                    $propertyValues->attach($value);
                }
            }
        }
        $project = $dto->getProject();
        $project->setRegistrant($dto->getRegistrant());
        $project->setEndUser($dto->getEndUser());
        $project->setPropertyValues($propertyValues);
        $this->projectRepository->add($project);

        $sender = $this->getAddressees(true, $addressee) ?: \TYPO3\CMS\Core\Utility\MailUtility::getSystemFrom();
        $this->view->assign('project', $project);
#        $this->redirect('confirmation');
    }

    /**
     * action edit
     *
     * @param \S3b0\ProjectRegistration\Domain\Model\Project $project
     * @ignorevalidation $project
     *
     * @return void
     */
    public function editAction(
        Model\Project $project
    ) {
        $this->view->assign('project', $project);
    }

    /**
     * action update
     *
     * @param \S3b0\ProjectRegistration\Domain\Model\Project $project
     *
     * @return void
     */
    public function updateAction(
        Model\Project $project
    ) {
        $this->addFlashMessage(
            'The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain',
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
        );
        $this->updateRecord($project);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \S3b0\ProjectRegistration\Domain\Model\Project $project
     *
     * @return void
     */
    public function deleteAction(
        Model\Project $project
    ) {
        $this->deleteRecord($project);
        $this->redirect('list');
    }

    /**
     * action confirmation
     *
     * @return void
     */
    public function confirmationAction()
    {

    }

    /**
     * action approve
     *
     * @return void
     */
    public function approveAction()
    {

    }

    /**
     * action addInternalNote
     *
     * @return void
     */
    public function addInternalNoteAction()
    {

    }

    /**
     * action addDenialNote
     *
     * @return void
     */
    public function addDenialNoteAction()
    {

    }

    /**
     * @param bool $returnMails     If set, mails will be returned, pre-formatted for use with
     *                              \TYPO3\CMS\Core\Mail\MailMessage
     * @param int  $returnArrayItem If set, a single array item will be returned
     *
     * @return array|string
     */
    private function getAddressees(
        $returnMails = false,
        $returnArrayItem = null
    ) {
        $return = [];

        if (is_array($this->settings[ 'addressees' ][ 'data' ]) && sizeof($this->settings[ 'addressees' ][ 'data' ])) {
            foreach ($this->settings[ 'addressees' ][ 'data' ] as $k => $addressee) {
                if (($label = $this->getTypoScriptFrontendController()
                        ->sL($addressee[ 'label' ])) && \TYPO3\CMS\Core\Utility\GeneralUtility::validEmail($addressee[ 'mail' ])
                ) {
                    $return[ $k ] = $returnMails ? ($addressee[ 'name' ] ? [$addressee[ 'mail' ] => $addressee[ 'name' ]] : [$addressee[ 'mail' ]]) : $label;
                }
            }
        }

        if (is_integer($returnArrayItem) && array_key_exists($returnArrayItem, $return)) {
            return $return[ $returnArrayItem ];
        } else {
            return $return;
        }
    }

}