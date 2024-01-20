<?php
/* Image Hotspot by DevVN support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ann_devvn_image_hotspot_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ann_devvn_image_hotspot_theme_setup9', 9 );
	function ann_devvn_image_hotspot_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'ann_filter_tgmpa_required_plugins', 'ann_devvn_image_hotspot_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ann_devvn_image_hotspot_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('ann_filter_tgmpa_required_plugins',	'ann_devvn_image_hotspot_tgmpa_required_plugins');
	function ann_devvn_image_hotspot_tgmpa_required_plugins( $list = array() ) {
		if ( ann_storage_isset( 'required_plugins', 'devvn-image-hotspot' ) && ann_storage_get_array( 'required_plugins', 'devvn-image-hotspot', 'install' ) !== false ) {
			$list[] = array(
				'name'     => ann_storage_get_array( 'required_plugins', 'devvn-image-hotspot', 'title' ),
				'slug'     => 'devvn-image-hotspot',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'ann_exists_devvn_image_hotspot' ) ) {
	function ann_exists_devvn_image_hotspot() {
        return defined( 'DEVVN_IHOTSPOT_DEV_MOD' );
	}
}
