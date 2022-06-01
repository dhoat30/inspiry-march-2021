<?php
get_header();
?>
<!-- home page -->
<section class="video-container ">
    <?php
    $argsVideos = array(
        'post_type' => 'videos',
        'posts_per_page' => 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'video-category',
                'field'    => 'slug',
                'terms'    => array('home-page-hero-video'),
            )
        ),
    );
    $video = new WP_Query($argsVideos);
    while ($video->have_posts()) {
        $video->the_post();
    ?>
        <a href="<?php echo get_field('add_a_landing_page_link'); ?>">
            <?php echo get_the_content(); ?>
        </a>
        <div class="title-container">
            <div class="title"><?php print_r(get_field('section_title')); ?></div>
            <h2 class="subtitle"><?php print_r(get_field('section_subtitle')); ?></h2>
        </div>
    <?php
    }
    wp_reset_postdata();
    ?>
</section>
<!-- home page -->
<section class="slider-container ">
    <ul class="card-list owl-carousel">
    <?php
    $argsVideos = array(
        'post_type' => 'sliders',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'slider-category',
                'field'    => 'slug',
                'terms'    => array('home-page-hero-slider'),
            )
        ),
    );
    $video = new WP_Query($argsVideos);
    while ($video->have_posts()) {
        $video->the_post();
        $mobileImage = get_field('mobile_image');
    ?>
    <li>
        <a href="<?php echo get_field('add_link'); ?>">
                <picture>
                    <source media="(min-width:1366px)" srcset="<?php echo get_the_post_thumbnail_url(null, "full"); ?>" >
                    <source media="(min-width:600px)" srcset="<?php echo get_the_post_thumbnail_url(null, "large"); ?>" >
                    <img loading="lazy" src="<?php echo $mobileImage['sizes']['woocommerce_thumbnail']; ?>" alt="<?php echo get_the_title(); ?>" width="100%">
                </picture>
        </a>
        </li>
    <?php
    }
    wp_reset_postdata();
    ?>
    </ul>
</section>

<!-- special section  -->
<section class="special-section wide-image-section row-container">
    <div class="image-container">
        <?php

        $argsSecondSectionImage = array(
            'post_type' => 'banners',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'banners_categories',
                    'field'    => 'slug',
                    'terms'    => array('home-special-section'),
                )
            )
        );
        $secondSectionImage = new WP_Query($argsSecondSectionImage);

        while ($secondSectionImage->have_posts()) {
            $secondSectionImage->the_post();
            // get desktop and mobile image 
            $image = get_field('banner_image');
            $mobileImage = get_field('banner_mobile_image');
        ?>
            <h3 class="title row-container"><?php echo get_field('title'); ?></h3>
            <a class="link" href="<?php echo get_field('banner_link'); ?>">
                <picture>
                    <source media="(min-width:1366px)" srcset="<?php echo $image['sizes']['2048x2048']; ?>">
                    <source media="(min-width:600px)" srcset="<?php echo $image['sizes']['large']; ?>">
                    <img loading="lazy" src="<?php echo $mobileImage['sizes']['woocommerce_thumbnail']; ?>" alt="<?php echo get_the_title(); ?>" width="100%">
                </picture>
            </a>
            <a class="row-container link-text" href="<?php echo get_field('banner_link'); ?>">
                <?php echo get_field('link_text'); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
  <path id="Path_63" data-name="Path 63" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(-96 -159.986)"/>
</svg>


            </a>
        <?php
        }
        wp_reset_postdata();

        ?>
    </div>
</section>

