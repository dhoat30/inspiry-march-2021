<?php
/*
Plugin Name: WPC Variation Swatches for WooCommerce
Plugin URI: https://wpclever.net/
Description: WooCommerce Variation Swatches by WPClever
Version: 2.1.1
Author: WPClever
Author URI: https://wpclever.net
Text Domain: wpc-variation-swatches
Domain Path: /languages/
Requires at least: 4.0
Tested up to: 5.9
WC requires at least: 3.0
WC tested up to: 6.4
*/

defined( 'ABSPATH' ) || exit;

! defined( 'WPCVS_VERSION' ) && define( 'WPCVS_VERSION', '2.1.1' );
! defined( 'WPCVS_URI' ) && define( 'WPCVS_URI', plugin_dir_url( __FILE__ ) );
! defined( 'WPCVS_DIR' ) && define( 'WPCVS_DIR', plugin_dir_path( __FILE__ ) );
! defined( 'WPCVS_REVIEWS' ) && define( 'WPCVS_REVIEWS', 'https://wordpress.org/support/plugin/wpc-variation-swatches/reviews/?filter=5' );
! defined( 'WPCVS_CHANGELOG' ) && define( 'WPCVS_CHANGELOG', 'https://wordpress.org/plugins/wpc-variation-swatches/#developers' );
! defined( 'WPCVS_DISCUSSION' ) && define( 'WPCVS_DISCUSSION', 'https://wordpress.org/support/plugin/wpc-variation-swatches' );
! defined( 'WPC_URI' ) && define( 'WPC_URI', WPCVS_URI );

include 'includes/wpc-dashboard.php';
include 'includes/wpc-menu.php';
include 'includes/wpc-kit.php';
include 'includes/wpc-notice.php';

