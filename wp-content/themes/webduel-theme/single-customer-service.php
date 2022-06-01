<?php 
get_header(); 
?>
<div class="customer-service-page">
    <div class="container">
        <div class="sidebar-mobile-menu">
            <button class="secondary-button">
                <span>Customer Service Menu</span>
                <i>
                <svg xmlns="http://www.w3.org/2000/svg" width="18.475" height="10.653" viewBox="0 0 18.475 10.653">
                    <g id="Group_11" data-name="Group 11" transform="translate(37.075 -24.1) rotate(90)">
                        <g id="Icon-Chevron-Left" transform="translate(24.1 18.6)">
                        <path id="Fill-35" d="M-211.551-297.925l-1.349-1.349,7.956-7.889-7.956-7.889,1.349-1.349,9.3,9.237-9.3,9.237" transform="translate(212.9 316.4)" fill="#474747"/>
                        </g>
                    </g>
                </svg>          

                </i>
            </button>
        </div>
        <div class="sidebar">
            <h3 class="sidebar-title">Customer Service</h3>
                <?php
                wp_nav_menu(
                        array(
                            'theme_location' => 'customer-service-sidebar', 
                            'container_id' => 'customer-service-sidebar'
                        ));
                ?>   
        </div>
        <div class="main-container">
            <?php 
                while(have_posts()){
                    the_post(); 
                    ?>
                        <h1 class="title"><?php the_title();?></h1>
                        <div class="content"> 
                            <?php the_content();?>
                        </div>

                    <?php
                }
            ?>
        </div>
    </div>
</div>

<?php 
    get_footer();
?> 