<!-- second section  -->
<section class="second-section wide-image-section row-container">
    <div class="image-container">
        <?php

        $argsSecondSectionImage = array(
            'post_type' => 'banners',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'banners_categories',
                    'field'    => 'slug',
                    'terms'    => array('second-section'),
                )
            )
        );
        $secondSectionImage = new WP_Query($argsSecondSectionImage);

        while ($secondSectionImage->have_posts()) {
            $secondSectionImage->the_post();
            // get desktop and mobile image 
            $image = get_field('banner_image');
            $mobileImage = get_field('banner_mobile_image');
        ?>
            <h3 class="title row-container"><?php echo get_field('title'); ?></h3>
            <a class="link" href="<?php echo get_field('banner_link'); ?>">
                <picture>
                    <source media="(min-width:1366px)" srcset="<?php echo $image['sizes']['2048x2048']; ?>">
                    <source media="(min-width:600px)" srcset="<?php echo $image['sizes']['large']; ?>">
                    <img loading="lazy" src="<?php echo $mobileImage['sizes']['woocommerce_thumbnail']; ?>" alt="<?php echo get_the_title(); ?>" width="100%">
                </picture>
            </a>
            <a class="row-container link-text" href="<?php echo get_field('banner_link'); ?>">
                <?php echo get_field('link_text'); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
  <path id="Path_63" data-name="Path 63" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(-96 -159.986)"/>
</svg>


            </a>
        <?php
        }
        wp_reset_postdata();

        ?>
    </div>
</section>

<!-- third section  -->
<section class="third-section wide-image-section row-container">
    <div class="image-container">
        <?php
        $argsThirdSectionImage = array(
            'post_type' => 'banners',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'banners_categories',
                    'field'    => 'slug',
                    'terms'    => array('third-section'),
                )
            )
        );
        $thirdSectionImage = new WP_Query($argsThirdSectionImage);

        while ($thirdSectionImage->have_posts()) {
            $thirdSectionImage->the_post();
            // get desktop and mobile image 
            $image = get_field('banner_image');
            $mobileImage = get_field('banner_mobile_image');
        ?>
            <h3 class="title row-container"><?php echo get_field('title'); ?></h3>
            <a class="link" href="<?php echo get_field('banner_link'); ?>">
                <picture>
                    <source media="(min-width:1366px)" srcset="<?php echo $image['sizes']['2048x2048']; ?>">
                    <source media="(min-width:600px)" srcset="<?php echo $image['sizes']['large']; ?>">
                    <img class="image" loading="lazy" src="<?php echo $mobileImage['sizes']['woocommerce_thumbnail']; ?>" alt="<?php echo get_the_title(); ?>" width="100%">
                </picture>
            </a>
            <a class="row-container link-text" href="<?php echo get_field('banner_link'); ?>">
                <?php echo get_field('link_text'); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
  <path id="Path_63" data-name="Path 63" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(-96 -159.986)"/>
</svg>


            </a>
        <?php
        }
        wp_reset_postdata();
        ?>
    </div>
</section>


<!-- fourth section  -->
<section class="fourth-section category-cards-section row-container">
    <h3 class="title">shop by category</h3>
    <ul class="card-list owl-carousel">
        <?php
        $argsCategoryCards = array(
            'post_type' => 'homepage-cards',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'home-page-card-category',
                    'field'    => 'slug',
                    'terms'    => array('category-section'),
                )
                ),
                'orderby' => 'publish_date',
                'order' => 'DSC'
        );
        $categoryCards = new WP_Query($argsCategoryCards);

        while ($categoryCards->have_posts()) {
            $categoryCards->the_post();
        ?>
            <li class="item">
                <a class="link" href="<?php echo get_field('category_link'); ?>">
                    <img loading="lazy" src="<?php echo get_the_post_thumbnail_url(null, "woocommerce_thumbnail"); ?>" alt="<?php echo get_the_title(); ?>" width="100%">
                    <span>
                        <?php echo get_the_title(); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
  <path id="Path_63" data-name="Path 63" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(-96 -159.986)"/>
</svg>


                    </span>
                </a>
            </li>
        <?php
        }
        wp_reset_postdata();
        ?>
    </ul>
