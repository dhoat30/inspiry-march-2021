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
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17.155" viewBox="0 0 18 17.155">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17.155" viewBox="0 0 18 17.155">
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
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18.003" viewBox="0 0 18 18.003">
  <path id="Path_21" data-name="Path 21" d="M9.763,1.044a.643.643,0,0,1,.478,0L18.6,4.388a.643.643,0,0,1,.4.6.629.629,0,0,1,0,.068c0,.008,0,.016,0,.024v9.9a.643.643,0,0,1-.4.6l-8.347,3.384a.687.687,0,0,1-.5,0L1.4,15.569a.643.643,0,0,1-.4-.6v-9.9q0-.03,0-.06t0-.033a.643.643,0,0,1,.4-.6Zm.872,16.366,7.078-2.869V5.935l-7.07,2.827ZM2.286,5.933v8.608L9.349,17.4,9.356,8.76ZM10,2.333,3.376,4.984,10,7.634l6.626-2.649Z" transform="translate(-1.001 -0.998)" fill="#474747"/>
</svg>

                    <span>Track Orders </span>
                </a>
            </li>
            <li class="list-item">
                <a href="<?php echo get_home_url() ?>/home/members/design-boards" class="anchor">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17.015" viewBox="0 0 19 17.015">
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
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20.795 24.581">
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
                    <svg id="Group_10" data-name="Group 10" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
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