<?php
// add free shipping if it exist for the given product 
function signInModal()
{
?>
    <div class="sign-in-modal">
        <ul class="list">
            <li class="list-item">
                <?php
                $currentLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                if (is_user_logged_in()) {
                ?>
                    <a href="<?php echo get_site_url(); ?>/home/members/edit-profile" class="anchor">
                        <svg width="18" height="17.155" viewBox="0 0 18 17.155">
                            <g id="Group_9" data-name="Group 9" transform="translate(-16.4 -18)">
                                <path id="Path_19" data-name="Path 19" d="M37,27.644a4.822,4.822,0,1,0-4.8-4.835A4.8,4.8,0,0,0,37,27.644Zm0-8.376a3.541,3.541,0,1,1-3.533,3.567A3.537,3.537,0,0,1,37,19.268Z" transform="translate(-11.625)" fill="#474747" />
                                <path id="Path_20" data-name="Path 20" d="M17.033,64.385H33.767a.643.643,0,0,0,.633-.634A6.063,6.063,0,0,0,28.356,57.7H22.444A6.063,6.063,0,0,0,16.4,63.751.643.643,0,0,0,17.033,64.385Zm5.411-5.417h5.912a4.762,4.762,0,0,1,4.724,4.148H17.72A4.762,4.762,0,0,1,22.444,58.968Z" transform="translate(0 -29.229)" fill="#474747" />
                            </g>
                        </svg>


                        <span>My Account </span>
                    </a>
                <?php
                } else {
                ?>
                    <a href="<?php echo get_site_url(); ?>/sign-in?redirect-link=<?php echo $currentLink ?>" class="anchor">
                        <svg width="18" height="17.155" viewBox="0 0 18 17.155">
                            <g id="Group_9" data-name="Group 9" transform="translate(-16.4 -18)">
                                <path id="Path_19" data-name="Path 19" d="M37,27.644a4.822,4.822,0,1,0-4.8-4.835A4.8,4.8,0,0,0,37,27.644Zm0-8.376a3.541,3.541,0,1,1-3.533,3.567A3.537,3.537,0,0,1,37,19.268Z" transform="translate(-11.625)" fill="#474747" />
                                <path id="Path_20" data-name="Path 20" d="M17.033,64.385H33.767a.643.643,0,0,0,.633-.634A6.063,6.063,0,0,0,28.356,57.7H22.444A6.063,6.063,0,0,0,16.4,63.751.643.643,0,0,0,17.033,64.385Zm5.411-5.417h5.912a4.762,4.762,0,0,1,4.724,4.148H17.72A4.762,4.762,0,0,1,22.444,58.968Z" transform="translate(0 -29.229)" fill="#474747" />
                            </g>
                        </svg>


                        <span>Sign In / Create Account </span>
                    </a>
                <?php } ?>
            </li>
            <li class="list-item">
                <a href="<?php echo get_home_url() . '/home/track-order' ?>" class="anchor">
                <svg width="18" height="18.003" viewBox="0 0 18 18.003">
  <path id="Path_21" data-name="Path 21" d="M9.763,1.044a.643.643,0,0,1,.478,0L18.6,4.388a.643.643,0,0,1,.4.6.629.629,0,0,1,0,.068c0,.008,0,.016,0,.024v9.9a.643.643,0,0,1-.4.6l-8.347,3.384a.687.687,0,0,1-.5,0L1.4,15.569a.643.643,0,0,1-.4-.6v-9.9q0-.03,0-.06t0-.033a.643.643,0,0,1,.4-.6Zm.872,16.366,7.078-2.869V5.935l-7.07,2.827ZM2.286,5.933v8.608L9.349,17.4,9.356,8.76ZM10,2.333,3.376,4.984,10,7.634l6.626-2.649Z" transform="translate(-1.001 -0.998)" fill="#474747"/>
</svg>

                    <span>Track Orders </span>
                </a>
            </li>
            <li class="list-item">
                <a href="<?php echo get_home_url() ?>/home/members/design-boards" class="anchor">
                    <svg width="19" height="17.015" viewBox="0 0 19 17.015">
  <g id="layer1" transform="translate(-1.014 -1038.368)">
    <g id="g4906" transform="translate(1.514 1038.868)">
      <g id="g6020" transform="translate(0 0)">
        <path id="path5035-4" d="M6.625,2.506c-3.058,0-5.112,2.475-5.112,5.533,0,3.469,4.846,7.614,9,10.381,4.153-2.768,8.943-6.979,9-10.381.05-3.057-1.929-5.533-4.987-5.533A5.853,5.853,0,0,0,10.513,4.58C9.129,3.2,7.93,2.506,6.625,2.506Z" transform="translate(-1.514 -2.506)" fill="none" stroke="#474747" stroke-width="1.3"/>
      </g>
    </g>
  </g>
</svg>

                    <span>Create / Manage Design Boards </span>
                </a>
            </li>
            <li class="list-item">
                <a href="<?php echo get_home_url() ?>/wishlist" class="anchor">
                <svg width="18" height="18" viewBox="0 0 20.795 24.581">
  <path id="Path_23" data-name="Path 23" d="M274.716,130.08H258.08v20.178l6.872-6.6,1.446-1.381,1.446,1.381,6.872,6.6Zm.195-2.08a1.8,1.8,0,0,1,.715.146,1.831,1.831,0,0,1,.853.666,1.723,1.723,0,0,1,.317,1.007v20.941a1.723,1.723,0,0,1-.317,1.007,1.892,1.892,0,0,1-1.568.8,1.931,1.931,0,0,1-1.348-.52l-7.165-6.888-7.165,6.888a1.936,1.936,0,0,1-1.348.536,1.8,1.8,0,0,1-.715-.146,1.831,1.831,0,0,1-.853-.666,1.723,1.723,0,0,1-.317-1.007V129.82a1.723,1.723,0,0,1,.317-1.007,1.831,1.831,0,0,1,.853-.666,1.8,1.8,0,0,1,.715-.146Z" transform="translate(-256 -128)" fill="#474747"/>
</svg>




                    <span>View Saved Items </span>
                </a>
            </li>
            <?php
            if (is_user_logged_in()) {
            ?>
                <li class="list-item">
                    <a href="<?php echo get_home_url() ?>/wp-login.php?action=logout" class="anchor">
                    <svg id="Group_10" data-name="Group 10" width="18" height="18" viewBox="0 0 18 18">
  <rect id="Rectangle_25" data-name="Rectangle 25" width="18" height="18" fill="none"/>
  <path id="Path_24" data-name="Path 24" d="M174.011,86l2.973,2.974-2.973,2.974" transform="translate(-161.691 -79.911)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
  <line id="Line_6" data-name="Line 6" x2="7.928" transform="translate(7.363 9.063)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
  <path id="Path_25" data-name="Path 25" d="M44.531,52.461H40.566A.566.566,0,0,1,40,51.895V40.566A.566.566,0,0,1,40.566,40h3.965" transform="translate(-37.168 -37.168)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
</svg>

                        <span>Sign Out </span>
                    </a>
                </li>
            <?php
            } ?>

        </ul>
    </div>
<?php
}

