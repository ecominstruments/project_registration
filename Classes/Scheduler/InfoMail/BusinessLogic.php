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


namespace S3b0\ProjectRegistration\Scheduler\InfoMail;


class BusinessLogic
{

    /**
     * @var string
     */
    protected $extensionName = 'project_registration';

    /**
     * @var \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected $databaseConnection;

    /**
     * @param \S3b0\ProjectRegistration\Scheduler\InfoMail\Task $task
     *
     * @return bool
     */
    public function run(\S3b0\ProjectRegistration\Scheduler\InfoMail\Task $task)
    {
        $upperLimit = new \DateTime();
        $lowerLimit = new \DateTime();
        $daysLeft   = $task->getDaysLeft();
        $daysValid  = $task->getDaysValid();
        $sender     = [ $task->getSenderAddress() ];
        $receiver   = [ $task->getReceiverAddress() ];
        $subject    = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('infomail.subject', $this->extensionName);

        $this->databaseConnection = $GLOBALS['TYPO3_DB'];
        $upperLimit->setTimestamp($upperLimit->getTimestamp() - ($daysValid * 86400) + ($daysLeft * 86400));
        $lowerLimit->setTimestamp($lowerLimit->getTimestamp() - ($daysValid * 86400) + ($daysLeft * 86400) - $task->getExecution()->getInterval());

        $where = "date_of_request < '{$upperLimit->format('Y-m-d h:i:s')}' AND date_of_request > '{$lowerLimit->format('Y-m-d h:i:s')}'";
        if ($this->databaseConnection->exec_SELECTcountRows('*', 'tx_projectregistration_domain_model_project', $where)) {
            $outdatedProjects = $this->databaseConnection->exec_SELECTgetRows(
                'project.*, registrant.name as registrant_name, registrant.company as registrant_company',
                'tx_projectregistration_domain_model_project as project join tx_projectregistration_domain_model_person as registrant on project.registrant=registrant.uid',
                $where);

            $list = [ ];
            /** @var array $outdatedProject */
            foreach ($outdatedProjects as $outdatedProject) {
                $list[] = "#{$outdatedProject['uid']} - '{$outdatedProject['title']}' by {$outdatedProject['registrant_name']} ({$outdatedProject['registrant_company']})";
            }

            $mailContent = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'infomail.message',
                $this->extensionName,
                [
                    $daysLeft,
                    '<li>' . implode('</li><li>', $list) . '</li>'
                ]
            );

            /** @var \TYPO3\CMS\Core\Mail\MailMessage $mail */
            $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $mail->setContentType('text/html');

            /**
             * Email to sender
             */
            $mail->setFrom($sender)
                ->setTo($receiver)
                ->setPriority(1)
                ->setSubject($subject)
                ->setBody($mailContent)
                ->send();
        }
        /*debug($upperLimit);*/
        /*debug($lowerLimit);*/
        /*debug($outdatedProjects);*/
        /*debug($task->getExecution()->getInterval());*/

        return true;
    }

}