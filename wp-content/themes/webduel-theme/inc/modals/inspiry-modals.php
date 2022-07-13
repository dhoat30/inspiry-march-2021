<?php

add_action('inspiry-modals', 'inspiry_modal_code', 10);

function inspiry_modal_code()
{
?>
    <section class="inspiry-modal">
        <div class="modal-container">
            <?php
            // get the child category id to show modal based on category 
            $childCategory = '';
            global $post;
            if (is_product()) {
                //Get all terms associated with post in taxonomy 'category'
                $terms = get_the_terms(get_the_ID(),'product_cat');
                //Get an array of their IDs
                $term_ids = wp_list_pluck($terms,'term_id');

                //Get array of parents - 0 is not a parent
                $parents = array_filter(wp_list_pluck($terms,'parent'));

                //Get array of IDs of terms which are not parents.
                $term_ids_not_parents = array_diff($term_ids,  $parents);

                //Get corresponding term objects
                $terms_not_parents = array_intersect_key($terms,  $term_ids_not_parents);
                // child category 
                $childCategory = $terms_not_parents[0]->term_id;
               
            }

            // get all the tag assigned to the product 
            global $product; // gets the Product object (correspoding to the single page)
            $productTags =  $product->tag_ids; // returns an array with product tags

            // modal query 
            $argsModal = array(
                'post_type' => 'modal',
                'posts_per_page' => -1,
            );
            $modal = new WP_Query($argsModal);
            $breakWhileLoop = false;
            while ($modal->have_posts()) {
                $modal->the_post();
                // get the show on value 
                $showOn = get_field('show_on');
                // if the show on product category 
                if ($showOn === 'show-on-product-category: Show on Product Category' &&  is_product()) {
                    // get the product category id from the modal
                    $terms = get_field('product_categories');
                    // function refracted
                    if ($terms) {
                        foreach ($terms as $term) {
                            // check if the category exist on modal post and check if the modal content exist

                            if ($term === $childCategory && have_rows('modal_content')) {
                                $breakWhileLoop = true;
                                $desktopImage = get_field('desktop_image');
                                // refracted html modal code 
                                modalWebduelHTML($desktopImage, $childCategory);
                                break;
                            }
                        }
                    }
                } elseif ($showOn === 'show-on-product-tag: Show on Product Tag'  && is_product()) {
                    // get the product tag id from the modal
                    $terms = get_field('product_tags');

                    if ($terms) {
                        foreach ($terms as $term) {
                            // check if the tag exist on modal post and check if the modal content exist
                            if (in_array($term, $productTags) &&  have_rows('modal_content')) {
                                $breakWhileLoop = true;
                                $desktopImage = get_field('desktop_image');
                                // refracted html code
                                modalWebduelHTML($desktopImage);
                                break;
                            }
                        }
                    }
                } elseif ($showOn === 'show-on-specific-page: Show on Specific Page') {
                    // get the page id 
                    $terms = get_field('select_pages');

                    // get the url to match with $terms 
                    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                    if ($terms) {
                        foreach ($terms as $term) {
                            // check if the tag exist on modal post and check if the modal content exist
                            if ($url === $term && have_rows('modal_content')) {
                                $desktopImage = get_field('desktop_image');
                                modalWebduelHTML($desktopImage);
                                break;
                            }
                        }
                    }
                }
                if ($breakWhileLoop) {
                    break;
                }
            }
            ?>
        </div>
    </section>
<?php
    wp_reset_postdata();
}




// modal HTML 
function modalWebduelHTML($desktopImage)
{

?>

    <!-- add show modal div to get the show modal value in javascript so that the modal is shown if it exist -->
    <div class="show-modal" data-show-modal="true"></div>
    <div class="image-container">
        <picture>
            <source media="(min-width:600px)" srcset="<?php echo $desktopImage['sizes']['woocommerce_single']; ?>">
            <img loading="lazy" src="<?php echo $desktopImage['sizes']['woocommerce_thumbnail']; ?>" alt="<?php echo get_the_title(); ?>" width="100%">
        </picture>
    </div>

    <?php
    // get modal content
    while (have_rows('modal_content')) {
        the_row();
        //  check if the row layout exists 
        if (get_row_layout() == 'content') {
    ?>
            <!-- dynamic styling of title line -->
            <style>
                .inspiry-modal .content .top-title::after {
                    background-color: <?php echo get_sub_field('font_color'); ?>;
                }

                .inspiry-modal .content .top-title::before {
                    background-color: <?php echo get_sub_field('font_color'); ?>;
                }
            </style>
            <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                <path id="Path_28" data-name="Path 28" d="M13.4,12l6.3-6.3a.99.99,0,1,0-1.4-1.4L12,10.6,5.7,4.3A.99.99,0,0,0,4.3,5.7L10.6,12,4.3,18.3A.908.908,0,0,0,4,19a.945.945,0,0,0,1,1,.908.908,0,0,0,.7-.3L12,13.4l6.3,6.3a.967.967,0,0,0,1.4,0,.967.967,0,0,0,0-1.4Z" transform="translate(-4 -4)" fill="<?php echo get_sub_field('font_color'); ?>"></path>
            </svg>
            <div class="content" style='background-color: <?php echo get_sub_field('background_color'); ?>'>
                <div class="top-title-container">
                    <div class="stroke"></div>
                    <div class="top-title" style='color: <?php echo get_sub_field('font_color'); ?>; background-color: <?php echo get_sub_field('background_color'); ?>;'>
                        <?php echo get_sub_field('top_title'); ?>
                    </div>

                </div>

                <h1 class="main-title" style='color: <?php echo get_sub_field('font_color'); ?>'>
                    <?php echo get_sub_field('main_title'); ?>
                </h1>
                <h2 class="subtitle" style='color: <?php echo get_sub_field('font_color'); ?>'>
                    <?php echo get_sub_field('subtitle'); ?>
                </h2>
                <?php
                if (get_sub_field('link')) {
                ?>
                    <a class="primary-button button" href=" <?php echo get_sub_field('link'); ?>" style='background-color: <?php echo get_sub_field('button_background_colour'); ?>; color: <?php echo get_sub_field('button_title_color'); ?> !important;'>
                        <?php echo get_sub_field('call_to_action_title'); ?>
                    </a>
                <?php
                }
                ?>

            </div><?php
                }
            }
        }
