<?php
// design board short code
function contact_form_webduel()
{

    // contact page query
    $contactQuery = array(
        'pagename' => 'contact',
        'posts_per_page' => 1,
    );
    $contact = new WP_Query($contactQuery);
    $enquiryTermsArr = array();
    while ($contact->have_posts()) {
        $contact->the_post();
        $phoneNumber = get_field('phone_number');
        $emailAddress = get_field('email_address');
        if (have_rows('enquiry_terms')) {
            while (have_rows('enquiry_terms')) {
                the_row();
                array_push($enquiryTermsArr, get_sub_field('term'));
            }
        }
    }
    wp_reset_postdata();

    ob_start();
?>

    <div class="contact-form-container">
        <form id="contact-form">
            <div class="flex">
                <div class="label-container">
                    <label for="First Name">First Name*</label>
                    <input type="text" name="first-name" id="first-name" required />
                </div>
                <div class="label-container">
                    <label for="Last Name">Last Name*</label>
                    <input type="text" name="last-name" id="last-name" required />
                </div>
            </div>
            <div class="label-container">
                <label for="Email">Email*</label>
                <input type="email" name="email" id="email" required />
            </div>
            <div class="label-container">
                <label for="Phone Number">Phone Number</label>
                <input type="tel" name="phone-number" id="phone-number" />
            </div>
            <div class="label-container">
                <label for="Enquiry About">Enquiry About</label>
                <select name="enquiry-term" id="enquiry-term">
                    <?php
                    foreach ($enquiryTermsArr as $term) {
                    ?>
                        <option value=<?php echo $term ?>><?php echo $term ?></option>
                    <?php
                    }

                    ?>
                </select>
            </div>
            <div class="label-container">
                <label for="Message">Message</label>
                <textarea name="message" id="message"></textarea>
            </div>
            <button class="primary-button">Send</button>
        </form>
        <div class="vertical-border"></div>
        <div class="contact-card">

            <div>
                <a href="tel:<?php echo $phoneNumber; ?>">
                    <span class="icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12.675" height="12.667" viewBox="0 0 12.675 12.667">
                            <path id="Path_54" data-name="Path 54" d="M6.461,4.24A3.922,3.922,0,0,0,4.232,1.373a.421.421,0,0,0-.251-.034C1.7,1.719,1.352,3.049,1.338,3.1a.428.428,0,0,0,.009.233C4.072,11.795,9.738,13.363,11.6,13.878c.143.04.262.072.352.1a.428.428,0,0,0,.312-.018,3.5,3.5,0,0,0,1.732-2.728.431.431,0,0,0-.041-.264A4.1,4.1,0,0,0,11.268,9.1a.422.422,0,0,0-.382.091,5.771,5.771,0,0,1-1.834,1.144,8.143,8.143,0,0,1-3.887-3.95A4.631,4.631,0,0,1,6.348,4.571a.431.431,0,0,0,.112-.331Z" transform="translate(-1.326 -1.333)" />
                        </svg>

                    </span>
                    <span><?php echo $phoneNumber; ?></span>
                </a>
            </div>
            <div>
                <a target="_blank" href="mailto:<?php echo $emailAddress; ?>">
                    <span class="icon-container">
                        <svg width="16.611" height="11.865" viewBox="0 0 16.611 11.865">
                            <g id="Group_18" data-name="Group 18" transform="translate(-2 -6)">
                                <path id="Path_52" data-name="Path 52" d="M10.8,11.226l7.582-4.87A1.78,1.78,0,0,0,17.327,6H4.276a1.78,1.78,0,0,0-1.056.356Z" transform="translate(-0.496)" fill="#231f20" />
                                <path id="Path_53" data-name="Path 53" d="M10.626,13.35h0l-.1.047h-.047a.593.593,0,0,1-.172.047h0a.593.593,0,0,1-.148,0H10.11l-.1-.047h0L2.059,8.26A1.78,1.78,0,0,0,2,8.7V17a1.78,1.78,0,0,0,1.78,1.78H16.831A1.78,1.78,0,0,0,18.611,17V8.7a1.78,1.78,0,0,0-.059-.439Z" transform="translate(0 -0.919)" fill="#231f20" />
                            </g>
                        </svg>


                    </span>
                    <span><?php echo $emailAddress; ?></span>
                </a>
            </div>
        </div>
    </div>
<?php return ob_get_clean();
}

// design board button shortcode
add_shortcode('contact_form_webduel_code', 'contact_form_webduel');
