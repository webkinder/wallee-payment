<?php
if (!defined('ABSPATH')) {
	exit(); // Exit if accessed directly.
}
/**
 * Provider of label descriptor information from the gateway.
 */
class WC_Wallee_Provider_Label_Descriptor extends WC_Wallee_Provider_Abstract {

	protected function __construct(){
		parent::__construct('wc_wallee_label_descriptor');
	}

	/**
	 * Returns the label descriptor by the given code.
	 *
	 * @param int $id
	 * @return \Wallee\Sdk\Model\LabelDescriptor
	 */
	public function find($id){
		return parent::find($id);
	}

	/**
	 * Returns a list of label descriptors.
	 *
	 * @return \Wallee\Sdk\Model\LabelDescriptor[]
	 */
	public function get_all(){
		return parent::get_all();
	}

	protected function fetch_data(){
		$label_descriptor_service = new \Wallee\Sdk\Service\LabelDescriptorService(WC_Wallee_Helper::instance()->get_api_client());
		return $label_descriptor_service->all();
	}

	protected function get_id($entry){
		/* @var \Wallee\Sdk\Model\LabelDescriptor $entry */
		return $entry->getId();
	}
}