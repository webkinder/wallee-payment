<?php 
if (!defined('ABSPATH')) {
	exit(); // Exit if accessed directly.
}
/**
 * wallee WooCommerce
 *
 * This WooCommerce plugin enables to process payments with wallee (https://www.wallee.com).
 *
 * @author customweb GmbH (http://www.customweb.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License (ASL 2.0)
 */
?>
<div class="error notice notice-error">
	<p><?php _e( 'The wallee payment method are not available, if the taxes are rounded at subtotal level. Please disable the \'Round tax at subtotal level, instead of rounding per line\' in the tax settings to enable the wallee payment methods.', 'woo-wallee' ); ?></p>
</div>