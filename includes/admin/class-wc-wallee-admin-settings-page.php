<?php
if (!defined('ABSPATH')) {
	exit();
}

/**
 * Adds Wallee settings to WooCommerce Settings Tabs
 */
class WC_Wallee_Admin_Settings_Page extends WC_Settings_Page {

	/**
	 * Adds Hooks to output and save settings
	 */
	public function __construct(){
		$this->id = 'wallee';
		$this->label = __('Wallee', 'woocommerce-wallee');
		
		add_filter('woocommerce_settings_tabs_array', array(
			$this,
			'add_settings_page' 
		), 20);
		add_action('woocommerce_settings_' . $this->id, array(
			$this,
			'settings_tab' 
		));
		add_action('woocommerce_update_options_' . $this->id, array(
			$this,
			'update_settings' 
		));
		//add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
	}

	public function add_settings_tab($settings_tabs){
		$settings_tabs[$this->id] = __('Wallee', 'woocommerce-wallee');
		return $settings_tabs;
	}

	public function settings_tab(){
		woocommerce_admin_fields($this->get_settings());
	}

	public function update_settings(){
		woocommerce_update_options($this->get_settings());
		$user_id = get_option('wc_wallee_application_user_id');
		$user_key = get_option('wc_wallee_application_user_key');
		if (!empty($user_id) && !empty($user_key)) {
			try {
				do_action('wc_wallee_settings_changed');
			}
			catch (Exception $e) {
				WC_Admin_Settings::add_error(
						__('Could not fetch configuration from Wallee. Please check your credentials and try again.', 'woocommerce-wallee'));
			}
		}
		$this->delete_provider_transients();
	}
	
	private function delete_provider_transients(){
		$transients = array(
			'wc_wallee_currencies',
			'wc_wallee_label_descriptor_group',
			'wc_wallee_label_descriptor',
			'wc_wallee_languages',
			'wc_wallee_payment_connectors',
			'wc_wallee_payment_methods',
		);
		foreach($transients as $transient){
			delete_transient($transient);
		}
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings(){
		$settings = array(
			
			array(
				'title' => __('General', 'woocommerce-wallee'),
				'desc' => sprintf(
						__('To use this extension, a wallee account is required. Sign up on <a href="%s" target="_blank">wallee.com</a>.', 
								'woocommerce-wallee'), 'https://app-wallee.com/user/signup'),
				'type' => 'title',
				'id' => 'general_options' 
			),
			
			array(
				'title' => __('Application User Id', 'woocommerce-wallee'),
				'desc' => __('The Application User needs to have full permissions in the space this shop is linked to.', 'woocommerce-wallee'),
				'id' => 'wc_wallee_application_user_id',
				'type' => 'text',
				'css' => 'min-width:300px;',
				'desc_tip' => true 
			),
			
			array(
				'title' => __('Application User Key', 'woocommerce-wallee'),
				'id' => 'wc_wallee_application_user_key',
				'type' => 'password',
				'css' => 'min-width:300px;' 
			),
			
			array(
				'title' => __('Space Id', 'woocommerce-wallee'),
				'id' => 'wc_wallee_space_id',
				'type' => 'text',
				'css' => 'min-width:300px;' 
			),
			
			array(
				'title' => __('Space View Id', 'woocommerce-wallee'),
				'id' => 'wc_wallee_space_view_id',
				'type' => 'text',
				'css' => 'min-width:300px;' 
			),
			
			array(
				'type' => 'sectionend',
				'id' => 'general_options' 
			),
			
			array(
				'title' => __('Email Options', 'woocommerce-wallee'),
				'type' => 'title',
				'id' => 'email_options' 
			),
			
			array(
				'title' => __('Send Order Email', 'woocommerce-wallee'),
				'desc' => __("Send the Woocommerce's order email.", 'woocommerce-wallee'),
				'id' => 'wc_wallee_shop_email',
				'type' => 'checkbox',
				'default' => 'yes',
				'css' => 'min-width:300px;' 
			),
			
			array(
				'type' => 'sectionend',
				'id' => 'email_options' 
			),
			
			array(
				'title' => __('Document Options', 'woocommerce-wallee'),
				'type' => 'title',
				'id' => 'document_options' 
			),
			
			array(
				'title' => __('Invoice Download', 'woocommerce-wallee'),
				'desc' => __("Allow customer's to download the invoice.", 'woocommerce-wallee'),
				'id' => 'wc_wallee_customer_invoice',
				'type' => 'checkbox',
				'default' => 'yes',
				'css' => 'min-width:300px;' 
			),
			array(
				'title' => __('Packing Slip Download', 'woocommerce-wallee'),
				'desc' => __("Allow customer's to download the packing slip.", 'woocommerce-wallee'),
				'id' => 'wc_wallee_customer_packing',
				'type' => 'checkbox',
				'default' => 'yes',
				'css' => 'min-width:300px;' 
			),
			
			array(
				'type' => 'sectionend',
				'id' => 'document_options' 
			) 
		
		);
		
		return apply_filters('wc_wallee_settings', $settings);
	}
}
