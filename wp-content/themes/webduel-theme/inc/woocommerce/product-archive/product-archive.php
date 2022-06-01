<?php
// add category and tag banner
add_action('woocommerce_before_main_content', 'add_category_banner_webduel', 5);
function add_category_banner_webduel()
{
    if (!is_archive()) {
        return;
    }
    // add category banner
    global $wp_query;
    $cat = $wp_query->get_queried_object();
    $catID = $cat->term_id;
    $thumbnail_id =   get_term_meta($catID, 'thumbnail_id', true);
    $imageLarge = wp_get_attachment_image_src($thumbnail_id, 'woocommerce-single');
    $imageMedium = wp_get_attachment_image_src($thumbnail_id, 'woocommerce-single');
    if ($thumbnail_id) {
        echo ' 
          <div class="category-banner-container">
            <picture class="category-banner">
                <source media="(min-width:1366px)" srcset="' . $imageLarge[0] . '">
                <source media="(min-width:600px)" srcset="' . $imageLarge[0] . '">
                <img class="product-cat-banner"  loading="lazy" src="' . $imageMedium[0] . '"
                alt="' . get_the_title() . '" width="100%" >
            </picture>
        </div>
            ';
    }

    // add tag banner
    if(is_product_tag()){ 
        $current_tags = get_the_terms(get_the_ID(), 'product_tag');
        $image_id = get_field('banner', $current_tags[0]);
        // check if the first tag has an image
        if (!$image_id) {
            $image_id = get_field('banner', $current_tags[1]);
        }
    
        // get one image for desktop and one for mobile
        $tagImage = wp_get_attachment_image_src($image_id, 'full');
        $tagImageMobile = wp_get_attachment_image_src($image_id, 'large');
        if ($tagImageMobile && $tagImage) {
            echo '
            <div class="category-banner-container">
            <picture class="category-banner">
                <source media="(min-width:1366px)" srcset="' . $tagImage[0] . '">
                <source media="(min-width:600px)" srcset="' . $tagImage[0] . '">
                <img class="product-cat-banner"  loading="lazy" src="' . $tagImageMobile[0] . '"
                alt="' . get_the_title() . '" width="100%" >
                </picture>
                </div>
                ';
        }
    }
  
}

// add filter side bar section 
add_action('filter_buttons_before_shop_loop', function () {
    global $wp;

    $current_url = home_url(add_query_arg(array(), $wp->request));

    if (is_product_category() || is_shop() || is_archive()) {
        echo '
        <div class="facet-product-container">
            <div class="facet-wp-container">';
        // echo do_shortcode('[add_filter_button]');
        echo '<div class="desktop">';

        echo do_shortcode('[facetwp facet="categories"]');
        echo do_shortcode('[facetwp facet="brand"]');
        echo do_shortcode('[facetwp facet="collection"]');
        echo do_shortcode('[facetwp facet="design_style"]');
        echo do_shortcode('[facetwp facet="colour_family"]');
        echo do_shortcode('[facetwp facet="pattern"]');
        echo do_shortcode('[facetwp facet="composition"]');
        // echo do_shortcode('[facetwp facet="availability"]');

        //   echo do_shortcode('[facetwp facet="price_range"]');  
        echo '<button class="product-archive-reset facet-reset-btn secondary-button" onclick="FWP.reset()">Reset All Filter</button>';
        echo '</div>';

        echo '<div class="mobile-filter-container"> 
                <div class="mobile-filters">
            ';

        echo do_shortcode('[facetwp facet="categories_m"]');
        echo do_shortcode('[facetwp facet="brand_m"]');
        echo do_shortcode('[facetwp facet="collection_m"]');
        echo do_shortcode('[facetwp facet="design_style_m"]');
        echo do_shortcode('[facetwp facet="colour_family_m"]');
        echo do_shortcode('[facetwp facet="pattern_m"]');
        echo do_shortcode('[facetwp facet="composition_m"]');
        // echo do_shortcode('[facetwp facet="availability_m"]');
        // echo do_shortcode('[facetwp facet="price_range_m"]');   

        echo '
                <div class="button-containers">
                    <button class="primary-button"> Show Results </button>
                    <button class="product-archive-reset facet-reset-btn secondary-button" onclick="FWP.reset()">Reset All Filter</button>
                </div>
                    ';
        echo '</div>';
        echo '<i class="close-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.994" viewBox="0 0 16 15.994">
        <path id="Path_27" data-name="Path 27" d="M19.853,19.147,12.707,12l7.147-7.147a.5.5,0,0,0-.707-.707L12,11.293,4.853,4.147a.5.5,0,0,0-.707.707L11.293,12,4.146,19.146a.5.5,0,1,0,.707.707L12,12.707l7.147,7.147a.5.5,0,1,0,.707-.707Z" transform="translate(-4 -4.006)"/>
      </svg>
      </i>';
        echo '</div>';
        echo '</div>';
    }
}, 10);

// add facet label 
function fwp_add_facet_labels()
{
    ?>
    <script>
        (function($) {
            $(document).on('facetwp-loaded', function() {
                if (window.matchMedia("(min-width: 1100px)").matches) {
                    $('.facetwp-facet').each(function() {
                        var $facet = $(this);
                        var facet_name = $facet.attr('data-name');
                        var facet_label = FWP.settings.labels[facet_name];

                        if ($facet.closest('.facet-wrap').length < 1 && $facet.closest('.facetwp-flyout').length < 1) {
                            $facet.wrap('<div class="facet-wrap"></div>');
                            $facet.before(`<div class="facet-label-button"><button class="facet-label">${facet_label}<i class="plus-icon">+</i></button></div>`);
                        }

                    });
                }
            });
        })(jQuery);
    </script>
<?php
}
add_action('wp_head', 'fwp_add_facet_labels', 100);

// add product loop container
add_action('woocommerce_before_shop_loop', function () {
    echo '
    <div class="product-loop-container">
        <div class="facetwp-template">
    ';
}, 20);
add_action('woocommerce_after_main_content', function () {
    echo '
            </div>
        </div>
    </div>';
}, 10);


// change image on hove on product archive page

add_action('woocommerce_before_shop_loop_item_title', 'add_on_hover_shop_loop_image');

function add_on_hover_shop_loop_image()
{
    $image_id = wc_get_product()->gallery_image_ids[0];
  
    if ($image_id) {
        // echo '<img src="' . wp_get_attachment_image_src($image_id, 'woocommerce_thumbnail')[0] . '" class="current">';
        echo '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg=="
        srcset="'.wp_get_attachment_image_src($image_id, 'woocommerce_thumbnail')[0].' 1300w,
        '.wp_get_attachment_image_src(wc_get_product()->image_id,  'woocommerce_thumbnail')[0].' 1200w"
        class="current"
        alt="'.wc_get_product()->name.'"
   />';
    } else {  //assuming not all products have galleries set

        echo wp_get_attachment_image(wc_get_product()->image_id,  'woocommerce_thumbnail');
    }
}
