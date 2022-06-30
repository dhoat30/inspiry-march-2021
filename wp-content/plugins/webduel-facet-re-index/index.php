<?php 
/*
Plugin Name: Webduel Schedule Indexer
Plugin URI: https://webduel.co.nz/
Description: Runs indexer periodically by cron
Version: 1.0
Author: Webduel Limited
*/
add_action( 'fwp_scheduled_index', 'fwp_scheduled_index' );
function fwp_scheduled_index() {
  FWP()->indexer->index();
}

register_activation_hook( __FILE__, 'fwp_schedule_indexer_activation' );
function fwp_schedule_indexer_activation() {
  if ( ! wp_next_scheduled( 'fwp_scheduled_index' ) ) {
    wp_schedule_event( time(), 'hourly', 'fwp_scheduled_index' );
  }
}

register_deactivation_hook( __FILE__, 'fwp_schedule_indexer_deactivation' );
function fwp_schedule_indexer_deactivation() {
  wp_clear_scheduled_hook( 'fwp_scheduled_index' );
}
// remove automatic indexing
add_filter( 'facetwp_indexer_is_enabled', '__return_false' );