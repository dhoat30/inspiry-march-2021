<?php
/**
 * Main view file of import section
 *
 * @link            
 *
 * @package  Wt_Import_Export_For_Woo
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
do_action('wt_iew_importer_before_head');
?>
<style type="text/css">
.wt_iew_import_step{ display:none; }
.wt_iew_import_step_loader{ width:100%; height:400px; text-align:center; line-height:400px; font-size:14px; }
.wt_iew_import_step_main{ float:left; box-sizing:border-box; padding:15px; padding-bottom:0px; width:95%; margin:30px 2.5%; background:#fff; box-shadow:0px 2px 2px #ccc; border:solid 1px #efefef; }
.wt_iew_import_main{ padding:20px 0px; }
</style>
<div class="wt_iew_view_log wt_iew_popup" style="text-align:left">
	<div class="wt_iew_popup_hd">
		<span style="line-height:40px;" class="dashicons dashicons-media-text"></span>
		<span class="wt_iew_popup_hd_label"><?php _e('History Details');?></span>
		<div class="wt_iew_popup_close">X</div>
	</div>
    <div class="wt_iew_log_container" style="padding:25px;">
		
	</div>
</div>
<div class="wt_iew_import_progress_wrap wt_iew_popup">
		<div class="wt_iew_popup_hd wt_iew_import_progress_header">
			<span style="line-height:40px;" class="dashicons dashicons-media-text"></span>
			<span class="wt_iew_popup_hd_label"><?php _e('Import progress');?></span>
			<div class="wt_iew_popup_close">X</div>
		</div>
		<div class="wt_iew_import_progress_content"  style="max-height:620px;overflow: auto;">
					<table id="wt_iew_import_progress" class="widefat_importer widefat wt_iew_import_progress wp-list-table fixed striped history_list_tb log_list_tb">
						<thead>
							<tr>
								<th  style="width:15%" class="row"><?php _e( 'Row', 'wt-import-export-for-woo' ); ?></th>
								<th  style="width:20%"><?php _e( 'Item', 'wt-import-export-for-woo' ); ?></th>
								<th  style="width:50%"><?php _e( 'Message', 'wt-import-export-for-woo' ); ?></th>
								<th  style="width:20%" class="reason"><?php _e( 'Status', 'wt-import-export-for-woo' ); ?></th>
							</tr>
						</thead>
<!--						<tfoot>
							<tr class="importer-loading">
								<td colspan="5"></td>
							</tr>
						</tfoot>-->
						<tbody id="wt_iew_import_progress_tbody"></tbody>
					</table>
		</div>
		<br/>
		<div id="wt_iew_import_progress_end"></div>
	<progress class="wt-iew-importer-progress" max="100" value="1" style="height:40px;width:80%;margin: 0 auto;"></progress>
	<div class="wt-iew-import-completed" style="display:none;border-top: 1px outset;">
		<h3><?php _e('Import Completed'); ?><span class="dashicons dashicons-yes"></span></h3>
		<div class="wt-iew-import-results">
			<div class="wt-iew-import-result-row">
			<div class="wt-iew-import-results-total wt-iew-import-result-column"><?php _e('Total records identified'); ?>:<span id="wt-iew-import-results-total-count"></span></div>
			<div style="color:green" class="wt-iew-import-results-imported wt-iew-import-result-column"><?php _e('Imported successfully'); ?>:<span id="wt-iew-import-results-imported-count"></span></div>
			<div style="color:red" class="wt-iew-import-results-failed wt-iew-import-result-column"><?php _e('Failed/Skipped'); ?>:<span id="wt-iew-import-results-failed-count"></span></div>
			</div>
		</div>
	</div>
	
	
	<div class="wt-iew-plugin-toolbar bottom" style="padding:5px;margin-left:-10px;">
		<div style="float: left">
			<div class="wt-iew-import-time" style="display:none;padding-left: 40px;margin-top:10px;" ><?php _e( 'Time taken to complete' );?>:<span id="wt-iew-import-time-taken"></span></div>
		</div>
		<div style="float:right;">
			<div style="float:right;">
				<button class="button button-primary wt_iew_popup_close_btn" style="display:none"  type="button" style="margin-right:10px;"><?php _e( 'Close' );?></button>
			</div>
		</div>
	</div>
	
	
	
</div>
<?php
Wt_Iew_IE_Helper::debug_panel($this->module_base);
?>
<?php include WT_IEW_PLUGIN_PATH."/admin/views/_save_template_popup.php"; ?>

<h2 class="wt_iew_page_hd"><?php _e('Import'); ?><span class="wt_iew_post_type_name"></span></h2>

<?php
	if($requested_rerun_id>0 && $this->rerun_id==0)
	{
		?>
		<div class="wt_iew_warn wt_iew_rerun_warn">
			<?php _e('Unable to handle Re-Run request.');?>
		</div>
		<?php
	}
?>

<div class="wt_iew_loader_info_box"></div>
<div class="wt_iew_overlayed_loader"></div>

<div class="wt_iew_import_step_main">
	<?php
	foreach($this->steps as $stepk=>$stepv)
	{
		?>
		<div class="wt_iew_import_step wt_iew_import_step_<?php echo $stepk;?>" data-loaded="0"></div>
		<?php
	}
	?>
</div>
<script type="text/javascript">
/* external modules can hook */
function wt_iew_importer_validate(action, action_type, is_previous_step)
{
	var is_continue=true;
	<?php
	do_action('wt_iew_importer_validate');
	?>
	return is_continue;
}
function wt_iew_importer_reset_form_data()
{
	<?php
	do_action('wt_iew_importer_reset_form_data');
	?>
}
</script>