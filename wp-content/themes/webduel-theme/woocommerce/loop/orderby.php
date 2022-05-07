<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form class="woocommerce-ordering" method="get">
	<!-- custome code starts -->
	<button id="sort-product-btn" class="secondary-button">
		<i class="fa-regular fa-arrow-up-arrow-down"></i>
		<span>SORT</span>
	</button>
	<!-- customer code ends -->
	<select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>" value="Sort">
	<option style="display:none" selected>SORT</option>

		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<?php print_r($catalog_orderby_options); ?>
			<option value="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form>
