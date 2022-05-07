<?php
// remove coupon --------------------
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);

remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);

// add custom order review area 
add_action('woocommerce_checkout_before_order_review', 'webduel_order_review', 10);
function webduel_order_review()
{
?>
    <div class="summary-payment">
    <?php
}

add_action('woocommerce_checkout_before_order_review', 'woocommerce_order_review', 15);

add_action('woocommerce_checkout_before_order_review', 'webduel_payment_btn', 20);

function webduel_payment_btn()
{
    ?>

        <div class="payment-logo-container">
            <div class="title">Ways to pay: </div>
            <div class="img-container">
                <?php
                $argsContact = array(
                    'pagename' => 'contact'
                );
                $queryContact = new WP_Query($argsContact);
                while ($queryContact->have_posts()) {
                    $queryContact->the_post();
                    // get images 
                    if (have_rows('payment_option_images')) {

                        while (have_rows('payment_option_images')) {
                            the_row();
                            $image = get_sub_field('image')['sizes']['medium'];
                ?>
                            <img src="<?php echo $image; ?>" alt="<?php echo get_sub_field('title'); ?>">
                    <?php
                        }
                    }
                    ?>

                <?php
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <div class="pay-button-container">
            <button class="primary-button" id="pay-button" disabled><i class="fa-regular fa-lock-keyhole"></i>Pay Securely Now</button>
        </div>
    <?php
}

// add payment option
add_action('woocommerce_checkout_before_order_review', 'woocommerce_checkout_payment', 20);

add_action('woocommerce_checkout_before_order_review', function () {
    ?>
    </div>
<?php
}, 30);


/* WooCommerce: The Code Below Removes Checkout Fields */
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields)
{

    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_2']);

    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_2']);
  
    return $fields;
}

//    change the country label and make region required  
add_filter('woocommerce_get_country_locale', 'marcelbotezat_change_state_label_locale');
function marcelbotezat_change_state_label_locale($locale){
    $locale['NZ']['country']['label'] = __('Country', 'woocommerce');
    $locale['NZ']['state']['required'] = true;
    return $locale;
}


add_filter('default_checkout_billing_state', 'change_default_checkout_state');
add_filter('default_checkout_shipping_state', 'change_default_checkout_state');

function change_default_checkout_state()
{
    return 'Select'; // state code
}


// add windcave iframe 
add_action('woocommerce_after_checkout_form', function () {
?>

    <div class="payment-gateway-container" data-carttotal="<?php echo WC()->cart->total; ?>">
        <div class="foreground-loader">
            <i class="fa-duotone fa-loader fa-spin"></i>
        </div>
        <img src="https://inspiry.co.nz/wp-content/uploads/2021/08/windcave-logo.png" width="95%">
        <div id="payment-iframe-container">

        </div>
        <div class="button-container">
            <button class="windcave-submit-button">Submit</button>
            <div class="cancel-payment">Cancel Payment</div>
        </div>
    </div>

<?php
}, 20);

