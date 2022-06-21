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
                           if(get_sub_field('title')==="Windcave"){ 
                             $windcaveLogo = $image; 
                           }
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
            <button class="primary-button" id="pay-button" disabled>
            <svg xmlns="http://www.w3.org/2000/svg" width="8.692" height="11.926" viewBox="0 0 8.692 11.926">
  <g id="Layer_2" data-name="Layer 2" transform="translate(-5.26 -1.25)">
    <path id="Path_48" data-name="Path 48" d="M13.091,21.522H6.117a.861.861,0,0,1-.857-.857V16.117a.861.861,0,0,1,.861-.857h6.97a.861.861,0,0,1,.861.861v4.544A.861.861,0,0,1,13.091,21.522Zm-6.974-5.66a.255.255,0,0,0-.251.255v4.548a.255.255,0,0,0,.255.255h6.97a.255.255,0,0,0,.255-.251V16.117a.255.255,0,0,0-.251-.251Z" transform="translate(0 -8.346)"/>
    <path id="Path_49" data-name="Path 49" d="M14.516,7.516H8.25V4.383a3.133,3.133,0,1,1,6.266,0ZM8.856,6.91H13.91V4.383a2.527,2.527,0,1,0-5.054,0Z" transform="translate(-1.781 0)"/>
    <path id="Path_50" data-name="Path 50" d="M13.532,16H6.558A.554.554,0,0,0,6,16.558v4.548a.554.554,0,0,0,.558.554h6.974a.554.554,0,0,0,.554-.554V16.558A.554.554,0,0,0,13.532,16ZM10.35,19.267v.982a.3.3,0,0,1-.606,0v-.982a1.112,1.112,0,1,1,.606,0Z" transform="translate(-0.441 -8.787)"/>
  </g>
</svg>
                Pay Securely Now
            </button>
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