<?php
/**
 * The plugin bootstrap file
 *
 * @link              http://procomsoftsol.com
 * @since             1.0.0
 * @package           Variations_As_Single_Products_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Variations as single products for WooCommerce
 * Plugin URI:        http://procomsoftsol.com
 * Description:       This plugin makes your product variations available as single products in shop, category & search result pages.
 * Version:           1.0.2
 * Author:            Procom
 * Author URI:        http://procomsoftsol.com
 * Developer:         Procom
 * Developer URI:     https://www.procomsoftsol.com
 * Text Domain:       variations-as-single-products-for-woocommerce
 * Domain Path:       /languages
 * Requires at least: 4.6
 * Tested up to: 5.9
 * WC requires at least: 4.0.0
 * WC tested up to:   6.2
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Woo: 8469860:efb04e513b599d8a319810b5edd48819
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'VARIATIONS_AS_SINGLE_PRODUCTS_FOR_WOOCOMMERCE_VERSION', '1.0.1' );

/**
* Define plugin file.
*/
if ( ! defined( 'VARIATIONS_AS_SINGLE_PRODUCTS_FOR_WOOCOMMERCE_FILE' ) ) {
	define( 'VARIATIONS_AS_SINGLE_PRODUCTS_FOR_WOOCOMMERCE_FILE', __FILE__ );
}

/**
* Defaine plugin base name
*/
if ( ! defined( 'VARIATIONS_AS_SINGLE_PRODUCTS_FOR_WOOCOMMERCE_BASENAME' ) ) {
	define( 'VARIATIONS_AS_SINGLE_PRODUCTS_FOR_WOOCOMMERCE_BASENAME', plugin_basename( VARIATIONS_AS_SINGLE_PRODUCTS_FOR_WOOCOMMERCE_FILE ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-variations-as-single-products-for-woocommerce-activator.php
 */
function activate_variations_as_single_products_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-variations-as-single-products-for-woocommerce-activator.php';
	Variations_As_Single_Products_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-variations-as-single-products-for-woocommerce-deactivator.php
 */
function deactivate_variations_as_single_products_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-variations-as-single-products-for-woocommerce-deactivator.php';
	Variations_As_Single_Products_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_variations_as_single_products_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_variations_as_single_products_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-variations-as-single-products-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_variations_as_single_products_for_woocommerce() {

	$plugin = new Variations_As_Single_Products_For_Woocommerce();
	$plugin->run();

}

/**
* Check if WooCommerce is active
*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	run_variations_as_single_products_for_woocommerce();
} else {
	add_action( 'admin_notices', 'variations_as_single_products_for_woocommerce_installed_notice' );
}

/**
 * Display Woocommerce Activation notice.
 */
function variations_as_single_products_for_woocommerce_installed_notice() {     ?>
	<div class="error">
	  <p><?php echo esc_html__( 'Variations as single products for WooCommerce requires the WooCommerce. Please install or activate woocommere', 'variations-as-single-products-for-woocommerce' ); ?></p>
	</div>
	<?php
}
