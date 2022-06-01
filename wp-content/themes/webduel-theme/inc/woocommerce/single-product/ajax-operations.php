<?php
// add to cart  Ajax -------------------------------------------------------------
add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');

function woocommerce_ajax_add_to_cart()
{

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        WC_AJAX::get_refreshed_fragments();
    } else {

        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
        );

        echo wp_send_json($data);
    }
    wp_die();
}
// show live cart item number in the header on add to cart
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_item_fragment');

function woocommerce_header_add_to_cart_item_fragment($fragments)
{
    global $woocommerce;
    ob_start();
?>
    <span class="cart-item-count cart-items-header">(<?php echo WC()->cart->get_cart_contents_count(); ?>)</span>
<?php
    $fragments['span.cart-item-count'] = ob_get_clean();
    return $fragments;
}


//add to cart ajax
/**
 * Show cart contents / total Ajax
 */

add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment($fragments)
{
    global $woocommerce;
    ob_start();
?>
       <div class="cart-box">
            <div class="title-section">
                <div class="title">My Cart</div>
                <svg class="close-cart" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path id="Path_28" data-name="Path 28" d="M13.4,12l6.3-6.3a.99.99,0,1,0-1.4-1.4L12,10.6,5.7,4.3A.99.99,0,0,0,4.3,5.7L10.6,12,4.3,18.3A.908.908,0,0,0,4,19a.945.945,0,0,0,1,1,.908.908,0,0,0,.7-.3L12,13.4l6.3,6.3a.967.967,0,0,0,1.4,0,.967.967,0,0,0,0-1.4Z" transform="translate(-4 -4)" fill="#474747" />
                </svg>

            </div>
            <div class="flex-card">
                <?php

                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $product = $cart_item['data'];
                    $product_id = $cart_item['product_id'];
                    $variationID = $cart_item['variation_id'];
                    $quantity = $cart_item['quantity'];
                    $price = WC()->cart->get_product_price($product);
                    $subtotal = WC()->cart->get_product_subtotal($product, $cart_item['quantity']);
                    $link = $product->get_permalink($cart_item);
                    // Anything related to $product, check $product tutorial
                    $meta = wc_get_formatted_cart_item_data($cart_item);
                    if ($variationID) {
                        $product_id = $variationID;
                    }
                ?>
                    <div class="product-card">
                        <?php

                        // condition to check if the product is simple
                        if ($product->name == "Free Sample") {
                            // pulling information of an original product in a form of an objec†
                            $originalProduct = wc_get_product($cart_item["free_sample"]);

                            if (!empty($originalProduct)) {
                                $permalink = get_the_permalink($originalProduct->get_id());
                                $imageID = $originalProduct->image_id;
                                $name = $originalProduct->get_name();
                            }
                        ?>
                            <a href="<?php echo $permalink; ?>" class="mini_cart_item <?php echo $cart_item_key; ?>">
                                <div class="img-container">
                                    <img src="<?php echo wp_get_attachment_image_url($imageID, 'woocommerce_gallery_thumbnail'); ?>" alt="<?php echo $name; ?>" />
                                </div>

                                <div class="title-container">
                                    <h5 class="title"> <?php echo $quantity; ?> X Free Sample (<?php echo $name; ?> )</h5>
                                </div>

                                <div class="price-container">
                                    <h6 class="cart-price">$<?php echo number_format($product->price * $quantity) ?></h6>
                                </div>

                            </a>
                            <div class="remove-column remove-product">

                            <svg data-product_id="<?php echo $product_id ?>" data-cart_item_key="<?php echo $cart_item_key; ?>" width="13.28" height="15.94" viewBox="0 0 18.469 22.17">
                                    <g id="Group_13" data-name="Group 13" transform="translate(-96.038 -64)">
                                        <path id="Path_29" data-name="Path 29" d="M114.373,68.006c-.139-.519-.231-.808-.231-.808-.15-.537-.531-.537-1.1-.629l-3.065-.387c-.381-.063-.381-.063-.531-.392-.5-1.131-.658-1.789-1.206-1.789H102.3c-.548,0-.7.658-1.2,1.8-.15.323-.15.323-.531.393l-3.071.387c-.56.092-.964.144-1.114.681,0,0-.069.237-.214.75-.185.687-.26.612.375.612H114C114.633,68.623,114.564,68.693,114.373,68.006Z" fill="#474747" />
                                        <path id="Path_30" data-name="Path 30" d="M131.123,176H116.878c-.958,0-1,.127-.947.848l1.079,14c.092.71.162.854,1.01.854h11.96c.848,0,.918-.144,1.01-.854l1.079-14C132.128,176.121,132.081,176,131.123,176Z" transform="translate(-18.73 -105.535)" fill="#474747" />
                                    </g>
                                </svg>
                            </div>
                        <?php
                        } else {
                        ?>
                            <a href="<?php echo $link ?>" class="mini_cart_item <?php echo $cart_item_key; ?>">
                                <div class="img-container">
                                    <img src="<?php echo get_the_post_thumbnail_url($product_id, 'woocommerce_gallery_thumbnail'); ?>" alt="<?php echo $product->name ?>" />
                                </div>
                                <div class="title-container">
                                    <h5 class="title"> <?php echo $quantity; ?> X <?php echo $product->name ?></h5>
                                </div>

                                <div class="price-container">
                                    <h6 class="cart-price">$<?php echo number_format($product->price * $quantity); ?></h6>
                                </div>
                            </a>
                            <div class="remove-column remove-product">
                                <svg data-product_id="<?php echo $product_id ?>" data-cart_item_key="<?php echo $cart_item_key; ?>" width="13.28" height="15.94" viewBox="0 0 18.469 22.17">
                                    <g id="Group_13" data-name="Group 13" transform="translate(-96.038 -64)">
                                        <path id="Path_29" data-name="Path 29" d="M114.373,68.006c-.139-.519-.231-.808-.231-.808-.15-.537-.531-.537-1.1-.629l-3.065-.387c-.381-.063-.381-.063-.531-.392-.5-1.131-.658-1.789-1.206-1.789H102.3c-.548,0-.7.658-1.2,1.8-.15.323-.15.323-.531.393l-3.071.387c-.56.092-.964.144-1.114.681,0,0-.069.237-.214.75-.185.687-.26.612.375.612H114C114.633,68.623,114.564,68.693,114.373,68.006Z" fill="#474747" />
                                        <path id="Path_30" data-name="Path 30" d="M131.123,176H116.878c-.958,0-1,.127-.947.848l1.079,14c.092.71.162.854,1.01.854h11.96c.848,0,.918-.144,1.01-.854l1.079-14C132.128,176.121,132.081,176,131.123,176Z" transform="translate(-18.73 -105.535)" fill="#474747" />
                                    </g>
                                </svg>

                            </div>
                        <?php
                        } ?>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="pop-up-footer">
                <!-- <div class="total-container"> -->
                <!-- <div class="total poppins-font">
                        Total: $<?php
                                //  $totalAmount = str_replace(".00", "", (string)number_format(WC()->cart->total, 2, ".", ""));
                                //echo number_format($totalAmount); 
                                ?>
                    </div> -->
                <!-- </div> -->
                <!-- <div class="cont-shopping">
                            <a class="secondary-button" href="#">Continue Shopping</a>
                        </div> -->
                <div class="checkout-btn">
                    <a class="primary-button" href="<?php echo get_site_url(); ?>/cart">Cart</a>
                </div>
            </div>
        </div>
<?php
    $fragments['.cart-box'] = ob_get_clean();
    return $fragments;
}

// remove item from cart pop up --ajax
// Remove product in the cart using ajax
// function warp_ajax_product_remove()
// {
//     // Get mini cart
//     ob_start();

//     foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item)
//     {
//         if($cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key'] )
//         {
//             WC()->cart->remove_cart_item($cart_item_key);
//         }
//         else if ($cart_item['variation_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key'] ){ 
//             WC()->cart->remove_cart_item($cart_item_key);
//         }
//     }

//     WC()->cart->calculate_totals();
//     WC()->cart->maybe_set_cart_cookies();

//     woocommerce_mini_cart();

//     $mini_cart = ob_get_clean();

//     // Fragments and mini cart are returned
//     $data = array(
//         'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
//                 'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
//             )
//         ),
//         'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
//     );

//     wp_send_json( $data );

//     die();
// }

// add_action( 'wp_ajax_product_remove', 'warp_ajax_product_remove' );
// add_action( 'wp_ajax_nopriv_product_remove', 'warp_ajax_product_remove' );