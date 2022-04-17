<?php
/**
 * The admin-specific functionality of the plugin.
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
class Variations_As_Single_Products_For_Woocommerce_Admin {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		add_filter( 'woocommerce_product_data_tabs', array( $this, 'product_tabs' ) );
		add_filter( 'woocommerce_product_data_panels', array( $this, 'product_panels' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_meta' ) );

		add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'add_fields_to_variations' ), 999, 3 );
		add_action( 'woocommerce_save_product_variation', array( $this, 'save_variation_fields' ), 10, 2 );

	}

	/**
	 * Add plugin action links
	 *
	 * @since      1.0.0
	 * @param      array $links     Plugin links.
	 * @return     array       $links     Plugin links.
	 */
	public function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=variations_as_single_products_for_woocommerce' ) . '" aria-label="' . esc_attr__( 'settings', 'variations-as-single-products-for-woocommerce' ) . '">' . esc_html__( 'Settings', 'variations-as-single-products-for-woocommerce' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}


	/**
	 * Custom products tabs
	 *
	 * @since    1.0.0
	 * @param    array $tabs  Product tabs.
	 */
	public function product_tabs( $tabs ) {
		$tabs['vaspfw_single_variation_tab'] = array(
			'label'    => esc_attr__( 'Single Variation', 'variations-as-single-products-for-woocommerce' ),
			'target'   => 'vaspfw_single_variation_tab_content',
			'priority' => 60,
			'class'    => array( ' show_if_variable ' ),
		);
		return $tabs;
	}

	/**
	 * Add product panel
	 *
	 * @since    1.0.0
	 */
	public function product_panels() {
		global $post;
		?>
		<div id='vaspfw_single_variation_tab_content' class='panel woocommerce_options_panel'>
			<div class='options_group'>
				<?php
					woocommerce_wp_checkbox(
						array(
							'id'          => '_vaspfw_exclude_product_single',
							'label'       => esc_attr__( 'Exclude Variations', 'variations-as-single-products-for-woocommerce' ),
							'cbvalue'     => 'yes',
							'value'       => get_post_meta( get_the_ID(), '_vaspfw_exclude_product_single', true ),
							'description' => esc_attr__( 'Check this option to hide single variations of this product on shop & category pages. ', 'variations-as-single-products-for-woocommerce' ),
						)
					);
				?>
				<?php
					woocommerce_wp_checkbox(
						array(
							'id'          => '_vaspfw_exclude_product_parent',
							'label'       => esc_attr__( 'Hide Parent Product', 'variations-as-single-products-for-woocommerce' ),
							'cbvalue'     => 'yes',
							'value'       => get_post_meta( get_the_ID(), '_vaspfw_exclude_product_parent', true ),
							'description' => esc_attr__( 'Check this option to hide the parent product on shop & category pages.', 'variations-as-single-products-for-woocommerce' ),
						)
					);
				?>
		</div>
		<?php wp_nonce_field( '_vaspfw_single_variation_action', '_vaspfw_single_variation_nonce' ); ?>
	</div>
		<?php
	}

	/**
	 * Save product meta
	 *
	 * @since    1.0.0
	 * @param    integer $post_id   Cuttrnt product id.
	 */
	public function save_meta( $post_id ) {
		if ( isset( $_GET['_vaspfw_single_variation_nonce'] ) && wp_verify_nonce( sanitize_text_field( $_GET['_vaspfw_single_variation_nonce'] ), '_vaspfw_single_variation_action' ) ) { // WPCS: input var ok, sanitization ok.

			$_vaspfw_exclude_product_single = isset( $_POST['_vaspfw_exclude_product_single'] ) ? 'yes' : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( 'yes' == $_vaspfw_exclude_product_single ) {
				update_post_meta( $post_id, '_vaspfw_exclude_product_single', $_vaspfw_exclude_product_single );
			} else {
				delete_post_meta( $post_id, '_vaspfw_exclude_product_single' );
			}
		// phpcs:disable WordPress.Security.NonceVerification.Missing
			$_vaspfw_exclude_product_parent = isset( $_POST['_vaspfw_exclude_product_parent'] ) ? 'yes' : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( 'yes' == $_vaspfw_exclude_product_parent ) {
				update_post_meta( $post_id, '_vaspfw_exclude_product_parent', $_vaspfw_exclude_product_parent );
			} else {
				delete_post_meta( $post_id, '_vaspfw_exclude_product_parent' );
			}
		}
	}

	/**
	 * Add custom fields to product variations
	 *
	 * @since    1.0.0
	 * @param    int   $loop       The loop.
	 * @param    mixed $variation_data   Variation data.
	 * @param    mixed $variation_post    Variation post data.
	 */
	public function add_fields_to_variations( $loop, $variation_data, $variation_post ) {

		woocommerce_wp_text_input(
			array(
				'id'            => '_vaspfw_variation_name' . $variation_post->ID,
				'name'          => '_vaspfw_variation_name[' . $variation_post->ID . ']',
				'value'         => get_post_meta( $variation_post->ID, '_vaspfw_variation_name', true ),
				'type'          => 'text',
				'label'         => esc_attr__( 'Variation Product Name', 'variations-as-single-products-for-woocommerce' ),
				'description'   => esc_attr__( 'This option support for display variations as single product', 'variations-as-single-products-for-woocommerce' ),
				'wrapper_class' => 'form-row form-row-full',
			)
		);
		 $_vaspfw_exclude_variation = get_post_meta( $variation_post->ID, '_vaspfw_exclude_variation', true );
		?>
	   <label class="tips" data-tip="<?php esc_html_e( 'Exclude this variation in shop and category page', 'variations-as-single-products-for-woocommerce' ); ?>">
							<?php echo esc_html_e( '&nbsp;&nbsp; Exclude Variation from display variations as single product', 'variations-as-single-products-for-woocommerce' ); ?>
							<input type="checkbox" class="checkbox" value='yes' name="_vaspfw_exclude_variation[<?php echo esc_attr( $variation_post->ID ); ?>]" <?php checked( 'yes' == $_vaspfw_exclude_variation, true ); ?>/>
		</label>
		<?php
	}

	/**
	 * Save variation custom fields
	 *
	 * @since    1.0.0
	 * @param    int $post_id   Current post id.
	 * @param    int $i   loop id.
	 */
	public function save_variation_fields( $post_id, $i ) {

		check_ajax_referer( 'save-variations', 'security' );

		$parent_product_id = wp_get_post_parent_id( $post_id );
		if ( $parent_product_id ) {
			$taxonomies = array(
				'product_cat',
				'product_tag',
			);
			foreach ( $taxonomies as $taxonomy ) {
				$terms = (array) wp_get_post_terms( $parent_product_id, $taxonomy, array( 'fields' => 'ids' ) );
				wp_set_post_terms( $post_id, $terms, $taxonomy );
			}
			update_post_meta( $post_id, '_is_vaspfw_cat_updated', 'yes' );
		}
		// @codingStandardsIgnoreStart
		// phpcs:disable WordPress.Security.NonceVerification.Missing
		$_vaspfw_variation_name = ( ! empty( $_POST['_vaspfw_variation_name'][ $post_id ] ) ) ? wc_clean( sanitize_text_field( wp_unslash( $_POST['_vaspfw_variation_name'][ $post_id ] ) ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		update_post_meta( $post_id, '_vaspfw_variation_name', esc_attr( $_vaspfw_variation_name ) );
		// phpcs:disable WordPress.Security.NonceVerification.Missing
		$_vaspfw_exclude_variation = isset( $_POST['_vaspfw_exclude_variation'][ $post_id ] ) ? 'yes' : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( 'yes' == $_vaspfw_exclude_variation ) {
			update_post_meta( $post_id, '_vaspfw_exclude_variation', $_vaspfw_exclude_variation );
		} else {
			delete_post_meta( $post_id, '_vaspfw_exclude_variation' );
		}
		// @codingStandardsIgnoreEnd

		$variation  = new WC_Product_Variation( $post_id );
		$attributes = $variation->get_variation_attributes();
		if ( ! empty( $attributes ) ) {
			foreach ( $attributes as $key => $term ) {
				$attr_tax = str_replace( 'attribute_', '', $key );
				wp_set_post_terms( $post_id, $term, $attr_tax );
			}
		}

		$parent_product    = wc_get_product( $parent_product_id );
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
					wp_set_post_terms( $post_id, $term_ids, $attr_tax );
				}
			}
		}

	}

}
