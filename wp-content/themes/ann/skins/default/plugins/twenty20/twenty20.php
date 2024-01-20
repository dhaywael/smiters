<?php
/* Twenty20 Image Before-After support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('ann_twenty20_theme_setup9')) {
	add_action( 'after_setup_theme', 'ann_twenty20_theme_setup9', 9 );
	function ann_twenty20_theme_setup9() {
		if (is_admin()) {
			add_filter( 'ann_filter_tgmpa_required_plugins',		'ann_twenty20_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'ann_twenty20_tgmpa_required_plugins' ) ) {
	function ann_twenty20_tgmpa_required_plugins($list=array()) {
		if (ann_storage_isset('required_plugins', 'twenty20') && ann_storage_get_array( 'required_plugins', 'twenty20', 'install' ) !== false) {
			$list[] = array(
				'name' 		=> ann_storage_get_array('required_plugins', 'twenty20', 'title'),
				'slug' 		=> 'twenty20',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'ann_exists_twenty20' ) ) {
	function ann_exists_twenty20() {
		return function_exists('twenty20_dir_init');
	}
}

?>