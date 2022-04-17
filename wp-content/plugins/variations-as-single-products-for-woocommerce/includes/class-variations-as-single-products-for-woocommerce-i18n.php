<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://procomsoftsol.com
 * @since      1.0.0
 *
 * @package    Variations_As_Single_Products_For_Woocommerce
 * @subpackage Variations_As_Single_Products_For_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Variations_As_Single_Products_For_Woocommerce
 * @subpackage Variations_As_Single_Products_For_Woocommerce/includes
 */
class Variations_As_Single_Products_For_Woocommerce_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'variations-as-single-products-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
