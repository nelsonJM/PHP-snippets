<?php
/*
Plugin Name: Ajax in the WP admin demo
Description: live demo
Author: Pippin Williamson
*/

function aad_admin_page(){
	global $aad_settings;
	$aad_settings = add_options_page(__('Admin Ajax Demo', 'aad'), __('Admin Ajax', 'aad'), 'manage_options', 'admin-ajax-demo', 'aad_render_admin');
}
add_action('admin_menu', 'aad_admin_page');

function aad_render_admin(){
	?>
	<div class="wrap">
		<h2><?php _e('Admin Ajax Demo', 'aad'); ?></h2>
		<form id="aad-form" action="" method="POST">
			<div>
				<input type="submit" id="aad_submit" name="aad-submit" class="button-primary"  value="<?php _e('Get Results','aad');?>" />
				<img src="<?php echo admin_url('/images/wpspin_light.gif'); ?>" class="waiting" id="aad_loading" style="display: none;"/>
			</div>
		</form>

		<div id="aad_results"></div>
	</div>
	<?php
}

function aad_load_scripts($hook){
	global $aad_settings;

	if( $hook != $aad_settings)
		return;

	wp_enqueue_script('aad-ajax', plugin_dir_url(__FILE__) . 'js/aad-ajax.js', array('jquery'));

	wp_localize_script('aad-ajax', 'aad_vars', array(
			'aad_nonce' => wp_create_nonce('aad-nonce')
			));
}
add_action('admin_enqueue_scripts', 'aad_load_scripts');

function aad_process_ajax(){
	if( !isset( $_POST['aad_nonce']) || !wp_verify_nonce( $_POST['aad_nonce'], 'aad-nonce'))
		die('Permissions check failed');

	$accessories = get_posts(array('post_type' => 'accessories', 'posts_per_page' => 5));
	if($accessories):
		echo '<ul>';
			foreach($accessories as $accessory) {
				echo '<li>' . get_the_title($accessory->ID) .  ' - <a href="' . get_permalink($accessory->ID) . '">' . __('View Accessory', 'aad') . '</a></li>';
			}
		echo '</ul>';
	else :
		echo '<p>' . __('No results found', 'aad') . '</p>';
	endif;
	die();
}
add_action('wp_ajax_aad_get_results', 'aad_process_ajax');