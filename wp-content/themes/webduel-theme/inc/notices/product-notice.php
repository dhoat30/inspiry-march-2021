<?php
add_action('woocommerce_before_single_product', 'webduel_product_notice', 30);

function webduel_product_notice()
{
    if (is_product()) { ?>
        <div class="webduel-notice">
            <div class="notice-text">
                This is a notice
            </div>
        </div>
<?php }
}
