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
      <div class="flex-item contact-social-container">
        <div class="social">
            <?php do_action('webduel_social_icons');?>
        </div>
        <div class="contact-container" >
          <?php do_action('webduel_contact_info'); ?> 
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

<!-- sticky phone button  -->
<?php do_action('webduel_sticky_phone_btn');?>
<!-- overlay without loader  -->
<div class="dark-overlay">
</div>
<!-- overlay without loader  -->
<div class="white-overlay">
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