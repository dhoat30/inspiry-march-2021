<?php

/**
 * Add a work-around to fix a bug in Regenerate Thumbnails that interferes with WPML.
 */
namespace WP_Smart_Image_Resize\Plugin_Support;


class Scripts extends \WP_Scripts
{
    function localize( $handle, $object_name, $l10n )
    {
        $l10n = apply_filters( 'wp_sir_script_l10n', $l10n, $handle, $object_name );
        return parent::localize($handle, $object_name, $l10n);
    }
}


add_action( 'wp_loaded', function() {
    $GLOBALS['wp_scripts'] = new \WP_Smart_Image_Resize\Plugin_Support\Scripts;
});

 function strip_lang_param_from_rt_rest_url($i10n, $handle, $object_name){

	if( $handle === 'wp-api-request' && $object_name === 'wpApiSettings' ){
		$i10n['root'] = strtok( $i10n['root'], '?' );
	}
	return $i10n;
}
add_action( 'wp_sir_script_l10n', __NAMESPACE__ . '\\strip_lang_param_from_rt_rest_url', 10,3 );
