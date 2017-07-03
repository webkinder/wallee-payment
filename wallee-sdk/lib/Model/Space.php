<?php
/**
 * Wallee SDK
 *
 * This library allows to interact with the Wallee payment service.
 * Wallee SDK: 1.0.0
 * 
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Wallee\Sdk\Model;

use \Wallee\Sdk\ValidationException;

/**
 * Space model
 *
 * @category    Class
 * @description 
 * @package     Wallee\Sdk
 * @author      customweb GmbH
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link        https://github.com/wallee-payment/wallee-php-sdk
 */
class Space  {

	/**
	 * The original name of the model.
	 *
	 * @var string
	 */
	private static $swaggerModelName = 'Space';

	/**
	 * An array of property to type mappings. Used for (de)serialization.
	 *
	 * @var string[]
	 */
	private static $swaggerTypes = array(
		'account' => '\Wallee\Sdk\Model\Account',
		'active' => 'bool',
		'activeOrRestrictedActive' => 'bool',
		'database' => '\Wallee\Sdk\Model\TenantDatabase',
		'id' => 'int',
		'name' => 'string',
		'plannedPurgeDate' => '\DateTime',
		'postalAddress' => '\Wallee\Sdk\Model\SpaceAddress',
		'requestLimit' => 'int',
		'restrictedActive' => 'bool',
		'state' => 'string',
		'technicalContactAddresses' => 'string[]',
		'timeZone' => 'string',
		'version' => 'int'	);

	/**
	 * Returns an array of property to type mappings.
	 *
	 * @return string[]
	 */
	public static function swaggerTypes() {
		return self::$swaggerTypes;
	}

	
	/**
	 * Values of state.
	 */
	const STATE_CREATE = 'CREATE';
	const STATE_ACTIVE = 'ACTIVE';
	const STATE_INACTIVE = 'INACTIVE';
	const STATE_DELETING = 'DELETING';
	const STATE_DELETED = 'DELETED';
	
	/**
	 * Returns allowable values of state.
	 *
	 * @return string[]
	 */
	public function getStateAllowableValues() {
		return array(
			self::STATE_CREATE,
			self::STATE_ACTIVE,
			self::STATE_INACTIVE,
			self::STATE_DELETING,
			self::STATE_DELETED,
		);
	}
	

	/**
	 * @var \Wallee\Sdk\Model\Account
	 */
	private $account;

	/**
	 * Active means that this account and all accounts in the hierarchy are active.
	 *
	 * @var bool
	 */
	private $active;

	/**
	 * This property is true when all accounts in the hierarchy are active or restricted active.
	 *
	 * @var bool
	 */
	private $activeOrRestrictedActive;

	/**
	 * @var \Wallee\Sdk\Model\TenantDatabase
	 */
	private $database;

	/**
	 * The ID is the primary key of the entity. The ID identifies the entity uniquely.
	 *
	 * @var int
	 */
	private $id;

	/**
	 * The space name is used internally to identify the space in administrative interfaces. For example it is used within search fields and hence it should be distinct and descriptive.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * The planned purge date indicates when the entity is permanently removed. When the date is null the entity is not planned to be removed.
	 *
	 * @var \DateTime
	 */
	private $plannedPurgeDate;

	/**
	 * @var \Wallee\Sdk\Model\SpaceAddress
	 */
	private $postalAddress;

	/**
	 * The request limit defines the maximum number of API request accepted within 2 minutes per cluster node. This limit can only be changed with special privileges.
	 *
	 * @var int
	 */
	private $requestLimit;

	/**
	 * Restricted active means that at least one account in the hierarchy is only restricted active, but all are either restricted active or active.
	 *
	 * @var bool
	 */
	private $restrictedActive;

	/**
	 * 
	 *
	 * @var string
	 */
	private $state;

	/**
	 * The email address provided as contact addresses will be informed about technical issues or errors triggered by the space.
	 *
	 * @var string[]
	 */
	private $technicalContactAddresses;

	/**
	 * The time zone assigned to the space determines the time offset for calculating dates within the space. This is typically used for background processed which needs to be triggered on a specific hour within the day. Changing the space time zone will not change the display of dates.
	 *
	 * @var string
	 */
	private $timeZone;

