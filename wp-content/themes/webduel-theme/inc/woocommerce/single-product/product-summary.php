<?php

// remove sku code
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

// remove sidebar 
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

/**
 * Remove product page tabs
 */
add_filter('woocommerce_product_tabs', 'my_remove_all_product_tabs', 98);

function my_remove_all_product_tabs($tabs)
{
    unset($tabs['description']);        // Remove the description tab
    unset($tabs['reviews']);       // Remove the reviews tab
    unset($tabs['additional_information']);    // Remove the additional information tab
    return $tabs;
}

// price ------------------------------------------------------------------------------------------
// Trim zeros in price decimals
add_filter('woocommerce_price_trim_zeros', '__return_true');

// remove short description on single product page
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);

// add free delivery tag ----------------------------------------------
add_action('woocommerce_single_product_summary', function () {
    echo '<div class="price-flex">';
}, 5);
add_action('woocommerce_single_product_summary', function () {
    global $product;
    if ($product->get_shipping_class() === "free-shipping") {
        // echo '<div class="free-shipping">
        // <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 20 20">
        //     <path id="Path_41" data-name="Path 41" d="M10.769,146.041l7.692-4.195V134.2L10.769,137ZM10,135.644l8.389-3.053L10,129.538l-8.389,3.053Zm10-3.029v9.231a1.491,1.491,0,0,1-.216.781,1.535,1.535,0,0,1-.589.565l-8.462,4.615a1.494,1.494,0,0,1-1.466,0L.805,143.192a1.535,1.535,0,0,1-.589-.565A1.491,1.491,0,0,1,0,141.846v-9.231a1.5,1.5,0,0,1,.276-.877,1.509,1.509,0,0,1,.733-.565L9.471,128.1a1.5,1.5,0,0,1,1.058,0l8.462,3.077A1.539,1.539,0,0,1,20,132.615Z" transform="translate(0 -128)" fill="#474747"/>
        //     </svg>

        // Free Delivery
        // </div>';
    }
    echo '
    </div>
    ';
}, 13);


// add deal information on single product page --------------------------------------
add_action('woocommerce_single_product_summary', 'webduelModal', 15);

function webduelModal()
{
    if (is_product()) {
        global $product;
        // get current deal for the single product 
        $currentDeal = $product->get_attribute('pa_current-deal');

        // get modal Categories
        $modalCategories = get_terms(array(
            'taxonomy' => 'modal-categories',
            'parent'   => 0
        ));
        // get category slug for custom post type
        $categorySlug = '';
        foreach ($modalCategories as $item) {
            // process element here
            if ($item->name === $currentDeal) {
                $categorySlug = $item->slug;
            }
        }

        singleProductQuery($categorySlug);
    }
}

// modal query 
function singleProductQuery($categorySlug)
{
    //  query modal with category slug
    $the_query = new WP_Query(array(
        'post_type' => 'modal',
        'tax_query' => array(
            array(
                'taxonomy' => 'modal-categories',
                'field' => 'slug',
                'terms' => $categorySlug
            )
        ),
    ));
    while ($the_query->have_posts()) {
        $the_query->the_post();
        echo '<div class="deal-section">
               <div class="content" >
                    <div class=" title">' . get_the_title() . '</div>
                    <div class="subtitle">' . get_the_content() . '</div>
                </div>
            </div>
        ';
    }
    wp_reset_postdata();
}


// availability section _--------------------------------------------------------------

add_action('woocommerce_single_product_summary', 'availabilitySectionWebduel', 60); 

