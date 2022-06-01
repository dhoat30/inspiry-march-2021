<?php 
get_header(); 
  ?>
      <section class="service-page">
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
        <picture>
            <source media="(min-width:1366px)" srcset="<?php echo $image['sizes']['2048x2048']; ?>">
            <source media="(min-width:600px)" srcset="<?php echo $image['sizes']['large']; ?>">
            <img loading="lazy" src="<?php echo $mobileImage['sizes']['woocommerce_thumbnail']; ?>" alt="<?php echo get_the_title(); ?>" width="100%">
        </picture>
 
   
<?php
}
wp_reset_postdata();

?>  
        <div class="hero-section"  style='background: url("<?php echo get_site_url(); ?>/wp-content/uploads/2020/11/HELP.jpg") no-repeat center top/cover;'>
            <div class="hero-overlay"></div>
        </div>    
        <div class="content">
            
            <div class="section-font-size white center-align">Free half an hour consultation </div>
         
            <a class="rm-txt-dec button btn-dk-green" href="<?php echo get_site_url();?>/consultation">Book Now</a>
        </div>
    </section>
    <section class="service-page">
        <div class="hero-section"  style='background: url("<?php echo get_site_url(); ?>/wp-content/uploads/2020/11/AdobeStock_171006496.jpg") no-repeat center top/cover;'>
            <div class="hero-overlay"></div>
        </div>    
        <div class="stamp hero-content">
            <i >
            <svg xmlns="http://www.w3.org/2000/svg" width="53.371" height="50.461" viewBox="0 0 53.371 50.461">
  <g id="Expanded" transform="translate(0 -2.616)">
    <path id="Path_57" data-name="Path 57" d="M46.027,50.461H30.461V36.007H21.566V50.461H6V27.112a1.112,1.112,0,1,1,2.224,0V48.237H19.342V33.783H32.685V48.237H43.8V28.224a1.112,1.112,0,0,1,2.224,0Z" transform="translate(0.671 2.616)"/>
    <path id="Path_58" data-name="Path 58" d="M52.258,29.728a1.109,1.109,0,0,1-.768-.308L26.685,5.694,1.88,29.42A1.112,1.112,0,0,1,.343,27.813l26.342-25.2,26.341,25.2a1.112,1.112,0,0,1-.768,1.916Z" transform="translate(0 0)"/>
    <path id="Path_59" data-name="Path 59" d="M39.895,16.007a1.112,1.112,0,0,1-1.112-1.112V8.224H32.112a1.112,1.112,0,0,1,0-2.224h8.895v8.895A1.112,1.112,0,0,1,39.895,16.007Z" transform="translate(3.468 0.379)"/>
  </g>
</svg>


            </i>
            <div class="section-font-size">INSPIRY</div>
            <div class="medium-font-size">Interior Design Services</div>
            <a class="rm-txt-dec button btn-dk-green" href="<?php echo get_site_url();?>/consultation">MAKE AN APPOINTMENT</a>
        </div>
    </section>

    <div class="services-section row-section margin-row">
        <div class="heading-line-through">
            <div class="underline-dg"></div>

            <div class="large-font-size center-align">Our Services</div>
        </div>
        
        <div class="flex">

        <?php 

            $argsLoving = array(
                'post_type' => 'loving',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field'    => 'slug',
                        'terms'    => array( 'our-services'),
                    )
                    ), 
                    'orderby' => 'date', 
                    'order' => 'ASC'
            );
            $loving = new WP_Query( $argsLoving );

            while($loving->have_posts()){ 
                $loving->the_post(); 

                ?>      
                        <div class="cards">
                            <div>
                                <img src="<?php echo get_the_post_thumbnail_url(null,"full"); ?>" alt="Khroma">                      
                                <div class="column-font-size"><?php the_title(); ?></div>
                                <div class="paragraph center-align"><?php the_content();?></div>
                            </div>
                        </div>
                   
                <?php 

            }
            wp_reset_postdata();
            ?>
            

          
                                
        </div>                                
    </div>



    <section class="testimonials">
        <div class="flex">
            <div>
                <div class="hero-section"  style='background: url("<?php echo get_site_url(); ?>/wp-content/uploads/2020/11/IMG_8586_large.jpg") no-repeat center top/cover;'>
                    <div class="hero-overlay"></div>
                </div>

                <div class="content">
                    <div class="white center-align large-font-size">Testimonials</div>
                </div>
            </div>
            <div class="quote">
                <i >
                <svg xmlns="http://www.w3.org/2000/svg" width="45.697" height="43.962" viewBox="0 0 45.697 43.962">
  <g id="Octicons" transform="translate(0 -1.66)">
    <g id="quote" transform="translate(0 1.66)">
      <path id="Shape" d="M21.374,8.044c-8.432,5.413-12.526,11-12.526,20.333a4.8,4.8,0,0,1,1.527-.173c4.407,0,8.674,2.984,8.674,8.362,0,5.586-3.574,9.056-8.674,9.056C3.782,45.622,0,40.348,0,30.876,0,17.69,6.072,8.218,17.418,1.66Zm24.289,0c-8.432,5.413-12.526,11-12.526,20.333a4.8,4.8,0,0,1,1.527-.173c4.407,0,8.674,2.984,8.674,8.362,0,5.586-3.574,9.056-8.674,9.056-6.558,0-10.34-5.274-10.34-14.747C24.323,17.69,30.4,8.218,41.742,1.66L45.7,8.044Z" transform="translate(0 -1.66)" fill-rule="evenodd"/>
    </g>
  </g>
</svg>

                </i>
                <div class='background beige-color-bc'>
                    <div class="column-font-size regular">Corrine has a great sense of style, taste & knew what I wanted. She helped me so much and inspired me with lights, drapes, furniture and painting. She took all the pressure away and I love everything.</div>
                    <span class="poppins-font medium medium-font-size">Mary Jaques</span>
                    <div class="poppins-font medium-font-size regular">Bay Of Plenty</div>
                </div>
                
            </div>

            
        </div>
    </section>
  

<?php
get_footer();
?>