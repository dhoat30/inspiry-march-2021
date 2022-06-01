<?php 
get_header(); 
  ?>
  <section class="consultation-page">

  
<?php 
    while(have_posts()){ 
        the_post(); 
        ?>

        <div class="flex">
            <div class="form">
                <div class="column-font-size"><?php the_title();?></div>
       <!-- Calendly inline widget begin -->
<div class="calendly-inline-widget" data-url="https://calendly.com/inspiry-services/30min?hide_event_type_details=1&hide_gdpr_banner=1&primary_color=000000" style="min-width:320px;height:630px;"></div>
<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
<!-- Calendly inline widget end -->
            </div>

            <div class="right-bar">
                <div class="stamp hero-content">
                    <div>
                        <i >
                        <svg xmlns="http://www.w3.org/2000/svg" width="53.371" height="50.461" viewBox="0 0 53.371 50.461">
  <g id="Expanded" transform="translate(0 -2.616)">
    <path id="Path_57" data-name="Path 57" d="M46.027,50.461H30.461V36.007H21.566V50.461H6V27.112a1.112,1.112,0,1,1,2.224,0V48.237H19.342V33.783H32.685V48.237H43.8V28.224a1.112,1.112,0,0,1,2.224,0Z" transform="translate(0.671 2.616)"/>
    <path id="Path_58" data-name="Path 58" d="M52.258,29.728a1.109,1.109,0,0,1-.768-.308L26.685,5.694,1.88,29.42A1.112,1.112,0,0,1,.343,27.813l26.342-25.2,26.341,25.2a1.112,1.112,0,0,1-.768,1.916Z" transform="translate(0 0)"/>
    <path id="Path_59" data-name="Path 59" d="M39.895,16.007a1.112,1.112,0,0,1-1.112-1.112V8.224H32.112a1.112,1.112,0,0,1,0-2.224h8.895v8.895A1.112,1.112,0,0,1,39.895,16.007Z" transform="translate(3.468 0.379)"/>
  </g>
</svg>

                        </i>
                        <div class="section-font-size center-align">INSPIRY</div>
                        <div class="medium-font-size center-align">Interior Design Services</div>
                    </div>



                    <div class="services">

                    
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
                                <div class="column-font-size center-align"><?php the_title(); ?></div>
                                <div class="underline underline-dg"></div>
                                <div class="paragraph center-align"><?php the_content();?></div>
                            </div>
                        </div>
                        <?php 
                         }
                        ?>
                    </div>
                    
                </div>
            </div>
        </div>

        <?php
    }
?>
</section>

<?php
get_footer();
?>