function availabilitySectionWebduel() {
    global $product;
    // Available on backorder
    $countryOfOrigin = $product->get_attribute('pa_country-of-origin');
    $availability = $product->get_attribute('pa_availability');
    $deliveryEta = $product->get_attribute('pa_delivery');

    if ($countryOfOrigin) {
        $countryOfOrigin = 'Country Of Origin: ' . $countryOfOrigin;
    }
    // add back order if the item is out of stock and add availability attributes for stock arrival date. 
    // if the product is in stock then add delivery attribute with eta date 
    echo '
    <div class="availability">
      ';
    if ($product->get_availability()['class'] === 'in-stock') {
        echo ' 
           <h3 class="title">
            <svg  viewBox="0 0 20 20">
                <path id="Path_40" data-name="Path 40" d="M12,22A10,10,0,1,0,2,12,10,10,0,0,0,12,22ZM15.535,8.464A1,1,0,0,1,16.95,9.879L11.3,15.532l0,0a1,1,0,0,1-1.414,0l0,0L7.05,12.707a1,1,0,0,1,1.414-1.414l2.121,2.121Z" transform="translate(-2 -2)" fill="#1fac75" fill-rule="evenodd"/>
            </svg>

            <span  style="color: var(--green); ">
            IN STOCK
            </span>
            </h3>
            <div class="content">
                <h4 class="subtitle">
                    ' . $countryOfOrigin . '
                </h4>
                <h5 class="delivery-info">
                    Delivery: ' . $deliveryEta . ' 
                </h5>
            </div>
            ';
    } else {
        echo ' 
            <h3 class="title">
            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 20 20">
                <path id="Path_40" data-name="Path 40" d="M12,22A10,10,0,1,0,2,12,10,10,0,0,0,12,22ZM15.535,8.464A1,1,0,0,1,16.95,9.879L11.3,15.532l0,0a1,1,0,0,1-1.414,0l0,0L7.05,12.707a1,1,0,0,1,1.414-1.414l2.121,2.121Z" transform="translate(-2 -2)" fill="#d69400" fill-rule="evenodd"/>
            </svg>

            <span  style="color: var(--orange); ">
            Pre Order
            </span>
            </h3>
            <div class="content">
                <h4 class="subtitle">
                    ' . $countryOfOrigin . '
                </h4>
                <h5 class="delivery-info">
                    Availability: ' . $availability . ' 
                </h5>
            </div>
            ';
    }
    echo '
    </div>';
};

// social share -----------------------------------------------------------
add_action('woocommerce_single_product_summary', function () {
    echo '
    <div class="social-share-container">
        <p>Share:</p>
    ';
    echo do_shortcode('[webduelSocialShare]');
    echo '</div>';
}, 80);

// add variation availability data before add to cart button ---------------------------------
function iconic_output_engraving_field()
{

    global $product;
    echo $product->get_stock_quantity();

    // $product->is_type( $type ) checks the product type, string/array $type ( 'simple', 'grouped', 'variable', 'external' ), returns boolean

    if ($product->is_type('variable')) {
        $dataArray = array();
        foreach ($product->get_available_variations() as $key) {
            $variation = wc_get_product($key['variation_id']);
            $stock = $variation->get_availability();

            array_push($dataArray, array(
                "variation_id" => $key['variation_id'],
                "availability" => $stock['class']
            ));
        }

?>
        <div class="variation-availability-data" data-variation_availability='<?php print_r(json_encode($dataArray)); ?>'>
        </div>
<?php

    }
}

add_action('woocommerce_before_add_to_cart_button', 'iconic_output_engraving_field', 10);

