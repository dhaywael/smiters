<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ann_mailchimp_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ann_mailchimp_theme_setup9', 9 );
	function ann_mailchimp_theme_setup9() {
		if ( ann_exists_mailchimp() ) {
			add_action( 'wp_enqueue_scripts', 'ann_mailchimp_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_mailchimp', 'ann_mailchimp_frontend_scripts', 10, 1 );
			add_filter( 'ann_filter_merge_styles', 'ann_mailchimp_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'ann_filter_tgmpa_required_plugins', 'ann_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ann_mailchimp_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('ann_filter_tgmpa_required_plugins',	'ann_mailchimp_tgmpa_required_plugins');
	function ann_mailchimp_tgmpa_required_plugins( $list = array() ) {
		if ( ann_storage_isset( 'required_plugins', 'mailchimp-for-wp' ) && ann_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'install' ) !== false ) {
			$list[] = array(
				'name'     => ann_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'title' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'ann_exists_mailchimp' ) ) {
	function ann_exists_mailchimp() {
		return function_exists( '__mc4wp_load_plugin' ) || defined( 'MC4WP_VERSION' );
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue styles for frontend
if ( ! function_exists( 'ann_mailchimp_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'ann_mailchimp_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_mailchimp', 'ann_mailchimp_frontend_scripts', 10, 1 );
	function ann_mailchimp_frontend_scripts( $force = false ) {
		ann_enqueue_optimized( 'mailchimp', $force, array(
			'css' => array(
				'ann-mailchimp-for-wp' => array( 'src' => 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'ann_mailchimp_merge_styles' ) ) {
	//Handler of the add_filter( 'ann_filter_merge_styles', 'ann_mailchimp_merge_styles');
	function ann_mailchimp_merge_styles( $list ) {
		$list[ 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( ann_exists_mailchimp() ) {
	$ann_fdir = ann_get_file_dir( 'plugins/mailchimp-for-wp/mailchimp-for-wp-style.php' );
	if ( ! empty( $ann_fdir ) ) {
		require_once $ann_fdir;
	}
}