add_shortcode('sign-in-modal', 'signInModal');

// add free shipping if it exist for the given product 
function designBoardExplainerModal()
{
?>
    <div class="design-board-header-modal">
        <?php
        if (!is_user_logged_in()) {
        ?>
            <div class="title">
                Something catch your eye?
            </div>

            <ul class="list">
                <li class="item"><span>1. Save</span> it to Favourites</li>
                <li class="item"><span>2. Create</span> a Design Board</li>
                <li class="item"><span>3. See</span> it all together</li>
            </ul>
            <div class="image-container">
                <?php
                $currentLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $argsDesignBoards = array(
                    'post_type' => 'page',
                    'pagename' => 'contact',
                    'posts_per_page' => 1
                );
                $queryDesignBoards = new WP_Query($argsDesignBoards);
                while ($queryDesignBoards->have_posts()) {
                    $queryDesignBoards->the_post();
                    $image = get_field('design_board_screenshot')['url'];
                ?>
                    <img src="<?php echo $image ?>" alt="Design Boards" />
                <?php
                }
                wp_reset_postdata();
                ?>
            </div>
            <p class="anchor">
                <a href="<?php echo get_site_url(); ?>/sign-in?redirect-link=<?php echo $currentLink ?>">Sign in</a> to see items you may have added using another computer or device.
            </p>
            <a href="<?php echo get_site_url(); ?>/sign-in?redirect-link=<?php echo $currentLink ?>" class="secondary-button">
                SIGN IN
            </a>
        <?php
        } else {
        ?>
            <div class="image-container">
                <?php
                $currentLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $argsDesignBoards = array(
                    'post_type' => 'page',
                    'pagename' => 'contact',
                    'posts_per_page' => 1
                );
                $queryDesignBoards = new WP_Query($argsDesignBoards);
                while ($queryDesignBoards->have_posts()) {
                    $queryDesignBoards->the_post();
                    $image = get_field('design_board_screenshot')['url'];
                ?>
                    <img src="<?php echo $image ?>" alt="Design Boards" />
                <?php
                }
                wp_reset_postdata();
                ?>
            </div>
            <a class="secondary-button" href="<?php echo get_site_url(); ?>/home/members/design-boards">View Design Boards</a>
        <?php
        }
        ?>

    </div>
<?php
}

