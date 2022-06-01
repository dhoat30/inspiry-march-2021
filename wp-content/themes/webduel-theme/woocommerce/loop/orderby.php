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
			<svg  viewBox="0 0 26.728 28">
		<path id="Path_12" data-name="Path 12" d="M10,26.586V2H8V26.586l-3.95-3.95L2.636,24.05l5.657,5.657a1,1,0,0,0,1.414,0l5.657-5.657L13.95,22.636ZM29.364,7.95,23.707,2.293a1,1,0,0,0-1.414,0L16.636,7.95,18.05,9.364,22,5.414V30h2V5.414l3.95,3.95Z" transform="translate(-2.636 -2)"/>
		</svg>

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
