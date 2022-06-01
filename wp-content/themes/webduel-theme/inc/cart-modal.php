<?php 

add_action('cart_modal', 'modal_html'); 

function modal_html(){
    $argsModal = array(
        'post_type' => 'modal',
        'posts_per_page'=> 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'modal-categories',
                'field'    => 'slug',
                'terms'    => array( 'cart-page')
            )
            )

    );
    $modal = new WP_Query( $argsModal );

    while($modal->have_posts()){
        $modal->the_post();
                    
              echo   '<section class="modal-section" data-overlay="true" > 
             
                <i >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                <path id="Path_28" data-name="Path 28" d="M13.4,12l6.3-6.3a.99.99,0,1,0-1.4-1.4L12,10.6,5.7,4.3A.99.99,0,0,0,4.3,5.7L10.6,12,4.3,18.3A.908.908,0,0,0,4,19a.945.945,0,0,0,1,1,.908.908,0,0,0,.7-.3L12,13.4l6.3,6.3a.967.967,0,0,0,1.4,0,.967.967,0,0,0,0-1.4Z" transform="translate(-4 -4)" fill="#474747"/>
                </svg>

                </i>
                <div class="flex"> 
                            
                            <div>
                        <img src="'; 
                        echo get_the_post_thumbnail_url(null,"medium_large"); 
                        echo '"/>'; 
                    echo '</div>
                    <div class="content">
                        <div class="section-font-size  center-align">'; 
                    echo get_the_title();
                    echo ' </div>
                        <div class="center-align medium-font-size poppins-font">'; 
               echo get_the_content(); 
               echo ' </div>
                    </div>
                        
                    
                </div> 
                </section> ';
        } 
        wp_reset_postdata();
}