	/**
	 * The version number indicates the version of the entity. The version is incremented whenever the entity is changed.
	 *
	 * @var int
	 */
	private $version;


	/**
	 * Constructor.
	 *
	 * @param mixed[] $data an associated array of property values initializing the model
	 */
	public function __construct(array $data = null) {
		if (isset($data['account']) && $data['account'] != null) {
			$this->setAccount($data['account']);
		}
		if (isset($data['database']) && $data['database'] != null) {
			$this->setDatabase($data['database']);
		}
		if (isset($data['id']) && $data['id'] != null) {
			$this->setId($data['id']);
		}
		if (isset($data['postalAddress']) && $data['postalAddress'] != null) {
			$this->setPostalAddress($data['postalAddress']);
		}
		if (isset($data['technicalContactAddresses']) && $data['technicalContactAddresses'] != null) {
			$this->setTechnicalContactAddresses($data['technicalContactAddresses']);
		}
		if (isset($data['version']) && $data['version'] != null) {
			$this->setVersion($data['version']);
		}
	}


	/**
	 * Returns account.
	 *
	 * @return \Wallee\Sdk\Model\Account
	 */
	public function getAccount() {
		return $this->account;
	}

	/**
	 * Sets account.
	 *
	 * @param \Wallee\Sdk\Model\Account $account
	 * @return Space
	 */
	public function setAccount($account) {
		$this->account = $account;

		return $this;
	}

	/**
	 * Returns active.
	 *
	 * Active means that this account and all accounts in the hierarchy are active.
	 *
	 * @return bool
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * Sets active.
	 *
	 * @param bool $active
	 * @return Space
	 */
	protected function setActive($active) {
		$this->active = $active;

		return $this;
	}

	/**
	 * Returns activeOrRestrictedActive.
	 *
	 * This property is true when all accounts in the hierarchy are active or restricted active.
	 *
	 * @return bool
	 */
	public function getActiveOrRestrictedActive() {
		return $this->activeOrRestrictedActive;
	}

	/**
	 * Sets activeOrRestrictedActive.
	 *
	 * @param bool $activeOrRestrictedActive
	 * @return Space
	 */
	protected function setActiveOrRestrictedActive($activeOrRestrictedActive) {
		$this->activeOrRestrictedActive = $activeOrRestrictedActive;

		return $this;
	}

	/**
	 * Returns database.
	 *
	 * @return \Wallee\Sdk\Model\TenantDatabase
	 */
	public function getDatabase() {
		return $this->database;
	}

	/**
	 * Sets database.
	 *
	 * @param \Wallee\Sdk\Model\TenantDatabase $database
	 * @return Space
	 */
	public function setDatabase($database) {
		$this->database = $database;

		return $this;
	}

	/**
	 * Returns id.
	 *
	 * The ID is the primary key of the entity. The ID identifies the entity uniquely.
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Sets id.
	 *
	 * @param int $id
	 * @return Space
	 */
	public function setId($id) {
		$this->id = $id;

		return $this;
	}

	/**
	 * Returns name.
	 *
	 * The space name is used internally to identify the space in administrative interfaces. For example it is used within search fields and hence it should be distinct and descriptive.
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets name.
	 *
	 * @param string $name
	 * @return Space
	 */
	protected function setName($name) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Returns plannedPurgeDate.
	 *
	 * The planned purge date indicates when the entity is permanently removed. When the date is null the entity is not planned to be removed.
	 *
	 * @return \DateTime
	 */
	public function getPlannedPurgeDate() {
		return $this->plannedPurgeDate;
	}

	/**
	 * Sets plannedPurgeDate.
	 *
	 * @param \DateTime $plannedPurgeDate
	 * @return Space
	 */
	protected function setPlannedPurgeDate($plannedPurgeDate) {
		$this->plannedPurgeDate = $plannedPurgeDate;

		return $this;
	}

	/**
	 * Returns postalAddress.
	 *
	 * @return \Wallee\Sdk\Model\SpaceAddress
	 */
	public function getPostalAddress() {
		return $this->postalAddress;
	}

	/**
	 * Sets postalAddress.
	 *
	 * @param \Wallee\Sdk\Model\SpaceAddress $postalAddress
	 * @return Space
	 */
	public function setPostalAddress($postalAddress) {
		$this->postalAddress = $postalAddress;

		return $this;
	}