//add wallpaper calculator 
add_action('woocommerce_single_product_summary', function () {
    global $post, $product;
    $category = wp_strip_all_tags($product->get_categories());
    $CategoryWallpaper = "Wallpaper";
    $categoryFabric = "Fabric";

    if ($category === 'Wallpaper') {
        echo '<div class="product-page-btn-container">
            <button class="sizing-calculator-button secondary-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="10.382" height="14.996" viewBox="0 0 10.382 14.996">
            <g id="Group_15" data-name="Group 15" transform="translate(-5.5 -1.5)">
              <path id="Path_42" data-name="Path 42" d="M14.151,16.5H7.23a1.732,1.732,0,0,1-1.73-1.73V3.23A1.732,1.732,0,0,1,7.23,1.5h6.921a1.732,1.732,0,0,1,1.73,1.73V14.765A1.732,1.732,0,0,1,14.151,16.5ZM7.23,2.654a.577.577,0,0,0-.577.577V14.765a.577.577,0,0,0,.577.577h6.921a.577.577,0,0,0,.577-.577V3.23a.577.577,0,0,0-.577-.577Z"/>
              <ellipse id="Ellipse_6" data-name="Ellipse 6" cx="1" cy="0.5" rx="1" ry="0.5" transform="translate(7.5 10.5)"/>
              <ellipse id="Ellipse_7" data-name="Ellipse 7" cx="1" cy="0.5" rx="1" ry="0.5" transform="translate(9.5 10.5)"/>
              <path id="Path_43" data-name="Path 43" d="M12.333,22.654H10.411a.577.577,0,1,1,0-1.154h1.922a.577.577,0,1,1,0,1.154Z" transform="translate(-1.834 -8.465)"/>
              <circle id="Ellipse_8" data-name="Ellipse 8" cx="0.5" cy="0.5" r="0.5" transform="translate(12.5 13.5)"/>
              <circle id="Ellipse_9" data-name="Ellipse 9" cx="0.5" cy="0.5" r="0.5" transform="translate(12.5 10.5)"/>
              <ellipse id="Ellipse_10" data-name="Ellipse 10" cx="1" cy="0.5" rx="1" ry="0.5" transform="translate(7.5 8.5)"/>
              <ellipse id="Ellipse_11" data-name="Ellipse 11" cx="1" cy="0.5" rx="1" ry="0.5" transform="translate(9.5 8.5)"/>
              <circle id="Ellipse_12" data-name="Ellipse 12" cx="0.5" cy="0.5" r="0.5" transform="translate(12.5 8.5)"/>
              <path id="Path_44" data-name="Path 44" d="M14.114,8.947H10.654A1.155,1.155,0,0,1,9.5,7.794V6.64a1.155,1.155,0,0,1,1.154-1.154l3.44-.018A1.156,1.156,0,0,1,15.25,6.623V7.776a1.155,1.155,0,0,1-1.136,1.171ZM14.1,6.623l-3.44.018,0,1.154h3.461L14.1,7.776Z" transform="translate(-1.693 -1.68)"/>
            </g>
          </svg>
          

            Wallpaper Calculator</button>       
        </div>';

        //add calculator body 
        calculator_body();
    }
}, 40);


//wallpaper calculator 


