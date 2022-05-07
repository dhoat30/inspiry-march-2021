<?php
/**
 * Plugin Name: WooCommerce Tree Table Rate Shipping
 * Description: Ultimate shipping plugin for WooCommerce
 * Version: 1.27.4
 * Author: tablerateshipping.com
 * Plugin URI: https://tablerateshipping.com
 * Author URI: https://tablerateshipping.com
 * Requires PHP: 7.1
 * Requires at least: 4.0
 * Tested up to: 5.9
 * WC requires at least: 3.2
 * WC tested up to: 6.4
 */

define('TRS_ENTRY_FILE', __FILE__);

if (!class_exists('TrsVendors_DgmWpPluginBootstrapGuard', false)) {
    require_once(__DIR__ .'/vendor/dangoodman/wp-plugin-bootstrap-guard/DgmWpPluginBootstrapGuard.php');
}

TrsVendors_DgmWpPluginBootstrapGuard::checkPrerequisitesAndBootstrap(
    'Tree Table Rate Shipping', '7.1', '4.0', '3.2', __DIR__ .'/bootstrap.php');