add_shortcode('design-board-header-modal', 'designBoardExplainerModal');

// loading icon 
add_action('webduel_loading_icon', 'wd_loading_icon', 20); 

function wd_loading_icon(){ 
   
    ?>
    <div class="lds-ring loading-icon">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
    <?php 
}

// webduel phone modal 
add_action('webduel_phone_modal', 'wd_phone_modal', 10); 

function wd_phone_modal(){ 
    $argsPhone = array(
        'post_type' => 'page',
        'pagename' => 'contact',
        'posts_per_page' => 1
    );
    $queryPhone = new WP_Query($argsPhone);
    ?>
      <div class="wd-phone-modal-container">
        <div class="content-container">
    <?php 
    while ($queryPhone->have_posts()) {
        $queryPhone->the_post();
        $phoneData = get_field('phone_modal');
        foreach($phoneData as $value){ 
           ?>
           <div class="content">
                <div class="title"><?php echo $value['title']; ?></div>
                <div class="phone-number">
                <?php echo $value['subtitle']; ?>
                    <a href="tel:<?php echo $value['phone_number'] ?>">
                    <?php echo $value['phone_number']; ?>
                    </a>
                </div>
            </div>
           <?php 
        }
    ?>
    <?php
    }
    ?>
        </div>
    </div>
    <?php 
    wp_reset_postdata();
    ?>

  
            
            
    <?php 
}
// loading icon 
add_action('webduel_sticky_phone_btn', 'wd_sticky_phone_btn', 20); 

function wd_sticky_phone_btn(){ 
    ?>
    <div class="sticky-phone-button">
        <?php 
            do_action('webduel_phone_modal');
        ?>
        <button class="btn">
            <div class="phone-icon">
                <svg width="20.672" height="20.356" viewBox="0 0 20.672 20.356">
                    <path id="Icon_awesome-phone-alt" data-name="Icon awesome-phone-alt" d="M18.121,12.958l-4.08-1.719a.884.884,0,0,0-1.02.247l-1.807,2.17A13.391,13.391,0,0,1,4.758,7.31L6.966,5.534a.848.848,0,0,0,.251-1L5.468.52a.884.884,0,0,0-1-.5L.678.882A.863.863,0,0,0,0,1.719,16.761,16.761,0,0,0,16.9,18.337a.871.871,0,0,0,.852-.666l.874-3.725A.866.866,0,0,0,18.121,12.958Z" transform="translate(1 1.019)" fill="none" stroke="#384238" stroke-width="2"/>
                </svg>
                <span>Call</span>
            </div>
            <div class="close-icon">
                <svg width="15.735" height="15.735" viewBox="0 0 15.735 15.735">
            <path id="Icon_ionic-md-close" data-name="Icon ionic-md-close" d="M23.258,9.1,21.685,7.523l-6.294,6.294L9.1,7.523,7.523,9.1l6.294,6.294L7.523,21.685,9.1,23.258l6.294-6.294,6.294,6.294,1.573-1.573-6.294-6.294Z" transform="translate(-7.523 -7.523)" fill="#384238"/>
        </svg>
            </div>
        </button>
      
    </div>
    <?php 
  
}

