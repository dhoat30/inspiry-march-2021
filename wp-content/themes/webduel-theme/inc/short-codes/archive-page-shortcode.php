<?php 
// add free shipping if it exist for the given product 
function addFreeShippingTag(){ 
    global $product;
    if($product->get_shipping_class()==="free-shipping"){ 
      return '<p class="free-shipping">FREE SHIPPING</p>'; 
    }
}

add_shortcode('add_free_shipping_tag', 'addFreeShippingTag'); 


// add deal text if it exist for the given product on product loop page
function addDealText(){ 
    global $product;
    $dealText = $product->get_attribute( 'pa_current-deal' );
    if(!empty($dealText)){ 
      return '<p class="loop-deal">'.$dealText.'</p>'; 
    }
}

add_shortcode('add_deal_text', 'addDealText'); 

// in stock toggle button shortcode 
function in_stock_toggle(){ 
    // stock toggle button
    $toggleEnableClass = ''; 
    $toggleText = 'OFF'; 
    // check if the availability param exist and is instock
    if (isset($_GET['_availability']) && $_GET['_availability'] === 'instock') { 
            $toggleEnableClass = 'enabled'; 
            $toggleText = "ON"; 
    }           
    ?>
        <div class="switch stock-toggle <?php echo $toggleEnableClass;?>">
            <input id="stock-toggle-input" class="cmn-toggle cmn-toggle-round" type="checkbox">
            <label for="stock-toggle-input" id="stock-toggle-label"><span><?php echo $toggleText; ?></span></label>
            <div class="title">In Stock & Ready to Deliver</div>
        </div>
  <?php 
}

add_shortcode('in_stock_toggle', 'in_stock_toggle'); 
