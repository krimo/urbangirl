<?php   
/* 
Plugin Name: Image de Promo UrbanGirl 
Plugin URI: http://krimohafsaoui.com 
Description: Plugin pour afficher ou non une image de pub de fond 
Author: Krimo Hafsaoui 
Version: 1.0 
Author URI: http://krimohafsaoui.com
License: GPLv2 
*/

function ugadbg_display_image() {
	$ugadbgUrl = get_option('ugadbg_url');

	if ($ugadbgUrl) {

		if (is_user_logged_in()) {
			$retval = '<style>
								body { background: #fafafa url('.$ugadbgUrl.') no-repeat; background-position: center 268px; }
								body > article[role="main"] { max-width: 55em; }
					</style>';
		} else {
			$retval = '<style>
								body { background: #fafafa url('.$ugadbgUrl.') no-repeat; background-position: center 207px; }
								body > article[role="main"] { max-width: 55em; }
					</style>';
		}
		
	} else {
		$retval = '';
	}

	return $retval;
}

function ugadbg_admin() {  
    include('ug_adbg_admin.php');  
}

function ugadbg_admin_actions() {  
      add_options_page("UG Image Promo", "UG Image Promo", 1, "UG_Image_Promo", "ugadbg_admin");
}  
add_action('admin_menu', 'ugadbg_admin_actions');
?>