<?php 

//upload images 

function handle_my_file_upload() {
 

    // will return the attachment id of the image in the media library
    $attachment_id = media_handle_upload('my_file_field', 0);
  
    // test if upload succeeded
    if (is_wp_error($attachment_id)) {
        http_response_code(400);
        echo 'Failed to upload file.';
        return 'failed to upload file';
    }
    else {
        http_response_code(200);
        echo $attachment_id;
        return 'saved a file';
    }
  
    // done!
    die();
  }
  
  // allow uploads from users that are logged in
  add_action('wp_ajax_my_file_upload', 'handle_my_file_upload');