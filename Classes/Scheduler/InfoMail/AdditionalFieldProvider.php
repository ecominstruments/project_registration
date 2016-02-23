<?php
namespace S3b0\ProjectRegistration\Scheduler\InfoMail;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Class AdditionalFieldProvider
 */
class AdditionalFieldProvider implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface
{

    /**
     * @param array                                                     $taskInfo
     * @param \TYPO3\CMS\Scheduler\Task\AbstractTask                    $task
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject
     *
     * @return array
     */
    public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {
        /** @var \S3b0\ProjectRegistration\Scheduler\InfoMail\Task $task */
        return [
            'daysLeft' => [
                 'code' => '<input type="text"
                                   id="tx_scheduler_days_left"
                                   class="form-control"
                                   name="tx_scheduler[daysLeft]"
                                   value="' . ($task instanceof \S3b0\ProjectRegistration\Scheduler\InfoMail\Task ? $task->getDaysLeft() : 30) . '" />',
                 'label' => 'Days left',
                 'cshKey' => '',
                 'cshLabel' => 'Amount of days left until project gets state \'outdated\', instantly inform admin!'
             ],
            'daysValid' => [
                 'code' => '<input type="text"
                                   id="tx_scheduler_days_to_outdated"
                                   class="form-control"
                                   name="tx_scheduler[daysValid]"
                                   value="' . ($task instanceof \S3b0\ProjectRegistration\Scheduler\InfoMail\Task ? $task->getDaysValid() : 365) . '" />',
                 'label' => 'Days to outdated',
                 'cshKey' => '',
                 'cshLabel' => 'Amount of days to be gone until project gets state \'outdated\''
             ],
            'senderAddress' => [
                 'code' => '<input type="email"
                                   id="tx_scheduler_sender_address"
                                   class="form-control"
                                   name="tx_scheduler[senderAddress]"
                                   value="' . ($task instanceof \S3b0\ProjectRegistration\Scheduler\InfoMail\Task ? $task->getSenderAddress() : 'noreply@ecom-ex.com') . '" />',
                 'label' => 'Sender email',
                 'cshKey' => '',
                 'cshLabel' => ''
             ],
            'receiverAddress' => [
                 'code' => '<input type="email"
                                   id="tx_scheduler_receiver_address"
                                   class="form-control"
                                   name="tx_scheduler[receiverAddress]"
                                   value="' . ($task instanceof \S3b0\ProjectRegistration\Scheduler\InfoMail\Task ? $task->getReceiverAddress() : '@ecom-ex.com') . '" />',
                 'label' => 'Receiver email',
                 'cshKey' => '',
                 'cshLabel' => ''
             ]
        ];
    }

    /**
     * @param array                                                     $submittedData
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject
     *
     * @return bool
     */
    public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {
        return MathUtility::canBeInterpretedAsInteger($submittedData['daysLeft']) && MathUtility::canBeInterpretedAsInteger($submittedData['daysValid']) && GeneralUtility::validEmail($submittedData['senderAddress']) && GeneralUtility::validEmail($submittedData['receiverAddress']);
    }

    /**
     * @param array                                  $submittedData
     * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task
     */
    public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task) {
        /** @var \S3b0\ProjectRegistration\Scheduler\InfoMail\Task $task */
        $task->setDaysLeft($submittedData['daysLeft']);
        $task->setDaysValid($submittedData['daysValid']);
        $task->setSenderAddress($submittedData['senderAddress']);
        $task->setReceiverAddress($submittedData['receiverAddress']);
    }
}