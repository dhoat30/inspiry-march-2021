<div class="footer-newsletter-section">
  <div class="flex-container  row-container">
    <div class="content">
      <h6 class="title">
        Sign Up for Inspiry Emails
      </h6>
      <p class="subtitle">
        Plus hear about the latest and greatest from our family of brands!
      </p>
    </div>
    <div class="form">
      <!-- hubspot form  -->
      <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
      <script>
        hbspt.forms.create({
          region: "na1",
          portalId: "21683990",
          formId: "35926044-580b-4391-84e6-b86524e985df"
        });
      </script>
     
    </div>
  </div>
  <div class="privacy-policy row-container">
    By signing up, you will receive Inspiry offers, promotions and other commercial messages. You are also agreeing to Inspiry's
    <a href="<?php echo get_privacy_policy_url() ?>">Privacy Policy</a>.
    You may unsubscribe at any time.
  </div>
</div>

<!-- footer section -->
<footer>
  <div class="flex-container row-container">
    <div class="columns">
      <div class="help-nav flex-item">
        <div class="title">
          Help
        </div>
        <div class="nav">
          <?php
          wp_nav_menu(array(
            'theme_location' => 'footer-help-info'
          ))
          ?>
        </div>
      </div>
      <div class="services-nav flex-item">
        <div class="title">
          Services
        </div>
        <div class="nav">
          <?php
          wp_nav_menu(array(
            'theme_location' => 'footer-services'
          ))
          ?>
        </div>
      </div>
      <div class="help-nav flex-item">
        <div class="title">
          Store
        </div>
        <div class="nav">
          <?php
          wp_nav_menu(array(
            'theme_location' => 'footer-store'
          ))
          ?>
        </div>
      </div>
      <div class="social flex-item">
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
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                <path id="Path_31" data-name="Path 31" d="M20.9,2H3.1A1.1,1.1,0,0,0,2,3.1V20.9A1.1,1.1,0,0,0,3.1,22h9.58V14.25h-2.6v-3h2.6V9a3.64,3.64,0,0,1,3.88-4,20.26,20.26,0,0,1,2.33.12v2.7H17.3c-1.26,0-1.5.6-1.5,1.47v1.93h3l-.39,3H15.8V22h5.1A1.1,1.1,0,0,0,22,20.9V3.1A1.1,1.1,0,0,0,20.9,2Z" transform="translate(-2 -2)" fill="#636363" />
              </svg>

            </a>
            <a href="<?php echo get_field("instagram"); ?>" aria-label="Follow Our Instagram Page">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                <path id="Path_32" data-name="Path 32" d="M12,9.52A2.48,2.48,0,1,0,14.48,12,2.48,2.48,0,0,0,12,9.52Zm9.93-2.45a6.53,6.53,0,0,0-.42-2.26,4,4,0,0,0-2.32-2.32,6.53,6.53,0,0,0-2.26-.42C15.64,2,15.26,2,12,2s-3.64,0-4.93.07a6.53,6.53,0,0,0-2.26.42A4,4,0,0,0,2.49,4.81a6.53,6.53,0,0,0-.42,2.26C2,8.36,2,8.74,2,12s0,3.64.07,4.93a6.86,6.86,0,0,0,.42,2.27,3.94,3.94,0,0,0,.91,1.4,3.89,3.89,0,0,0,1.41.91,6.53,6.53,0,0,0,2.26.42C8.36,22,8.74,22,12,22s3.64,0,4.93-.07a6.53,6.53,0,0,0,2.26-.42,3.89,3.89,0,0,0,1.41-.91,3.94,3.94,0,0,0,.91-1.4,6.6,6.6,0,0,0,.42-2.27C22,15.64,22,15.26,22,12s0-3.64-.07-4.93Zm-2.54,8a5.73,5.73,0,0,1-.39,1.8A3.86,3.86,0,0,1,16.87,19a5.73,5.73,0,0,1-1.81.35H8.94A5.73,5.73,0,0,1,7.13,19,3.722,3.722,0,0,1,5,16.87a5.49,5.49,0,0,1-.34-1.81c0-.79,0-1,0-3.06V8.94A5.49,5.49,0,0,1,5,7.13a3.51,3.51,0,0,1,.86-1.31A3.59,3.59,0,0,1,7.13,5a5.73,5.73,0,0,1,1.81-.35h6.12A5.73,5.73,0,0,1,16.87,5,3.722,3.722,0,0,1,19,7.13a5.73,5.73,0,0,1,.35,1.81c0,.79,0,1,0,3.06s.07,2.27.04,3.06Zm-1.6-7.44a2.38,2.38,0,0,0-1.41-1.41A4,4,0,0,0,15,6H9a4,4,0,0,0-1.38.26A2.38,2.38,0,0,0,6.21,7.62,4.27,4.27,0,0,0,6,9v6a4.27,4.27,0,0,0,.26,1.38,2.38,2.38,0,0,0,1.41,1.41A4.27,4.27,0,0,0,9,18.05h6a4,4,0,0,0,1.38-.26,2.38,2.38,0,0,0,1.41-1.41A4,4,0,0,0,18.05,15V9a3.78,3.78,0,0,0-.26-1.38ZM12,15.82A3.81,3.81,0,0,1,8.19,12h0A3.82,3.82,0,1,1,12,15.82Zm4-6.89a.9.9,0,0,1,0-1.79h0a.9.9,0,0,1,0,1.79Z" transform="translate(-2 -2)" fill="#636363" />
              </svg>


            </a>
            <a href="<?php echo get_field("pintrest_"); ?>" aria-label="Follow Our Pinterest Page">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.953" viewBox="0 0 20 19.953">
                <path id="Path_33" data-name="Path 33" d="M17.5,19.953H3.98A3.239,3.239,0,0,1,.742,16.721V3.232A3.239,3.239,0,0,1,3.98,0H17.5a3.238,3.238,0,0,1,3.238,3.232v13.49A3.238,3.238,0,0,1,17.5,19.953ZM7.861,18.367A33.242,33.242,0,0,0,10.118,13.4l.131-.352.281.249a2.622,2.622,0,0,0,1.562.548,3.552,3.552,0,0,0,1.338-.243c1.921-.706,3.009-2.751,2.759-5.235a4.688,4.688,0,0,0-4.859-4.234C8.9,4.049,6.75,5.282,6.194,7.442a4.982,4.982,0,0,0,.577,3.893c.323.431.694.58,1,.448a.55.55,0,0,0,.373-.733A2.769,2.769,0,0,0,8,10.6l-.045-.109-.058-.139a3.472,3.472,0,0,1-.3-1.086,2.951,2.951,0,0,1,.773-2.276A3.659,3.659,0,0,1,11.087,5.98a3.033,3.033,0,0,1,2.538,1.37,3.4,3.4,0,0,1-.09,3.517,2.085,2.085,0,0,1-1.591.973,1.412,1.412,0,0,1-.791-.264c-.344-.312-.31-.623.019-1.53A4.375,4.375,0,0,0,11.525,8.6a1.118,1.118,0,0,0-1.16-1.129,1.1,1.1,0,0,0-1.139.74A2.575,2.575,0,0,0,9.2,9.485a1.465,1.465,0,0,1-.1.872c-.138.387-.509,2.13-.821,3.472a40.535,40.535,0,0,0-.843,4.419q0,.078,0,.594Q7.836,18.4,7.861,18.367Z" transform="translate(-0.742)" fill="#636363" />
              </svg>

            </a>
            <a href="<?php echo get_field("youtube"); ?>" aria-label="Follow Our Youtube Channel">
              <svg xmlns="http://www.w3.org/2000/svg" width="19.924" height="19.924" viewBox="0 0 19.924 19.924">
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
      </div>
    </div>
  </div>
  <div class="banner row-container">
    <?php
    $argsBanner = array(
      'post_type' => 'banners',
      'posts_per_page' => 1,
      'tax_query' => array(
        array(
          'taxonomy' => 'banners_categories',
          'field'    => 'slug',
          'terms'    => array('footer'),
        )
      ),
    );
    $banner = new WP_Query($argsBanner);

    while ($banner->have_posts()) {
      $banner->the_post();
      $image = get_field('banner_image');
      $mobileImageUrl = get_field('banner_mobile_image')['url'];
      $imgUrl = $image['url'];
    ?>
      <a href="<?php echo get_field('banner_link'); ?>">
        <picture>
          <source media="(min-width:900px)" srcset="<?php echo $imgUrl; ?>">
          <img loading="lazy" src="<?php echo $mobileImageUrl; ?>" alt="<?php echo get_the_title(); ?>" width="100%">
        </picture>
      </a>
    <?php
    }
    wp_reset_postdata();
    ?>
  </div>

  <!-- copyright section -->
  <div class="copyright-section row-container">
    <div class="columns">
      <div class="links">
        <a class="first-child" href="<?php echo get_privacy_policy_url(); ?>">Privacy Policy</a>
        <a href="<?php echo get_site_url(); ?>/customer-service/terms-conditions/">Terms & Conditions</a>
      </div>
      <div class="copyright">
        © Copyright 2022 Inspiry NZ. All rights reserved.
      </div>
    </div>
  </div>
