<?php
if ( ! defined ( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if ( ! class_exists( 'YITH_WooCommerce_Gift_Cards' ) ) {

	/**
	 * Class YITH_WooCommerce_Gift_Cards
	 *
	 * @class   YITH_WooCommerce_Gift_Cards
	 * @package Yithemes
	 * @since   1.0.0
	 * @author  Lorenzo Giuffrida
	 */
	class YITH_WooCommerce_Gift_Cards {

		const YWGC_DB_VERSION_OPTION = 'yith_gift_cards_db_version';

		/**
		 * Single instance of the class
		 *
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Panel_page
		 *
		 * @var string Plugin panel page
		 */
		protected $panel_page = 'yith_woocommerce_gift_cards_panel';

		/**
		 * Returns single instance of the class
		 *
		 * @return instance|YITH_WooCommerce_Gift_Cards
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * Initialize plugin and registers actions and filters to be used
		 *
		 * @since  1.0
		 * @author Lorenzo Giuffrida
		 */
		protected function __construct() {

			$this->includes();
			$this->init_hooks();
			$this->start();
		}

		/**
		 * Includes
		 *
		 * @return void
		 */
		public function includes() {

			// Elementor Widgets integration.
			if ( defined( 'ELEMENTOR_VERSION' ) ) {
				require_once YITH_YWGC_DIR . 'includes/compatibilities/elementor/class-ywgc-elementor.php';
			}
		}

		/**
		 * Init_hooks
		 *
		 * @return void
		 */
		public function init_hooks() {
			/**
			 * Do some stuff on plugin init
			 */
			add_action( 'init', array( $this, 'on_plugin_init' ) );

			add_filter( 'yith_plugin_status_sections', array( $this, 'set_plugin_status' ) );

			add_filter( 'plugin_action_links_' . plugin_basename( YITH_YWGC_DIR . '/' . basename( YITH_YWGC_FILE ) ), array( $this, 'action_links' ) );

			add_filter( 'yith_show_plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 5 );

			/**
			 * Including the GDRP
			 */
			add_action( 'plugins_loaded', array( $this, 'load_privacy' ), 20 );

			$this->register_custom_post_statuses();

			/**
			 * Add an option to let the admin set the gift card as a physical good or digital goods
			 */
			add_filter( 'product_type_options', array( $this, 'add_type_option' ) );

			/**
			 * Append CSS for the email being sent to the customer
			 */
			add_action( 'yith_gift_cards_template_before_add_to_cart_form', array( $this, 'append_css_files' ) );

			/**
			 * Add taxonomy and assign it to gift card products
			 */
			add_action( 'woocommerce_after_register_taxonomy', array( $this, 'create_gift_cards_category' ) );

			/**
			 * Remove the view button in the gift card taxonomy
			 */
			add_filter( 'giftcard-category_row_actions', array( $this, 'ywgc_taxonomy_remove_view_row_actions' ), 10, 1 );

			add_filter( 'yith_ywgc_get_product_instance', array( $this, 'get_product_instance' ), 10, 2 );

			/**
			 * Select the date format option
			 */
			add_filter( 'yith_wcgc_date_format', array( $this, 'yith_ywgc_date_format_callback' ) );
		}

		/**
		 * Start
		 *
		 * @return void
		 */
		public function start() {
			// Init the backend.
			$this->backend = YITH_YWGC_Backend();

			// Init the frontend.
			$this->frontend = YITH_YWGC_Frontend();

			YITH_YWGC_Gift_Cards_Table();

			YITH_YWGC_Cart_Checkout();

			YITH_YWGC_Emails();

			YITH_YWGC_Shortcodes();
		}

		/**
		 *  Execute all the operation need when the plugin init
		 */
		public function on_plugin_init() {

			$this->init_post_type();

			$this->init_plugin();

			$this->update_database();

			$is_ajax = defined( 'DOING_AJAX' ) && DOING_AJAX;
			if ( is_admin() && ! $is_ajax ) {
				$this->init_metabox();
			}
		}

		/**
		 * Register the custom post type
		 */
		public function init_post_type() {

			/**
			 * APPLY_FILTERS: yith_wcgc_show_in_menu_cpt
			 *
			 * Filter to show or not the gift card dashboard in the WordPress menu.
			 *
			 * @param bool true to show it, false to hide it
			 *
			 * @return bool
			 */
			$args = array(
				'labels'          => array(
					'name'               => _x( 'All Gift Cards', 'post type general name', 'yith-woocommerce-gift-cards' ),
					'singular_name'      => _x( 'Gift Card', 'post type singular name', 'yith-woocommerce-gift-cards' ),
					'menu_name'          => _x( 'Gift Cards', 'admin menu', 'yith-woocommerce-gift-cards' ),
					'name_admin_bar'     => _x( 'Gift Card', 'add new on admin bar', 'yith-woocommerce-gift-cards' ),
					'add_new'            => _x( 'Create Code', 'admin menu item', 'yith-woocommerce-gift-cards' ),
					'add_new_item'       => esc_html__( 'Create Gift Card Code', 'yith-woocommerce-gift-cards' ),
					'new_item'           => esc_html__( 'New Gift Card', 'yith-woocommerce-gift-cards' ),
					'edit_item'          => esc_html__( 'Edit Gift Card', 'yith-woocommerce-gift-cards' ),
					'view_item'          => esc_html__( 'View Gift Card', 'yith-woocommerce-gift-cards' ),
					'all_items'          => esc_html__( 'All gift cards', 'yith-woocommerce-gift-cards' ),
					'search_items'       => esc_html__( 'Search gift cards', 'yith-woocommerce-gift-cards' ),
					'parent_item_colon'  => esc_html__( 'Parent gift cards:', 'yith-woocommerce-gift-cards' ),
					'not_found'          => esc_html__( 'No gift cards found.', 'yith-woocommerce-gift-cards' ),
					'not_found_in_trash' => esc_html__( 'No gift cards found in Trash.', 'yith-woocommerce-gift-cards' ),
				),
				'label'           => esc_html__( 'Gift Cards', 'yith-woocommerce-gift-cards' ),
				'description'     => esc_html__( 'Gift Cards', 'yith-woocommerce-gift-cards' ),
				'supports'        => array( 'title' ),
				'hierarchical'    => false,
				'capability_type' => 'product',
				'capabilities'    => array(
					'delete_post'  => 'edit_posts',
					'delete_posts' => 'edit_posts',
				),
				'public'          => false,
				'show_in_menu'    => apply_filters( 'yith_wcgc_show_in_menu_cpt', false ),
				'show_ui'         => true,
				'menu_position'   => 9,
				'can_export'      => true,
				'has_archive'     => false,
				'menu_icon'       => 'dashicons-clipboard',
				'query_var'       => false,
			);

			// Registering your Custom Post Type.
			register_post_type( YWGC_CUSTOM_POST_TYPE_NAME, $args );

		}

		/**
		 * Initialize plugin data, if any
		 */
		public function init_plugin() {
			// nothing to do.
		}

		/**
		 * Execute update on data used by the plugin that has been changed passing
		 * from a DB version to another
		 */
		public function update_database() {

			/**
			 * Init DB version if not exists
			 */
			$db_version = get_option( self::YWGC_DB_VERSION_OPTION );

			if ( ! $db_version ) {
				// Update from previous version where the DB option was not set.
				global $wpdb;

				// Update metakey from YITH Gift Cards 1.0.0.
				// @codingStandardsIgnoreStart --Direct call to Database is discouraged.
				$query = "Update {$wpdb->prefix}woocommerce_order_itemmeta
                        set meta_key = '" . YWGC_META_GIFT_CARD_POST_ID . "'
                        where meta_key = 'gift_card_post_id'";
				$wpdb->query( $query );
				// @codingStandardsIgnoreEnd
				$db_version = '1.0.0';
			}

			/**
			 * Start the database update step by step
			 */

			if ( version_compare( $db_version, '1.0.0', '<=' ) ) {

				// extract the user_id from the order where a gift card is applied and register
				// it so the gift card will be shown on my-account.

				$args = array(
					'numberposts' => - 1,
					'meta_key'    => YWGC_META_GIFT_CARD_ORDERS,//phpcs:ignore --slow query ok.
					'post_type'   => YWGC_CUSTOM_POST_TYPE_NAME,
					'post_status' => 'any',
				);

				// Retrieve the gift cards matching the criteria.
				$posts = get_posts( $args );

				foreach ( $posts as $post ) {
					$gift_card = new YITH_YWGC_Gift_Card( array( 'ID' => $post->ID ) );

					if ( ! $gift_card->exists() ) {
						continue;
					}

					$orders = $gift_card->get_registered_orders();
					foreach ( $orders as $order_id ) {
						$order = wc_get_order( $order_id );
						if ( $order ) {
							$customer_user = $order->get_meta( 'customer_user' );
							$gift_card->register_user( $customer_user );
						}
					}
				}

				$db_version = '1.0.1';  // Continue to next step...
			}

			// Update the current DB version.
			update_option( self::YWGC_DB_VERSION_OPTION, YITH_YWGC_DB_CURRENT_VERSION );
		}

		/**
		 * Init_metabox
		 *
		 * @return void
		 */
		public function init_metabox() {

			$args = array(
				'label'    => esc_html__( 'Gift card detail', 'yith-woocommerce-gift-cards' ),
				'pages'    => YWGC_CUSTOM_POST_TYPE_NAME,
				'context'  => 'normal',
				'priority' => 'high',
				'tabs'     => array(
					'General' => array(
						'label'  => esc_html__( 'General', 'yith-woocommerce-gift-cards' ),
						'fields' => apply_filters(
							'yith_ywgc_gift_card_instance_metabox_custom_fields',
							array(

								YITH_YWGC_Gift_Card::META_AMOUNT_TOTAL => array(
									'label'   => esc_html__( 'Amount', 'yith-woocommerce-gift-cards' ),
									'desc'    => esc_html__( 'The gift card amount.', 'yith-woocommerce-gift-cards' ),
									'type'    => 'text',
									'private' => false,
									'std'     => '',
								),
								YITH_YWGC_Gift_Card::META_BALANCE_TOTAL => array(
									'label'   => esc_html__( 'Current balance', 'yith-woocommerce-gift-cards' ),
									'desc'    => esc_html__( 'The current amount available for the customer.', 'yith-woocommerce-gift-cards' ),
									'type'    => 'text',
									'private' => false,
									'std'     => '',
								),
								'_ywgc_is_digital'     => array(
									'label'   => esc_html__( 'Virtual', 'yith-woocommerce-gift-cards' ),
									'desc'    => esc_html__( 'Check if the gift card will be sent via email. Leave it unchecked to make this work as a physical gift card.', 'yith-woocommerce-gift-cards' ),
									'type'    => 'checkbox',
									'private' => false,
									'std'     => '',
								),
								'_ywgc_sender_name'    => array(
									'label'   => esc_html__( 'Sender\'s name', 'yith-woocommerce-gift-cards' ),
									'desc'    => esc_html__( 'The name of the digital gift card sender, if any.', 'yith-woocommerce-gift-cards' ),
									'type'    => 'text',
									'private' => false,
									'std'     => '',
									'css'     => 'width: 80px;',
									'deps'    => array(
										'ids'    => '_ywgc_is_digital',
										'values' => 'yes',
									),
								),
								'_ywgc_recipient'      => array(
									'label'   => esc_html__( 'Recipient\'s email', 'yith-woocommerce-gift-cards' ),
									'desc'    => esc_html__( 'The email address of the digital gift card recipient.', 'yith-woocommerce-gift-cards' ),
									'type'    => 'text',
									'private' => false,
									'std'     => '',
									'deps'    => array(
										'ids'    => '_ywgc_is_digital',
										'values' => 'yes',
									),
								),
								'_ywgc_recipient_name' => array(
									'label'   => esc_html__( 'Recipient\'s name', 'yith-woocommerce-gift-cards' ),
									'desc'    => esc_html__( 'The name of the digital gift card recipient.', 'yith-woocommerce-gift-cards' ),
									'type'    => 'text',
									'private' => false,
									'std'     => '',
									'deps'    => array(
										'ids'    => '_ywgc_is_digital',
										'values' => 'yes',
									),
								),
								'_ywgc_message'        => array(
									'label'   => esc_html__( 'Message', 'yith-woocommerce-gift-cards' ),
									'desc'    => esc_html__( 'The message attached to the gift card.', 'yith-woocommerce-gift-cards' ),
									'type'    => 'textarea',
									'private' => false,
									'std'     => '',
									'deps'    => array(
										'ids'    => '_ywgc_is_digital',
										'values' => 'yes',
									),
								),

								'_ywgc_internal_notes' => array(
									'label'   => esc_html__( 'Internal notes', 'yith-woocommerce-gift-cards' ),
									'desc'    => esc_html__( 'Enter your notes here. This will only be visible to the admin.', 'yith-woocommerce-gift-cards' ),
									'type'    => 'textarea',
									'private' => false,
									'std'     => '',
								),

							)
						),
					),
				),
			);

			$metabox = YIT_Metabox( 'yit-metabox-id' );
			$metabox->init( $args );

		}

		/**
		 * Current_user_can_create
		 *
		 * @return bool
		 */
		public function current_user_can_create() {
			/**
			 * APPLY_FILTERS: ywgc_can_create_gift_card
			 *
			 * Filter if current user can create a gift card.
			 *
			 * @param bool true if the current user can create a gift card, false if not
			 *
			 * @return bool
			 */
			return apply_filters( 'ywgc_can_create_gift_card', true );
		}

		/**
		 * Retrieve a gift card product instance from the gift card code
		 *
		 * @param string $code the gift card code to search for.
		 *
		 * @return YITH_YWGC_Gift_Card
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function get_gift_card_by_code( $code ) {

			$args = array( 'gift_card_number' => $code );

			return new YITH_YWGC_Gift_Card( $args );
		}

		/**
		 * Generate a new gift card code
		 *
		 * @return string
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function generate_gift_card_code() {

			// Create a new gift card number.
			$numeric_code     = (string) wp_rand( 99999999, mt_getrandmax() );
			$numeric_code_len = strlen( $numeric_code );

			/**
			 * APPLY_FILTERS: ywgc_random_generate_gift_card_code
			 *
			 * Filter the random generation of the gift card code.
			 *
			 * @param string the code randomly generated
			 *
			 * @return string
			 */
			$code        = apply_filters( 'ywgc_random_generate_gift_card_code', strtoupper( sha1( uniqid( wp_rand() ) ) ) );
			$code_len    = strlen( $code );
			$pattern     = get_option( 'ywgc_code_pattern', '****-****-****-****' );
			$pattern_len = strlen( $pattern );

			for ( $i = 0; $i < $pattern_len; $i ++ ) {

				if ( '*' === $pattern[ $i ] ) {
					// replace all '*'s with one letter from the unique $code generated.
					$pattern[ $i ] = $code[ $i % $code_len ];
				} elseif ( 'D' === $pattern[ $i ] ) {
					// replace all 'D's with one digit from the unique integer $numeric_code generated.
					$pattern[ $i ] = $numeric_code[ $i % $numeric_code_len ];
				}
			}

			return $pattern;
		}

		/**
		 * Action links
		 *
		 * @param mixed $links links.
		 *
		 * @return array|mixed
		 */
		public function action_links( $links ) {

			$links = is_array($links) ? $links : array();
			$links = yith_add_action_links( $links, $this->panel_page, false, YITH_YWGC_SLUG );

			return $links;

		}

		/**
		 * Plugin Row Meta
		 *
		 * @param  mixed $new_row_meta_args new_row_meta_args.
		 * @param  mixed $plugin_meta plugin_meta.
		 * @param  mixed $plugin_file plugin_file.
		 * @param  mixed $plugin_data plugin_data.
		 * @param  mixed $status status.
		 * @param  mixed $init_file init_file.
		 *
		 * @return mixed
		 */
		public function plugin_row_meta( $new_row_meta_args, $plugin_meta, $plugin_file, $plugin_data, $status, $init_file = 'YITH_YWGC_FREE_INIT' ) {

			if ( defined( $init_file ) && constant( $init_file ) === $plugin_file ) {
				$new_row_meta_args['slug'] = YITH_YWGC_SLUG;
			}

			return $new_row_meta_args;
		}

		/**
		 * Including the GDRP
		 */
		public function load_privacy() {

			if ( class_exists( 'YITH_Privacy_Plugin_Abstract' ) ) {
				require_once YITH_YWGC_DIR . 'includes/class.yith-woocommerce-gift-cards-privacy.php';
			}

		}

		/**
		 * Register all the custom post statuses of gift cards
		 *
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function register_custom_post_statuses() {

			register_post_status(
				YITH_YWGC_Gift_Card::STATUS_DISABLED,
				array(
					'label'                     => esc_html__( 'Disabled', 'yith-woocommerce-gift-cards' ),
					'public'                    => true,
					'exclude_from_search'       => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					'post_type'                 => array( 'gift_card' ),
					'label_count'               => _n_noop( esc_html__( 'Disabled', 'yith-woocommerce-gift-cards' ) . '<span class="count"> (%s)</span>', esc_html__( 'Disabled', 'yith-woocommerce-gift-cards' ) . ' <span class="count"> (%s)</span>' ),
				)
			);

			register_post_status(
				YITH_YWGC_Gift_Card::STATUS_DISMISSED,
				array(
					'label'                     => esc_html__( 'Dismissed', 'yith-woocommerce-gift-cards' ),
					'public'                    => true,
					'exclude_from_search'       => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					'post_type'                 => array( 'gift_card' ),
					'label_count'               => _n_noop( esc_html__( 'Dismissed', 'yith-woocommerce-gift-cards' ) . '<span class="count"> (%s)</span>', esc_html__( 'Dismissed', 'yith-woocommerce-gift-cards' ) . ' <span class="count"> (%s)</span>' ),
				)
			);

			register_post_status(
				YITH_YWGC_Gift_Card::STATUS_CODE_NOT_VALID,
				array(
					'label'                     => esc_html__( 'Code not valid', 'yith-woocommerce-gift-cards' ),
					'public'                    => true,
					'exclude_from_search'       => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					'post_type'                 => array( 'gift_card' ),
					'label_count'               => _n_noop( esc_html__( 'Code not valid', 'yith-woocommerce-gift-cards' ) . '<span class="count"> (%s)</span>', esc_html__( 'Code not valid', 'yith-woocommerce-gift-cards' ) . ' <span class="count"> (%s)</span>' ),
				)
			);

			register_post_status(
				YITH_YWGC_Gift_Card::STATUS_PRE_PRINTED,
				array(
					'label'                     => esc_html__( 'Pre-Printed', 'yith-woocommerce-gift-cards' ),
					'public'                    => false,
					'exclude_from_search'       => false,
					'show_in_admin_all_list'    => false,
					'show_in_admin_status_list' => true,
					'post_type'                 => array( 'gift_card' ),
					'label_count'               => _n_noop( esc_html__( 'Pre-Printed', 'yith-woocommerce-gift-cards' ) . '<span class="count"> (%s)</span>', esc_html__( 'Pre-Printed', 'yith-woocommerce-gift-cards' ) . ' <span class="count"> (%s)</span>' ),
				)
			);
		}

		/**
		 * Add an option to let the admin set the gift card as a physical good or digital goods.
		 *
		 * @param array $array
		 *
		 * @return mixed
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function add_type_option( $array ) {
			if ( isset( $array['virtual'] ) ) {
				$css_class     = $array['virtual']['wrapper_class'];
				$add_css_class = 'show_if_gift-card';
				$class         = empty( $css_class ) ? $add_css_class : $css_class .= ' ' . $add_css_class;

				$array['virtual']['wrapper_class'] = $class;
			}

			return $array;
		}

		/**
		 * Append CSS for the email being sent to the customer
		 */
		public function append_css_files() {
			YITH_YWGC()->frontend->enqueue_frontend_style();
		}

		/**
		 * Create_gift_cards_category
		 *
		 * Register new taxonomy which applies to attachments.
		 *
		 * @return void
		 */
		public function create_gift_cards_category() {

			$labels = array(
				'name'              => esc_html__( 'Gift card categories', 'yith-woocommerce-gift-cards' ),
				'singular_name'     => esc_html__( 'Gift card category', 'yith-woocommerce-gift-cards' ),
				'search_items'      => esc_html__( 'Search categories', 'yith-woocommerce-gift-cards' ),
				'all_items'         => esc_html__( 'All categories', 'yith-woocommerce-gift-cards' ),
				'parent_item'       => esc_html__( 'Parent category', 'yith-woocommerce-gift-cards' ),
				'parent_item_colon' => esc_html__( 'Parent category:', 'yith-woocommerce-gift-cards' ),
				'edit_item'         => esc_html__( 'Edit category', 'yith-woocommerce-gift-cards' ),
				'update_item'       => esc_html__( 'Update gift card category', 'yith-woocommerce-gift-cards' ),
				'add_new_item'      => esc_html__( 'Add new category', 'yith-woocommerce-gift-cards' ),
				'new_item_name'     => esc_html__( 'New category name', 'yith-woocommerce-gift-cards' ),
				'menu_name'         => esc_html__( 'Gift card category', 'yith-woocommerce-gift-cards' ),
			);

			$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'query_var'         => true,
				'rewrite'           => true,
				'show_admin_column' => true,
				'show_in_menu'      => false, // hide in the WordPress dashboard.
				'show_ui'           => true,
				'public'            => true,
				'show_in_rest'      => true,
			);

			$taxonomies = register_taxonomy( YWGC_CATEGORY_TAXONOMY, array( 'attachment', 'product' ), $args );

			//wp_die( print_r( $taxonomies, true ) );

			if ( ! term_exists( 'none', YWGC_CATEGORY_TAXONOMY ) ) {
				wp_insert_term(
					__( 'None', 'yith-woocommerce-gift-cards' ),
					YWGC_CATEGORY_TAXONOMY,
					array(
						'description' => __( 'Select this category in your gift card product if you do not want to display images in your gift card gallery', 'yith-woocommerce-gift-cards' ),
						'slug'        => 'none',
					)
				);
			}

			if ( ! term_exists( 'all', YWGC_CATEGORY_TAXONOMY ) ) {
				wp_insert_term(
					__( 'All', 'yith-woocommerce-gift-cards' ),
					YWGC_CATEGORY_TAXONOMY,
					array(
						'description' => __( 'Select this category in your gift card product if you want to display all the images categories in your gift card gallery', 'yith-woocommerce-gift-cards' ),
						'slug'        => 'all',
					)
				);
			}
		}

		/**
		 * Ywgc_taxonomy_remove_view_row_actions
		 *
		 * Remove the view button in the gift card taxonomy
		 *
		 * @param  mixed $actions actions.
		 * @return actions
		 */
		public function ywgc_taxonomy_remove_view_row_actions( $actions ) {

			unset( $actions['view'] );
			return $actions;
		}

		/**
		 * Retrieve the product instance
		 *
		 * @param WC_Product_Gift_Card $product product.
		 *
		 * @return null|WC_Product
		 */
		public function get_product_instance( $product ) {

			global $sitepress;

			if ( $sitepress ) {
				$_wcml_settings = get_option( '_wcml_settings' );
				if ( isset( $_wcml_settings['trnsl_interface'] ) && '1' === $_wcml_settings['trnsl_interface'] ) {
					$product_id = $product->get_id();

					if ( $product_id ) {
						$id = yit_wpml_object_id( $product_id, 'product', true, $sitepress->get_default_language() );

						if ( $id !== $product_id ) {
							$product = wc_get_product( $id );
						}
					}
				}
			}

			return $product;
		}

		/**
		 * Add option select the date format
		 *
		 * @return string
		 * @since  2.0.5
		 * @author Francisco Mendoza
		 */
		public function yith_ywgc_date_format_callback() {

			$date_format_in_js = get_option( 'ywgc_plugin_date_format_option', 'yy-mm-dd' );

			$js_to_php_date_format = array(
				'd'  => 'j',
				'dd' => 'd',
				'o'  => 'z',
				'D'  => 'D',
				'DD' => 'l',
				'm'  => 'n',
				'mm' => 'm',
				'M'  => 'M',
				'MM' => 'F',
				'y'  => 'y',
				'yy' => 'Y',
			);

			$date_format_in_php = strtr( $date_format_in_js, $js_to_php_date_format );

			return $date_format_in_php;
		}

		/**
		 * Getter option mandatory recipient
		 *
		 * @return bool
		 * @author Carlos Rodríguez
		 * @since  2.2.6
		 */
		public function mandatory_recipient() {

			return ( 'yes' === get_option( 'ywgc_recipient_mandatory', 'no' ) );
		}

		/**
		 * Retrieve if the gift cards should be updated on order refunded
		 *
		 * @return bool
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function change_status_on_refund() {
			return $this->disable_on_refund() || $this->dismiss_on_refund();
		}

		/**
		 * Retrieve if the gift cards should be updated on order cancelled
		 *
		 * @return bool
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function change_status_on_cancelled() {
			return $this->disable_on_cancelled() || $this->dismiss_on_cancelled();
		}

		/**
		 * Retrieve if a gift card should be set as dismissed if an order change its status
		 * to refunded
		 *
		 * @return bool
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function dismiss_on_refund() {
			return 'dismiss' === $this->order_refunded_action();
		}

		/**
		 * Retrieve if a gift card should be set as disabled if an order change its status
		 * to refunded
		 *
		 * @return bool
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function disable_on_refund() {
			return 'disable' === $this->order_refunded_action();
		}

		/**
		 * Retrieve if a gift card should be set as dismissed if an order change its status
		 * to cancelled
		 *
		 * @return bool
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function dismiss_on_cancelled() {
			return 'dismiss' === $this->order_cancelled_action();
		}

		/**
		 * Retrieve if a gift card should be set as disabled if an order change its status
		 * to cancelled
		 *
		 * @return bool
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function disable_on_cancelled() {
			return 'disable' === $this->order_cancelled_action();
		}

		/**
		 * Retrieve the image to be used as a main image for the gift card
		 *
		 * @param WC_product $product the product object.
		 *
		 * @return string
		 */
		public function get_header_image_for_product( $product ) {
			$header_image_url = '';

			if ( $product ) {

				$product_id = yit_get_product_id( $product );
				if ( $product instanceof WC_Product_Gift_Card ) {
					$header_image_url = $product->get_manual_header_image();
				}

				if ( ( empty( $header_image_url ) ) && has_post_thumbnail( $product_id ) ) {
					$image            = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), apply_filters( 'ywgc_email_image_size', 'full' ) );
					$header_image_url = $image[0];
				}
			}
			return $header_image_url;
		}

		/**
		 * Get_default_header_image
		 *
		 * @return string
		 */
		public function get_default_header_image() {

			$default_header_image_url = get_option( 'ywgc_gift_card_header_url', YITH_YWGC_ASSETS_IMAGES_URL . 'default-giftcard-main-image.jpg' );

			return $default_header_image_url ? $default_header_image_url : YITH_YWGC_ASSETS_IMAGES_URL . 'default-giftcard-main-image.jpg';
		}

		/**
		 * Retrieve the default image, configured from the plugin settings, to be used as gift card header image
		 *
		 * @param YITH_YWGC_Gift_Card|WC_Product $obj the product object.
		 *
		 * @return mixed|string|void
		 */
		public function get_header_image( $obj = null ) {

			$header_image_url = '';
			if ( $obj instanceof YITH_YWGC_Gift_Card ) {

				if ( $obj->has_custom_design && is_numeric( $obj->design ) && $obj->design > 0 ) {
					/**
					 * APPLY_FILTERS: ywgc_email_image_size
					 *
					 * Filter the size of the gift card image in the emails.
					 *
					 * @param string Image size. Accepts any registered image size name, or an array of width and height values in pixels (in that order). Default value: 'full'
					 *
					 * @return string
					 */
					$header_image_url = yith_get_attachment_image_url( $obj->design, apply_filters( 'ywgc_email_image_size', 'full' ) );
				} else {
					$product          = wc_get_product( $obj->product_id );
					$header_image_url = $this->get_header_image_for_product( $product );
				}
			}

			if ( is_object( $obj ) ) {
				if ( get_class( $obj ) === 'WC_Product_Gift_Card' ) {

					$image_id         = $obj->get_manual_header_image( $obj->get_id(), 'id' );
					$header_image_url = wp_get_attachment_url( $image_id );
				}
			}

			if ( ! $header_image_url ) {
				$header_image_url = $this->get_default_header_image();
			}

			return $header_image_url;
		}

		/**
		 * Output a gift cards template filled with real data or with sample data to start editing it
		 * on product page
		 *
		 * @param WC_Product|YITH_YWGC_Gift_Card $object object.
		 * @param string                         $context context.
		 * @param  mixed                          $case case.
		 * @return void
		 */
		public function preview_digital_gift_cards( $object, $context = 'shop', $case = 'recipient' ) {

			if ( $object instanceof WC_Product ) {
				$product_type = version_compare( WC()->version, '3.0', '<' ) ? $object->product_type : $object->get_type();

				$header_image_url = $this->get_header_image( $object );

				// check if the admin set a default image for gift card.
				$amount = 0;
				if ( $object instanceof WC_Product_Simple || $object instanceof WC_Product_Variable || $object instanceof WC_Product_Yith_Bundle ) {
					$amount = yit_get_display_price( $object );
				}

				$amount          = wc_format_decimal( $amount );
				$formatted_price = wc_price( $amount );

				$gift_card_code = 'xxxx-xxxx-xxxx-xxxx';
				$message        = apply_filters( 'yith_ywgc_gift_card_template_message_text', esc_html__( 'Your message will show up here…', 'yith-woocommerce-gift-cards' ) );
			} elseif ( $object instanceof YITH_YWGC_Gift_Card ) {

				$header_image_url = $this->get_header_image( $object );
				$amount           = $object->total_amount;
				$formatted_price  = apply_filters( 'yith_ywgc_gift_card_template_amount', wc_price( $amount ), $object, $amount );
				$gift_card_code   = $object->gift_card_number;
				$message          = $object->message;
				$expiration_date  = ! is_numeric( $object->expiration ) ? strtotime( $object->expiration ) : $object->expiration;
			}

			// Checking if the image sent is a product image, if so then we set $header_image_url with correct url.
			if ( isset( $header_image_url ) ) {
				if ( strpos( $header_image_url, '-yith_wc_gift_card_premium_separator_ywgc_template_design-' ) !== false ) {
					$array_header_image_url = explode( '-yith_wc_gift_card_premium_separator_ywgc_template_design-', $header_image_url );
					$header_image_url       = $array_header_image_url['1'];
				}
			}

			$product_id = isset( $object->product_id ) ? $object->product_id : '';

			$args = array(
				'company_logo_url'         => ( 'yes' === get_option( 'ywgc_shop_logo_on_gift_card', 'no' ) ) ? get_option( 'ywgc_shop_logo_url', YITH_YWGC_ASSETS_IMAGES_URL . 'default-giftcard-main-image.png' ) : '',
				'header_image_url'         => $header_image_url,
				'default_header_image_url' => $this->get_default_header_image(),
				'formatted_price'          => $formatted_price,
				'gift_card_code'           => $gift_card_code,
				'message'                  => $message,
				'context'                  => $context,
				'object'                   => $object,
				'product_id'               => $product_id,
				'case'                     => $case,
				'date_format'              => apply_filters( 'yith_wcgc_date_format', 'Y-m-d' ),
				'expiration_date'          => $expiration_date,
			);

			wc_get_template( 'yith-gift-cards/ywgc-gift-card-template.php', $args, '', trailingslashit( YITH_YWGC_TEMPLATES_DIR ) );

		}

		/**
		 * Perform some check to a gift card that should be applied to the cart
		 * and retrieve a message code
		 *
		 * @param YITH_YWGC_Gift_Card $gift the gift card object.
		 * @param bool $remove
		 *
		 * @return bool
		 */
		public function check_gift_card( $gift, $remove = false ) {

			$err_code = '';

			/**
			 * APPLY_FILTERS: yith_wcgc_deny_usage_of_gift_cards_to_purchase_gift_cards
			 *
			 * Filter the condition to deny or not the usage of gift cards codes to purchase gift card products.
			 *
			 * @param bool true to deny it, false for not. Default: false
			 *
			 * @return bool
			 */

			if ( ! is_object( $gift ) || ! $gift->exists() ) {
				$err_code = YITH_YWGC_Gift_Card::E_GIFT_CARD_NOT_EXIST;
			} elseif ( ! $gift->is_owner( get_current_user_id() ) ) {
				$err_code = YITH_YWGC_Gift_Card::E_GIFT_CARD_NOT_YOURS;
			} elseif ( isset( WC()->cart->applied_gift_cards[ $gift->get_code() ] ) ) {
				$err_code = YITH_YWGC_Gift_Card::E_GIFT_CARD_ALREADY_APPLIED;
			} elseif ( $gift->is_expired() ) {
				$err_code = YITH_YWGC_Gift_Card::E_GIFT_CARD_EXPIRED;
			} elseif ( $gift->is_disabled() ) {
				$err_code = YITH_YWGC_Gift_Card::E_GIFT_CARD_DISABLED;
			} elseif ( $gift->is_dismissed() ) {
				$err_code = YITH_YWGC_Gift_Card::E_GIFT_CARD_DISMISSED;
			} elseif ( apply_filters( 'yith_wcgc_deny_usage_of_gift_cards_to_purchase_gift_cards', false ) ) {

				$cart = WC()->cart->get_cart();

				foreach ( $cart as $cart_item_key => $cart_item ) {

					$product = $cart_item['data'];

					if ( $product instanceof WC_Product_Gift_Card ) {
						$err_code = YITH_YWGC_Gift_Card::GIFT_CARD_NOT_ALLOWED_FOR_PURCHASING_GIFT_CARD;
						break;
					}
				}
			}
			/**
			 * If the flag $remove is true and there is an error,
			 * the gift card will be removed from the cart, then we set the general
			 * error message here.
			 * */
			if ( $err_code && $remove ) {
				$err_code = YITH_YWGC_Gift_Card::E_GIFT_CARD_INVALID_REMOVED;
			}

			if ( ! is_object( $gift ) ) {
				wc_add_notice( esc_html__( 'This gift card code does not exist!', 'yith-woocommerce-gift-cards' ), 'error' );
				return false;
			}

			/**
			 * APPLY_FILTERS: yith_ywgc_check_gift_card
			 *
			 * Filter if the gift card have errors when applying it.
			 *
			 * @param string $err_code the error code
			 * @param object $gift the gift card object
			 *
			 * @return string
			 */
			$err_code = apply_filters( 'yith_ywgc_check_gift_card', $err_code, $gift );
			if ( $err_code ) {

				$err_msg = $gift->get_gift_card_error( $err_code );

				if ( $err_msg ) {
					wc_add_notice( $err_msg, 'error' );
				}

				return false;
			}

			if ( $gift->get_balance() <= 0 ) {
				$err_code = YITH_YWGC_Gift_Card::E_GIFT_CARD_ALREADY_APPLIED;
				$err_msg  = $gift->get_gift_card_error( $err_code );
				wc_add_notice( $err_msg, 'error' );

				return false;
			}

			if ( ! $remove ) {

				$ywgc_minimal_car_total = get_option( 'ywgc_minimal_car_total' );

				if ( WC()->cart->total < $ywgc_minimal_car_total ) {
					wc_add_notice( esc_html__( 'In order to use the gift card, the minimum total amount in the cart has to be ' . $ywgc_minimal_car_total . get_woocommerce_currency_symbol(), 'yith-woocommerce-gift-cards' ), 'error' );

					return false;
				}
			}

			$items = WC()->cart->get_cart();
			foreach ( $items as $cart_item_key => $values ) {
				$product = $values['data'];

				/**
				 * APPLY_FILTERS: yith_ywgc_check_subscription_product_on_cart
				 *
				 * Filter the condition to allow to apply the gift card codes to WC_Subscriptions_Product products in the cart.
				 *
				 * @param bool true to now allow it and display an error in the cart, false to allow it. Default: true
				 *
				 * @return bool
				 */
				if ( apply_filters( 'yith_ywgc_check_subscription_product_on_cart', true ) && class_exists( 'WC_Subscriptions_Product' ) && WC_Subscriptions_Product::is_subscription( $product ) ) {
					wc_add_notice( esc_html__( 'It is not possible to add any gift card if the cart contains a subscription-based product', 'yith-woocommerce-gift-cards' ), 'error' );

					return false;
				}
			}

			$cart_coupons = WC()->cart->get_coupons();

			foreach ( $cart_coupons as $coupon ) {

				$coupon_code = strtoupper( $coupon->get_code() );
				$gift_code   = strtoupper( $gift->get_code() );

				if ( $gift_code === $coupon_code ) {
					wc_add_notice( esc_html__( 'This code is already applied', 'yith-woocommerce-gift-cards' ), 'error' );

					return false;
				}
			}

			/**
			 * APPLY_FILTERS: yith_ywgc_check_gift_card_return
			 *
			 * Filter the gift card code response when applied to the cart. It allows to add conditions based on the products in the cart.
			 *
			 * @param bool true to apply the gift card code, false to not
			 * @param object $gift the gift card applied object
			 *
			 * @return bool
			 */
			return apply_filters( 'yith_ywgc_check_gift_card_return', true, $gift );
		}

	}
}