</section>
<!-- fifth section- wallpaper -->
<section class="wallpaper-section fifth-section">
    <div class="container row-container">
        <?php
        $argsWallpaper = array(
            'posts_per_page' => 1,
            'tag' => 'home-page-wallpaper-section'
        );
        $wallpaper = new WP_Query($argsWallpaper);
        while ($wallpaper->have_posts()) {
            $wallpaper->the_post();
            $largeImage = get_field('large_image');
        ?>
            <a class="primary-button" href="<?php echo get_field('subtitle_link'); ?>"><?php echo get_field('subtitle'); ?></a>
            <h3 class="title"><?php echo get_the_title(); ?></h3>
            <a class="link" href="<?php echo get_field('big_image_link'); ?>">BROWSE NOW</a>

            <div class="grid">
                <!-- large image -->
                <a href="<?php echo get_field('big_image_link'); ?>" class="large-image">
                    <picture>
                        <source media="(min-width:1366px)" srcset="<?php echo $largeImage['url']; ?>">
                        <source media="(min-width:600px)" srcset="<?php echo $largeImage['sizes']['large']; ?>">
                        <img loading="lazy" src="<?php echo $largeImage['sizes']['woocommerce_thumbnail']; ?>" alt="<?php echo get_the_title(); ?>">
                    </picture>
                </a>
                <div class="cards-container">
                    <?php
                    if (have_rows('four_images_column')) {
                        while (have_rows('four_images_column')) {
                            the_row();
                    ?>
                            <a href="<?php echo get_sub_field('link'); ?>" class="small-image-box">
                                <img src="<?php echo get_sub_field('image')['sizes']['woocommerce_thumbnail']; ?>" />
                                <div class="content">
                                    <h4 class="title">
                                        <?php echo get_sub_field('product_title'); ?>
                                    </h4>
                                    <h5 class="excerpt">
                                        <?php echo get_sub_field('product_excerpt'); ?>
                                    </h5>
                                </div>
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        wp_reset_postdata();
        ?>
    </div>
</section>
<!-- sixth section - fabric -->
<section class="fabric-section sixth-section">
    <div class="container row-container">
        <?php
        $argsWallpaper = array(
            'posts_per_page' => 1,
            'tag' => 'home-page-fabric-section'
        );
        $wallpaper = new WP_Query($argsWallpaper);
        while ($wallpaper->have_posts()) {
            $wallpaper->the_post();
            $largeImage = get_field('large_image');
        ?>
            <a class="primary-button" href="<?php echo get_field('subtitle_link'); ?>"><?php echo get_field('subtitle'); ?></a>
            <h3 class="title"><?php echo get_the_title(); ?></h3>
            <a class="link" href="<?php echo get_field('big_image_link'); ?>">BROWSE NOW</a>

            <div class="grid">
                <!-- large image -->
                <a href="<?php echo get_field('big_image_link'); ?>" class="large-image">
                    <picture>
                        <source media="(min-width:1366px)" srcset="<?php echo $largeImage['url']; ?>">
                        <source media="(min-width:600px)" srcset="<?php echo $largeImage['sizes']['large']; ?>">
                        <img loading="lazy" src="<?php echo $largeImage['sizes']['woocommerce_thumbnail']; ?>" alt="<?php echo get_the_title(); ?>">
                    </picture>
                </a>
                <div class="cards-container">
                    <?php
                    if (have_rows('four_images_column')) {
                        while (have_rows('four_images_column')) {
                            the_row();
                    ?>
                            <a href="<?php echo get_sub_field('link'); ?>" class="small-image-box">
                                <img src="<?php echo get_sub_field('image')['sizes']['woocommerce_thumbnail']; ?>" />
                                <div class="content">
                                    <h4 class="title">
                                        <?php echo get_sub_field('product_title'); ?>
                                    </h4>
                                    <h5 class="excerpt">
                                        <?php echo get_sub_field('product_excerpt'); ?>
                                    </h5>
                                </div>
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        wp_reset_postdata();
        ?>
    </div>
</section>
<!-- seventh section - kitchen  -->
<section class="sixth-section kitchen-section">
    <div class="image-container">
        <?php
        $argsSecondSectionImage = array(
            'post_type' => 'banners',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'banners_categories',
                    'field'    => 'slug',
                    'terms'    => array('sixth-section'),
                )
            )
        );
        $secondSectionImage = new WP_Query($argsSecondSectionImage);

        while ($secondSectionImage->have_posts()) {
            $secondSectionImage->the_post();
            // get desktop and mobile image 
            $image = get_field('banner_image');
            $mobileImage = get_field('banner_mobile_image');
        ?>
            <a class="link" href="<?php echo get_field('banner_link'); ?>">
                <picture>
                    <source media="(min-width:1366px)" srcset="<?php echo $image['sizes']['2048x2048']; ?>">
                    <source media="(min-width:600px)" srcset="<?php echo $image['sizes']['large']; ?>">
                    <img loading="lazy" src="<?php echo $mobileImage['sizes']['woocommerce_thumbnail']; ?>" alt="<?php echo get_the_title(); ?>" width="100%">
                </picture>
            </a>
            <h3 class="title row-container"><?php echo get_field('title'); ?></h3>

            <a class="primary-button" href="<?php echo get_field('banner_link'); ?>">
                <?php echo get_field('link_text'); ?>
            </a>
        <?php
        }
        wp_reset_postdata();

        ?>
    </div>
</section>
<!-- services section  -->
<section class="seventh-section services-section">
    <div class="container row-container">
        <?php

        $argsServices = array(
            'post_type' => 'loving',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => array('our-services'),
                )
            ),
            'orderby' => 'date',
            'order' => 'ASC'
        );
        $services = new WP_Query($argsServices);

        while ($services->have_posts()) {
            $services->the_post();
            $words = str_word_count(get_the_content(), 2);
            $pos   = array_keys($words);
            $excerpt  = substr(get_the_content(), 0, $pos[22]) . '...';
        ?>
            <div class="card">
                <div>
                    <img class="service-image" src="<?php echo get_the_post_thumbnail_url(null, "full"); ?>" alt="<?php echo get_the_title(); ?>">
                    <div class="icon">
                        <img src="<?php echo get_field('icon')['url']; ?>" alt="<?php echo get_the_title(); ?>" />
                    </div>
                    <div class="content">
                        <h5 class="title"><?php echo get_the_title(); ?></h5>
                        <p class="excerpt"><?php echo $excerpt; ?></p>
                        <a href="<?php echo get_field('add_link'); ?>" class="link"><?php echo get_field('add_subtitle_'); ?></a>
                    </div>

                </div>
            </div>
        <?php
        }
        wp_reset_postdata();
        ?>
    </div>
</section>

<!-- eighth section - be inspired  -->
<section class="be-inspired-section row-container">
    <div class="container">
        <?php

        $argsTrade = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_tag',
                    'field'    => 'slug',
                    'terms'    => array('be-inspired-section-home-page'),
                )
            )
        );
        $trade = new WP_Query($argsTrade);

        while ($trade->have_posts()) {
            $trade->the_post();
        ?>
        <h2 class="title"><?php echo get_the_title();?></h2>
            <div class="cards owl-carousel">

                <?php
                if (have_rows('images')) {
                    while (have_rows('images')) {
                        the_row();
                ?>
                        <a class="anchor-container" href="<?php echo get_sub_field('link'); ?>">
                            <img src="<?php echo get_sub_field('image')['sizes']['woocommerce_thumbnail']; ?>" alt="<?php echo get_sub_field('title'); ?>" />
                            <span><?php echo get_sub_field('title'); ?></span>
                        </a>

                <?php
                    }
                }
                ?>

            </div>
        <?php
        }
        wp_reset_postdata();
        ?>

    </div>