</footer>

<div class="go-to-header hide" id='go-to-header'>
  <a href="#header">

    <svg xmlns="http://www.w3.org/2000/svg" width="18.475" height="10.653" viewBox="0 0 18.475 10.653">
      <g id="Group_11" data-name="Group 11" transform="translate(-18.6 34.753) rotate(-90)">
        <g id="Icon-Chevron-Left" transform="translate(24.1 18.6)">
          <path id="Fill-35" d="M-211.551-297.925l-1.349-1.349,7.956-7.889-7.956-7.889,1.349-1.349,9.3,9.237-9.3,9.237" transform="translate(212.9 316.4)" fill="#ffffff" />
        </g>
      </g>
    </svg>


  </a>
</div>


<!-- overlay without loader  -->
<div class="dark-overlay">
</div>
<!-- overlay  -->
<div class="overlay">
  <?php do_action('webduel_loading_icon'); ?>
</div>
<!-- foreground overlay  -->
<div class="foreground-loader">
  <?php do_action('webduel_loading_icon'); ?>
</div>
<!-- error pop up  -->
<div class="error-modal">

  <div class="container">
    <i>
      <svg width="40" height="43" viewBox="0 0 24.001 22">
        <path id="Path_39" data-name="Path 39" d="M14.876,2.672a3.309,3.309,0,0,0-5.752,0L.414,18.19a3.178,3.178,0,0,0,.029,3.189A3.264,3.264,0,0,0,3.29,23H20.71a3.264,3.264,0,0,0,2.847-1.621,3.178,3.178,0,0,0,.029-3.189ZM12,19a1,1,0,1,1,1-1A1,1,0,0,1,12,19Zm1-5a1,1,0,0,1-2,0V8a1,1,0,0,1,2,0Z" transform="translate(0 -1)" />
      </svg>

    </i>
    <div class="content"></div>
    <button>Dismiss</button>
  </div>
</div>


<?php
do_action('design_board_modal_hook'); ?>
<?php wp_footer(); ?>

</body>

</html>