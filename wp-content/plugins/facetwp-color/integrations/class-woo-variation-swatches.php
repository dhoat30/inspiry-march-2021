<?php

defined( 'ABSPATH' ) or exit;

class FacetWP_Woo_Variation_Swatches
{

    function __construct() {
        add_filter( 'facetwp_facet_option', [ $this, 'render_colors' ], 10, 3 );
    }

    function render_colors( $item, $value, $params ) {

        if ( 'color' == $params['facet']['type'] ) {

            $attrs = wc_get_attribute_taxonomy_ids( );
            $attr = wc_get_attribute( $attrs[ str_replace( 'tax/pa_', '', $params['facet']['source'] ) ] );

            if ( ! isset( $attr->type ) ) {
                return $item;
            }

            if ( 0 < (int)$value['term_id'] ) {

                $term = get_term( (int)$value['term_id'] );

                if ( ! is_wp_error( $term ) && ! empty( $term ) ) {

                    $img = '';
                    if ( 'image' == $attr->type ) {
                        $img = (int) wvs_get_product_attribute_image( $term );
                        $img = ( 0 < $img ) ? wp_get_attachment_image_url( $img ) : '';
                    }

                    $color = ( ! empty( wvs_get_product_attribute_color( $term ) ) ) ? wvs_get_product_attribute_color( $term ) : $value['facet_display_value'];
                    $selected = in_array( $value['facet_value'], $params['selected_values'] ) ? ' checked' : '';
                    $selected .= ( 0 == $value['counter'] ) ? ' disabled' : '';
                    $item = '<div class="facetwp-color' . $selected . '" data-value="' . $value['facet_value'] . '" data-color="' . esc_attr( $color ) . '" data-img="' . esc_attr( $img ) . '"></div>';

                }
            }

        }
        return $item;
    }
}

new FacetWP_Woo_Variation_Swatches();