</section>

<!-- ninth section - Trade Professional -->
<section class="trade-section">
    <div class="container">
        <?php

        $argsTrade = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_tag',
                    'field'    => 'slug',
                    'terms'    => array('trade-professional-section-home-page'),
                )
            )
        );
        $trade = new WP_Query($argsTrade);

        while ($trade->have_posts()) {
            $trade->the_post();
        ?>
            <div class="first-section">
                <h2 class="title"><?php echo get_the_title(); ?></h2>
                <div class="subtitle"><?php echo get_the_content(); ?></div>
                <div class="buttons">
                    <a href="https://inspiry.co.nz/home/join-trade" class="primary-button">Join Directory</a>
                    <a href="https://inspiry.co.nz/home/professionals" class="secondary-button">View Professionals</a>
                </div>
            </div>
            <div class="middle-section">
                <div class="header">
                    <div class="image-container">
                        <img src="<?php echo get_field('trade_logo')['url']; ?> " alt="<?php echo get_field('trade_title');  ?>" />
                    </div>
                    <div class="title-container">
                        <div class="title">
                            <?php echo get_field('trade_title');  ?>
                        </div>
                        <div class="category">
                            <?php echo get_field('trade_category');  ?>
                        </div>
                    </div>
                </div>
                <div class="name"><?php echo get_field('trade_title'); ?></div>
                <div class="content"><?php echo get_field('trade_content'); ?></div>
                <div class="footer">
                    <div class="social-container">
                        <?php
                        if (have_rows('trade_social')) {
                            while (have_rows('trade_social')) {
                                the_row();
                                if (get_sub_field('social_media_name') === 'Facebook') {
                        ?>
                                    <a href="<?php echo get_sub_field('social_media_link'); ?>">
                                        <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20">
  <path id="Path_31" data-name="Path 31" d="M20.9,2H3.1A1.1,1.1,0,0,0,2,3.1V20.9A1.1,1.1,0,0,0,3.1,22h9.58V14.25h-2.6v-3h2.6V9a3.64,3.64,0,0,1,3.88-4,20.26,20.26,0,0,1,2.33.12v2.7H17.3c-1.26,0-1.5.6-1.5,1.47v1.93h3l-.39,3H15.8V22h5.1A1.1,1.1,0,0,0,22,20.9V3.1A1.1,1.1,0,0,0,20.9,2Z" transform="translate(-2 -2)" fill="#8e99a8"/>
</svg>

                                        </i>
                                    </a>
                                <?php
                                } else if (get_sub_field('social_media_name') === 'Instagram') {
                                ?>
                                    <a href="<?php echo get_sub_field('social_media_link'); ?>">
                                        <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20">
  <path id="Path_32" data-name="Path 32" d="M12,9.52A2.48,2.48,0,1,0,14.48,12,2.48,2.48,0,0,0,12,9.52Zm9.93-2.45a6.53,6.53,0,0,0-.42-2.26,4,4,0,0,0-2.32-2.32,6.53,6.53,0,0,0-2.26-.42C15.64,2,15.26,2,12,2s-3.64,0-4.93.07a6.53,6.53,0,0,0-2.26.42A4,4,0,0,0,2.49,4.81a6.53,6.53,0,0,0-.42,2.26C2,8.36,2,8.74,2,12s0,3.64.07,4.93a6.86,6.86,0,0,0,.42,2.27,3.94,3.94,0,0,0,.91,1.4,3.89,3.89,0,0,0,1.41.91,6.53,6.53,0,0,0,2.26.42C8.36,22,8.74,22,12,22s3.64,0,4.93-.07a6.53,6.53,0,0,0,2.26-.42,3.89,3.89,0,0,0,1.41-.91,3.94,3.94,0,0,0,.91-1.4,6.6,6.6,0,0,0,.42-2.27C22,15.64,22,15.26,22,12s0-3.64-.07-4.93Zm-2.54,8a5.73,5.73,0,0,1-.39,1.8A3.86,3.86,0,0,1,16.87,19a5.73,5.73,0,0,1-1.81.35H8.94A5.73,5.73,0,0,1,7.13,19,3.722,3.722,0,0,1,5,16.87a5.49,5.49,0,0,1-.34-1.81c0-.79,0-1,0-3.06V8.94A5.49,5.49,0,0,1,5,7.13a3.51,3.51,0,0,1,.86-1.31A3.59,3.59,0,0,1,7.13,5a5.73,5.73,0,0,1,1.81-.35h6.12A5.73,5.73,0,0,1,16.87,5,3.722,3.722,0,0,1,19,7.13a5.73,5.73,0,0,1,.35,1.81c0,.79,0,1,0,3.06s.07,2.27.04,3.06Zm-1.6-7.44a2.38,2.38,0,0,0-1.41-1.41A4,4,0,0,0,15,6H9a4,4,0,0,0-1.38.26A2.38,2.38,0,0,0,6.21,7.62,4.27,4.27,0,0,0,6,9v6a4.27,4.27,0,0,0,.26,1.38,2.38,2.38,0,0,0,1.41,1.41A4.27,4.27,0,0,0,9,18.05h6a4,4,0,0,0,1.38-.26,2.38,2.38,0,0,0,1.41-1.41A4,4,0,0,0,18.05,15V9a3.78,3.78,0,0,0-.26-1.38ZM12,15.82A3.81,3.81,0,0,1,8.19,12h0A3.82,3.82,0,1,1,12,15.82Zm4-6.89a.9.9,0,0,1,0-1.79h0a.9.9,0,0,1,0,1.79Z" transform="translate(-2 -2)" fill="#8e99a8"/>
</svg>

                                        </i>
                                    </a>
                                <?php
                                } else if (get_sub_field('social_media_name') === 'Twitter') {
                                ?>
                                    <a href="<?php echo get_sub_field('social_media_link'); ?>">
                                        <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 19.953 19.953">
  <g id="Group_22" data-name="Group 22" transform="translate(-6 -6)">
    <path id="Path_64" data-name="Path 64" d="M25.953,23.182a2.771,2.771,0,0,1-2.771,2.771H8.771A2.771,2.771,0,0,1,6,23.182V8.771A2.771,2.771,0,0,1,8.771,6H23.182a2.771,2.771,0,0,1,2.771,2.771Z" transform="translate(0 0)" fill="#8e99a8"/>
    <path id="Path_65" data-name="Path 65" d="M25.3,16.175a6.222,6.222,0,0,1-1.663.488A4.055,4.055,0,0,0,25.3,15a7.934,7.934,0,0,1-2.1.76,2.678,2.678,0,0,0-4.549,2.011V18.88c-2.217,0-4.379-1.689-5.724-3.326a2.668,2.668,0,0,0-.37,1.362,3.539,3.539,0,0,0,1.659,2.518,5.144,5.144,0,0,1-1.663-.554v.032a2.485,2.485,0,0,0,2.168,2.451,3.471,3.471,0,0,1-1.574.289c.347,1.072,2.091,1.639,3.286,1.663a7,7,0,0,1-3.88,1.109A4.084,4.084,0,0,1,12,24.41a8.619,8.619,0,0,0,4.434,1.121,7.446,7.446,0,0,0,7.76-7.41c0-.118,0-.511-.01-.626A4.211,4.211,0,0,0,25.3,16.175" transform="translate(-2.674 -4.012)" fill="#474747"/>
  </g>
</svg>


                                        </i>
                                    </a>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="buttons">
                        <a href="<?php echo get_field('project_link'); ?>" class="secondary-button">View Projects</a>
                        <a href="<?php echo get_field('trade_profile_link'); ?>" class="secondary-button">Contact</a>
                    </div>

                </div>
            </div>
            <div class="last-section">
                <?php
                if (have_rows('side_images')) {
                    while (have_rows('side_images')) {
                        the_row();
                ?>
                        <img src="<?php echo get_sub_field('image')['sizes']['woocommerce_thumbnail']; ?>" alt="<?php echo get_the_title(); ?>">
                <?php
                    }
                }
                ?>
            </div>
        <?php

        }
        wp_reset_postdata();
        ?>
    </div>
</section>
<?php

get_footer();
?>