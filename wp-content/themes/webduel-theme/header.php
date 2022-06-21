<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PS7XFHN');
    </script>
    <!-- End Google Tag Manager -->

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>


    <!-- splide -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css"> -->
    <!-- font awesome  -->
    <!-- <script src="https://kit.fontawesome.com/71827cc3f2.js" crossorigin="anonymous"></script> -->
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <!-- bing tag -->
    <meta name="msvalidate.01" content="8BB2BD3056EE954D25649333FBFC2D75" />

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '828264374302518');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=828264374302518&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

    <?php
    // get user email address 
    $pinterestUserEmail;
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $pinterestUserEmail = $current_user->user_email;
        $hashedPinterestEmail = wp_hash($pinterestUserEmail);
    }
    ?>
    <!-- pinterest Tag -->
    <!-- Pinterest Tag -->
    <script>
        ! function(e) {
            if (!window.pintrk) {
                window.pintrk = function() {
                    window.pintrk.queue.push(Array.prototype.slice.call(arguments))
                };
                var
                    n = window.pintrk;
                n.queue = [], n.version = "3.0";
                var
                    t = document.createElement("script");
                t.async = !0, t.src = e;
                var
                    r = document.getElementsByTagName("script")[0];
                r.parentNode.insertBefore(t, r)
            }
        }("https://s.pinimg.com/ct/core.js");
        pintrk('load', '2612506427665', {
            em: '<?php echo $pinterestUserEmail; ?>'
        });
        pintrk('page');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none;" alt="" src='https://ct.pinterest.com/v3/?event=init&tid=2612506427665&pd[em]=<<?php echo $hashedPinterestEmail ?>>&noscript=1' />
    </noscript>
    <!-- end Pinterest Tag -->


</head>

