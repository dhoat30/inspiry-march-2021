<?php

add_action('woocommerce_single_product_summary', 'add_enquiry_button', 38);

function add_enquiry_button()
{
    echo '<a href="#" class="enquire-button" id="enquire-button">
    <i>
            <svg  width="16" height="16" viewBox="0 0 18.488 18.487">
        <g id="Group_20" data-name="Group 20" transform="translate(-48 -48)">
            <circle id="Ellipse_13" data-name="Ellipse 13" cx="0.889" cy="0.889" r="0.889" transform="translate(56.155 52.622)"/>
            <path id="Path_55" data-name="Path 55" d="M226.133,221.688V216H224v.356h.711v5.333H224v.356h2.844v-.356Z" transform="translate(-168.178 -160.534)"/>
            <g id="Group_19" data-name="Group 19" transform="translate(48 48)">
            <path id="Path_56" data-name="Path 56" d="M57.244,48a9.244,9.244,0,1,0,9.244,9.244A9.242,9.242,0,0,0,57.244,48Zm0,17.719a8.475,8.475,0,1,1,8.475-8.475A8.485,8.485,0,0,1,57.244,65.719Z" transform="translate(-48 -48)"/>
            </g>
        </g>
        </svg>

    </i>
     Enquire Now</a>';
}
// add a enquiry modal 
add_action('woocommerce_after_main_content', 'enquiry_button_modal');

function enquiry_button_modal()
{
    global $product;
    if (is_product()) {
        echo '<div class="enquiry-form-section">
            <div class="enquiry-modal-container">
                
                <div class="form-container">
                    <i class="close-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
  <path id="Path_28" data-name="Path 28" d="M13.4,12l6.3-6.3a.99.99,0,1,0-1.4-1.4L12,10.6,5.7,4.3A.99.99,0,0,0,4.3,5.7L10.6,12,4.3,18.3A.908.908,0,0,0,4,19a.945.945,0,0,0,1,1,.908.908,0,0,0,.7-.3L12,13.4l6.3,6.3a.967.967,0,0,0,1.4,0,.967.967,0,0,0,0-1.4Z" transform="translate(-4 -4)" fill="#474747"/>
</svg>


                    </i>
                    <div class="large-font-size regular center-align upper-case">
                        Interested to know more? 
                    </div>
                    <div class="paragraph-font-size thin center-align poppins-font margin-elements">
                        Please fill in the form and one of our design consultants will respond to your enquiry as quickly as possible.
                    </div>
                    <div class="form">
                        <form id="enquiry-form" data-name="';
        echo $product->get_name();
        echo '" data-id="';
        echo $product->get_id();

        echo '"> 
                            <div class="name-container">
                                <input type="text" placeholder="First Name" id="name"  name="name" required>
                                <input type="text" placeholder="Last Name" id="last-name"  name="last-name" required>
                            </div>
                            <input type="email" placeholder="Email" id="email" name="email" required>
                            <input type="phone" placeholder="Phone" id="phone" name="phone" required>
                            <textarea id="enquiry" name="enquiry" placeholder="Enquiry"></textarea> 
                            <div class="checkbox-container">
                                <input class="checkbox" type="checkbox" id="newsletter" name="newsletter" value="No" >
                                <label for="newsletter" class="paragraph-font-size thin"> Receive the latest news, events and special offers from Inspiry.</label>
                            </div>
                            <button class="primary-button">Send</button>
                            
                        </form>
                    </div>
                </div>
    
                <div class="product-container beige-color-bc flex-center flex-column align-center">
                    <img src="';

        echo get_the_post_thumbnail_url($product->get_id(), 'large');
        echo  '" alt="';
        echo  $product->get_name();
        echo '">';
        echo '<div class="column-font-size center-align regular dark-grey margin-elements">';
        echo $product->get_name();
        echo '</div>
                    <div class="section-font-size center-align regular">$';
        echo $product->get_price();
        echo '</div>
                </div>
              
            </div>
           
        </div>';
    }
}
