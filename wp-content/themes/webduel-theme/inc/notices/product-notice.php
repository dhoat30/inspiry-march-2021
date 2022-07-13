<?php
add_action('woocommerce_before_single_product', 'webduel_product_notice', 30);

function webduel_product_notice()
{
   
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

    
        
        // get all the tag assigned to the product 
        global $product; // gets the Product object (correspoding to the single page)
        $productTags =  $product->tag_ids; // returns an array with product tags

          // modal query 
          $argsNotice = array(
            'post_type' => 'product-notice',
            'posts_per_page' => -1,
        );
        $productNotice = new WP_Query($argsNotice);
        $breakWhileLoop = false;
       
        while ($productNotice->have_posts()) {
            $productNotice->the_post();
            // get the show on value 
            $showOn = get_field('show_on');
            // if the show on product category 
            if ($showOn === 'show-on-product-category: Show on Product Category') {
                // get the product category id from the modal
                $terms = get_field('product_category');
                // function refracted
                if ($terms) {
                    foreach ($terms as $term) {
                        // check if the category exist on modal post and check if the modal content exist

                        if ($term === $childCategory ) {
                            $breakWhileLoop = true;
                            
                            // refracted html modal code 
                            productNoticeHTML(); 
                            break;
                        }
                    }
                }
            } elseif ($showOn === 'show-on-product-tag: Show on Product Tag') {
                // get the product tag id from the modal
                $terms = get_field('product_tag');
                if ($terms) {
                    foreach ($terms as $term) {
                        // check if the tag exist on modal post and check if the modal content exist
                        if (in_array($term, $productTags) ) {
                            $breakWhileLoop = true;
                            // refracted html code
                            productNoticeHTML(); 
                            break;
                        }
                    }
                }
            } 
            elseif ($showOn === 'show-on-brand-page: Show on Brand Page') {
                $terms = get_field('product_brand');
                $attributeID = $product->get_attributes()['pa_brands']['options'][0]; 
                if ($terms) {
                    foreach ($terms as $term) {
                        // check if the tag exist on modal post and check if the modal content exist
                        if ($term === $attributeID) {
                            $breakWhileLoop = true;
                            // refracted html code
                            productNoticeHTML(); 
                            break;
                        }
                    }
                }
            } 
            if ($breakWhileLoop) {
                break;
            }
        }
        wp_reset_postdata();

 }
}


// modal HTML 
function productNoticeHTML()
{
    ?>
        <div class="webduel-notice">
            <div class="notice-text">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 43 43">
                <g id="Group_92" data-name="Group 92" transform="translate(24443 11928)">
                    <circle id="Ellipse_30" data-name="Ellipse 30" cx="21.5" cy="21.5" r="21.5" transform="translate(-24443 -11928)" fill="#ff9d00"/>
                    <path id="Icon_ionic-ios-warning" data-name="Icon ionic-ios-warning" d="M13.833,5.419,3.595,24.1a1.757,1.757,0,0,0,1.567,2.6H25.644a1.761,1.761,0,0,0,1.567-2.6L16.967,5.419A1.8,1.8,0,0,0,13.833,5.419Zm2.584,7.753-.208,7.053H14.591l-.208-7.053ZM15.4,24.064A1.064,1.064,0,1,1,16.5,23,1.074,1.074,0,0,1,15.4,24.064Z" transform="translate(-24436.902 -11922.1)" fill="#fff"/>
                </g>
            </svg>

                <span style="color:#ff9d00"><?php echo get_field('notice_text'); ?> </span>
            </div>
        </div>
<?php
}
