<?php
/**
 *
 * WC_Wallee_Admin_Settings_Page Class
 *
 * Wallee
 * This plugin will add support for all Wallee payments methods and connect the Wallee servers to your WooCommerce webshop (https://www.wallee.com).
 *
 * @category Class
 * @package  Wallee
 * @author   wallee AG (http://www.wallee.com/)
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Software License (ASL 2.0)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
/**
 * Class WC_Wallee_Admin_Settings_Page.
 *
 * @class WC_Wallee_Admin_Settings_Page
 */
/**
 * Adds Wallee settings to WooCommerce Settings Tabs
 */
class WC_Wallee_Admin_Settings_Page extends WC_Settings_Page {

	/**
	 * Adds Hooks to output and save settings
	 */
	public function __construct() {
		$this->id    = 'wallee';
		$this->label = 'wallee';

		add_filter(
			'woocommerce_settings_tabs_array',
			array(
				$this,
				'add_settings_page',
			),
			20
		);
		add_action(
			'woocommerce_settings_' . $this->id,
			array(
				$this,
				'settings_tab',
			)
		);
		add_action(
			'woocommerce_settings_save_' . $this->id,
			array(
				$this,
				'save',
			)
		);

		add_action(
			'woocommerce_update_options_' . $this->id,
			array(
				$this,
				'update_settings',
			)
		);

		add_action(
			'woocommerce_admin_field_wallee_links',
			array(
				$this,
				'output_links',
			)
		);
	}

