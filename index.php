<?php
/*
Plugin Name: FrontPage Title Meta Description
Plugin URI: http://antonhoelstad.dk
Description: This plugin changes frontpage title and meta description easily from the admin backend
Version: 1.0
Author: AntonAKH
Author URI: http://antonhoelstad.dk
*/
add_action('wp_head','jctm_hook');

function jctm_hook()
{
	$output = '';
	if(is_home() || is_front_page()){
		if(strlen(get_option('jctm_title'))>0){
			if(get_option('jctm_title') != ""){
			$jctm_title = get_option('jctm_title');
				//echo "<title>$jctm_title</title>";
				$output .= "
				<script type='text/javascript'>
				jQuery(document).ready(function(){
					jQuery('title').html('". $jctm_title . "');
				});
				</script>
				'";
			}
				
		}
		if(strlen(get_option('jctm_meta_description'))>0){
			if(get_option('jctm_meta_description') != ""){
			$jctm_meta_description = get_option('jctm_meta_description');
			$output .= "
				<script type='text/javascript'>
				jQuery(document).ready(function(){
						if(jQuery('meta[name=\'description\']').length < 1){
							jQuery('head').prepend('<meta name=\'description\' content=\'$jctm_meta_description\' />');
						}
						else{
							jQuery('meta[name=\'description\']').attr('content', '$jctm_meta_description');	
						}
						
				});
				</script>
				'";
			//$jctm_meta_description = get_option('jctm_meta_description');
			//$output .= "<meta name='description' content='$jctm_meta_description' />";
			}
		}
	}
	echo $output;
}








// create custom plugin settings menu
add_action('admin_menu', 'jctm_create_menu');

function jctm_create_menu() {

	//create new top-level menu
	add_options_page('Title Meta Settings', 'Title Meta Settings', 'administrator', __FILE__, 'jctm_settings_page');

	//call register settings function
	add_action( 'admin_init', 'jctm_register_mysettings' );
}


function jctm_register_mysettings() {
	//register our settings
	register_setting( 'jctm-settings-group', 'jctm_title' );
	register_setting( 'jctm-settings-group', 'jctm_meta_description' );
}

function jctm_settings_page() {
?>
<div class="wrap">
<h2>Title Meta Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'jctm-settings-group' ); ?>
    <?php do_settings_sections( 'jctm-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Frontpage Title</th>
        <td><input style='width:379px;' type="text" name="jctm_title" value="<?php echo esc_attr( get_option('jctm_title') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Frontpage Keyword Description</th>
        <td><textarea cols="50" rows="5" name="jctm_meta_description"><?php echo esc_attr( get_option('jctm_meta_description') ); ?></textarea></td>
        </tr>
        
        
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } 