<?php 
// design board short code
function design_board_button(){ 
    $designBoardButton = '<div class="wishlist-designer-board-container">
        <div class="design-board-save-btn-container" data-user="'.is_user_logged_in().'" data-id='.get_the_id().' data-name="'.get_the_title().'">         
            <svg  viewBox="0 0 13.442 12.101">
            <g id="layer1" transform="translate(-1.014 -1038.368)">
            <g id="g4906" transform="translate(1.015 -0.003)">
                <g id="g6020" transform="translate(-1.028 1.003)">
                <path id="path5035-4" d="M5.047,2.506A3.585,3.585,0,0,0,1.514,6.33c0,2.4,3.35,5.263,6.221,7.176,2.871-1.913,6.182-4.824,6.221-7.176a3.5,3.5,0,0,0-3.447-3.824A4.046,4.046,0,0,0,7.734,3.939,3.881,3.881,0,0,0,5.047,2.506Z" transform="translate(0.013 1035.362)" fill="none" stroke="#000" stroke-width="1.3"/>
                </g>
            </g>
                </g>
            </svg>
      
   
        </div>
    
    </div>
    '; 
            // do_shortcode('[yith_wcwl_add_to_wishlist]')

    return $designBoardButton; 
}

// design board button shortcode
add_shortcode('design_board_button_code', 'design_board_button'); 