	/**
	 * Add Settings Tab
	 *
	 * @param mixed $settings_tabs settings_tabs.
	 * @return mixed $settings_tabs
	 */
	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs[ $this->id ] = 'wallee';
		return $settings_tabs;
	}

	/**
	 * Settings Tab
	 *
	 * @return void
	 */
	public function settings_tab() {
		woocommerce_admin_fields( $this->get_settings() );
	}

	/**
	 * Save
	 *
	 * @return void
	 */
	public function save() {
		$settings = $this->get_settings();
		WC_Admin_Settings::save_fields( $settings );

	}

	/**
	 * Update Settings
	 *
	 * @return void
	 * @throws Exception Exception.
	 */
	public function update_settings() {
		WC_Wallee_Helper::instance()->reset_api_client();
		$user_id  = get_option( WooCommerce_Wallee::CK_APP_USER_ID );
		$user_key = get_option( WooCommerce_Wallee::CK_APP_USER_KEY );
		if ( ! ( empty( $user_id ) || empty( $user_key ) ) ) {
			$error_message = '';
			try {
				WC_Wallee_Service_Method_Configuration::instance()->synchronize();
			} catch ( \Exception $e ) {
				WooCommerce_Wallee::instance()->log( $e->getMessage(), WC_Log_Levels::ERROR );
				WooCommerce_Wallee::instance()->log( $e->getTraceAsString(), WC_Log_Levels::DEBUG );
				$error_message = __( 'Could not update payment method configuration.', 'woo-wallee' );
				WC_Admin_Settings::add_error( $error_message );
			}
			try {
				WC_Wallee_Service_Webhook::instance()->install();
			} catch ( \Exception $e ) {
				WooCommerce_Wallee::instance()->log( $e->getMessage(), WC_Log_Levels::ERROR );
				WooCommerce_Wallee::instance()->log( $e->getTraceAsString(), WC_Log_Levels::DEBUG );
				$error_message = __( 'Could not install webhooks, please check if the feature is active in your space.', 'woo-wallee' );
				WC_Admin_Settings::add_error( $error_message );
			}
			try {
				WC_Wallee_Service_Manual_Task::instance()->update();
			} catch ( \Exception $e ) {
				WooCommerce_Wallee::instance()->log( $e->getMessage(), WC_Log_Levels::ERROR );
				WooCommerce_Wallee::instance()->log( $e->getTraceAsString(), WC_Log_Levels::DEBUG );
				$error_message = __( 'Could not update the manual task list.', 'woo-wallee' );
				WC_Admin_Settings::add_error( $error_message );
			}
			try {
				do_action( 'wc_wallee_settings_changed' );
			} catch ( \Exception $e ) {
				WooCommerce_Wallee::instance()->log( $e->getMessage(), WC_Log_Levels::ERROR );
				WooCommerce_Wallee::instance()->log( $e->getTraceAsString(), WC_Log_Levels::DEBUG );
				$error_message = $e->getMessage();
				WC_Admin_Settings::add_error( $error_message );
			}

			if ( wc_tax_enabled() && ( 'yes' === get_option( 'woocommerce_tax_round_at_subtotal' ) ) ) {
				if ( 'yes' === get_option( WooCommerce_Wallee::CK_ENFORCE_CONSISTENCY ) ) {
					$error_message = __( "'WooCommerce > Settings > Wallee > Enforce Consistency' and 'WooCommerce > Settings > Tax > Rounding' are both enabled. Please disable at least one of them.", 'woo-wallee' );
					WC_Admin_Settings::add_error( $error_message );
					WooCommerce_Wallee::instance()->log( $error_message, WC_Log_Levels::ERROR );
				}
			}

			if ( ! empty( $error_message ) ) {
				$error_message = __( 'Please check your credentials and grant the application user the necessary rights (Account Admin) for your space.', 'woo-wallee' );
				WC_Admin_Settings::add_error( $error_message );
			}
			WC_Wallee_Helper::instance()->delete_provider_transients();
		}

	}

	/**
	 * Output Links
	 *
	 * @param mixed $value value.
	 * @return void
	 */
	public function output_links( $value ) {
		foreach ( $value['links'] as $url => $text ) {
			echo '<a href="' . esc_url( $url ) . '" class="page-title-action">' . esc_html( $text ) . '</a>';
		}
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {

		$settings = array(
			array(
				'links' => array(
					'https://plugin-documentation.wallee.com/wallee-payment/woocommerce/2.1.14/docs/en/documentation.html' => __( 'Documentation', 'woo-wallee' ),
					'https://app-wallee.com/user/signup' => __( 'Sign Up', 'woo-wallee' ),
				),
				'type'  => 'wallee_links',
			),

			array(
				'title' => __( 'General Settings', 'woo-wallee' ),
				'desc'  =>
					__(
						'Enter your application user credentials and space id, if you don\'t have an account already sign up above.',
						'woo-wallee'
					),
				'type'  => 'title',
				'id'    => 'general_options',
			),

			array(
				'title' => __( 'Space Id', 'woo-wallee' ),
				'id'    => WooCommerce_Wallee::CK_SPACE_ID,
				'type'  => 'text',
				'css'   => 'min-width:300px;',
				'desc'  => __( '(required)', 'woo-wallee' ),
			),

			array(
				'title'    => __( 'User Id', 'woo-wallee' ),
				'desc_tip' => __( 'The user needs to have full permissions in the space this shop is linked to.', 'woo-wallee' ),
				'id'       => WooCommerce_Wallee::CK_APP_USER_ID,
				'type'     => 'text',
				'css'      => 'min-width:300px;',
				'desc'     => __( '(required)', 'woo-wallee' ),
			),

			array(
				'title' => __( 'Authentication Key', 'woo-wallee' ),
				'id'    => WooCommerce_Wallee::CK_APP_USER_KEY,
				'type'  => 'password',
				'css'   => 'min-width:300px;',
				'desc'  => __( '(required)', 'woo-wallee' ),
			),

			array(
				'type' => 'sectionend',
				'id'   => 'general_options',
			),

			array(
				'title' => __( 'Email Options', 'woo-wallee' ),
				'type'  => 'title',
				'id'    => 'email_options',
			),

			array(
				'title'   => __( 'Send Order Email', 'woo-wallee' ),
				'desc'    => __( 'Send the order email of WooCommerce.', 'woo-wallee' ),
				'id'      => WooCommerce_Wallee::CK_SHOP_EMAIL,
				'type'    => 'checkbox',
				'default' => 'yes',
				'css'     => 'min-width:300px;',
			),

			array(
				'type' => 'sectionend',
				'id'   => 'email_options',
			),

			array(
				'title' => __( 'Document Options', 'woo-wallee' ),
				'type'  => 'title',
				'id'    => 'document_options',
			),

			array(
				'title'   => __( 'Invoice Download', 'woo-wallee' ),
				'desc'    => __( 'Allow customers to download the invoice.', 'woo-wallee' ),
				'id'      => WooCommerce_Wallee::CK_CUSTOMER_INVOICE,
				'type'    => 'checkbox',
				'default' => 'yes',
				'css'     => 'min-width:300px;',
			),
			array(
				'title'   => __( 'Packing Slip Download', 'woo-wallee' ),
				'desc'    => __( 'Allow customers to download the packing slip.', 'woo-wallee' ),
				'id'      => WooCommerce_Wallee::CK_CUSTOMER_PACKING,
				'type'    => 'checkbox',
				'default' => 'yes',
				'css'     => 'min-width:300px;',
			),

			array(
				'type' => 'sectionend',
				'id'   => 'document_options',
			),

			array(
				'title' => __( 'Space View Options', 'woo-wallee' ),
				'type'  => 'title',
				'id'    => 'space_view_options',
			),

			array(
				'title'    => __( 'Space View Id', 'woo-wallee' ),
				'desc_tip' => __( 'The Space View Id allows to control the styling of the payment form and the payment page within the space.', 'woo-wallee' ),
				'id'       => WooCommerce_Wallee::CK_SPACE_VIEW_ID,
				'type'     => 'number',
				'css'      => 'min-width:300px;',
			),

			array(
				'type' => 'sectionend',
				'id'   => 'space_view_options',
			),

			array(
				'title' => __( 'Integration Options', 'woo-wallee' ),
				'type'  => 'title',
				'id'    => 'integration_options',
			),

			array(
				'title'    => __( 'Integration Type', 'woo-wallee' ),
				'desc_tip' => __( 'The integration type controls how the payment form is integrated into the WooCommerce checkout. The Lightbox integration type offers better performance but with a less compelling checkout experience.', 'woo-wallee' ),
				'id'       => WooCommerce_Wallee::CK_INTEGRATION,
				'type'     => 'select',
				'css'      => 'min-width:300px;',
				'default'  => WC_Wallee_Integration::IFRAME,
				'options'  => array(
				    WC_Wallee_Integration::IFRAME => $this->format_display_string( __( 'iframe', 'woo-wallee' ) ),
				    WC_Wallee_Integration::LIGHTBOX  => $this->format_display_string( __( 'lightbox', 'woo-wallee' ) ),
				),
			),

			array(
				'type' => 'sectionend',
				'id'   => 'integration_options',
			),

			array(
				'title' => __( 'Line Items Options', 'woo-wallee' ),
				'type'  => 'title',
				'id'    => 'line_items_options',
			),

			array(
				'title'   => __( 'Enforce Consistency', 'woo-wallee' ),
				'desc'    => __( 'Require that the transaction line items total is matching the order total.', 'woo-wallee' ),
				'id'      => WooCommerce_Wallee::CK_ENFORCE_CONSISTENCY,
				'type'    => 'checkbox',
				'default' => 'yes',
				'css'     => 'min-width:300px;',
			),

			array(
				'type' => 'sectionend',
				'id'   => 'line_items_options',
			),

			array(
				'title' => __( 'Reference Options', 'woo-wallee' ),
				'type'  => 'title',
				'id'    => 'reference_options',
			),

			array(
				'title'    => __( 'Order Reference Type', 'woo-wallee' ),
				'desc_tip' => __( 'Choose which order reference is sent.', 'woo-wallee' ),
				'id'       => WooCommerce_Wallee::CK_ORDER_REFERENCE,
				'type'     => 'select',
				'css'      => 'min-width:300px;',
				'default'  => WC_Wallee_Order_Reference::ORDER_ID,
				'options'  => array(
				    WC_Wallee_Order_Reference::ORDER_ID => $this->format_display_string( __( 'order_id', 'woo-wallee' ) ),
				    WC_Wallee_Order_Reference::ORDER_NUMBER  => $this->format_display_string( __( 'order_number', 'woo-wallee' ) ),
				),
			),

			array(
				'type' => 'sectionend',
				'id'   => 'reference_options',
			),

		);

		return apply_filters( 'wc_wallee_settings', $settings );
	}

	/**
	 * Format Display String
	 *
	 * @param string $display_string display string.
	 * @return string
	 */
	private function format_display_string( $display_string ) {
		return ucwords( str_replace( '_', ' ', $display_string ) );
	}
}
