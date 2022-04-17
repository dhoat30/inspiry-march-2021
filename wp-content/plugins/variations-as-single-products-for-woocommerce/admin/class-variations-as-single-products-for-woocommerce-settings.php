<?php
/**
 * The admin-settings functionality of the plugin.
 *
 * @link       http://procomsoftsol.com
 * @since      1.0.0
 *
 * @package    Variations_As_Single_Products_For_Woocommerce
 * @subpackage Variations_As_Single_Products_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Variations_As_Single_Products_For_Woocommerce
 * @subpackage Variations_As_Single_Products_For_Woocommerce/admin
 */
class Variations_As_Single_Products_For_Woocommerce_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0

	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0

	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Settings id
	 *
	 * @since    1.0.0

	 * @var      string
	 */
	private $id;

	 /**
	  * Settings label
	  *
	  * @since    1.0.0

	  * @var      string
	  */
	private $label;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->id    = 'variations_as_single_products_for_woocommerce';
		$this->label = _x( 'Variations as Products', 'Settings tab label', 'variations-as-single-products-for-woocommerce' );

		add_filter( 'woocommerce_settings_tabs_array', array( &$this, 'add_settings_tab' ), 50 );
		add_action( 'woocommerce_settings_' . $this->id, array( &$this, 'settings_tab' ) );
		add_action( 'woocommerce_update_options_' . $this->id, array( &$this, 'update_settings' ) );
		add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );

		add_action( 'woocommerce_admin_field_process_variations', array( $this, 'process_variations_field' ), 10, 1 );

		add_action( 'init', array( $this, 'check_update_variations' ) );

	}

	/**
	 * Add a new settings tab to the WooCommerce settings tabs array.
	 *
	 * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
	 * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
	 */
	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs[ $this->id ] = $this->label;
		return $settings_tabs;
	}

	/**
	 * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
	 *
	 * @uses woocommerce_admin_fields()
	 * @uses self::get_settings()
	 */
	public function settings_tab() {
		global $current_section;
		woocommerce_admin_fields( $this->get_settings( $current_section ) );
	}

	/**
	 * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
	 *
	 * @uses woocommerce_update_options()
	 * @uses self::get_settings()
	 */
	public function update_settings() {
		global $current_section;
		woocommerce_update_options( $this->get_settings( $current_section ) );
	}

	/**
	 * Print sub menus
	 */
	public function output_sections() {
		global $current_section;

		$sections = $this->get_sections();

		if ( empty( $sections ) || 1 === count( $sections ) ) {
			return;
		}

		echo '<ul class="subsubsub">';

		$array_keys = array_keys( $sections );

		foreach ( $sections as $id => $label ) {
			echo '<li><a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=' . $this->id . '&section=' . sanitize_title( $id ) ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . esc_attr( $label ) . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
		}

		echo '</ul><br class="clear" />';
	}

	/**
	 * Get settings sections
	 *
	 * @since     1.0.0
	 */
	public function get_sections() {
		$sections = array(
			'' => esc_attr__( 'General options', 'variations-as-single-products-for-woocommerce' ),
		);

		$sections = apply_filters( 'variations_as_single_products_for_woocommerce_settings_sections', $sections );

		return $sections;
	}

	/**
	 * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
	 *
	 * @since     1.0.0
	 * @param    string $current_section Curent section.
	 * @return array Array of settings for @see woocommerce_admin_fields() function.
	 */
	public function get_settings( $current_section = '' ) {
		$settings = array();
		$id       = $this->id . '_' . $current_section;

		if ( isset( $_GET['message'] ) && 'success' == $_GET['message'] ) {
			echo '<div id="message" class="updated inline"><p>' . esc_html__( 'All veriations updated', 'variations-as-single-products-for-woocommerce' ) . '</p></div>';
		}

		if ( '' == $current_section ) {
			$id       = $this->id;
			$settings = array(

				'section_title'  => array(
					'name' => esc_attr__( 'Plugin Settings', 'variations-as-single-products-for-woocommerce' ),
					'type' => 'title',
					'desc' => '',
					'id'   => $id . '_section_title',
				),
				'enable'         => array(
					'name'    => esc_attr__( 'Enable/Disable', 'variations-as-single-products-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'yes',
					'desc'    => esc_attr__( 'Display all product variations as single product on shop and category pages.', 'variations-as-single-products-for-woocommerce' ),
					'id'      => $id . '_enable',
				),
				'hide_parents'   => array(
					'name'    => esc_attr__( 'Hide parent products', 'variations-as-single-products-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'yes',
					'desc'    => esc_attr__( 'Hide parent products on shop and category pages.', 'variations-as-single-products-for-woocommerce' ),
					'id'      => $id . '_hide_parents',
				),
				'process_childs' => array(
					'name'    => esc_attr__( 'Process variations to display on shop/category pages', 'variations-as-single-products-for-woocommerce' ),
					'type'    => 'process_variations',
					'default' => 'yes',
					'id'      => $id . '_process_childs',
				),

				'section_end'    => array(
					'type' => 'sectionend',
					'id'   => $id . '_section_end',
				),
			);
		}

		$settings = apply_filters( 'variations_as_single_products_for_woocommerce_sections_settings', $settings, $current_section, $this->id );
		return apply_filters( 'wc_settings_tab_' . $this->id, $settings );
	}

	/**
	 * Create new field type for settings
	 *
	 * @since    1.0.0
	 * @param    array $value    Variations field.
	 */
	public function process_variations_field( $value ) {
		global $wpdb;
		$count = $wpdb->get_var( $wpdb->prepare( "SELECT count(ID) as total  FROM {$wpdb->posts} as t1 LEFT JOIN {$wpdb->postmeta} as t2 ON (t1.ID = t2.post_id AND t2.meta_key = '_is_vaspfw_cat_updated' ) WHERE 1=1  AND ( t2.post_id IS NULL) AND t1.post_type = 'product_variation' AND (t1.post_status = 'publish' OR t1.post_status = 'future' OR t1.post_status = 'draft' OR t1.post_status = 'pending' OR t1.post_status = 'private')" ) );
		if ( $count ) {
			?>
			<tr valign="top">
				<th>
				<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
				</th>
				<td>
				<?php /* translators: %s count */ ?>
				<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=wc-settings&tab=variations_as_single_products_for_woocommerce&vaspfw_woo_task=update_variations' ), 'update_variations', 'update_variations_nonce' ) ); ?>" class="button button-primary"><?php printf( esc_html__( 'Process %s variations', 'variations-as-single-products-for-woocommerce' ), esc_html( $count ) ); ?></a>
				</td>
			</tr>
			<?php
		} else {
			?>
			<tr valign="top">
				<th>
				<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
				</th>
				<td>
				<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=wc-settings&tab=variations_as_single_products_for_woocommerce&vaspfw_woo_task=update_variations' ), 'update_variations', 'update_variations_nonce' ) ); ?>" class="button button-primary"><?php echo esc_html__( 'Re Process all variations', 'variations-as-single-products-for-woocommerce' ); ?></a>
				</td>
			</tr>
			<?php
		}
	}

	/**
	 * Update product variations
	 *
	 * @since    1.0.0
	 */
	public function check_update_variations() {
		if ( isset( $_GET['vaspfw_woo_task'] ) && 'update_variations' == $_GET['vaspfw_woo_task'] ) {

			if ( isset( $_GET['update_variations_nonce'] ) && wp_verify_nonce( sanitize_text_field( $_GET['update_variations_nonce'] ), 'update_variations' ) ) { // WPCS: input var ok, sanitization ok.

							global $wpdb;
							$sql = $wpdb->delete(
								$wpdb->postmeta,
								array(
									'meta_key'   => '_vaspfw_exclude_variation',
									'meta_value' => '',
								)
							);

							$args  = array(
								'post_type'      => 'product_variation',
								'posts_per_page' => -1,
							);
							$query = new WP_Query( $args );
							if ( $query->have_posts() ) {
								while ( $query->have_posts() ) {
									$query->the_post();
									$variation_id      = get_the_id();
									$parent_product_id = wp_get_post_parent_id( $variation_id );
												$meta  = get_post_meta( $variation_id, '_vaspfw_exclude_variation', true );

									if ( $parent_product_id ) {
										$taxonomies = array(
											'product_cat',
											'product_tag',
										);
										foreach ( $taxonomies as $taxonomy ) {
											$terms = (array) wp_get_post_terms( $parent_product_id, $taxonomy, array( 'fields' => 'ids' ) );
											wp_set_post_terms( $variation_id, $terms, $taxonomy );

										}
										update_post_meta( $variation_id, '_is_vaspfw_cat_updated', 'yes' );

										$variation = new WC_Product_Variation( $variation_id );

										$attributes = $variation->get_variation_attributes();
										if ( ! empty( $attributes ) ) {
											foreach ( $attributes as $key => $term ) {
												$attr_tax = str_replace( 'attribute_', '', $key );
												wp_set_post_terms( $variation_id, $term, $attr_tax );
											}
										}
										if ( ! $parent_product ) {
											continue;
										}
										$parent_attributes = $parent_product->get_attributes();
										if ( ! empty( $parent_attributes ) ) {
											foreach ( $parent_attributes as $parent_attribute ) {
												if ( $parent_attribute->get_variation() == true ) {
													continue;
												}

												$attr_tax = $parent_attribute->get_taxonomy();
												$terms    = (array) $parent_attribute->get_terms();
												if ( ! empty( $terms ) ) {
													$term_ids = array();
													foreach ( $terms as $term ) {
														$term_ids[] = $term->term_id;
													}

													wp_set_post_terms( $variation_id, $term_ids, $attr_tax );
												}
											}
										}
									}
								}
							}
							wp_safe_redirect( get_admin_url() . 'admin.php?page=wc-settings&tab=variations_as_single_products_for_woocommerce&message=success' );
							exit;
			}
		}
	}

}
