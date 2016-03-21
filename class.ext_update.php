<?php
/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Messaging\FlashMessage;

/**
 * Update class for the extension manager.
 *
 * @package    TYPO3
 * @subpackage project_registration
 */
class ext_update
{

    /**
     * @var integer
     */
    protected $defaultExpiry = 365;

    /**
     * @var string
     */
    protected $feedback = '';

    /**
     * @var \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected $databaseConnection;

    /**
     * @var string
     */
    protected $transferTable = 'tx_projectregistration_domain_model_project_transfer';

    /**
     * @var string The message severity class names
     */
    protected $classes = [
        FlashMessage::NOTICE  => 'notice',
        FlashMessage::INFO    => 'info',
        FlashMessage::OK      => 'success',
        FlashMessage::WARNING => 'warning',
        FlashMessage::ERROR   => 'danger'
    ];

    /**
     * @var string The message severity icon names
     */
    protected $icons = [
        FlashMessage::NOTICE  => 'lightbulb-o',
        FlashMessage::INFO    => 'info',
        FlashMessage::OK      => 'check',
        FlashMessage::WARNING => 'exclamation',
        FlashMessage::ERROR   => 'times'
    ];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->databaseConnection = $GLOBALS[ 'TYPO3_DB' ];
    }

    /**
     * Main update function called by the extension manager.
     *
     * @return string
     */
    public function main()
    {
        $this->processUpdates();
        return $this->feedback ?: $this->renderFlashMessage('', 'No update necessary.', FlashMessage::INFO);
    }

    /**
     * Called by the extension manager to determine if the update menu entry
     * should by showed.
     *
     * @return bool
     */
    public function access()
    {
        return array_key_exists($this->transferTable, $this->databaseConnection->admin_get_tables());
    }

    /**
     * The actual update function. Add your update task in here.
     *
     * @return void
     */
    protected function processUpdates()
    {
        // Do the magic!
        $transferData = $this->databaseConnection->exec_SELECTgetRows('*', $this->transferTable, '1=1');

        if ($transferData && sizeof($transferData)) {
            $this->truncateTables();
            $this->addInitialStaticData();
            $this->transferData($transferData);
        }
    }

    /**
     * Truncate tables before data transfer
     *
     * @return void
     */
    private function truncateTables()
    {
        $this->databaseConnection->exec_TRUNCATEquery('tx_projectregistration_domain_model_person');
        $this->databaseConnection->exec_TRUNCATEquery('tx_projectregistration_domain_model_product');
        $this->databaseConnection->exec_TRUNCATEquery('tx_projectregistration_domain_model_productproperty');
        $this->databaseConnection->exec_TRUNCATEquery('tx_projectregistration_domain_model_productpropertyvalue');
        $this->databaseConnection->exec_TRUNCATEquery('tx_projectregistration_domain_model_project');
        $this->databaseConnection->exec_TRUNCATEquery('tx_projectregistration_product_property_mm');
        $this->feedback .= $this->renderFlashMessage('Truncated extension tables.', 'Tables truncated', FlashMessage::WARNING);
    }

    /**
     * @param array $data
     */
    private function transferData(array $data)
    {
        $uidPersons = 1;
        foreach ($data as $row) {
            /**
             * Add registrant to person model
             */
            $registrant = $this->addRegistrant($row, $uidPersons);
            if ($registrant === $uidPersons) {
                $uidPersons++;
            }
            /**
             * Add end user to Person model
             */
            $endUser = $this->addEndUser($row, $uidPersons);
            if ($endUser === $uidPersons) {
                $uidPersons++;
            }
            /**
             * Get product / product property values
             * @var array<\S3b0\ProjectRegistration\Domain\Model\Product> $product
             */
            $product = $this->databaseConnection->exec_SELECTgetSingleRow(
                '*',
                'tx_projectregistration_domain_model_product',
                'title="' . $row['product_with_configuration'] . '"'
            );
            $propertyValues = '';
            if ($product['properties']) {
                $mmConnect = $this->databaseConnection->exec_SELECTgetSingleRow(
                    'uid_foreign',
                    'tx_projectregistration_product_property_mm',
                    'uid_local=' . $product['uid']
                );
                $property = $this->databaseConnection->exec_SELECTgetSingleRow(
                    '*',
                    'tx_projectregistration_domain_model_productproperty',
                    'uid=' . $mmConnect['uid_foreign']
                );
                switch ((int)$property['uid']) {
                    case 1:
                        $propertyValues = (int)$row['wwan'] === 1 ? 1 : 2;
                        break;
                    case 2:
                        $propertyValues = (int)$row['lte'] === 1 ? 3 : 4;
                        break;
                }
            }

            /**
             * Add former region, now addressee
             */
            $addressee = 0;
            switch ($row['region']) {
                case 'Americas':
                    $addressee = 10;
                    break;
                case 'EMEA':
                    $addressee = 20;
                    break;
                case 'APAC':
                    $addressee = 30;
                    break;
            }

            /**
             * Add project to database
             */
            $this->databaseConnection->exec_INSERTquery('tx_projectregistration_domain_model_project', [
                'uid' => $row['uid'],
                'pid' => $row['pid'],
                'title' => $row['title'],
                'date_of_request' => $row['date_of_request'],
                'date_of_expiry' => date("Y-m-d H:i:s", strtotime($row['date_of_request']) + ($this->defaultExpiry * 86400)),
                'application' => $row['application'],
                'quantity' => $row['quantity'],
                'estimated_purchase_date' => $row['estimated_rollout'],
                'registration_notes' => $row['notes'],
                'internal_note' => $row['internal_notes'],
                'denial_note' => $row['denial_notes'],
                'approved' => $row['approved'],
                'tstamp' => $row['tstamp'],
                'crdate' => $row['tstamp'],
                'deleted' => $row['deleted'],
                'hidden' => (int)!$row['approval_confirmed'],
                'addressee' => $addressee,
                'registrant' => abs((int)$registrant),
                'end_user' => abs((int)$endUser),
                'product' => abs((int)$product['uid']),
                'property_values' => $propertyValues
            ]);
        }

        // Update pid´s of static import tables according to last project record fetched.
        $this->databaseConnection->exec_UPDATEquery('tx_projectregistration_domain_model_product', '1=1', [ 'pid' => (int)$row['pid'] ]);
        $this->databaseConnection->exec_UPDATEquery('tx_projectregistration_domain_model_productproperty', '1=1', [ 'pid' => (int)$row['pid'] ]);
        $this->databaseConnection->exec_UPDATEquery('tx_projectregistration_domain_model_productpropertyvalue', '1=1', [ 'pid' => (int)$row['pid'] ]);

        $this->feedback .= $this->renderFlashMessage('Data has successfully transferred.', 'Data transferred!');
    }

    /**
     * Add end user record (if new) and return corresponding uid
     *
     * @param         $data
     * @param integer $uid
     *
     * @return integer
     */
    private function addEndUser($data, $uid = 1)
    {
        $endUser = [
            'name' => $data['end_user_name'] ?: '',
            'company' => $data['end_user_company'] ?: '',
            'email' => $data['end_user_email'] ?: '',
            'phone' => $data['end_user_phone'] ?: '',
            'city' => $data['end_user_location_city'] ?: '',
            'site' => $data['end_user_location_site'] ?: ''
        ];

        $checkForExistingRecord = $this->databaseConnection->exec_SELECTgetSingleRow(
            '*',
            'tx_projectregistration_domain_model_person',
            'name="' . $endUser['name'] . '" AND email="' . $endUser['email'] . '" AND company="' . $endUser['company'] . '" AND phone="' . $endUser['phone'] . '"'
        );

        if ($checkForExistingRecord) {
            return (int)$checkForExistingRecord['uid'];
        } else {
            $country = $this->databaseConnection->exec_SELECTgetSingleRow(
                '*',
                'tx_ecomtoolbox_domain_model_region',
                'title="' . $data['end_user_location_country'] . '"'
            );
            $endUser['country'] = $country ? $country['uid'] : 0;
            $state = $this->databaseConnection->exec_SELECTgetSingleRow(
                '*',
                'tx_ecomtoolbox_domain_model_state',
                'title="' . $data['end_user_location_state'] . '"'
            );
            $endUser['state']   = $state ? $state['uid'] : 0;
            $this->databaseConnection->exec_INSERTquery('tx_projectregistration_domain_model_person', $endUser);

            return $uid;
        }
    }

    /**
     * Add registrant record (if new) and return corresponding uid
     *
     * @param         $data
     * @param integer $uid
     *
     * @return integer
     */
    private function addRegistrant($data, $uid = 1)
    {
        if ((int)$data['registrant'] > 0 && $this->databaseConnection->exec_SELECTcountRows('*', 'fe_users', 'uid=' . (int)$data['registrant'])) {
            $registrant = $this->databaseConnection->exec_SELECTgetSingleRow('*', 'fe_users', 'uid=' . (int)$data['registrant']);
        } else {
            $registrant = [
                'name' => $data['registrant_name'],
                'company' => $data['registrant_company'],
                'email' => $data['registrant_email'],
                'telephone' => $data['registrant_phone']
            ];
        }

        $checkForExistingRecord = $this->databaseConnection->exec_SELECTgetSingleRow(
            '*',
            'tx_projectregistration_domain_model_person',
            'name="' . $registrant['name'] . '" AND email="' . $registrant['email'] . '" AND company="' . $registrant['company'] . '" AND phone="' . $registrant['telephone'] . '"'
        );

        if ($checkForExistingRecord) {
            return (int)$checkForExistingRecord['uid'];
        } else {
            $this->databaseConnection->exec_INSERTquery('tx_projectregistration_domain_model_person', [
                'username' => $registrant['username'] ?: '',
                'name' => $registrant['name'] ?: '',
                'first_name' => $registrant['first_name'] ?: '',
                'middle_name' => $registrant['middle_name'] ?: '',
                'last_name' => $registrant['last_name'] ?: '',
                'company' => $registrant['company'] ?: '',
                'address' => $registrant['address'] ?: '',
                'zip' => $registrant['zip'] ?: '',
                'city' => $registrant['city'] ?: '',
                'country' => abs((int)$registrant['ecom_toolbox_country']),
                'state' => abs((int)$registrant['ecom_toolbox_state']),
                'email' => $registrant['email'] ?: '',
                'phone' => $registrant['telephone'] ?: '',
                'fax' => $registrant['fax'] ?: '',
                'title' => $registrant['title'] ?: '',
                'www' => $registrant['www'] ?: '',
                'fe_user' => abs((int)$data['registrant'])
            ]);

            return $uid;
        }
    }

    /**
     * Add initial static data (standing: 2016-02-18)
     */
    private function addInitialStaticData()
    {
        /**
         * Import products static data
         */
        $this->databaseConnection->exec_INSERTmultipleRows(
            'tx_projectregistration_domain_model_product',
            [ 'uid', 'pid', 'title', 'properties', 'sorting', 'tstamp', 'crdate', 'cruser_id' ],
            [
                [1, 1, 'i.roc® Ci70 -Ex', 1, 512, 0, 0, 0],
                [2, 1, 'i.roc® Ci70 -Ex RFID LF', 1, 768, 0, 0, 0],
                [3, 1, 'i.roc® Ci70 -Ex RFID HF', 1, 1024, 0, 0, 0],
                [4, 1, 'i.roc® Ci70 -Ex RFID UHF US', 1, 1280, 0, 0, 0],
                [5, 1, 'i.roc® Ci70 -Ex RFID UHF', 1, 1536, 0, 0, 0],
                [6, 1, 'i.roc® Ci70 -Ex 1D Barcode', 1, 1792, 0, 0, 0],
                [7, 1, 'i.roc® Ci70 -Ex 2D EX25', 1, 2048, 0, 0, 0],
                [8, 1, 'i.roc® Ci70 -Ex Combi Reader LF/ 1D', 1, 2304, 0, 0, 0],
                [9, 1, 'i.roc® Ci70 -Ex Combi Reader HF/ 1D', 1, 2560, 0, 0, 0],
                [10, 1, 'Getac V100-Ex2, Standard', 0, 2816, 0, 0, 0],
                [11, 1, 'Getac V100-Ex2, Premium', 0, 3072, 0, 0, 0],
                [12, 1, 'Z710-Ex Basic', 0, 3328, 0, 0, 0],
                [13, 1, 'Z710-Ex Basic 1D/2D Barcode', 0, 3584, 0, 0, 0],
                [14, 1, 'Z710-Ex Basic HF RFID', 0, 3840, 0, 0, 0],
                [15, 1, 'Z710-Ex Basic 1D/2D + HF RFID', 0, 4096, 0, 0, 0],
                [16, 1, 'Z710-Ex Premium', 0, 4352, 0, 0, 0],
                [17, 1, 'Z710-Ex Premium 1D/2D', 0, 4608, 0, 0, 0],
                [18, 1, 'Z710-Ex Premium HF RFID', 0, 4864, 0, 0, 0],
                [19, 1, 'Z710-Ex Premium 1D/2D + HF RFID', 0, 5120, 0, 0, 0],
                [20, 1, 'CK70 ATEX', 0, 5376, 0, 0, 0],
                [21, 1, 'CK71 ATEX', 0, 5632, 0, 0, 0],
                [22, 1, 'CN70A ATEX', 0, 5888, 0, 0, 0],
                [23, 1, 'CN70E ATEX', 0, 6144, 0, 0, 0],
                [24, 1, 'Tab-Ex® Zone 1', 1, 6400, 0, 0, 0],
                [25, 1, 'Tab-Ex® Division 1', 1, 6656, 0, 0, 0],
                [26, 1, 'Tab-Ex® Zone 2', 1, 6912, 0, 0, 0],
                [27, 1, 'Tab-Ex® Division 2', 1, 7168, 0, 0, 0],
                [28, 1, 'Smart-Ex® 01 EU no camera', 0, 7424, 0, 0, 0],
                [29, 1, 'Smart-Ex® 01 EU camera', 0, 7680, 0, 0, 0],
                [30, 1, 'Smart-Ex® 01 US no camera', 0, 7936, 0, 0, 0],
                [31, 1, 'Smart-Ex® 01 US camera', 0, 8192, 0, 0, 0],
                [32, 1, 'Smart-Ex® 201 EU no camera', 0, 8448, 0, 0, 0],
                [33, 1, 'Smart-Ex® 201 EU camera', 0, 8704, 0, 0, 0],
                [34, 1, 'Smart-Ex® 201 US camera', 0, 8960, 0, 0, 0],
                [35, 1, 'Smart-Ex® 201 US no camera', 0, 9216, 0, 0, 0],
                [36, 1, 'Ex-Handy 09 Zone 1 EU', 0, 9472, 0, 0, 0],
                [37, 1, 'Ex-Handy 09 Div 1 US', 0, 9728, 0, 0, 0],
                [38, 1, 'Ex-Handy 209 EU', 0, 9984, 0, 0, 0],
                [39, 1, 'Ex-Handy 209 US', 0, 10240, 0, 0, 0],
                [40, 1, 'others', 0, 10496, 0, 0, 0]
            ]
        );
        $this->feedback .= $this->renderFlashMessage('Added static data to \'tx_projectregistration_domain_model_product\'', 'Static data imported!');

        /**
         * Import product properties static data
         */
        $this->databaseConnection->exec_INSERTmultipleRows(
            'tx_projectregistration_domain_model_productproperty',
            [ 'uid', 'pid', 'title', 'form_element_type', 'sorting', 'tstamp', 'crdate', 'cruser_id' ],
            [
                [1, 1, 'WWAN', 0, 0, 0, 0, 0],
                [2, 1, 'LTE', 0, 0, 0, 0, 0]
            ]
        );
        $this->feedback .= $this->renderFlashMessage('Added static data to \'tx_projectregistration_domain_model_productproperty\'', 'Static data imported!');

        /**
         * Import product property values static data
         */
        $this->databaseConnection->exec_INSERTmultipleRows(
            'tx_projectregistration_domain_model_productpropertyvalue',
            [ 'uid', 'pid', 'title', 'sorting', 'tstamp', 'crdate', 'cruser_id', 'property' ],
            [
                [1, 1, 'Yes', 0, 0, 0, 0, 1],
                [2, 1, 'No', 0, 0, 0, 0, 1],
                [3, 1, 'Yes', 0, 0, 0, 0, 2],
                [4, 1, 'No', 0, 0, 0, 0, 2]
            ]
        );
        $this->feedback .= $this->renderFlashMessage('Added static data to \'tx_projectregistration_domain_model_productpropertyvalue\'', 'Static data imported!');

        /**
         * Import product <> property MM-relations
         */
        $this->databaseConnection->exec_INSERTmultipleRows(
            'tx_projectregistration_product_property_mm',
            [ 'uid_local', 'uid_foreign', 'sorting', 'sorting_foreign' ],
            [
                [1, 1, 1, 0],
                [2, 1, 1, 0],
                [3, 1, 1, 0],
                [4, 1, 1, 0],
                [5, 1, 1, 0],
                [6, 1, 1, 0],
                [7, 1, 1, 0],
                [8, 1, 1, 0],
                [9, 1, 1, 0],
                [24, 2, 1, 0],
                [25, 2, 1, 0],
                [26, 2, 1, 0],
                [27, 2, 1, 0]
            ]
        );
        $this->feedback .= $this->renderFlashMessage('Added product <> property MM-relations to \'tx_projectregistration_product_property_mm\'', 'Static data imported!');
    }

    /**
     * @param        $message
     * @param string $title
     * @param int    $severity
     *
     * @return string
     */
    private function renderFlashMessage($message, $title = '', $severity = \TYPO3\CMS\Core\Messaging\FlashMessage::OK)
    {
        if ($title !== '') {
            $title = '<h4 class="alert-title">' . $title . '</h4>';
        }
        $message = '
			<div class="alert alert-' . $this->classes[ $severity ] . '">
				<div class="media">
					<div class="media-left">
						<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-' . $this->icons[ $severity ] . ' fa-stack-1x"></i>
						</span>
					</div>
					<div class="media-body">
						' . $title . '
						<div class="alert-message">' . $message . '</div>
					</div>
				</div>
			</div>';

        return $message;
    }

}
