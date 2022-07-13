<?php // phpcs:ignore WordPress.NamingConventions
/**
 * YWGC_Plugin_FW_Loader class
 *
 * @package yith-woocommerce-gift-cards\lib
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'YWGC_Plugin_FW_Loader' ) ) {

	/**
	 * YWGC_Plugin_FW_Loader
	 *
	 * @class   YWGC_Plugin_FW_Loader
	 *
	 * @since   1.0.0
	 * @author  Lorenzo Giuffrida
	 */
	class YWGC_Plugin_FW_Loader {

		/**
		 * Panel
		 *
		 * @var $panel Panel Object
		 */
		protected $panel;

		/**
		 * Status_page
		 *
		 * @var string the YITH plugin stats page
		 */
		protected $status_page = 'status.php';

		/**
		 * Premium_landing
		 *
		 * @var string Premium version landing link
		 */
		protected $premium_landing = '//yithemes.com/themes/plugins/yith-woocommerce-gift-cards/';

		/**
		 * Official_documentation
		 *
		 * @var string Plugin official documentation
		 */
		protected $official_documentation = 'https://docs.yithemes.com/yith-woocommerce-gift-cards/';

		/**
		 * Panel_page
		 *
		 * @var string Plugin panel page
		 */
		protected $panel_page = 'yith_woocommerce_gift_cards_panel';

		/**
		 * Premium_live
		 *
		 * @var string Official plugin landing page
		 */
		protected $premium_live = 'https://plugins.yithemes.com/yith-woocommerce-gift-cards/';

		/**
		 * Support
		 *
		 * @var string Official plugin support page
		 */
		protected $support = 'https://yithemes.com/my-account/support/dashboard/';

		/**
		 * Single instance of the class
		 *
		 * @since 1.0.0
		 * @var instance instance
		 */
		protected static $instance;

		/**
		 * Returns single instance of the class
		 *
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * __construct
		 *
		 * @return void
		 */
		public function __construct() {

			$this->plugin_fw_loader();
			/**
			 * Register actions and filters to be used for creating an entry on YIT Plugin menu
			 */
			add_action( 'admin_init', array( $this, 'register_pointer' ) );

			// Add stylesheets and scripts files.
			add_action( 'admin_menu', array( $this, 'register_panel' ), 5 );

			/**
			 * Register plugin to licence/update system.
			 */
			$this->licence_activation();

		}

		/**
		 * Load YIT core plugin
		 *
		 * @since  1.0
		 * @access public
		 * @return void
		 * @author Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function plugin_fw_loader() {
			if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
				global $plugin_fw_data;
				if ( ! empty( $plugin_fw_data ) ) {
					$plugin_fw_file = array_shift( $plugin_fw_data );
					require_once $plugin_fw_file;
				}
			}
		}

		/**
		 * Add a panel under YITH Plugins tab
		 *
		 * @return   void
		 * @since    1.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 * @use      /Yit_Plugin_Panel class
		 * @see      plugin-fw/lib/yit-plugin-panel.php
		 */
		public function register_panel() {

			if ( ! empty( $this->panel ) ) {
				return;
			}

			$admin_tabs['gift-cards']          = esc_html__( 'Dashboard', 'yith-woocommerce-gift-cards' );
			$admin_tabs['general']             = esc_html__( 'General', 'yith-woocommerce-gift-cards' );
			$admin_tabs['gift-cards-category'] = esc_html__( 'Image categories', 'yith-woocommerce-gift-cards' );

			$capability = apply_filters( 'yith_wcgc_plugin_settings_capability', 'manage_options' );

			$premium_tab      =  array(
				'landing_page_url' => $this->get_premium_landing_uri(),
				'premium_features' => array(
					// Put here all the premium Features.
					__( 'Set an <strong>expiration date for the gift card</strong> (a specific date, like January 01, or after a specific time after the purchase, like 3 months after)', 'yith-woocommerce-gift-cards' ),
					__( 'Manage stock of each gift card product', 'yith-woocommerce-gift-cards' ),
					__( 'Enable an optional <strong>QR code</strong> in gift cards', 'yith-woocommerce-gift-cards' ),
					__( 'Import and export gift cards into a <strong>CSV file</strong>', 'yith-woocommerce-gift-cards' ),
					__( 'Allow users to <strong>choose a delivery date</strong> for the gift card', 'yith-woocommerce-gift-cards' ),
					__( 'Allow users to <strong>enter a custom amount</strong> (and set the minimum and/or maximum amount)', 'yith-woocommerce-gift-cards' ),
					__( 'Allow users to <strong>upload a custom image or photo</strong> to customize the gift card', 'yith-woocommerce-gift-cards' ),
					__( 'Option to attach a PDF to gift card email', 'yith-woocommerce-gift-cards' ),
					__( 'Notify the sender via email when the gift card is delivered to recipient', 'yith-woocommerce-gift-cards' ),
					__( 'Allow users to enter the gift card code into the standard coupon code field (instead of showing two different forms in cart and checkout)', 'yith-woocommerce-gift-cards' ),
					__( 'Enable the “Gift this product” option in product pages to sell gift cards linked to specific products', 'yith-woocommerce-gift-cards' ),
					'<b>' . __( 'Regular updates, Translations and Premium Support', 'yith-woocommerce-gift-cards' ) . '</b>',
				),
				'main_image_url'  => YITH_YWGC_ASSETS_URL . '/images/gift-cards-get-premium.jpeg', // Plugin main image should be in your plugin assets folder.
			);

			$args = array(
				'create_menu_page' => true,
				'parent_slug'      => '',
				'plugin_slug'      => YITH_YWGC_SLUG,
				'page_title'       => 'Gift Cards',
				'menu_title'       => 'Gift Cards',
				'capability'       => $capability,
				'parent'           => '',
				'class'            => yith_set_wrapper_class(),
				'parent_page'      => 'yit_plugin_panel',
				'page'             => $this->panel_page,
				'admin-tabs'       => $admin_tabs,
				'options-path'     => YITH_YWGC_DIR . 'plugin-options',
				'premium_tab'      => $premium_tab,
				'is_premium'       => defined( 'YITH_YWGC_PREMIUM' ),
				'is_extended'      => defined( 'YITH_YWGC_EXTENDED' ),
			);

			/* === Fixed: not updated theme  === */
			if ( ! class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {

				require_once YITH_YWGC_DIR . 'plugin-fw/lib/yit-plugin-panel-wc.php';
			}

			$this->panel = new YIT_Plugin_Panel_WooCommerce( $args );

		}

		/**
		 * Register_pointer
		 *
		 * @return void
		 */
		public function register_pointer() {

			$is_ajax = defined( 'DOING_AJAX' ) && DOING_AJAX;

			if ( $is_ajax ) {
				return;
			}

			if ( ! class_exists( 'YIT_Pointers' ) ) {
				include_once 'plugin-fw/lib/yit-pointers.php';
			}

			$premium_message = defined( 'YITH_YWGC_PREMIUM' )
				? ''
				: esc_html__( 'YITH WooCommerce Gift Cards is available in an outstanding premium version with many new options, discover it now.', 'yith-woocommerce-gift-cards' ) .
				' <a href="' . $this->get_premium_landing_uri() . '">' . esc_html__( 'Premium version', 'yith-woocommerce-gift-cards' ) . '</a>';

			$args[] = array(
				'screen_id'  => 'plugins',
				'pointer_id' => 'yith_woocommerce_gift_cards',
				'target'     => '#toplevel_page_yit_plugin_panel',
				'content'    => sprintf(
					'<h3> %s </h3> <p> %s </p>',
					esc_html__( 'YITH WooCommerce Gift Cards', 'yith-woocommerce-gift-cards' ),
					esc_html__( 'In the YITH Plugins tab you can find YITH WooCommerce Gift Cards options.<br> From this menu you can access all the settings of your active YITH plugins.', 'yith-woocommerce-gift-cards' ) . '<br>' . $premium_message
				),
				'position'   => array(
					'edge'  => 'left',
					'align' => 'center',
				),
				'init'       => defined( 'YITH_YWGC_PREMIUM' ) ? YITH_YWGC_INIT : YITH_YWGC_FREE_INIT,
			);

			YIT_Pointers()->register( $args );
		}

		/**
		 * Get the premium landing uri
		 *
		 * @since   1.0.0
		 * @author  Andrea Grillo <andrea.grillo@yithemes.com>
		 * @return  string The premium landing link
		 */
		public function get_premium_landing_uri() {
			return apply_filters( 'yith_plugin_fw_premium_landing_uri', $this->premium_landing, YITH_YWGC_SLUG );
		}

		// region    ****    licence related methods ****.

		/**
		 * Add actions to manage licence activation and updates
		 */
		public function licence_activation() {
			if ( ! defined( 'YITH_YWGC_PREMIUM' ) ) {
				return;
			}

			add_action( 'wp_loaded', array( $this, 'register_plugin_for_activation' ), 99 );
			add_action( 'admin_init', array( $this, 'register_plugin_for_updates' ) );
		}

		/**
		 * Register plugins for activation tab
		 *
		 * @return void
		 * @since    2.0.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function register_plugin_for_activation() {

			if ( ! class_exists( 'YIT_Plugin_Licence' ) ) {
				require_once YITH_YWGC_DIR . '/plugin-fw/licence/lib/yit-licence.php';
				require_once YITH_YWGC_DIR . '/plugin-fw/licence/lib/yit-plugin-licence.php';
			}

			YIT_Plugin_Licence()->register( YITH_YWGC_INIT, YITH_YWGC_SECRET_KEY, YITH_YWGC_SLUG );
		}

		/**
		 * Register plugins for update tab
		 *
		 * @return void
		 * @since    2.0.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function register_plugin_for_updates() {
			if ( ! class_exists( 'YIT_Upgrade' ) ) {
				require_once YITH_YWGC_DIR . '/plugin-fw/lib/yit-upgrade.php';
			}
			YIT_Upgrade()->register( YITH_YWGC_SLUG, YITH_YWGC_INIT );
		}
		// endregion.
	}
}
YWGC_Plugin_FW_Loader::get_instance();