if ( ! function_exists( 'wpcvs_init' ) ) {
	add_action( 'plugins_loaded', 'wpcvs_init', 11 );

	function wpcvs_init() {
		// load text-domain
		load_plugin_textdomain( 'wpc-variation-swatches', false, basename( __DIR__ ) . '/languages/' );

		if ( ! function_exists( 'WC' ) || ! version_compare( WC()->version, '3.0', '>=' ) ) {
			add_action( 'admin_notices', 'wpcvs_notice_wc' );

			return;
		}

		if ( ! class_exists( 'WPCleverWpcvs' ) && class_exists( 'WC_Product' ) ) {
			class WPCleverWpcvs {
				function __construct() {
					add_action( 'init', array( $this, 'init' ) );

					add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
					add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

					// add field for attributes
					add_filter( 'product_attributes_type_selector', array( $this, 'type_selector' ) );

					$attribute_taxonomies = wc_get_attribute_taxonomies();

					foreach ( $attribute_taxonomies as $attribute_taxonomy ) {
						add_action( 'pa_' . $attribute_taxonomy->attribute_name . '_add_form_fields', array(
							$this,
							'show_field'
						) );
						add_action( 'pa_' . $attribute_taxonomy->attribute_name . '_edit_form_fields', array(
							$this,
							'show_field'
						) );
						add_action( 'create_pa_' . $attribute_taxonomy->attribute_name, array(
							$this,
							'save_field'
						) );
						add_action( 'edited_pa_' . $attribute_taxonomy->attribute_name, array( $this, 'save_field' ) );
						add_filter( "manage_edit-pa_{$attribute_taxonomy->attribute_name}_columns", array(
							$this,
							'custom_columns'
						) );
						add_filter( "manage_pa_{$attribute_taxonomy->attribute_name}_custom_column", array(
							$this,
							'custom_columns_content'
						), 10, 3 );
					}

					add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array(
						$this,
						'variation_attribute_options_html'
					), 199, 2 );

					// settings page
					add_action( 'admin_menu', array( $this, 'admin_menu' ) );

					// settings link
					add_filter( 'plugin_action_links', array( $this, 'wpcvs_action_links' ), 10, 2 );
					add_filter( 'plugin_row_meta', array( $this, 'wpcvs_row_meta' ), 10, 2 );

					// archive page
					if ( get_option( 'wpcvs_archive_enable', 'no' ) === 'yes' ) {
						if ( get_option( 'wpcvs_archive_position', 'before' ) === 'before' ) {
							add_action( 'woocommerce_after_shop_loop_item', array( $this, 'archive' ), 9 );
						} elseif ( get_option( 'wpcvs_archive_position', 'before' ) === 'after' ) {
							add_action( 'woocommerce_after_shop_loop_item', array( $this, 'archive' ), 11 );
						}
					}

					// ajax add to cart
					add_action( 'wp_ajax_wpcvs_add_to_cart', array( $this, 'add_to_cart' ) );
					add_action( 'wp_ajax_nopriv_wpcvs_add_to_cart', array( $this, 'add_to_cart' ) );

					// variation
					add_filter( 'woocommerce_available_variation', array( $this, 'available_variation' ), 100, 3 );
				}

				function init() {
					add_shortcode( 'wpcvs_archive', array( $this, 'shortcode_archive' ) );
				}

				function shortcode_archive( $attrs ) {
					$attrs = shortcode_atts( array(
						'id' => null,
					), $attrs, 'wpcvs_archive' );

					ob_start();
					$this->archive( $attrs['id'] );

					return ob_get_clean();
				}

				function add_to_cart() {
					if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wpcvs_nonce' ) ) {
						die( esc_html__( 'Permissions check failed', 'wpc-variation-swatches' ) );
					}

					$product_id   = (int) $_POST['product_id'];
					$variation_id = (int) $_POST['variation_id'];
					$quantity     = (float) $_POST['quantity'];
					$variation    = (array) json_decode( stripslashes( $_POST['attributes'] ) );

					if ( $product_id && $variation_id ) {
						$item_key = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation );

						if ( ! empty( $item_key ) ) {
							echo true;
						}
					}

					die();
				}

				function available_variation( $available, $variable, $variation ) {
					$thumbnail_id   = $available['image_id'];
					$thumbnail_size = apply_filters( 'woocommerce_thumbnail_size', 'woocommerce_thumbnail' );
					$thumbnail_src  = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size );

					if ( $thumbnail_id ) {
						$available['image']['wpcvs_src']    = $thumbnail_src[0];
						$available['image']['wpcvs_srcset'] = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, $thumbnail_size ) : false;
						$available['image']['wpcvs_sizes']  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, $thumbnail_size ) : false;
					}

					return $available;
				}

				function scripts() {
					if ( get_option( 'wpcvs_tooltip', 'top' ) !== 'no' ) {
						wp_enqueue_style( 'hint', WPCVS_URI . 'assets/css/hint.css' );
					}

					if ( get_option( 'wpcvs_archive_enable', 'no' ) === 'yes' ) {
						wp_enqueue_script( 'wc-add-to-cart-variation' );
					}

					wp_enqueue_style( 'wpcvs-frontend', WPCVS_URI . 'assets/css/frontend.css', array(), WPCVS_VERSION );
					wp_enqueue_script( 'wpcvs-frontend', WPCVS_URI . 'assets/js/frontend.js', array( 'jquery' ), WPCVS_VERSION, true );

					$archive_product = apply_filters( 'wpcvs_archive_product_selector', '' );

					if ( empty( $archive_product ) ) {
						$archive_product = get_option( 'wpcvs_archive_product', '.product' );
					}

					$archive_image = apply_filters( 'wpcvs_archive_image_selector', '' );

					if ( empty( $archive_image ) ) {
						$archive_image = get_option( 'wpcvs_archive_image', '.attachment-woocommerce_thumbnail' );
					}

					$archive_atc = apply_filters( 'wpcvs_archive_atc_selector', '' );

					if ( empty( $archive_atc ) ) {
						$archive_atc = get_option( 'wpcvs_archive_atc', '.add_to_cart_button' );
					}

					$archive_atc_text = apply_filters( 'wpcvs_archive_atc_text_selector', '' );

					if ( empty( $archive_atc_text ) ) {
						$archive_atc_text = get_option( 'wpcvs_archive_atc_text', '.add_to_cart_button' );
					}

					wp_localize_script( 'wpcvs-frontend', 'wpcvs_vars', array(
							'ajax_url'         => admin_url( 'admin-ajax.php' ),
							'nonce'            => wp_create_nonce( 'wpcvs_nonce' ),
							'second_click'     => get_option( 'wpcvs_second_click', 'no' ),
							'archive_enable'   => get_option( 'wpcvs_archive_enable', 'no' ),
							'archive_product'  => ! empty( $archive_product ) ? esc_attr( $archive_product ) : '.product',
							'archive_image'    => ! empty( $archive_image ) ? esc_attr( $archive_image ) : '.attachment-woocommerce_thumbnail',
							'archive_atc'      => ! empty( $archive_atc ) ? esc_attr( $archive_atc ) : '.add_to_cart_button',
							'archive_atc_text' => ! empty( $archive_atc_text ) ? esc_attr( $archive_atc_text ) : '.add_to_cart_button',
							'add_to_cart'      => esc_html__( 'Add to cart', 'wpc-variation-swatches' ),
							'select_options'   => esc_html__( 'Select options', 'wpc-variation-swatches' ),
							'view_cart'        => '<a href="' . wc_get_cart_url() . '" class="added_to_cart wc-forward" title="' . esc_attr__( 'View cart', 'wpc-variation-swatches' ) . '">' . esc_html__( 'View cart', 'wpc-variation-swatches' ) . '</a>',
						)
					);
				}

				function admin_scripts() {
					$args = array(
						'placeholder_img' => wc_placeholder_img_src()
					);
					wp_enqueue_script( 'wpcvs-backend', WPCVS_URI . 'assets/js/backend.js', array(
						'jquery',
						'wp-color-picker'
					), WPCVS_VERSION, true );
					wp_localize_script( 'wpcvs-backend', 'wpcvs_vars', $args );
				}

				function admin_menu() {
					add_submenu_page( 'wpclever', esc_html__( 'WPC Variation Swatches', 'wpc-variation-swatches' ), esc_html__( 'Variation Swatches', 'wpc-variation-swatches' ), 'manage_options', 'wpclever-wpcvs', array(
						&$this,
						'admin_menu_content'
					) );
				}

				function admin_menu_content() {
					$active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'settings';
					?>
                    <div class="wpclever_settings_page wrap">
                        <h1 class="wpclever_settings_page_title"><?php echo esc_html__( 'WPC Variation Swatches', 'wpc-variation-swatches' ) . ' ' . WPCVS_VERSION; ?></h1>
                        <div class="wpclever_settings_page_desc about-text">
                            <p>
								<?php printf( esc_html__( 'Thank you for using our plugin! If you are satisfied, please reward it a full five-star %s rating.', 'wpc-variation-swatches' ), '<span style="color:#ffb900">&#9733;&#9733;&#9733;&#9733;&#9733;</span>' ); ?>
                                <br/>
                                <a href="<?php echo esc_url( WPCVS_REVIEWS ); ?>"
                                   target="_blank"><?php esc_html_e( 'Reviews', 'wpc-variation-swatches' ); ?></a> | <a
                                        href="<?php echo esc_url( WPCVS_CHANGELOG ); ?>"
                                        target="_blank"><?php esc_html_e( 'Changelog', 'wpc-variation-swatches' ); ?></a>
                                | <a href="<?php echo esc_url( WPCVS_DISCUSSION ); ?>"
                                     target="_blank"><?php esc_html_e( 'Discussion', 'wpc-variation-swatches' ); ?></a>
                            </p>
                        </div>
                        <div class="wpclever_settings_page_nav">
                            <h2 class="nav-tab-wrapper">
                                <a href="<?php echo admin_url( 'admin.php?page=wpclever-wpcvs&tab=settings' ); ?>"
                                   class="<?php echo esc_attr( $active_tab === 'settings' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
									<?php esc_html_e( 'Settings', 'wpc-variation-swatches' ); ?>
                                </a>
                                <a href="<?php echo admin_url( 'admin.php?page=wpclever-kit' ); ?>" class="nav-tab">
									<?php esc_html_e( 'Essential Kit', 'wpc-variation-swatches' ); ?>
                                </a>
                            </h2>
                        </div>
                        <div class="wpclever_settings_page_content">
							<?php if ( $active_tab === 'settings' ) {
								$button_default   = get_option( 'wpcvs_button_default', 'no' );
								$second_click     = get_option( 'wpcvs_second_click', 'no' );
								$tooltip          = get_option( 'wpcvs_tooltip', 'top' );
								$style            = get_option( 'wpcvs_style', 'square' );
								$archive_enable   = get_option( 'wpcvs_archive_enable', 'no' );
								$archive_position = get_option( 'wpcvs_archive_position', 'before' );
								?>
                                <form method="post" action="options.php">
									<?php wp_nonce_field( 'update-options' ); ?>
                                    <table class="form-table">
                                        <tr class="heading">
                                            <th colspan="2">
												<?php esc_html_e( 'General', 'wpc-variation-swatches' ); ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Button swatch by default', 'wpc-variation-swatches' ); ?></th>
                                            <td>
                                                <select name="wpcvs_button_default">
                                                    <option value="yes" <?php echo esc_attr( $button_default === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variation-swatches' ); ?></option>
                                                    <option value="no" <?php echo esc_attr( $button_default === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variation-swatches' ); ?></option>
                                                </select>
                                                <span class="description">
                                                    <?php esc_html_e( 'Turn the default type to button type.', 'wpc-variation-swatches' ); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Enable second click to undo?', 'wpc-variation-swatches' ); ?></th>
                                            <td>
                                                <select name="wpcvs_second_click">
                                                    <option value="yes" <?php echo esc_attr( $second_click === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variation-swatches' ); ?></option>
                                                    <option value="no" <?php echo esc_attr( $second_click === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variation-swatches' ); ?></option>
                                                </select>
                                                <span class="description">
                                                    <?php esc_html_e( 'Enable/disable click again to undo the selection on current attribute.', 'wpc-variation-swatches' ); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Tooltip position', 'wpc-variation-swatches' ); ?></th>
                                            <td>
                                                <select name="wpcvs_tooltip">
                                                    <option value="top" <?php echo esc_attr( $tooltip === 'top' ? 'selected' : '' ); ?>><?php esc_html_e( 'Top', 'wpc-variation-swatches' ); ?></option>
                                                    <option value="right" <?php echo esc_attr( $tooltip === 'right' ? 'selected' : '' ); ?>><?php esc_html_e( 'Right', 'wpc-variation-swatches' ); ?></option>
                                                    <option value="bottom" <?php echo esc_attr( $tooltip === 'bottom' ? 'selected' : '' ); ?>><?php esc_html_e( 'Bottom', 'wpc-variation-swatches' ); ?></option>
                                                    <option value="left" <?php echo esc_attr( $tooltip === 'left' ? 'selected' : '' ); ?>><?php esc_html_e( 'Left', 'wpc-variation-swatches' ); ?></option>
                                                    <option value="no" <?php echo esc_attr( $tooltip === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variation-swatches' ); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Style', 'wpc-variation-swatches' ); ?></th>
                                            <td>
                                                <select name="wpcvs_style">
                                                    <option value="square" <?php echo esc_attr( $style === 'square' ? 'selected' : '' ); ?>><?php esc_html_e( 'Square', 'wpc-variation-swatches' ); ?></option>
                                                    <option value="rounded" <?php echo esc_attr( $style === 'rounded' ? 'selected' : '' ); ?>><?php esc_html_e( 'Rounded', 'wpc-variation-swatches' ); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="heading">
                                            <th colspan="2">
												<?php esc_html_e( 'Shop/ Archive', 'wpc-variation-swatches' ); ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Enable', 'wpc-variation-swatches' ); ?></th>
                                            <td>
                                                <select name="wpcvs_archive_enable">
                                                    <option value="yes" <?php echo esc_attr( $archive_enable === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variation-swatches' ); ?></option>
                                                    <option value="no" <?php echo esc_attr( $archive_enable === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variation-swatches' ); ?></option>
                                                </select>
                                                <span class="description">
                                                    <?php esc_html_e( 'Enable swatches for shop/ archive page.', 'wpc-variation-swatches' ); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Position', 'wpc-variation-swatches' ); ?></th>
                                            <td>
                                                <select name="wpcvs_archive_position">
                                                    <option value="before" <?php echo esc_attr( $archive_position === 'before' ? 'selected' : '' ); ?>><?php esc_html_e( 'Before add to cart button', 'wpc-variation-swatches' ); ?></option>
                                                    <option value="after" <?php echo esc_attr( $archive_position === 'after' ? 'selected' : '' ); ?>><?php esc_html_e( 'After add to cart button', 'wpc-variation-swatches' ); ?></option>
                                                    <option value="none" <?php echo esc_attr( $archive_position === 'none' ? 'selected' : '' ); ?>><?php esc_html_e( 'None', 'wpc-variation-swatches' ); ?></option>
                                                </select>
                                                <span class="description">
                                                    <?php printf( esc_html__( 'Swatches position on archive page. You also can use the shortcode: %s', 'wpc-variation-swatches' ), '<code>[wpcvs_archive]</code>' ); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Product wrapper selector', 'wpc-variation-swatches' ); ?></th>
                                            <td>
												<?php $archive_product = apply_filters( 'wpcvs_archive_product_selector', '' ); ?>
                                                <input type="text" name="wpcvs_archive_product"
                                                       value="<?php echo esc_attr( ! empty( $archive_product ) ? $archive_product : get_option( 'wpcvs_archive_product' ) ); ?>"
													<?php echo( ! empty( $archive_product ) ? 'readonly' : 'placeholder=".product"' ); ?>/>
                                                <span class="description">
													<?php printf( esc_html__( 'Archive product wrapper selector. Default: %s', 'wpc-variation-swatches' ), '<code>.product</code>' ); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Image selector', 'wpc-variation-swatches' ); ?></th>
                                            <td>
												<?php $archive_image = apply_filters( 'wpcvs_archive_image_selector', '' ); ?>
                                                <input type="text" name="wpcvs_archive_image"
                                                       value="<?php echo esc_attr( ! empty( $archive_image ) ? $archive_image : get_option( 'wpcvs_archive_image' ) ); ?>"
													<?php echo( ! empty( $archive_image ) ? 'readonly' : 'placeholder=".attachment-woocommerce_thumbnail"' ); ?>/>
                                                <span class="description">
													<?php printf( esc_html__( 'Archive product image selector to show variation image. Default: %s', 'wpc-variation-swatches' ), '<code>.attachment-woocommerce_thumbnail</code>' ); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Add to cart button selector', 'wpc-variation-swatches' ); ?></th>
                                            <td>
												<?php $archive_atc = apply_filters( 'wpcvs_archive_atc_selector', '' ); ?>
                                                <input type="text" name="wpcvs_archive_atc"
                                                       value="<?php echo esc_attr( ! empty( $archive_atc ) ? $archive_atc : get_option( 'wpcvs_archive_atc' ) ); ?>"
													<?php echo( ! empty( $archive_atc ) ? 'readonly' : 'placeholder=".add_to_cart_button"' ); ?>/>
                                                <span class="description">
													<?php printf( esc_html__( 'Archive add to cart button selector. Default: %s', 'wpc-variation-swatches' ), '<code>.add_to_cart_button</code>' ); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Add to cart text selector', 'wpc-variation-swatches' ); ?></th>
                                            <td>
												<?php $archive_atc_text = apply_filters( 'wpcvs_archive_atc_text_selector', '' ); ?>
                                                <input type="text" name="wpcvs_archive_atc_text"
                                                       value="<?php echo esc_attr( ! empty( $archive_atc_text ) ? $archive_atc_text : get_option( 'wpcvs_archive_atc_text' ) ); ?>"
													<?php echo( ! empty( $archive_atc_text ) ? 'readonly' : 'placeholder=".add_to_cart_button"' ); ?>/>
                                                <span class="description">
													<?php printf( esc_html__( 'Archive add to cart button text selector. Default: %s', 'wpc-variation-swatches' ), '<code>.add_to_cart_button</code>' ); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="submit">
                                            <th colspan="2">
                                                <input type="submit" name="submit" class="button button-primary"
                                                       value="<?php esc_html_e( 'Update Options', 'wpc-variation-swatches' ); ?>"/>
                                                <input type="hidden" name="action" value="update"/>
                                                <input type="hidden" name="page_options"
                                                       value="wpcvs_button_default,wpcvs_second_click,wpcvs_tooltip,wpcvs_style,wpcvs_archive_enable,wpcvs_archive_position,wpcvs_archive_product,wpcvs_archive_image,wpcvs_archive_atc,wpcvs_archive_atc_text"/>
                                            </th>
                                        </tr>
                                    </table>
                                </form>
							<?php } ?>
                        </div>
                    </div>
					<?php
				}

				function wpcvs_action_links( $links, $file ) {
					static $plugin;

					if ( ! isset( $plugin ) ) {
						$plugin = plugin_basename( __FILE__ );
					}

					if ( $plugin === $file ) {
						$settings = '<a href="' . admin_url( 'admin.php?page=wpclever-wpcvs&tab=settings' ) . '">' . esc_html__( 'Settings', 'wpc-variation-swatches' ) . '</a>';
						array_unshift( $links, $settings );
					}

					return (array) $links;
				}

				function wpcvs_row_meta( $links, $file ) {
					static $plugin;

					if ( ! isset( $plugin ) ) {
						$plugin = plugin_basename( __FILE__ );
					}

					if ( $plugin === $file ) {
						$row_meta = array(
							'support' => '<a href="' . esc_url( WPCVS_DISCUSSION ) . '" target="_blank">' . esc_html__( 'Community support', 'wpc-variation-swatches' ) . '</a>',
						);

						return array_merge( $links, $row_meta );
					}

					return (array) $links;
				}

				function type_selector( $types ) {
					global $pagenow;

					if ( ( $pagenow === 'post-new.php' ) || ( $pagenow === 'post.php' ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
						return $types;
					} else {
						$types['select'] = esc_html__( 'Select', 'wpc-variation-swatches' );
						$types['button'] = esc_html__( 'Button', 'wpc-variation-swatches' );
						$types['color']  = esc_html__( 'Color', 'wpc-variation-swatches' );
						$types['image']  = esc_html__( 'Image', 'wpc-variation-swatches' );
						$types['radio']  = esc_html__( 'Radio', 'wpc-variation-swatches' );

						return $types;
					}
				}

				function show_field( $term_or_tax ) {
					if ( is_object( $term_or_tax ) ) {
						// is term
						$term_id    = $term_or_tax->term_id;
						$attr_id    = wc_attribute_taxonomy_id_by_name( $term_or_tax->taxonomy );
						$attr       = wc_get_attribute( $attr_id );
						$wrap_start = '<tr class="form-field"><th><label>';
						$wrap_mid   = '</label></th><td>';
						$wrap_end   = '</td></tr>';
					} else {
						// is taxonomy
						$term_id    = 0;
						$attr_id    = wc_attribute_taxonomy_id_by_name( $term_or_tax );
						$attr       = wc_get_attribute( $attr_id );
						$wrap_start = '<div class="form-field"><label>';
						$wrap_mid   = '</label>';
						$wrap_end   = '</div>';
					}

					$wpcvs_tooltip = get_term_meta( $term_id, 'wpcvs_tooltip', true );

					switch ( $attr->type ) {
						case 'button':
							$wpcvs_val = get_term_meta( $term_id, 'wpcvs_button', true );
							echo $wrap_start . esc_html__( 'Button', 'wpc-variation-swatches' ) . $wrap_mid . '<input id="wpcvs_button" name="wpcvs_button" value="' . esc_attr( $wpcvs_val ) . '" type="text"/>' . $wrap_end;
							echo $wrap_start . esc_html__( 'Tooltip', 'wpc-variation-swatches' ) . $wrap_mid . '<input id="wpcvs_tooltip" name="wpcvs_tooltip" value="' . esc_attr( $wpcvs_tooltip ) . '" type="text"/>' . $wrap_end;

							break;
						case 'color':
							$wpcvs_val = get_term_meta( $term_id, 'wpcvs_color', true );
							echo $wrap_start . esc_html__( 'Color', 'wpc-variation-swatches' ) . $wrap_mid . '<input class="wpcvs_color" id="wpcvs_color" name="wpcvs_color" value="' . esc_attr( $wpcvs_val ) . '" type="text"/>' . $wrap_end;
							echo $wrap_start . esc_html__( 'Tooltip', 'wpc-variation-swatches' ) . $wrap_mid . '<input id="wpcvs_tooltip" name="wpcvs_tooltip" value="' . esc_attr( $wpcvs_tooltip ) . '" type="text"/>' . $wrap_end;

							break;
						case 'image':
							wp_enqueue_media();
							$wpcvs_val = get_term_meta( $term_id, 'wpcvs_image', true );

							if ( $wpcvs_val ) {
								$image = wp_get_attachment_thumb_url( $wpcvs_val );
							} else {
								$image = wc_placeholder_img_src();
							}

							echo $wrap_start . 'Image' . $wrap_mid; ?>
                            <div id="wpcvs_image_thumbnail" style="float: left; margin-right: 10px;"><img
                                        src="<?php echo esc_url( $image ); ?>" width="60px" height="60px"/></div>
                            <div style="line-height: 60px;">
                                <input type="hidden" id="wpcvs_image" name="wpcvs_image"
                                       value="<?php echo esc_attr( $wpcvs_val ); ?>"/>
                                <button id="wpcvs_upload_image" type="button"
                                        class="wpcvs_upload_image button"><?php esc_html_e( 'Upload/Add image', 'wpc-variation-swatches' ); ?>
                                </button>
                                <button id="wpcvs_remove_image" type="button"
                                        class="wpcvs_remove_image button"><?php esc_html_e( 'Remove image', 'wpc-variation-swatches' ); ?>
                                </button>
                            </div>
							<?php
							echo $wrap_end;
							echo $wrap_start . 'Tooltip' . $wrap_mid . '<input id="wpcvs_tooltip" name="wpcvs_tooltip" value="' . esc_attr( $wpcvs_tooltip ) . '" type="text"/>' . $wrap_end;

							break;
						case 'radio':
							$wpcvs_val = get_term_meta( $term_id, 'wpcvs_radio', true );
							echo $wrap_start . esc_html__( 'Label', 'wpc-variation-swatches' ) . $wrap_mid . '<input id="wpcvs_radio" name="wpcvs_radio" value="' . esc_attr( $wpcvs_val ) . '" type="text"/>' . $wrap_end;
							echo $wrap_start . esc_html__( 'Tooltip', 'wpc-variation-swatches' ) . $wrap_mid . '<input id="wpcvs_tooltip" name="wpcvs_tooltip" value="' . esc_attr( $wpcvs_tooltip ) . '" type="text"/>' . $wrap_end;

							break;
						default:
							echo '';
					}
				}

				function save_field( $term_id ) {
					if ( isset( $_POST['wpcvs_color'] ) ) {
						update_term_meta( $term_id, 'wpcvs_color', sanitize_text_field( $_POST['wpcvs_color'] ) );
					}

					if ( isset( $_POST['wpcvs_button'] ) ) {
						update_term_meta( $term_id, 'wpcvs_button', sanitize_text_field( $_POST['wpcvs_button'] ) );
					}

					if ( isset( $_POST['wpcvs_image'] ) ) {
						update_term_meta( $term_id, 'wpcvs_image', sanitize_text_field( $_POST['wpcvs_image'] ) );
					}

					if ( isset( $_POST['wpcvs_radio'] ) ) {
						update_term_meta( $term_id, 'wpcvs_radio', sanitize_text_field( $_POST['wpcvs_radio'] ) );
					}

					if ( isset( $_POST['wpcvs_tooltip'] ) ) {
						update_term_meta( $term_id, 'wpcvs_tooltip', sanitize_text_field( $_POST['wpcvs_tooltip'] ) );
					}
				}

				function variation_attribute_options_html( $html, $args ) {
					$options    = $args['options'];
					$product    = $args['product'];
					$attribute  = $args['attribute'];
					$hint       = get_option( 'wpcvs_tooltip', 'top' );
					$hint_class = $hint !== 'no' ? 'hint--' . $hint : '';
					$style      = get_option( 'wpcvs_style', 'square' );
					$attr_id    = wc_attribute_taxonomy_id_by_name( $attribute );
					$wpcvs_html = '';

					if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
						$attributes = $product->get_variation_attributes();
						$options    = $attributes[ $attribute ];
					}

					if ( $attr_id ) {
						$attr      = wc_get_attribute( $attr_id );
						$attr_type = isset( $attr->type ) ? $attr->type : 'select';

						$terms = wc_get_product_terms(
							$product->get_id(),
							$attribute,
							array(
								'fields' => 'all',
							)
						);

						if ( ( $attr_type === 'select' ) && ( get_option( 'wpcvs_button_default', 'no' ) === 'yes' ) ) {
							$attr_type = 'button';
						}

						if ( ( $attr_type !== '' ) && ( $attr_type !== 'select' ) ) {
							$wpcvs_html .= '<div class="wpcvs-terms wpcvs-type-' . esc_attr( $attr_type ) . ' wpcvs-style-' . $style . '" data-attribute="' . esc_attr( $attribute ) . '">';

							switch ( $attr_type ) {
								case 'button' :
									foreach ( $terms as $term ) {
										$val        = get_term_meta( $term->term_id, 'wpcvs_button', true ) ?: $term->name;
										$tooltip    = get_term_meta( $term->term_id, 'wpcvs_tooltip', true ) ?: $val;
										$wpcvs_html .= '<span class="wpcvs-term ' . $hint_class . '" aria-label="' . esc_attr( $tooltip ) . '" title="' . esc_attr( $tooltip ) . '" data-term="' . esc_attr( $term->slug ) . '"><span>' . esc_html( $val ) . '</span></span>';
									}

									break;
								case 'color':
									foreach ( $terms as $term ) {
										$val        = get_term_meta( $term->term_id, 'wpcvs_color', true ) ?: '';
										$tooltip    = get_term_meta( $term->term_id, 'wpcvs_tooltip', true ) ?: $term->name;
										$wpcvs_html .= '<span class="wpcvs-term ' . $hint_class . '" aria-label="' . esc_attr( $tooltip ) . '" title="' . esc_attr( $tooltip ) . '" data-term="' . esc_attr( $term->slug ) . '"><span ' . ( ! empty( $val ) ? 'style="background-color: ' . esc_attr( $val ) . '"' : '' ) . '>' . esc_html( $val ) . '</span></span>';
									}

									break;
								case 'image':
									foreach ( $terms as $term ) {
										$val        = get_term_meta( $term->term_id, 'wpcvs_image', true ) ? wp_get_attachment_thumb_url( get_term_meta( $term->term_id, 'wpcvs_image', true ) ) : wc_placeholder_img_src();
										$tooltip    = get_term_meta( $term->term_id, 'wpcvs_tooltip', true ) ?: $term->name;
										$wpcvs_html .= '<span class="wpcvs-term ' . $hint_class . '" aria-label="' . esc_attr( $tooltip ) . '" title="' . esc_attr( $tooltip ) . '" data-term="' . esc_attr( $term->slug ) . '"><span><img src="' . esc_url( $val ) . '" alt="' . esc_attr( $term->name ) . '"/></span></span>';
									}

									break;
								case 'radio':
									$name = uniqid( 'wpcvs_radio_' );

									foreach ( $terms as $term ) {
										$val        = get_term_meta( $term->term_id, 'wpcvs_radio', true ) ?: $term->name;
										$tooltip    = get_term_meta( $term->term_id, 'wpcvs_tooltip', true ) ?: $term->name;
										$wpcvs_html .= '<span class="wpcvs-term ' . $hint_class . '" aria-label="' . esc_attr( $tooltip ) . '" title="' . esc_attr( $tooltip ) . '" data-term="' . esc_attr( $term->slug ) . '"><span><input type="radio" name="' . esc_attr( $name ) . '" value="' . esc_attr( $term->slug ) . '"/> ' . esc_html( $val ) . '</span></span>';
									}

									break;
								default:
									break;
							}

							$wpcvs_html .= '</div>';
						}
					} else {
						// custom attribute
						if ( get_option( 'wpcvs_button_default', 'no' ) === 'yes' ) {
							$wpcvs_html .= '<div class="wpcvs-terms wpcvs-type-button wpcvs-style-' . $style . '" data-attribute="' . sanitize_key( esc_attr( $attribute ) ) . '">';

							foreach ( $options as $option ) {
								$wpcvs_html .= '<span class="wpcvs-term ' . $hint_class . '" aria-label="' . esc_attr( $option ) . '" title="' . esc_attr( $option ) . '" data-term="' . esc_attr( $option ) . '"><span>' . esc_html( $option ) . '</span></span>';
							}

							$wpcvs_html .= '</div>';
						}
					}

					return $wpcvs_html . $html;
				}

				function custom_columns( $columns ) {
					$columns['wpcvs_value']   = esc_html__( 'Value', 'wpc-variation-swatches' );
					$columns['wpcvs_tooltip'] = esc_html__( 'Tooltip', 'wpc-variation-swatches' );

					return $columns;
				}

				function custom_columns_content( $columns, $column, $term_id ) {
					if ( $column === 'wpcvs_value' ) {
						$term    = get_term( $term_id );
						$attr_id = wc_attribute_taxonomy_id_by_name( $term->taxonomy );
						$attr    = wc_get_attribute( $attr_id );

						switch ( $attr->type ) {
							case 'image':
								$val = get_term_meta( $term_id, 'wpcvs_image', true );
								echo '<img style="display: inline-block; border-radius: 3px; width: 40px; height: 40px; background-color: #eee; box-sizing: border-box; border: 1px solid #eee;" src="' . esc_url( $val ? wp_get_attachment_thumb_url( $val ) : wc_placeholder_img_src() ) . '"/>';

								break;
							case 'color':
								$val = get_term_meta( $term_id, 'wpcvs_color', true );
								echo '<span style="display: inline-block; border-radius: 3px; width: 40px; height: 40px; background-color: ' . esc_attr( $val ) . '; box-sizing: border-box; border: 1px solid #eee;"></span>';

								break;
							case 'button':
								$val = get_term_meta( $term_id, 'wpcvs_button', true );
								echo '<span style="display: inline-block; border-radius: 3px; height: 40px; line-height: 40px; padding: 0 15px; border: 1px solid #eee; background-color: #fff; min-width: 44px; box-sizing: border-box;">' . esc_html( $val ) . '</span>';

								break;
						}
					}

					if ( $column === 'wpcvs_tooltip' ) {
						echo get_term_meta( $term_id, 'wpcvs_tooltip', true );
					}
				}

				function archive( $product_id = null ) {
					if ( $product_id ) {
						$product = wc_get_product( $product_id );
					} else {
						global $product;
					}

					if ( ! $product || ! $product->is_type( 'variable' ) ) {
						return;
					}

					$attributes           = $product->get_variation_attributes();
					$available_variations = $product->get_available_variations();
					$variations_json      = wp_json_encode( $available_variations );
					$variations_attr      = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

					if ( is_array( $attributes ) && ( count( $attributes ) > 0 ) ) {
						echo '<div class="variations_form wpcvs_archive" data-product_id="' . absint( $product->get_id() ) . '" data-product_variations="' . $variations_attr . '">';
						echo '<div class="variations">';

						foreach ( $attributes as $attribute_name => $options ) { ?>
                            <div class="variation">
                                <div class="label">
									<?php echo wc_attribute_label( $attribute_name ); ?>
                                </div>
                                <div class="select">
									<?php
									$attr     = 'attribute_' . sanitize_title( $attribute_name );
									$selected = isset( $_REQUEST[ $attr ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ $attr ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );
									wc_dropdown_variation_attribute_options( array(
										'options'          => $options,
										'attribute'        => $attribute_name,
										'product'          => $product,
										'selected'         => $selected,
										'show_option_none' => esc_html__( 'Choose', 'wpc-variation-swatches' ) . ' ' . wc_attribute_label( $attribute_name )
									) );
									?>
                                </div>
                            </div>
						<?php }

						echo '<div class="reset">' . apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'wpc-variation-swatches' ) . '</a>' ) . '</div>';
						echo '</div>';
						echo '</div>';
					}
				}
			}

			new WPCleverWpcvs();
		}
	}
}

if ( ! function_exists( 'wpcvs_notice_wc' ) ) {
	function wpcvs_notice_wc() {
		?>
        <div class="error">
            <p><strong>WPC Variation Swatches</strong> requires WooCommerce version 3.0 or greater.</p>
        </div>
		<?php
	}
}
