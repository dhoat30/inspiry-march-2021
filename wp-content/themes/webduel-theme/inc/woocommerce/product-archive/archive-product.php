<?php

// add result count in header on archive page for flex box 
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
add_action('woocommerce_archive_title', 'woocommerce_result_count', 10);

// add sort by and filter--------------------------------------------
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action('woocommerce_archive_description', 'filter_container_start', 20);
function filter_container_start() {
   ?>
   <div class="filter-sort-container "> 
      <div class="filter-sort-flex">
   <?php
}
// add sort form 
add_action('woocommerce_archive_description', 'woocommerce_catalog_ordering', 60);
add_action('woocommerce_archive_description', "adding_filter_button", 50);
function adding_filter_button() {
   ?> 
         <button class="filter-button secondary-button">
            <svg  viewBox="0 0 27.998 30">
               <path id="Path_14" data-name="Path 14" d="M2,7h.142A3.981,3.981,0,0,0,9.858,7H30a1,1,0,0,0,0-2H9.858A3.981,3.981,0,0,0,2.142,5H2A1,1,0,0,0,2,7ZM6,4A2,2,0,1,1,4,6,2,2,0,0,1,6,4ZM30,15h-.142a3.981,3.981,0,0,0-7.716,0H2a1,1,0,0,0,0,2H22.142a3.981,3.981,0,0,0,7.716,0H30a1,1,0,0,0,0-2Zm-4,3a2,2,0,1,1,2-2A2,2,0,0,1,26,18Zm4,7H19.858a3.981,3.981,0,0,0-7.716,0H2a1,1,0,0,0,0,2H12.142a3.981,3.981,0,0,0,7.716,0H30a1,1,0,0,0,0-2ZM16,28a2,2,0,1,1,2-2A2,2,0,0,1,16,28Z" transform="translate(29.999 -1) rotate(90)"/>
            </svg>

            <span>Filter</span></button>

 
   <?php 
}

add_action('woocommerce_archive_description', "filter_container_end", 70); 
function filter_container_end(){ 
   ?>
     </div>
   <?php 
    echo do_shortcode('[in_stock_toggle]');
   ?>
</div>
<?php 
}


// remove add to cart button on loop product page
add_action('woocommerce_after_shop_loop_item', 'remove_add_to_cart_buttons', 1);
function remove_add_to_cart_buttons()
{
   if (is_product_category() || is_shop() || is_archive()) {
      remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
      // remove_action('woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30);
   }
}

// remove product anchor tag and add it right under the thumbnail
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 5);
// woocommerce variations 
// re add variation swatches 
// add_action('woocommerce_shop_loop_item_title', 'wvs_pro_archive_variation_template', 5);
// wrap product archive title with anchor 
add_action('woocommerce_shop_loop_item_title', 'wrap_title_with_anchor', 6);
function wrap_title_with_anchor()
{
   global $product;
   echo do_shortcode('[design_board_button_code]')
?> 
   <a href="<?php echo get_permalink($product->get_id()); ?>" alt="<?php echo $product->get_name(); ?>" class="product-title">
   <?php
}
add_action('woocommerce_shop_loop_item_title', function () {
   ?>
   </a>
<?php
}, 30);

// add product attributes on product loop product page
add_action("woocommerce_after_shop_loop_item_title", "add_product_attributes", 1);

function add_product_attributes()
{
   echo do_shortcode('[add_free_shipping_tag]');
   // add free shipping 
   echo do_shortcode(('[add_deal_text]'));
}

// show percentage discount on product loop page
add_action('woocommerce_after_shop_loop_item', 'webduel_show_sale_percentage_loop', 1);
add_action("woocommerce_single_product_summary", 'webduel_show_sale_percentage_loop', 14);
function webduel_show_sale_percentage_loop()
{
   global $product;
   if (!$product->is_on_sale()) return;
   if ($product->is_type('simple')) {
      $max_percentage = (($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100;
   } elseif ($product->is_type('variable')) {
      $max_percentage = 0;
      foreach ($product->get_children() as $child_id) {
         $variation = wc_get_product($child_id);
         $price = $variation->get_regular_price();
         $sale = $variation->get_sale_price();
         if ($price != 0 && !empty($sale)) $percentage = ($price - $sale) / $price * 100;
         if ($percentage > $max_percentage) {
            $max_percentage = $percentage;
         }
      }
   }
   if ($max_percentage > 0) echo "<div class='sale-perc'>(" . round($max_percentage) . "% OFF)</div>";
}