	/**
	 * Returns requestLimit.
	 *
	 * The request limit defines the maximum number of API request accepted within 2 minutes per cluster node. This limit can only be changed with special privileges.
	 *
	 * @return int
	 */
	public function getRequestLimit() {
		return $this->requestLimit;
	}

	/**
	 * Sets requestLimit.
	 *
	 * @param int $requestLimit
	 * @return Space
	 */
	protected function setRequestLimit($requestLimit) {
		$this->requestLimit = $requestLimit;

		return $this;
	}

	/**
	 * Returns restrictedActive.
	 *
	 * Restricted active means that at least one account in the hierarchy is only restricted active, but all are either restricted active or active.
	 *
	 * @return bool
	 */
	public function getRestrictedActive() {
		return $this->restrictedActive;
	}

	/**
	 * Sets restrictedActive.
	 *
	 * @param bool $restrictedActive
	 * @return Space
	 */
	protected function setRestrictedActive($restrictedActive) {
		$this->restrictedActive = $restrictedActive;

		return $this;
	}

	/**
	 * Returns state.
	 *
	 * 
	 *
	 * @return string
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * Sets state.
	 *
	 * @param string $state
	 * @return Space
	 */
	protected function setState($state) {
		$allowed_values = array('CREATE', 'ACTIVE', 'INACTIVE', 'DELETING', 'DELETED');
		if (!is_null($state) && (!in_array($state, $allowed_values))) {
			throw new \InvalidArgumentException("Invalid value for 'state', must be one of 'CREATE', 'ACTIVE', 'INACTIVE', 'DELETING', 'DELETED'");
		}
		$this->state = $state;

		return $this;
	}

	/**
	 * Returns technicalContactAddresses.
	 *
	 * The email address provided as contact addresses will be informed about technical issues or errors triggered by the space.
	 *
	 * @return string[]
	 */
	public function getTechnicalContactAddresses() {
		return $this->technicalContactAddresses;
	}

	/**
	 * Sets technicalContactAddresses.
	 *
	 * @param string[] $technicalContactAddresses
	 * @return Space
	 */
	public function setTechnicalContactAddresses($technicalContactAddresses) {
		$this->technicalContactAddresses = $technicalContactAddresses;

		return $this;
	}

	/**
	 * Returns timeZone.
	 *
	 * The time zone assigned to the space determines the time offset for calculating dates within the space. This is typically used for background processed which needs to be triggered on a specific hour within the day. Changing the space time zone will not change the display of dates.
	 *
	 * @return string
	 */
	public function getTimeZone() {
		return $this->timeZone;
	}

	/**
	 * Sets timeZone.
	 *
	 * @param string $timeZone
	 * @return Space
	 */
	protected function setTimeZone($timeZone) {
		$this->timeZone = $timeZone;

		return $this;
	}

	/**
	 * Returns version.
	 *
	 * The version number indicates the version of the entity. The version is incremented whenever the entity is changed.
	 *
	 * @return int
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * Sets version.
	 *
	 * @param int $version
	 * @return Space
	 */
	public function setVersion($version) {
		$this->version = $version;

		return $this;
	}

	/**
	 * Validates the model's properties and throws a ValidationException if the validation fails.
	 *
	 * @throws ValidationException
	 */
	public function validate() {

		$allowed_values = array("CREATE", "ACTIVE", "INACTIVE", "DELETING", "DELETED");
		if (!in_array($this->getState(), $allowed_values)) {
			throw new ValidationException("invalid value for 'state', must be one of #{allowed_values}.", 'state', $this);
		}

	}

	/**
	 * Returns true if all the properties in the model are valid.
	 *
	 * @return boolean
	 */
	public function isValid() {
		try {
			$this->validate();
			return true;
		} catch (ValidationException $e) {
			return false;
		}
	}

	/**
	 * Returns the string presentation of the object.
	 *
	 * @return string
	 */
	public function __toString() {
		if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
			return json_encode(\Wallee\Sdk\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
		}

		return json_encode(\Wallee\Sdk\ObjectSerializer::sanitizeForSerialization($this));
	}

}