// webduel social icons 
add_action('webduel_social_icons', 'wd_social_icons', 10);
function wd_social_icons() { 
    ?>
    <div class="title">
          Get Social
        </div>
        <div class="social-icons">
          <?php
          $argsContact = array(
            'pagename' => 'contact'
          );
          $queryContact = new WP_Query($argsContact);
          while ($queryContact->have_posts()) {
            $queryContact->the_post();
          ?>
            <a href="<?php echo get_field("facebook"); ?>" aria-label="Follow Our Facebook Page">
              <svg width="20" height="20" viewBox="0 0 20 20">
                <path id="Path_31" data-name="Path 31" d="M20.9,2H3.1A1.1,1.1,0,0,0,2,3.1V20.9A1.1,1.1,0,0,0,3.1,22h9.58V14.25h-2.6v-3h2.6V9a3.64,3.64,0,0,1,3.88-4,20.26,20.26,0,0,1,2.33.12v2.7H17.3c-1.26,0-1.5.6-1.5,1.47v1.93h3l-.39,3H15.8V22h5.1A1.1,1.1,0,0,0,22,20.9V3.1A1.1,1.1,0,0,0,20.9,2Z" transform="translate(-2 -2)" fill="#636363" />
              </svg>

            </a>
            <a href="<?php echo get_field("instagram"); ?>" aria-label="Follow Our Instagram Page">
              <svg width="20" height="20" viewBox="0 0 20 20">
                <path id="Path_32" data-name="Path 32" d="M12,9.52A2.48,2.48,0,1,0,14.48,12,2.48,2.48,0,0,0,12,9.52Zm9.93-2.45a6.53,6.53,0,0,0-.42-2.26,4,4,0,0,0-2.32-2.32,6.53,6.53,0,0,0-2.26-.42C15.64,2,15.26,2,12,2s-3.64,0-4.93.07a6.53,6.53,0,0,0-2.26.42A4,4,0,0,0,2.49,4.81a6.53,6.53,0,0,0-.42,2.26C2,8.36,2,8.74,2,12s0,3.64.07,4.93a6.86,6.86,0,0,0,.42,2.27,3.94,3.94,0,0,0,.91,1.4,3.89,3.89,0,0,0,1.41.91,6.53,6.53,0,0,0,2.26.42C8.36,22,8.74,22,12,22s3.64,0,4.93-.07a6.53,6.53,0,0,0,2.26-.42,3.89,3.89,0,0,0,1.41-.91,3.94,3.94,0,0,0,.91-1.4,6.6,6.6,0,0,0,.42-2.27C22,15.64,22,15.26,22,12s0-3.64-.07-4.93Zm-2.54,8a5.73,5.73,0,0,1-.39,1.8A3.86,3.86,0,0,1,16.87,19a5.73,5.73,0,0,1-1.81.35H8.94A5.73,5.73,0,0,1,7.13,19,3.722,3.722,0,0,1,5,16.87a5.49,5.49,0,0,1-.34-1.81c0-.79,0-1,0-3.06V8.94A5.49,5.49,0,0,1,5,7.13a3.51,3.51,0,0,1,.86-1.31A3.59,3.59,0,0,1,7.13,5a5.73,5.73,0,0,1,1.81-.35h6.12A5.73,5.73,0,0,1,16.87,5,3.722,3.722,0,0,1,19,7.13a5.73,5.73,0,0,1,.35,1.81c0,.79,0,1,0,3.06s.07,2.27.04,3.06Zm-1.6-7.44a2.38,2.38,0,0,0-1.41-1.41A4,4,0,0,0,15,6H9a4,4,0,0,0-1.38.26A2.38,2.38,0,0,0,6.21,7.62,4.27,4.27,0,0,0,6,9v6a4.27,4.27,0,0,0,.26,1.38,2.38,2.38,0,0,0,1.41,1.41A4.27,4.27,0,0,0,9,18.05h6a4,4,0,0,0,1.38-.26,2.38,2.38,0,0,0,1.41-1.41A4,4,0,0,0,18.05,15V9a3.78,3.78,0,0,0-.26-1.38ZM12,15.82A3.81,3.81,0,0,1,8.19,12h0A3.82,3.82,0,1,1,12,15.82Zm4-6.89a.9.9,0,0,1,0-1.79h0a.9.9,0,0,1,0,1.79Z" transform="translate(-2 -2)" fill="#636363" />
              </svg>


            </a>
            <a href="<?php echo get_field("pintrest_"); ?>" aria-label="Follow Our Pinterest Page">
              <svg width="20" height="19.953" viewBox="0 0 20 19.953">
                <path id="Path_33" data-name="Path 33" d="M17.5,19.953H3.98A3.239,3.239,0,0,1,.742,16.721V3.232A3.239,3.239,0,0,1,3.98,0H17.5a3.238,3.238,0,0,1,3.238,3.232v13.49A3.238,3.238,0,0,1,17.5,19.953ZM7.861,18.367A33.242,33.242,0,0,0,10.118,13.4l.131-.352.281.249a2.622,2.622,0,0,0,1.562.548,3.552,3.552,0,0,0,1.338-.243c1.921-.706,3.009-2.751,2.759-5.235a4.688,4.688,0,0,0-4.859-4.234C8.9,4.049,6.75,5.282,6.194,7.442a4.982,4.982,0,0,0,.577,3.893c.323.431.694.58,1,.448a.55.55,0,0,0,.373-.733A2.769,2.769,0,0,0,8,10.6l-.045-.109-.058-.139a3.472,3.472,0,0,1-.3-1.086,2.951,2.951,0,0,1,.773-2.276A3.659,3.659,0,0,1,11.087,5.98a3.033,3.033,0,0,1,2.538,1.37,3.4,3.4,0,0,1-.09,3.517,2.085,2.085,0,0,1-1.591.973,1.412,1.412,0,0,1-.791-.264c-.344-.312-.31-.623.019-1.53A4.375,4.375,0,0,0,11.525,8.6a1.118,1.118,0,0,0-1.16-1.129,1.1,1.1,0,0,0-1.139.74A2.575,2.575,0,0,0,9.2,9.485a1.465,1.465,0,0,1-.1.872c-.138.387-.509,2.13-.821,3.472a40.535,40.535,0,0,0-.843,4.419q0,.078,0,.594Q7.836,18.4,7.861,18.367Z" transform="translate(-0.742)" fill="#636363" />
              </svg>

            </a>
            <a href="<?php echo get_field("youtube"); ?>" aria-label="Follow Our Youtube Channel">
              <svg width="19.924" height="19.924" viewBox="0 0 19.924 19.924">
                <g id="youtube__x2C__social__x2C_media__x2C__icons_x2C_" transform="translate(-16 -16)">
                  <path id="Path_34" data-name="Path 34" d="M222.9,205.461v3.9l3.591-1.941-1.973-1.073Z" transform="translate(-198.311 -181.597)" fill="#636363" fill-rule="evenodd" />
                  <path id="Path_35" data-name="Path 35" d="M33.371,16H18.554A2.563,2.563,0,0,0,16,18.554V33.371a2.563,2.563,0,0,0,2.554,2.554H33.371a2.563,2.563,0,0,0,2.554-2.554V18.554A2.563,2.563,0,0,0,33.371,16ZM32.6,25.627v.857a22.372,22.372,0,0,1-.13,2.245,3.061,3.061,0,0,1-.526,1.376,1.858,1.858,0,0,1-1.33.588c-1.862.139-4.656.145-4.656.145S22.5,30.8,21.44,30.7a2.2,2.2,0,0,1-1.467-.592,3.058,3.058,0,0,1-.523-1.376,22.478,22.478,0,0,1-.129-2.245V25.433a22.454,22.454,0,0,1,.129-2.244,3.074,3.074,0,0,1,.525-1.377,1.834,1.834,0,0,1,1.332-.577c1.86-.14,4.652-.13,4.652-.13h.006s2.791-.01,4.653.129a1.848,1.848,0,0,1,1.331.583,3.044,3.044,0,0,1,.524,1.374,22.293,22.293,0,0,1,.13,2.242Z" fill="#636363" fill-rule="evenodd" />
                </g>
              </svg>

            </a>
          <?php
          }
          wp_reset_postdata();
          ?>
        </div>
    <?php 
}


// contact section 
add_action('webduel_contact_info', 'wd_contact_info', 10); 

function wd_contact_info(){ 
    ?> 
    <div class="title">
        Contact Us        
    </div>
    <div class="contact-links">
        <?php 
                  do_action('webduel_phone_modal');

        ?> 
       
    </div>
    <?php 
}