<body id="header" <?php body_class(); ?>>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PS7XFHN" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
  
    <section class="header desktop-header">
        <div class="top-banner">
            <div class="banner-container">
                <div class="banner-card owl-carousel">
                    <?php

                    $argsBanner = array(
                        'post_type' => 'banners',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'banners_categories',
                                'field'    => 'slug',
                                'terms'    => array('top-banner'),
                            )
                        )
                    );
                    $banner = new WP_Query($argsBanner);

                    while ($banner->have_posts()) {
                        $banner->the_post();
                        if (get_field('banner_link')) {
                    ?>
                            <a href="<?php echo get_field('banner_link'); ?>" class="anchor"> <?php echo get_the_title(); ?> LEARN
                                <svg xmlns="http://www.w3.org/2000/svg" width="5" height="8.67" viewBox="0 0 9.501 16.477">
                                    <g id="Group_11" data-name="Group 11" transform="translate(-24.1 -18.6)">
                                        <g id="Icon-Chevron-Left" transform="translate(24.1 18.6)">
                                            <path id="Fill-35" d="M-211.7-299.923l-1.2-1.2,7.1-7.036-7.1-7.036,1.2-1.2,8.3,8.239-8.3,8.239" transform="translate(212.9 316.4)" fill="#ffffff" />
                                        </g>
                                    </g>
                                </svg>


                            </a>

                        <?php
                        } else {
                        ?>
                            <a href="<?php echo get_field('banner_link'); ?>" class="anchor"> <?php echo get_the_title(); ?></a>
                    <?php
                        }
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
        <div class="middle-section row-container">
            <div class="search-container">
                <div class="search-code">
                    <div class="search-bar">
                        <input autocomplete="off" type="text" class="search-input" placeholder="Search for rugs, furniture, and more" id="search-term" />
                        <?php 
                         do_action('webduel_loading_icon'); 
                        ?>
                        <svg class="desktop-search search" width="15.605" height="15.605" viewBox="0 0 15.605 15.605">
                            <g id="Group_12" data-name="Group 12" transform="translate(-2.354 -2.354)">
                                <circle id="Ellipse_5" data-name="Ellipse 5" cx="5.689" cy="5.689" r="5.689" transform="translate(2.854 2.854)" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="1" />
                                <path id="Path_26" data-name="Path 26" d="M18.451,18.451l4.757,4.757" transform="translate(-5.956 -5.956)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1" />
                            </g>
                        </svg>

                    </div>
                    <div class="result-div"></div>
                </div>
            </div>
            <div class="logo-container">
                <?php
                $argsLogo = array(
                    'post_type' => 'page',
                    'pagename' => 'contact',
                    'posts_per_page' => 1
                );
                $queryLogo = new WP_Query($argsLogo);
                while ($queryLogo->have_posts()) {
                    $queryLogo->the_post();
                    $image = get_field('logo')['url'];
                ?>
                    <a href="/">
                        <img src="<?php echo $image ?>" alt="Inspiry Logo" />
                    </a>
                <?php
                }
                wp_reset_postdata();
                ?>
            </div>
            <div class="useful-links-container">
                <div class="phone-container container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path fill="#474747" id="Icon_awesome-phone-alt" data-name="Icon awesome-phone-alt" d="M19.43,14.133l-4.375-1.875a.938.938,0,0,0-1.094.27l-1.938,2.367A14.479,14.479,0,0,1,5.1,7.973L7.469,6.036a.935.935,0,0,0,.27-1.094L5.863.567A.944.944,0,0,0,4.789.024L.727.962A.938.938,0,0,0,0,1.875,18.123,18.123,0,0,0,18.125,20a.938.938,0,0,0,.914-.727l.938-4.063A.949.949,0,0,0,19.43,14.133Z" transform="translate(0 0)"/>
                    </svg>
                    <span>Call</span>
                    <?php do_action('webduel_phone_modal'); ?>
                </div>
                <div class="sign-in-container container">
                    <svg width="25" height="20" viewBox="0 0 45.629 45.629">
                        <path id="Path_16" data-name="Path 16" d="M86.815,86.815A11.407,11.407,0,1,0,75.407,75.407,11.441,11.441,0,0,0,86.815,86.815Zm0,5.7C79.258,92.518,64,96.369,64,103.926v5.7h45.629v-5.7C109.629,96.369,94.372,92.518,86.815,92.518Z" transform="translate(-64 -64)" fill="#474747" />
                    </svg>
                    <!-- get logged in user -->
                    <?php
                    if (is_user_logged_in()) {
                        global $current_user;
                    ?>
                        <span>Hi, <?php echo  $current_user->first_name; ?></span>
                    <?php
                    } else {
                    ?>
                        <span>Orders & Sign In</span>
                    <?php

                    } ?>
                    

                    <?php
                    // sign in modal 
                    echo do_shortcode('[sign-in-modal]');
                    ?>
                </div>
                <div class="design-board-icon-container container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 22 18.258">
                        <path id="Path_17" data-name="Path 17" d="M2.2,10.124a7.75,7.75,0,0,0,2.268,5.784c1.814,1.814,7.825,5.9,8.052,6.124a1.612,1.612,0,0,0,.68.227,1.612,1.612,0,0,0,.68-.227c.227-.227,6.237-4.2,8.052-6.124A7.75,7.75,0,0,0,24.2,10.124,6.1,6.1,0,0,0,18.076,4a6.037,6.037,0,0,0-4.763,2.608A6.108,6.108,0,0,0,2.2,10.124Z" transform="translate(-2.2 -4)" fill="#474747" />
                    </svg>


                    <?php
                    // sign in modal 
                    echo do_shortcode('[design-board-header-modal]');
                    ?>
                </div>

                <div class="cart-container container shopping-cart ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path id="Path_18" data-name="Path 18" d="M19.3,16.414l2.683-8.579a.475.475,0,0,0-.058-.4.4.4,0,0,0-.337-.183H6.475L5.937,4.917a1.641,1.641,0,0,0-1.55-1.262H2.417a.449.449,0,0,0,0,.9H4.387a.781.781,0,0,1,.742.6l3.329,14.4a2.09,2.09,0,0,0-1.383,2.009,2.033,2.033,0,0,0,1.954,2.1,2.033,2.033,0,0,0,1.95-2.1,2.209,2.209,0,0,0-.35-1.2h6.617a2.177,2.177,0,0,0-.354,1.2,1.957,1.957,0,1,0,1.95-2.1.222.222,0,0,0-.054,0,.05.05,0,0,0-.025,0H9.3l-.633-2.734H18.9A.424.424,0,0,0,19.3,16.414Z" transform="translate(-2 -3.655)" fill="#474747" />
                    </svg>

                    <span class="cart-item-count cart-items-header">(<?php echo WC()->cart->get_cart_contents_count(); ?>)</span>
                </div>
            </div>
        </div>

        <!-- top navbar -->
        <section class="top-navbar-section row-container">
            <nav class="navbar">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'top-navbar',
                        'container_id' => 'top-navbar'
                    )
                );
                ?>
            </nav>
        </section>

        <!--  main menu-->
        <section class="main-navbar-section">
            <nav class="navbar row-container">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'inspiry_main_menu',
                        'container_id' => 'cssmenu'
                    )
                );
                ?>
            </nav>
        </section>
    </section>

    <!-- mobile header  -->
    <section class="mobile-header header">
        <div class="top-banner">
            <div class="banner-container">
                <div class="banner-card owl-carousel">
                    <?php
                    $argsBanner = array(
                        'post_type' => 'banners',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'banners_categories',
                                'field'    => 'slug',
                                'terms'    => array('top-banner'),
                            )
                        )
                    );
                    $banner = new WP_Query($argsBanner);

                    while ($banner->have_posts()) {
                        $banner->the_post();
                        if (get_field('banner_link')) {
                    ?>
                            <a href="<?php echo get_field('banner_link'); ?>" class="anchor"> <?php echo get_the_title(); ?> LEARN
                                <svg xmlns="http://www.w3.org/2000/svg" width="5" height="8.67" viewBox="0 0 9.501 16.477">
                                    <g id="Group_11" data-name="Group 11" transform="translate(-24.1 -18.6)">
                                        <g id="Icon-Chevron-Left" transform="translate(24.1 18.6)">
                                            <path id="Fill-35" d="M-211.7-299.923l-1.2-1.2,7.1-7.036-7.1-7.036,1.2-1.2,8.3,8.239-8.3,8.239" transform="translate(212.9 316.4)" fill="#ffffff" />
                                        </g>
                                    </g>
                                </svg>
                            </a>

                        <?php
                        } else {
                        ?>
                            <a href="<?php echo get_field('banner_link'); ?>" class="anchor"> <?php echo get_the_title(); ?></a>
                    <?php
                        }
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>



        <!--  main menu-->
        <div class="fixed-nav-container" id="fixed-nav-container">
            <div class="mobile-nav-overlay"></div>
            <section class="main-navbar-section row-container">

                <nav class="navbar ">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'inspiry_main_menu_mobile',
                            'container_id' => 'cssmenu'
                        )
                    );
                    ?>
                </nav>
                <div class="logo-container">
                    <?php
                    $argsLogo = array(
                        'post_type' => 'page',
                        'pagename' => 'contact',
                        'posts_per_page' => 1
                    );
                    $queryLogo = new WP_Query($argsLogo);
                    while ($queryLogo->have_posts()) {
                        $queryLogo->the_post();
                        $image = get_field('logo')['url'];
                    ?>
                        <a href="/">
                            <img src="<?php echo $image ?>" alt="Inspiry Logo" />
                        </a>
                    <?php
                    }
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="useful-links-container">
                    <div class="cart-container container shopping-cart ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path id="Path_18" data-name="Path 18" d="M19.3,16.414l2.683-8.579a.475.475,0,0,0-.058-.4.4.4,0,0,0-.337-.183H6.475L5.937,4.917a1.641,1.641,0,0,0-1.55-1.262H2.417a.449.449,0,0,0,0,.9H4.387a.781.781,0,0,1,.742.6l3.329,14.4a2.09,2.09,0,0,0-1.383,2.009,2.033,2.033,0,0,0,1.954,2.1,2.033,2.033,0,0,0,1.95-2.1,2.209,2.209,0,0,0-.35-1.2h6.617a2.177,2.177,0,0,0-.354,1.2,1.957,1.957,0,1,0,1.95-2.1.222.222,0,0,0-.054,0,.05.05,0,0,0-.025,0H9.3l-.633-2.734H18.9A.424.424,0,0,0,19.3,16.414Z" transform="translate(-2 -3.655)" fill="#474747" />
                    </svg>

                        <span class="cart-item-count cart-items-header">(<?php echo WC()->cart->get_cart_contents_count(); ?>)</span>
                    </div>
                    <div class="sign-in-container container">
                    <svg width="20" height="20" viewBox="0 0 45.629 45.629">
                        <path id="Path_16" data-name="Path 16" d="M86.815,86.815A11.407,11.407,0,1,0,75.407,75.407,11.441,11.441,0,0,0,86.815,86.815Zm0,5.7C79.258,92.518,64,96.369,64,103.926v5.7h45.629v-5.7C109.629,96.369,94.372,92.518,86.815,92.518Z" transform="translate(-64 -64)" fill="#474747" />
                    </svg>
                        <?php
                        // sign in modal 
                        echo do_shortcode('[sign-in-modal]');
                        ?>
                    </div>

                </div>
            </section>
            <div class="search-container">
                <div class="search-code row-container">
                    <div class="search-bar">
                        <input autocomplete="off" type="text" class="search-input" placeholder="Search for rugs, furniture, and more" id="mobile-search-term" />
                        <svg class="mobile-search search" width="15.605" height="15.605" viewBox="0 0 15.605 15.605">
                            <g id="Group_12" data-name="Group 12" transform="translate(-2.354 -2.354)">
                                <circle id="Ellipse_5" data-name="Ellipse 5" cx="5.689" cy="5.689" r="5.689" transform="translate(2.854 2.854)" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="1" />
                                <path id="Path_26" data-name="Path 26" d="M18.451,18.451l4.757,4.757" transform="translate(-5.956 -5.956)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1" />
                            </g>
                        </svg>
                        <?php 
                         do_action('webduel_loading_icon'); 
                        ?>
                    </div>
                    <div class="result-div"></div>
                </div>
            </div>

        </div>
    </section>
    <!-- cart drop down -->
    <div class="cart-popup-container box-shadow">
        <div class="cart-box">
            <div class="title-section">
                <div class="title">My Cart</div>
                <svg class="close-cart" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path id="Path_28" data-name="Path 28" d="M13.4,12l6.3-6.3a.99.99,0,1,0-1.4-1.4L12,10.6,5.7,4.3A.99.99,0,0,0,4.3,5.7L10.6,12,4.3,18.3A.908.908,0,0,0,4,19a.945.945,0,0,0,1,1,.908.908,0,0,0,.7-.3L12,13.4l6.3,6.3a.967.967,0,0,0,1.4,0,.967.967,0,0,0,0-1.4Z" transform="translate(-4 -4)" fill="#474747" />
                </svg>

            </div>
            <div class="flex-card">
                <?php

                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $product = $cart_item['data'];
                    $product_id = $cart_item['product_id'];
                    $variationID = $cart_item['variation_id'];
                    $quantity = $cart_item['quantity'];
                    $price = WC()->cart->get_product_price($product);
                    $subtotal = WC()->cart->get_product_subtotal($product, $cart_item['quantity']);
                    $link = $product->get_permalink($cart_item);
                    // Anything related to $product, check $product tutorial
                    $meta = wc_get_formatted_cart_item_data($cart_item);
                    if ($variationID) {
                        $product_id = $variationID;
                    }
                ?>
                    <div class="product-card">
                        <?php

                        // condition to check if the product is simple
                        if ($product->name == "Free Sample") {
                            // pulling information of an original product in a form of an objec†
                            $originalProduct = wc_get_product($cart_item["free_sample"]);

                            if (!empty($originalProduct)) {
                                $permalink = get_the_permalink($originalProduct->get_id());
                                $imageID = $originalProduct->image_id;
                                $name = $originalProduct->get_name();
                            }
                        ?>
                            <a href="<?php echo $permalink; ?>" class="mini_cart_item <?php echo $cart_item_key; ?>">
                                <div class="img-container">
                                    <img src="<?php echo wp_get_attachment_image_url($imageID, 'woocommerce_gallery_thumbnail'); ?>" alt="<?php echo $name; ?>" />
                                </div>

                                <div class="title-container">
                                    <h5 class="title"> <?php echo $quantity; ?> X Free Sample (<?php echo $name; ?> )</h5>
                                </div>

                                <div class="price-container">
                                    <h6 class="cart-price">$<?php echo number_format($product->price * $quantity) ?></h6>
                                </div>

                            </a>
                            <div class="remove-column remove-product">

                            <svg data-product_id="<?php echo $product_id ?>" data-cart_item_key="<?php echo $cart_item_key; ?>" width="13.28" height="15.94" viewBox="0 0 18.469 22.17">
                                    <g id="Group_13" data-name="Group 13" transform="translate(-96.038 -64)">
                                        <path id="Path_29" data-name="Path 29" d="M114.373,68.006c-.139-.519-.231-.808-.231-.808-.15-.537-.531-.537-1.1-.629l-3.065-.387c-.381-.063-.381-.063-.531-.392-.5-1.131-.658-1.789-1.206-1.789H102.3c-.548,0-.7.658-1.2,1.8-.15.323-.15.323-.531.393l-3.071.387c-.56.092-.964.144-1.114.681,0,0-.069.237-.214.75-.185.687-.26.612.375.612H114C114.633,68.623,114.564,68.693,114.373,68.006Z" fill="#474747" />
                                        <path id="Path_30" data-name="Path 30" d="M131.123,176H116.878c-.958,0-1,.127-.947.848l1.079,14c.092.71.162.854,1.01.854h11.96c.848,0,.918-.144,1.01-.854l1.079-14C132.128,176.121,132.081,176,131.123,176Z" transform="translate(-18.73 -105.535)" fill="#474747" />
                                    </g>
                                </svg>
                            </div>
                        <?php
                        } else {
                        ?>
                            <a href="<?php echo $link ?>" class="mini_cart_item <?php echo $cart_item_key; ?>">
                                <div class="img-container">
                                    <img src="<?php echo get_the_post_thumbnail_url($product_id, 'woocommerce_gallery_thumbnail'); ?>" alt="<?php echo $product->name ?>" />
                                </div>
                                <div class="title-container">
                                    <h5 class="title"> <?php echo $quantity; ?> X <?php echo $product->name ?></h5>
                                </div>

                                <div class="price-container">
                                    <h6 class="cart-price">$<?php echo number_format($product->price * $quantity); ?></h6>
                                </div>
                            </a>
                            <div class="remove-column remove-product">
                                <svg data-product_id="<?php echo $product_id ?>" data-cart_item_key="<?php echo $cart_item_key; ?>" width="13.28" height="15.94" viewBox="0 0 18.469 22.17">
                                    <g id="Group_13" data-name="Group 13" transform="translate(-96.038 -64)">
                                        <path id="Path_29" data-name="Path 29" d="M114.373,68.006c-.139-.519-.231-.808-.231-.808-.15-.537-.531-.537-1.1-.629l-3.065-.387c-.381-.063-.381-.063-.531-.392-.5-1.131-.658-1.789-1.206-1.789H102.3c-.548,0-.7.658-1.2,1.8-.15.323-.15.323-.531.393l-3.071.387c-.56.092-.964.144-1.114.681,0,0-.069.237-.214.75-.185.687-.26.612.375.612H114C114.633,68.623,114.564,68.693,114.373,68.006Z" fill="#474747" />
                                        <path id="Path_30" data-name="Path 30" d="M131.123,176H116.878c-.958,0-1,.127-.947.848l1.079,14c.092.71.162.854,1.01.854h11.96c.848,0,.918-.144,1.01-.854l1.079-14C132.128,176.121,132.081,176,131.123,176Z" transform="translate(-18.73 -105.535)" fill="#474747" />
                                    </g>
                                </svg>

                            </div>
                        <?php
                        } ?>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="pop-up-footer">
                <!-- <div class="total-container"> -->
                <!-- <div class="total poppins-font">
                        Total: $<?php
                                //  $totalAmount = str_replace(".00", "", (string)number_format(WC()->cart->total, 2, ".", ""));
                                //echo number_format($totalAmount); 
                                ?>
                    </div> -->
                <!-- </div> -->
                <!-- <div class="cont-shopping">
                            <a class="secondary-button" href="#">Continue Shopping</a>
                        </div> -->
                <div class="checkout-btn">
                    <a class="primary-button" href="<?php echo get_site_url(); ?>/cart">Cart</a>
                </div>
            </div>
        </div>
    </div>
<?php 
do_action('inspiry-modals'); 
do_action('inspiry-modals-tags'); 
?>
