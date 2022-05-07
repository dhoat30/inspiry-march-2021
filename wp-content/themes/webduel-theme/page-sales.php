<?php 
get_header(); 
  ?> 
  <section class="inspiry-specials">
      <!-- hero section -->
      <!-- style='background: url("<?php echo get_the_post_thumbnail_url(null,"full"); ?>")' -->
    <div class="hero-section" >
        <picture class="sales-banner">
                <source media="(min-width:1366px)" srcset="<?php echo get_the_post_thumbnail_url(null,"woocommerce-single");?>">
                <source media="(min-width:600px)" srcset="<?php echo get_the_post_thumbnail_url(null,"woocommerce-single");?>">
                <img class="sales-banner" src="<?php echo get_the_post_thumbnail_url(null,"woocommerce_thumbnail");?>" alt="Foyer Mirror Distressed Cream" width="100%">
        </picture>
    </div>

    <!-- sale cards -->
        <?php
        $rows = get_field('special_cards', get_the_id());
        if( $rows ) {
           ?> 
           <ul class="special-cards row-container">
            <?php 
                // for each loop for repeater content 
                foreach( $rows as $row ) {
                    $image = $row['image'];
                    $link = $row['link'];          
                ?>
                <li class="card">
                    <a  href="<?php echo $link;?>" target="_blank">
                                        <img loading="lazy" src="<?php echo esc_url($image['url']);?>"
                                        alt="<?php echo get_the_title();?>" width="100%">
                                        
                    </a>
                </li>
                   
                <?php 
                }
            ?>
           </ul>
           <?php 
        }
        ?>

    </section>
<?php
get_footer();
?>