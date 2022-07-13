<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists ( 'WC_Product_Gift_Card' ) ) {

	/**
	 *
	 * @class   YITH_YWGC_Gift_Card
	 *
	 * @since   1.0.0
	 * @author  Lorenzo Giuffrida
	 */
	class WC_Product_Gift_Card extends WC_Product {

		const YWGC_AMOUNTS                  = '_gift_card_amounts';
		const YWGC_PRODUCT_IMAGE            = '_ywgc_product_image';
		const YWGC_PRODUCT_TEMPLATE_DESIGN  = '_ywgc_show_product_template_design';
		const YWGC_MANUAL_AMOUNT_MODE       = '_ywgc_manual_amount_mode';
		const YWGC_OVERRIDE_GLOBAL_SETTINGS = '_ywgc_override_global_settings';
		const YWGC_ADD_DISCOUNT_SETTINGS    = '_ywgc_add_discount_settings';
		const YWGC_EXPIRATION_SETTINGS      = '_ywgc_expiration_settings';

		public $amounts = null;

		/**
		 * Initialize a gift card product.
		 *
		 * @param mixed $product
		 */
		public function __construct( $product ) {
			parent::__construct( $product );

			$this->downloadable = 'no';
			$this->product_type = YWGC_GIFT_CARD_PRODUCT_TYPE;
		}

		/**
		 * Get_type
		 *
		 * @return string
		 */
		public function get_type() {
			return YWGC_GIFT_CARD_PRODUCT_TYPE;
		}

		/**
		 * Is_downloadable
		 *
		 * @return bool
		 */
		public function is_downloadable() {
			return false;
		}

		/**
		 * Retrieve the number of current amounts for this product
		 *
		 * @return int
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function get_amounts_count() {
			$amounts = $this->get_product_amounts();

			return count( $amounts );
		}

		/**
		 * Retrieve the amounts set for the product
		 *
		 * @return array
		 */
		public function get_product_amounts() {

			if ( ! is_array( $this->amounts ) ) {
				if ( $this->id ) {
					$result        = get_post_meta( $this->get_id(), self::YWGC_AMOUNTS, true );
					$this->amounts = is_array( $result ) ? $result : array();
				}
			}

			/**
			 * APPLY_FILTERS: yith_ywgc_gift_card_amounts
			 *
			 * Filter the gift card amounts.
			 *
			 * @param string $amounts_to_show gift card amounts
			 * @param object $this  gift card object
			 *
			 * @return array
			 */
			return apply_filters( 'yith_ywgc_gift_card_amounts', $this->amounts, $this );
		}

		/**
		 * Returns false if the product cannot be bought.
		 *
		 * @return bool
		 */
		public function is_purchasable() {

			$purchasable = $this->get_amounts_count() > 0 || $this->is_manual_amount_enabled() ? 1 : 0;

			return apply_filters( 'woocommerce_is_purchasable', $purchasable, $this );
		}

		/**
		 * Save current gift card amounts
		 *
		 * @param array $amounts amounts.
		 */
		public function set_amounts( $amounts = array() ) {
			$this->amounts = $amounts;
		}

		/**
		 * Save current gift card amounts
		 *
		 * @param array $amounts amounts.
		 */
		public function save_amounts( $amounts = array() ) {
			$this->update_meta_data( self::YWGC_AMOUNTS, $amounts );
			$this->save_meta_data();
		}

		/**
		 * Update the design status for the gift card
		 *
		 * @param $status status.
		 */
		public function set_design_status( $status ) {
			$this->update_meta_data( self::YWGC_PRODUCT_TEMPLATE_DESIGN, $status );
			$this->save_meta_data();
		}

		/**
		 * Retrieve the design status
		 *
		 * @return mixed
		 */
		public function get_design_status() {
			return $this->get_product_instance()->get_meta( self::YWGC_PRODUCT_TEMPLATE_DESIGN );
		}

		/**
		 * Process the current product instance in order to let third party plugin
		 * change the reference(Useful for WPML and similar plugins)
		 *
		 * @return WC_Product
		 */
		protected function get_product_instance() {
			/**
			 * APPLY_FILTERS: yith_ywgc_get_product_instance
			 *
			 * Filter the gift card product instance.
			 *
			 * @param object $this gift card product instance
			 *
			 * @return object
			 */
			return apply_filters( 'yith_ywgc_get_product_instance', $this );
		}

		/**
		 * Get the specific product settings to override the globals
		 */
		public function get_override_global_settings_status() {
			return $this->get_product_instance()->get_meta( self::YWGC_OVERRIDE_GLOBAL_SETTINGS );

		}

		/**
		 * Get the discount settings status
		 */
		public function get_add_discount_settings_status() {
			return $this->get_product_instance()->get_meta( self::YWGC_ADD_DISCOUNT_SETTINGS );

		}

		/**
		 * Get the expiration settings status
		 */
		public function get_expiration_settings_status() {
			return $this->get_product_instance()->get_meta( self::YWGC_EXPIRATION_SETTINGS );

		}

		/**
		 * Get the manual settings status
		 */
		public function get_manual_amount_status() {
			return $this->get_product_instance()->get_meta( self::YWGC_MANUAL_AMOUNT_MODE );

		}

		/**
		 * Update the specific product settings to override the globals
		 *
		 * @param string $status the status.
		 *
		 * @return void
		 */
		public function update_override_global_settings_status( $status ) {
			$this->update_meta_data( self::YWGC_OVERRIDE_GLOBAL_SETTINGS, $status );
			$this->save_meta_data();
		}

		/**
		 * Update the manual amount settings status.
		 *
		 * @param string $status Available values are "global", "accept" and "reject".
		 */
		public function update_manual_amount_status( $status ) {
			$this->update_meta_data( self::YWGC_MANUAL_AMOUNT_MODE, $status );
			$this->save_meta_data();
		}

		/**
		 * Update the discount settings status.
		 *
		 * @param string $status Available values are "global", "accept" and "reject".
		 */
		public function update_add_discount_settings_status( $status ) {
			$this->update_meta_data( self::YWGC_ADD_DISCOUNT_SETTINGS, $status );
			$this->save_meta_data();
		}

		/**
		 * Update the expiration settings status.
		 *
		 * @param string $status Available values are "global", "accept" and "reject".
		 */
		public function update_expiration_settings_status( $status ) {
			$this->update_meta_data( self::YWGC_EXPIRATION_SETTINGS, $status );
			$this->save_meta_data();
		}

		/**
		 * Returns the price in html format
		 *
		 * @access public
		 *
		 * @param string $price (default: '')
		 *
		 * @return string
		 */
		public function get_price_html( $price = '' ) {
			$amounts = $this->get_amounts_to_be_shown();

			// No price for current gift card.
			if ( !count ( $amounts ) ) {
				/**
				 * APPLY_FILTERS: yith_woocommerce_gift_cards_empty_price_html
				 *
				 * Filter the empty price HTML for the gift cards.
				 *
				 * @param string empty string
				 * @param object $this gift card product instance
				 *
				 * @return string
				 */
				$price = apply_filters( 'yith_woocommerce_gift_cards_empty_price_html', '', $this );
			} else {
				ksort( $amounts, SORT_NUMERIC );

				$min_price = current( $amounts );
				$min_price = wc_price( $min_price['price'] );
				$max_price = end( $amounts );
				$max_price = wc_price( $max_price['price'] );

				/**
				 * APPLY_FILTERS: yith_woocommerce_gift_cards_amount_range
				 *
				 * Filter the price range of a gift card product.
				 *
				 * @param string $price price range of the gift card
				 * @param object $this gift card product instance
				 * @param string $min_price minimum amount of the gift card
				 * @param string $max_price maximum amount of the gift card
				 *
				 * @return string
				 */
				$price = apply_filters( 'yith_woocommerce_gift_cards_amount_range', $min_price !== $max_price ? wc_format_price_range( $min_price, $max_price ) : $min_price, $this, $min_price, $max_price );
			}

			return apply_filters( 'woocommerce_get_price_html', $price, $this );
		}

		/**
		 * Retrieve an array of gift cards amounts with the corrected value to be shown(inclusive or not inclusive taxes)
		 *
		 * @return array
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function get_amounts_to_be_shown() {

			$amounts_to_show  = array();
			$tax_display_mode = get_option( 'woocommerce_tax_display_shop' );
			$index            = 0;
			$product_amounts  = array_values( $this->get_product_amounts() );

			foreach ( $product_amounts as $amount ) {

				$amount = wc_format_decimal( floatval( $amount ) );

				if ( 'incl' === $tax_display_mode ) {
					$price = yit_get_price_including_tax( $this, 1, $amount );
				} else {
					$price = yit_get_price_excluding_tax( $this, 1, $amount );
				}

				$original_amount = $product_amounts[ $index ];
				$negative        = $price < 0;
				$price_format    = get_woocommerce_price_format();
				$formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, get_woocommerce_currency_symbol(), $price );

				$amounts_to_show[ $original_amount ] = array(
					'amount'   => $amount,
					'price'    => $price,
					'wc-price' => $formatted_price,
					'title'    => wc_price( $price ),
				);
				$index ++;
			}

			return apply_filters( 'yith_ywgc_gift_cards_amounts', $amounts_to_show, $this->id );
		}

		/**
		 * Retrieve if manual amount is enabled for this gift card
		 */
		public function is_manual_amount_enabled() {

			$override_globals = $this->get_override_global_settings_status();
			$status           = $this->get_manual_amount_status();

			if ( 'yes' !== $override_globals ) {
				$status = get_option( 'ywgc_permit_free_amount', 'no' );
			}

			if ( 'yes' === $status || '1' === $status ) {
				$status = 'yes';
			}

			/**
			 * APPLY_FILTERS: yith_gift_cards_is_manual_amount_enabled
			 *
			 * Filter the manual amount status for the gift card product.
			 *
			 * @param bool bool to check if the manual amount is enabled
			 * @param bool $status manual amount status
			 * @param object $this gift card product instance
			 *
			 * @return bool
			 */
			return apply_filters( 'yith_gift_cards_is_manual_amount_enabled', 'yes' === $status, $status, $this );
		}

		/**
		 * Get the add to cart button text
		 *
		 * @return string
		 */
		public function add_to_cart_text() {

			/**
			 * APPLY_FILTERS: yith_ywgc_select_amount_text
			 *
			 * Filter the "Select amount" text for the gift card products on the catalog pages.
			 *
			 * @param string $text Select amount text
			 *
			 * @return string
			 */
			$text = $this->is_purchasable() && $this->is_in_stock() ? apply_filters( 'yith_ywgc_select_amount_text', esc_html__( 'Select amount', 'yith-woocommerce-gift-cards' ) ) : esc_html__( 'Read more', 'yith-woocommerce-gift-cards' );

			/**
			 * APPLY_FILTERS: woocommerce_product_add_to_cart_text
			 *
			 * Filter the WooCommerce add to cart button text for the gift card products, using the gift card object on the second param.
			 *
			 * @param string $text add to cart text
			 * @param string $this gift card object
			 *
			 * @return string
			 */
			return apply_filters( 'woocommerce_product_add_to_cart_text', $text, $this );
		}

		/**
		 * Retrieve the custom image set from the edit product page for a specific gift card product
		 *
		 * @param string $size size.
		 * @param string $return Choose whether to return url or id (url|id).
		 *
		 * @return mixed
		 */
		public function get_manual_header_image( $size = 'full', $return = 'url' ) {
			global $post;
			$image_url = '';

			$product = wc_get_product( $post );

			if ( ! is_object( $product ) ) {
				return;
			}

			if ( $product ) {
				$image_id = $product->get_meta( self::YWGC_PRODUCT_IMAGE );
			} else {
				$image_id = '';
			}

			$image_id = ( isset( $image_id ) && $image_id ) ? $image_id : $this->get_product_instance()->get_meta( self::YWGC_PRODUCT_IMAGE );

			$image_id = ( '' !== $image_id ) ? $image_id : get_post_thumbnail_id( $post->ID );

			if ( 'id' === $return ) {
				return $image_id;
			}

			if ( $image_id ) {
				$image     = wp_get_attachment_image_src( $image_id, $size );
				$image_url = $image[0];
			}

			return $image_url;
		}

		/**
		 * Set the header image for a gift card product
		 *
		 * @param int $attachment_id attachment_id.
		 */
		public function set_header_image( $attachment_id ) {
			$this->update_meta_data( self::YWGC_PRODUCT_IMAGE, $attachment_id );
			$this->save_meta_data();
		}

		/**
		 * Unset the header image for a gift card product
		 */
		public function unset_header_image() {
			$this->delete_meta_data( self::YWGC_PRODUCT_IMAGE );
			$this->save_meta_data();
		}
	}
}
