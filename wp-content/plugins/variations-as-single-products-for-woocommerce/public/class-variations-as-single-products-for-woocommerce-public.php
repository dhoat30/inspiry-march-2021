<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://procomsoftsol.com
 * @since      1.0.0
 *
 * @package    Variations_As_Single_Products_For_Woocommerce
 * @subpackage Variations_As_Single_Products_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Variations_As_Single_Products_For_Woocommerce
 * @subpackage Variations_As_Single_Products_For_Woocommerce/public
 */
class Variations_As_Single_Products_For_Woocommerce_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Initilize the plugin
	 *
	 * @since    1.0.0
	 */
	public function init() {

		$is_enable = get_option( 'variations_as_single_products_for_woocommerce_enable', 'yes' );

		if ( 'yes' === $is_enable ) {
			add_action( 'woocommerce_product_query', array( $this, 'woocommerce_product_query' ), 10, 1 );

						add_action( 'pre_get_posts', array( $this, 'change_jet_filters_query' ) );

			add_filter( 'posts_clauses', array( $this, 'posts_clauses' ), 10, 2 );
			add_filter( 'the_title', array( $this, 'variable_product_title' ), 10, 2 );

			add_filter( 'woocommerce_subcategory_count_html', array( $this, 'subcategory_count' ), 10, 2 );
			add_filter( 'woocommerce_get_filtered_term_product_counts_query', array( $this, 'filtered_term_product_counts_query' ), 10, 1 );
		}

	}

		/**
		 * Change Jet filters woocommerce products query
		 *
		 * @since    1.0.1
		 * @param    mixed $query    products query.
		 */
	public function change_jet_filters_query( $query ) {
		if ( isset( $query->query_vars['jet_smart_filters'] ) ) {
			$query->set( 'post_type', array( 'product', 'product_variation' ) );
			$meta_query   = (array) $query->get( 'meta_query' );
			$meta_query[] = array(
				'relation' => 'AND',
				array(
					'key'     => '_vaspfw_exclude_variation',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => '_vaspfw_exclude_product_parent',
					'compare' => 'NOT EXISTS',
				),
			);

			$query->set( 'meta_query', $meta_query );
			$query->set( 'vaspfw_single_variation_filter', 'yes' );
		}
	}

	/**
	 * Filter Woocommerce products query
	 *
	 * @since    1.0.0
	 * @param    mixed $query    products query.
	 */
	public function woocommerce_product_query( $query ) {

		$query->set( 'post_type', array( 'product', 'product_variation' ) );
		$meta_query   = (array) $query->get( 'meta_query' );
		$meta_query[] = array(
			'relation' => 'AND',
			array(
				'key'     => '_vaspfw_exclude_variation',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => '_vaspfw_exclude_product_parent',
				'compare' => 'NOT EXISTS',
			),
		);

		$query->set( 'meta_query', $meta_query );
		$query->set( 'vaspfw_single_variation_filter', 'yes' );
	}

	/**
	 * Modify woocommerce products query
	 *
	 * @since    1.0.0
	 * @param      mixed $clauses        query clauses.
	 * @param      mixed $query          products query.
	 * @return     mixed    $clauses     query clauses.
	 */
	public function posts_clauses( $clauses, $query ) {
		global $wpdb;
		if ( isset( $query->query_vars['vaspfw_single_variation_filter'] ) && 'yes' == $query->query_vars['vaspfw_single_variation_filter'] ) {
			$hide_parents = get_option( 'variations_as_single_products_for_woocommerce_hide_parents' );
			if ( 'yes' == $hide_parents ) {
				$clauses['where'] .= " AND  0 = (select count(*) as variationcount from {$wpdb->posts} as vaspfw_products where vaspfw_products.post_parent = {$wpdb->posts}.ID and vaspfw_products.post_type= 'product_variation' and vaspfw_products.post_status = 'publish') ";
			}

			$clauses['join']  .= " LEFT JOIN {$wpdb->postmeta} as  vaspfw_product_meta ON ({$wpdb->posts}.post_parent = vaspfw_product_meta.post_id AND vaspfw_product_meta.meta_key = '_vaspfw_exclude_product_single' )";
			$clauses['where'] .= " AND  ( vaspfw_product_meta.meta_value IS NULL OR vaspfw_product_meta.meta_value!='yes') ";
		}
		return $clauses;
	}

	/**
	 * Filter variation title if have
	 *
	 * @since    1.0.0
	 * @param      string  $title variation title.
	 * @param      integer $post_id post id.
	 * @return     string    $title variation title.
	 */
	public function variable_product_title( $title, $post_id ) {
		if ( 'product_variation' == get_post_type( $post_id ) && ! empty( get_post_meta( $post_id, '_vaspfw_variation_name', true ) ) ) {
			$title = get_post_meta( $post_id, '_vaspfw_variation_name', true );
		}
		return $title;
	}


	/**
	 * Display sub category count.
	 *
	 * @since    1.0.1
	 * @param      string $html Count text.
	 * @param      object $category Category.
	 * @return     string    $html Count text.
	 */
	public function subcategory_count( $html, $category ) {
		$args = array(
			'post_type'   => array( 'product', 'product_variation' ),
			'post_status' => 'publish',
			'tax_query'   => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => $category->term_id,
				),
			),
			'meta_query'  => array(
				'relation' => 'AND',
				array(
					'key'     => '_vaspfw_exclude_variation',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => '_vaspfw_exclude_product_parent',
					'compare' => 'NOT EXISTS',
				),
			),
		);

		$hide_parents = get_option( 'variations_as_single_products_for_woocommerce_hide_parents' );
		if ( 'yes' == $hide_parents ) {
			$parents = $this->get_variable_product_ids();
			if ( ! empty( $parents ) ) {
				$args['post__not_in'] = $parents;
			}
		}

		$new_query = new WP_Query( $args );
		$count     = $new_query->found_posts;
		wp_reset_postdata();

		$html = '<mark class="count">(' . esc_html( $count ) . ')</mark>';
		return $html;
	}

	/**
	 * Return variable product ids
	 *
	 * @since    1.0.1
	 * @return     array    $products Product ids.
	 */
	public function get_variable_product_ids() {
		$args     = array(
			'status' => 'publish',
			'type'   => 'variable',
			'return' => 'ids',
			'limit'  => -1,
		);
		$products = wc_get_products( $args );
		return $products;
	}

	/**
	 * Modify query
	 *
	 * @since    1.0.1
	 * @param      array $query Query array.
	 * @return     array  $query Query array.
	 */
	public function filtered_term_product_counts_query( $query ) {
		global $wpdb;
		$query['where'] = str_replace( "'product'", "'product', 'product_variation'", $query['where'] );

		$hide_parents = get_option( 'variations_as_single_products_for_woocommerce_hide_parents' );
		if ( 'yes' == $hide_parents ) {
			$query['where'] .= " AND  0 = (select count(*) as variationcount from {$wpdb->posts} as vaspfw_products where vaspfw_products.post_parent = {$wpdb->posts}.ID and vaspfw_products.post_type= 'product_variation' and vaspfw_products.post_status = 'publish') ";
		}

		$query['join']  .= " LEFT JOIN {$wpdb->postmeta} as  vaspfw_product_meta ON ({$wpdb->posts}.post_parent = vaspfw_product_meta.post_id AND vaspfw_product_meta.meta_key = '_vaspfw_exclude_product_single' )";
		$query['where'] .= " AND  ( vaspfw_product_meta.meta_value IS NULL OR vaspfw_product_meta.meta_value!='yes') ";
		return $query;
	}

}
