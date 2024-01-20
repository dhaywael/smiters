<?php

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ann_advanced_popups_theme_setup9' ) ) {
    add_action( 'after_setup_theme', 'ann_advanced_popups_theme_setup9', 9 );
    function ann_advanced_popups_theme_setup9() {
        if ( is_admin() ) {
            add_filter( 'ann_filter_tgmpa_required_plugins', 'ann_advanced_popups_tgmpa_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ann_advanced_popups_tgmpa_required_plugins' ) ) {    
    function ann_advanced_popups_tgmpa_required_plugins( $list = array() ) {
        if ( ann_storage_isset( 'required_plugins', 'advanced-popups' ) && ann_storage_get_array( 'required_plugins', 'advanced-popups', 'install' ) !== false ) {
            $list[] = array(
                'name'     => ann_storage_get_array( 'required_plugins', 'advanced-popups', 'title' ),
                'slug'     => 'advanced-popups',
                'required' => false,
            );
        }
        return $list;
    }
}

// Check if plugin installed and activated
if ( ! function_exists( 'ann_exists_advanced_popups' ) ) {
    function ann_exists_advanced_popups() {
        return function_exists('adp_init');
    }
}