function calculator_body()
{
    global $product;
    echo '<div class="body-container">
       

    <!--sizing calculator-->
    <div class="overlay-background">
        <div class="calculator-overlay">
       
        <svg class="close" width="16" height="16" viewBox="0 0 16 16">
            <path id="Path_28" data-name="Path 28" d="M13.4,12l6.3-6.3a.99.99,0,1,0-1.4-1.4L12,10.6,5.7,4.3A.99.99,0,0,0,4.3,5.7L10.6,12,4.3,18.3A.908.908,0,0,0,4,19a.945.945,0,0,0,1,1,.908.908,0,0,0,.7-.3L12,13.4l6.3,6.3a.967.967,0,0,0,1.4,0,.967.967,0,0,0,0-1.4Z" transform="translate(-4 -4)" fill="#474747"/>
        </svg>
    
       
            <div id="calculator-container">
                <div class="popup-modal wallpaper-calculator-modal is-open">
          
                  <h1>Wallpaper Calculator</h1>
          
          
              <form name="wallpaper_calculator" id="wallpaper-calculator">
                <section>
                  <div>
                    <label for="calc-roll-width">Roll Width<em>*</em> </label>
                    <select name="calc-roll-width" id="calc-roll-width"><option value="37.2">37.2 cm</option><option value="42">42 cm</option><option value="45">45 cm</option><option value="48.5">48.5 cm</option><option value="53">53 cm</option><option value="52">52 cm</option><option value="64">64 cm</option><option value="68">68 cm</option><option value="68.5">68.5 cm</option><option value="70">70 cm</option><option value="90">90 cm</option><option value="95">95 cm</option><option value="100">100 cm</option><option value="140">140 cm</option></select>
                    <label for="calc-roll-height">Roll Length<em>*</em> </label>
                    <select name="calc-roll-height" id="calc-roll-height"><option value="2.65">2.65 cm</option><option value="2.79">2.79 cm</option><option value="3">3 cm</option><option value="5.6">5.6 cm</option><option value="6">6 cm</option><option value="8.5">8.5 cm</option><option value="8.37">8.37 cm</option><option value="9">9 cm</option><option value="10">10 cm</option><option value="10.05">10.05 cm</option><option value="12">12 cm</option><option value="24">24 cm</option></select>
                  </div>
                  <aside>
                    <label for="last-name">Wall width<em>*</em></label>
                    <div class="input-group">
                      <input type="text" name="calc-wall-width1" value="" id="calc-wall-width1" class="form-control" placeholder="Wall 1 width">
                          <span class="input-group-addon">m</span>
                    </div>
                    <div class="input-group">
                      <input type="text" name="calc-wall-width2" value="" id="calc-wall-width2" class="form-control" placeholder="Wall 2 width">
                          <span class="input-group-addon">m</span>
                    </div>
                    <div class="input-group">
                      <input type="text" name="calc-wall-width" value="" id="calc-wall-width3" class="form-control" placeholder="Wall 3 width">
                          <span class="input-group-addon">m</span>
                    </div>
                    <div class="input-group">
                      <input type="text" name="calc-wall-width4" value="" id="calc-wall-width4" class="form-control" placeholder="Wall 4 width">
                          <span class="input-group-addon">m</span>
                      </div>
                  </aside>
                  <aside>
                    <label for="last-name">Wall height<em>*</em></label>
                    <div class="input-group">
                      <input type="text" name="calc-wall-height1" value="" id="calc-wall-height1" class="form-control" placeholder="Wall 1 length">
                          <span class="input-group-addon">m</span>
                    </div>
                    <div class="input-group">
                      <input type="text" name="calc-wall-height2" value="" id="calc-wall-height2" class="form-control" placeholder="Wall 3 length">
                          <span class="input-group-addon">m</span>
                    </div>
                    <div class="input-group">
                      <input type="text" name="calc-wall-height3" value="" id="calc-wall-height3" class="form-control" placeholder="Wall 3 length">
                          <span class="input-group-addon">m</span>
                    </div>
                    <div class="input-group">
                      <input type="text" name="calc-wall-height4" value="" id="calc-wall-height4" class="form-control" placeholder="Wall 4 length">
                          <span class="input-group-addon">m</span>
                      </div>
                  </aside>
                </section>
                <section>
                  <label for="address">Repeat<em>(optional)</em></label>
                  <div class="input-group">
                    <input type="text" name="calc-pattern-repeat" value="" id="calc-pattern-repeat" class="form-control">
                    <span class="input-group-addon">cm</span>
                  </div>
                </section>
                <section class="buttons">
                  <button id="estimate-roll" class="primary-button">Calculate</button>
                </section>
                <section class="estimate-result margin-elements">
                      <div>Result</div>
                      <p>
                      
                              <span class="calc-round">0</span>&nbsp;
                              <span class="suffix-singular hidden" style="display: none;">roll</span>
                              <span class="suffix-plural">rolls</span>
                   
                      </p>
                </section>
            
                <section class="message margin-elements">
                  <p>Please check your measurements carefully. Inspiry is not responsible for overages or shortages based on this calculator.</p>
                </section>
            
              </form>
          
          
          
          
                </div>
              </div>
        </div>
      </div>
</div>';
}

// single product page wishlist container and add brand name before title 
add_action("woocommerce_single_product_summary", "single_product_page_title_start", 1);

function single_product_page_title_start()
{

    global $product;
    // find the brand name of the product
    $brand = array_shift(wc_get_product_terms($product->id, 'pa_brands', array('fields' => 'names')));

    echo  '<div class="single-product-before-title-container">';
    echo '<div class="brand-name">';
    echo $brand;
    echo '</div>';
    echo '<div class="design-board-container">' . do_shortcode('[design_board_button_code]') . '</div>';
    echo '</div>';
}
