<?php
/**
 *  Plugin Name: WPC Show Single Variations for WooCommerce
 *  Plugin URI: https://wpclever.net/
 *  Description: WPC Show Single Variations help you show all variations as single products on catalog pages (shop, category, tag, search).
 *  Version: 2.1.1
 *  Author: WPClever
 *  Author URI: https://wpclever.net
 *  Text Domain: wpc-show-single-variations
 *  Domain Path: /languages/
 *  Requires at least: 4.0
 *  Tested up to: 5.9
 *  WC requires at least: 3.0
 *  WC tested up to: 6.3
 **/

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPCleverWoosv' ) && class_exists( 'WC_Product' ) ) {
	class WPCleverWoosv {
		public function __construct() {
			$this->define_constants();
			$this->include_library();
			$this->admin_hooks();
			$this->public_hooks();
		}

		private function define_constants() {
			! defined( 'WOOSV_VERSION' ) && define( 'WOOSV_VERSION', '2.1.1' );
			! defined( 'WOOSV_URI' ) && define( 'WOOSV_URI', plugin_dir_url( __FILE__ ) );
			! defined( 'WOOSV_BASE' ) && define( 'WOOSV_BASE', plugin_basename( __FILE__ ) );
			! defined( 'WOOSV_REVIEWS' ) && define( 'WOOSV_REVIEWS', 'https://wordpress.org/support/plugin/wpc-show-single-variations/reviews/?filter=5' );
			! defined( 'WOOSV_CHANGELOG' ) && define( 'WOOSV_CHANGELOG', 'https://wordpress.org/plugins/wpc-show-single-variations/#developers' );
			! defined( 'WOOSV_DISCUSSION' ) && define( 'WOOSV_DISCUSSION', 'https://wordpress.org/support/plugin/wpc-show-single-variations' );
			! defined( 'WPC_URI' ) && define( 'WPC_URI', WOOSV_URI );
		}

		private function include_library() {
			require_once 'includes/wpc-dashboard.php';
			require_once 'includes/wpc-menu.php';
			require_once 'includes/wpc-kit.php';
			require_once 'includes/wpc-notice.php';
			require_once 'includes/class-admin.php';
			require_once 'includes/class-public.php';
		}

		private function admin_hooks() {
			$woosv_admin = new Woosv_Admin();
			add_action( 'admin_enqueue_scripts', array( $woosv_admin, 'admin_enqueue_scripts' ), 99 );
			add_action( 'admin_menu', array( $woosv_admin, 'admin_menu' ) );
			add_action( 'admin_init', array( $woosv_admin, 'register_settings' ) );
			add_filter( 'plugin_action_links', array( $woosv_admin, 'action_links' ), 10, 2 );
			add_filter( 'plugin_row_meta', array( $woosv_admin, 'row_meta' ), 10, 2 );
			add_action( 'woocommerce_product_after_variable_attributes', array( $woosv_admin, 'add_fields' ), 10, 3 );
			add_action( 'woocommerce_save_product_variation', array( $woosv_admin, 'save_fields' ), 10, 2 );
			add_action( 'woocommerce_variable_product_bulk_edit_actions', array(
				$woosv_admin,
				'bulk_edit_actions'
			), 10, 2 );
			add_action( 'woocommerce_bulk_edit_variations', array(
				$woosv_admin,
				'bulk_edit_variations'
			), 10, 4 );
		}

		private function public_hooks() {
			$woosv_public = new Woosv_Public();
			add_action( 'woocommerce_product_query', array( $woosv_public, 'product_query' ), 999 );
			add_filter( 'posts_clauses', array( $woosv_public, 'posts_clauses' ), 999, 2 );
		}
	}

	new WPCleverWoosv();
}