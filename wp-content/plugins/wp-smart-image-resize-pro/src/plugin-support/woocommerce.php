<?php

namespace WP_Smart_Image_Resize\Plugin_Support;

/*
|--------------------------------------------------------------------------
| Add support for WooCommerce.
|--------------------------------------------------------------------------
*/


// Prevent WooCommerce from regenerating thumbnails on the fly.
add_filter('woocommerce_resize_images', '__return_false');

// Prevent WooCommerce from regenerating thumbnails in the background.
add_filter('woocommerce_background_image_regeneration', '__return_false');
