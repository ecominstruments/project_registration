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
use In2code\Powermail\Utility\SessionUtility;
use S3b0\ProjectRegistration\Domain\Model;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility as Lang;
use TYPO3\CMS\Core\Utility as CoreUtility;

/**
 * ProjectController
 */
class ProjectController extends RepositoryInjectionController
{

    /**
     * @var \S3b0\ProjectRegistration\Domain\Model\LoginUserRole
     */
    protected $logInUserRole;

    /**
     * @var array
     */
    protected $adminActions = [ 'addInternalNote', 'delete' ];

    /**
     * @var array
     */
    protected $actionsThatRequireProjectArgumentToBeSet = [ 'accept', 'addInternalNote', 'confirmation', 'delete', 'reject', 'resendRequestMail', 'show', 'submitted' ];

    /**
     * Initializes the controller before invoking an action method.
     *
     * @return void
     */
    public function initializeAction()
    {
        if ($this->request->getPluginName() === 'Administration') {
            $this->logInUserRole = new Model\LoginUserRole();
            if ($this->getTypoScriptFrontendController()->loginUser) {
                if ((int)$this->settings[ 'investigator' ] === (int)$this->getTypoScriptFrontendController()->fe_user->user[ $this->getTypoScriptFrontendController()->fe_user->userid_column ]) {
                    $this->logInUserRole = new Model\LoginUserRole(Model\LoginUserRole::INVESTIGATOR);
                }
                if ((int)$this->settings[ 'admin' ] === (int)$this->getTypoScriptFrontendController()->fe_user->user[ $this->getTypoScriptFrontendController()->fe_user->userid_column ]) {
                    $this->logInUserRole = new Model\LoginUserRole(Model\LoginUserRole::ADMINISTRATOR);
                }
            }

            if ($this->logInUserRole->isNotAuthorized()) {
                $this->getTypoScriptFrontendController()->pageNotFoundAndExit();
            } elseif ($this->logInUserRole->isInvestigator() && in_array($this->request->getControllerActionName(), $this->adminActions)) {
                $this->getTypoScriptFrontendController()->pageNotFoundAndExit();
            }
        }

        if (in_array($this->request->getControllerActionName(), $this->actionsThatRequireProjectArgumentToBeSet)) {
            $this->manuallySetProjectArgument();
        }

    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $projects = $this->projectRepository->findAll();
        $addressees = $this->getAddressees(false, null, true, true);

        $this->view->assignMultiple([
            'projects'         => $projects,
            'addressees'       => $addressees,
            'logInUserRole' => $this->logInUserRole
        ]);
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
        $this->view->assignMultiple([
            'project'   => $project,
            'addressee' => $this->getAddressees(false, $project->getAddressee())
        ]);
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
        $addressees = $this->getAddressees(false, null, false);
        if ($this->getTypoScriptFrontendController()->loginUser) {
            /** @var \Ecom\EcomToolbox\Domain\Model\User $feUser */
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
        $propertyMappingConfiguration = $this->arguments[ 'dto' ]->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->allowAllProperties();
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
     * @ignorevalidation $dto
     *
     * @dontverifyrequesthash
     *
     * @return void
     */
    public function createAction(Model\Dto\ProjectPersonsDto $dto)
    {
        // Add endUser to personRepository
        $this->personRepository->add($dto->getEndUser());
        // Add registrant to personRepository (if not existing feUser reference)
        if ($dto->getRegistrant()->getFeUser() instanceof \Ecom\EcomToolbox\Domain\Model\User
        ) {
            $registrant = $this->personRepository->findOneByFeUser($dto->getRegistrant()->getFeUser());
            if ($registrant instanceof Model\Person) {
                $dto->setRegistrant($registrant);
            } else {
                $dto->setRegistrant(new Model\Person($dto->getRegistrant()->getFeUser()));
                $this->personRepository->add($dto->getRegistrant());
            }
        } else {
            $this->personRepository->add($dto->getRegistrant());
        }
        /**
         * Persist Persons in order to get corresponding uid to link to in Project
         *
         * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $persistenceManager
         */
        $persistenceManager = CoreUtility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
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
        // Persist Project to get the uid to use as Project# in emails
        $this->projectRepository->add($project);
        $persistenceManager->persistAll();

        $noReply = null;
        if ($this->settings[ 'mail' ][ 'noReplyEmail' ] && CoreUtility\GeneralUtility::validEmail($this->settings[ 'mail' ][ 'noReplyEmail' ])) {
            $noReply = [$this->settings[ 'mail' ][ 'noReplyEmail' ] => $this->settings[ 'mail' ][ 'noReplyName' ] ?: $this->settings[ 'mail' ][ 'senderName' ]];
        }
        $sender = $this->getAddressees(true, $project->getAddressee()) ?: CoreUtility\MailUtility::getSystemFrom();
        $carbonCopyReceivers = [];
        if ($this->settings[ 'mail' ][ 'carbonCopy' ]) {
            foreach (explode(',', $this->settings[ 'mail' ][ 'carbonCopy' ]) as $carbonCopyReceiver) {
                $tokens = CoreUtility\GeneralUtility::trimExplode(' ', $carbonCopyReceiver, true, 2);
                if (CoreUtility\GeneralUtility::validEmail($tokens[ 0 ])) {
                    $carbonCopyReceivers[ $tokens[ 0 ] ] = $tokens[ 1 ];
                }
            }
        }

        /** @var \TYPO3\CMS\Core\Mail\MailMessage $mailToSender */
        $mailToSender = CoreUtility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
        $mailToSender->setContentType('text/html');

        /**
         * Email to sender
         */
        $mailToSender->setFrom($noReply ?: $sender)
            ->setTo([
                $dto->getRegistrant()
                    ->getEmail() => $dto->getRegistrant()
                    ->getName()
            ])
            ->setSubject($this->settings[ 'mail' ][ 'projectRegisteredConfirmationSubject' ] ?: (Lang::translate('mail_project_registered_confirmation_subject', $this->extensionName) ?: 'Your project registration request'))
            ->setBody($this->getStandAloneTemplate(
                CoreUtility\ExtensionManagementUtility::siteRelPath(CoreUtility\GeneralUtility::camelCaseToLowerCaseUnderscored($this->extensionName)) . 'Resources/Private/Templates/Email/ProjectRegisteredConfirmation.html',
                [
                    'settings'   => $this->settings,
                    'submitted'  => $dto,
                    'addressees' => $this->getAddressees()
                ]
            ))
            ->send();

        /** @var \TYPO3\CMS\Core\Mail\MailMessage $mailToSender */
        $mailToReceiver = CoreUtility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
        $mailToReceiver->setContentType('text/html');

        /**
         * Email to receiver (notification mail)
         */
        $mailToReceiver->setTo($sender)
            ->setCc($carbonCopyReceivers)
            ->setFrom([
                $dto->getRegistrant()->getEmail() => $dto->getRegistrant()->getName()
            ])
            ->setSubject(($this->settings[ 'mail' ][ 'projectRegisteredInfoSubject' ] ?: (Lang::translate('mail_project_registered_info_subject', $this->extensionName) ?: 'New project registration submitted')) . ($dto->getRegistrant()->getFeUserGroups() && in_array($this->settings[ 'certifiedUsersUserGroup' ], $dto->getRegistrant()->getFeUserGroups()) ? ' » ' . Lang::translate('user_certified', $this->extensionName) : ' » ' . Lang::translate('user_default', $this->extensionName)))
            ->setBody($this->getStandAloneTemplate(
                CoreUtility\ExtensionManagementUtility::siteRelPath(CoreUtility\GeneralUtility::camelCaseToLowerCaseUnderscored($this->extensionName)) . 'Resources/Private/Templates/Email/ProjectRegisteredInfo.html',
                [
                    'settings'             => $this->settings,
                    'submitted'            => $dto,
                    'addressees'           => $this->getAddressees(),
                    'marketingInformation' => SessionUtility::getMarketingInfos()
                ]
            ))
            ->send();
        $this->internalRedirect('submitted', ['project' => $dto->getProject()]);
    }

    /**
     * action submitted
     *
     * @param Model\Project $project
     *
     * @return void
     */
    public function submittedAction(Model\Project $project)
    {
        $this->view->assignMultiple([
            'project'    => $project,
            'addressees' => $this->getAddressees()
        ]);
    }

    /**
     * action confirmation
     *
     * @param Model\Project $project
     * @param string        $do
     *
     * @return void
     */
    public function confirmationAction(Model\Project $project, $do = 'accept')
    {
        $receivers = [];
        if (isset($this->settings[ 'notificationEmails' ]) && is_array($this->settings[ 'notificationEmails' ])) {
            foreach ($this->settings[ 'notificationEmails' ] as $receiver) {
                $receivers[ $receiver[ 'mail' ] ] = "{$receiver[ 'name' ]} <{$receiver[ 'mail' ]}>";
            }
        }

        $this->view->assignMultiple([
            'receivers' => $receivers,
            'project'   => $project,
            'action'    => $do
        ]);
    }

    /**
     * action delete
     *
     * @param \S3b0\ProjectRegistration\Domain\Model\Project $project
     *
     * @return void
     */
    public function deleteAction(Model\Project $project)
    {
        $this->deleteRecord($project, "Project with #{$project->getUid()} was deleted!", \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, self::NEUTER_ARTICLE, true);
        $this->internalRedirect('list');
    }

    /**
     * action accept
     *
     * @param \S3b0\ProjectRegistration\Domain\Model\Project $project
     * @param array                                          $receivers
     * @param bool                                           $sendmail
     *
     * @return void
     */
    public function acceptAction(Model\Project $project, array $receivers = [], $sendmail = true)
    {
        $project->setHidden(false);
        $project->setApproved(true);
        $this->updateRecord($project, "Project with #{$project->getUid()} was accepted!", \TYPO3\CMS\Core\Messaging\AbstractMessage::OK, self::NEUTER_ARTICLE, true);

        if ($sendmail) {
            $this->updateStatusMail($project, $receivers, true);
        }
        $this->internalRedirect('list');
    }

    /**
     * action reject
     *
     * @param \S3b0\ProjectRegistration\Domain\Model\Project $project
     * @param array                                          $receivers
     * @param bool                                           $sendmail
     *
     * @return void
     */
    public function rejectAction(Model\Project $project, array $receivers = [], $sendmail = true)
    {
        $project->setHidden(false);
        $project->setApproved(false);
        $this->updateRecord($project, "Project with #{$project->getUid()} was rejected!", \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, self::NEUTER_ARTICLE, true);

        if ($sendmail) {
            $this->updateStatusMail($project, $receivers, false);
        }
        $this->internalRedirect('list');
    }

    /**
     * action addInternalNote
     *
     * @return void
     */
    public function addInternalNoteAction(Model\Project $project)
    {
        if ($project->_isDirty()) {
            $this->updateRecord($project, "Project with #{$project->getUid()} was updated!", \TYPO3\CMS\Core\Messaging\AbstractMessage::INFO, self::NEUTER_ARTICLE, true);
            $this->internalRedirect('list');
        }
        $this->view->assign('project', $project);
    }

    /**
     * action resendRequestMail
     *
     * @param Model\Project $project
     *
     * @return void
     */
    public function resendRequestMailAction(Model\Project $project)
    {
        if (CoreUtility\GeneralUtility::validEmail($this->settings['adminEmail'])) {
            /** @var \TYPO3\CMS\Core\Mail\MailMessage $mailToSender */
            $mail = CoreUtility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $mail->setContentType('text/html');

            /**
             * Email to receiver (notification mail)
             */
            $mail->setTo([ $this->settings['adminEmail'] ])
                ->setFrom([
                    $project->getRegistrant()->getEmail() => $project->getRegistrant()->getName()
                ])
                ->setSubject('RE-SUBMIT: ' . ($this->settings[ 'mail' ][ 'projectRegisteredInfoSubject' ] ?: (Lang::translate('mail_project_registered_info_subject', $this->extensionName) ?: 'New project registration submitted')) . ($project->getRegistrant()->getFeUserGroups() && in_array($this->settings[ 'certifiedUsersUserGroup' ], $project->getRegistrant()->getFeUserGroups()) ? ' » ' . Lang::translate('user_certified', $this->extensionName) : ' » ' . Lang::translate('user_default', $this->extensionName)))
                ->setBody($this->getStandAloneTemplate(
                    CoreUtility\ExtensionManagementUtility::siteRelPath(CoreUtility\GeneralUtility::camelCaseToLowerCaseUnderscored($this->extensionName)) . 'Resources/Private/Templates/Email/ProjectRegisteredInfo.html',
                    [
                        'settings'             => $this->settings,
                        'submitted'            => new Model\Dto\ProjectPersonsDto(
                            $project, $project->getRegistrant(), $project->getEndUser()
                        ),
                        'addressees'           => $this->getAddressees(),
                        'marketingInformation' => [ ]
                    ]
                ))
                ->send();
            $this->addFlashMessage("Mail for project #{$project->getUid()} ('{$project->getTitle()}') re-sent.");
        } else {
            $this->addFlashMessage('Invalid mail: ' . $this->settings['adminEmail'], '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        }

        $this->internalRedirect('list');
    }

    /**
     * action exportCSV
     *
     * @param bool $noUSFormat
     *
     * @return void
     */
    public function exportCSVAction($noUSFormat = false)
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface $querySettings */
        $querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface::class);
        $querySettings->setRespectStoragePage(false); // Disable storage pid
        $querySettings->setIncludeDeleted(true);
        $querySettings->setIgnoreEnableFields(true);
        $querySettings->setEnableFieldsToBeIgnored(['disabled']); // Disable hidden field
        $this->projectRepository->setDefaultQuerySettings($querySettings);
        $this->projectRepository->setDefaultOrderings([
            'hidden'          => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
            'date_of_request' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ]);
        $projects = $this->projectRepository->findAll();
        $deleted = $this->projectRepository->findByDeleted(1);
        $csvArray = [];

        if ($projects && $projects instanceof \Countable) {
            /** @var Model\Project $project */
            foreach ($projects as $project) {
                if ($project instanceof Model\Project) {
                    $eN = $this->extensionName;
                    $status = $project->isHidden() ? Lang::translate('state_2', $eN) : ($project->isAccepted() ? Lang::translate('state_1', $eN) : Lang::translate('state_0', $eN));
                    $isOutdated = $project->isOutdated() ? 'X' : '';
                    $isDeleted = $deleted instanceof \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult && in_array($project, $deleted->toArray()) ? 'X' : '';
                    $data = [
                        Lang::translate('status', $eN) => $status,
                        'old' => $isOutdated,
                        'del' => $isDeleted,
                        Lang::translate('legend_project_id', $eN) => $project->getUid(),
                        Lang::translate('date_of_request', $eN) => $project->getDateOfRequest()->format($this->settings[ 'formatDate' ] . ' h:i A'),
                        Lang::translate('legend_project_region', $eN) => $this->getAddressees(false, $project->getAddressee()),
                        Lang::translate('registrant', $eN) => $project->getRegistrant()->getName(),
                        Lang::translate('company', $eN) => $project->getRegistrant()->getCompany(),
                        Lang::translate('email', $eN) => $project->getRegistrant()->getEmail(),
                        Lang::translate('phone', $eN) => $project->getRegistrant()->getPhone(),
                        Lang::translate('legend_project_name', $eN) => $project->getTitle(),
                        Lang::translate('product', $eN) => $project->getProduct() instanceof Model\Product ? $project->getProduct()->getTitle() : '',
                        Lang::translate('application', $eN) => $project->getApplication(),
                        Lang::translate('quantity', $eN) => $project->getQuantity(),
                        Lang::translate('estimated_purchase_date', $eN) => $project->getEstimatedPurchaseDate()->format($this->settings[ 'formatDate' ]),
                        Lang::translate('registration_notes', $eN) => $project->getRegistrationNotes(),
                        Lang::translate('legend_enduser_company', $eN) => $project->getEndUser()->getCompany(),
                        Lang::translate('contact', $eN) => $project->getEndUser()->getName(),
                        Lang::translate('email', $eN) => $project->getEndUser()->getEmail(),
                        Lang::translate('phone', $eN) => $project->getEndUser()->getPhone(),
                        Lang::translate('city', $eN) => $project->getEndUser()->getCity(),
                        Lang::translate('site', $eN) => $project->getEndUser()->getSite(),
                        Lang::translate('country', $eN) => $project->getEndUser()->getCountry() instanceof \Ecom\EcomToolbox\Domain\Model\Region ? $project->getEndUser()->getCountry()->getTitle() : '',
                        Lang::translate('state_province', $eN) => $project->getEndUser()->getState() instanceof \Ecom\EcomToolbox\Domain\Model\State ? $project->getEndUser()->getState()->getTitle() : '',
                        Lang::translate('internal_note', $eN) => $project->getInternalNote(),
                        Lang::translate('denial_note', $eN) => $project->getDenialNote()
                    ];
                    /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $values */
                    if ($values = $project->getPropertyValues()) {
                        /** @var Model\ProductPropertyValue $value */
                        foreach ($values as $value) {
                            $data[ Lang::translate('product', $eN) ] .= " | {$value->getProperty()->getTitle()}: {$value->getTitle()}";
                        }
                    }
                    // Convert UTF-8 to ANSI for Excel
                    array_walk($data, create_function('&$val', '$val = iconv("UTF-8", "Windows-1252", $val);'));
                    $csvArray[] = $data;
                }
            }
        }

        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename=export_" . date("Y-m-d") . ".csv");
        header("Content-Transfer-Encoding: binary");

        echo $this->array2csv($csvArray, $noUSFormat);
        die();
    }

    /**
     * @param array $array
     * @param bool  $noUSFormat
     *
     * @return null|string
     */
    private function array2csv(array &$array, $noUSFormat = false)
    {
        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        $delimiter = $noUSFormat ? ';' : ',';
        fputcsv($df, array_keys(reset($array)), $delimiter);
        foreach ($array as $row) {
            fputcsv($df, $row, $delimiter);
        }
        fclose($df);

        return ob_get_clean();
    }

    /**
     * @param Model\Project $project
     * @param array         $receivers
     * @param bool          $isAccepted
     */
    public function updateStatusMail(Model\Project $project, array $receivers = [], $isAccepted = true)
    {
        $noReply = null;
        if ($this->settings[ 'mail' ][ 'noReplyEmail' ] && CoreUtility\GeneralUtility::validEmail($this->settings[ 'mail' ][ 'noReplyEmail' ])) {
            $noReply = [$this->settings[ 'mail' ][ 'noReplyEmail' ] => $this->settings[ 'mail' ][ 'noReplyName' ] ?: $this->settings[ 'mail' ][ 'senderName' ]];
        }
        $sender = $this->getAddressees(true, $project->getAddressee()) ?: CoreUtility\MailUtility::getSystemFrom();
        $carbonCopyReceivers = [];
        if ($this->settings[ 'mail' ][ 'carbonCopy' ]) {
            foreach (explode(',', $this->settings[ 'mail' ][ 'carbonCopy' ]) as $carbonCopyReceiver) {
                $tokens = CoreUtility\GeneralUtility::trimExplode(' ', $carbonCopyReceiver, true, 2);
                if (CoreUtility\GeneralUtility::validEmail($tokens[ 0 ])) {
                    $carbonCopyReceivers[ $tokens[ 0 ] ] = $tokens[ 1 ];
                }
            }
        }

        /** @var \TYPO3\CMS\Core\Mail\MailMessage $mailToSender */
        $mailToSender = CoreUtility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
        $mailToSender->setContentType('text/html');

        /**
         * Email to sender
         */
        $mailToSender->setFrom($noReply ?: $sender)
            ->setTo([
                $project->getRegistrant()->getEmail() => $project->getRegistrant()->getName()
            ])
            ->setCc($receivers)
            ->setSubject($this->settings[ 'mail' ][ 'projectStatusUpdateSubject' ] ?: (Lang::translate('mail_project_status_update_subject', $this->extensionName) ?: 'Project status update'))
            ->setBody($this->getStandAloneTemplate(
                CoreUtility\ExtensionManagementUtility::siteRelPath(CoreUtility\GeneralUtility::camelCaseToLowerCaseUnderscored($this->extensionName)) . 'Resources/Private/Templates/Email/ProjectStatusUpdated.html',
                [
                    'settings' => $this->settings,
                    'project'  => $project,
                    'accepted' => $isAccepted
                ]
            ))
            ->send();
    }

    /**
     * manuallySetProjectArgument action.
     * Needed since working with hidden records displayed too, but handling them is not supported by the core! Our
     * repository does this job.
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidArgumentNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function manuallySetProjectArgument()
    {
        if (!$this->request->getArgument('project') instanceof Model\Project) {
            if (CoreUtility\MathUtility::canBeInterpretedAsInteger($this->request->getArgument('project'))) {
                $this->request->setArgument('project', $this->projectRepository->findByUid($this->request->getArgument('project')));
            } elseif (is_array($this->request->getArgument('project')) && array_key_exists('__identity', $this->request->getArgument('project'))) {
                /** @var \S3b0\ProjectRegistration\Domain\Model\Project $project */
                $project = $this->projectRepository->findByUid($this->request->getArgument('project')[ '__identity' ]);
                foreach ((array)$this->request->getArgument('project') as $property => $propertyValue) {
                    if ($project->_hasProperty($property)) {
                        $project->_setProperty($property, $propertyValue);
                    }
                }
                $this->request->setArgument('project', $project);
            }
        }
    }

    /**
     * @param bool $returnMails     If set, mails will be returned, pre-formatted for use with
     *                              \TYPO3\CMS\Core\Mail\MailMessage
     * @param int  $returnArrayItem If set, a single array item will be returned
     * @param bool $includeInactive
     * @param bool $useShortName
     *
     * @return array|string
     */
    private function getAddressees(
        $returnMails = false,
        $returnArrayItem = null,
        $includeInactive = true,
        $useShortName = false
    ) {
        $return = [];

        if (is_array($this->settings[ 'addressees' ][ 'data' ]) && sizeof($this->settings[ 'addressees' ][ 'data' ])) {
            foreach ($this->settings[ 'addressees' ][ 'data' ] as $k => $addressee) {
                if ($includeInactive === false && $addressee[ 'inactive' ]) {
                    continue;
                }
                if (($label = Lang::translate($addressee[ 'label' ], $this->extensionName)) && CoreUtility\GeneralUtility::validEmail($addressee[ 'mail' ])
                ) {
                    $shortName = Lang::translate($addressee[ 'shortName' ], $this->extensionName) ?: $label;
                    $return[ $k ] = $returnMails ? ($addressee[ 'name' ] ? [$addressee[ 'mail' ] => $addressee[ 'name' ]] : [$addressee[ 'mail' ]]) : ($useShortName ? $shortName : $label);
                }
            }
        }

        if (is_integer($returnArrayItem) && array_key_exists($returnArrayItem, $return)) {
            return $return[ $returnArrayItem ];
        } else {
            return $return;
        }
    }

    /**
     * @param string $templateFile template name (UpperCamelCase)
     * @param mixed  $data         variables to be passed to the Fluid view
     *
     * @return string
     */
    protected function getStandAloneTemplate($templateFile, $data)
    {
        /** @var \TYPO3\CMS\Fluid\View\StandaloneView $view */
        $view = $this->objectManager->get(\TYPO3\CMS\Fluid\View\StandaloneView::class);

        $templatePathAndFilename = $templateFile;
        $view->setTemplatePathAndFilename($templatePathAndFilename);
        $view->setControllerContext($this->controllerContext);
        $view->assign('data', $data);
        $view->setFormat('html');

        return \Ecom\EcomToolbox\Utility\Div::sanitize_output($view->render());
    }

}