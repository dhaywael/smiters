<?php
/* Paid Memberships Pro support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ann_paid_memberships_pro_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ann_paid_memberships_pro_theme_setup9', 9 );
	function ann_paid_memberships_pro_theme_setup9() {
		if ( ann_exists_paid_memberships_pro() ) {
            add_action( 'wp_enqueue_scripts', 'ann_paid_memberships_pro_frontend_scripts', 1100 );
            add_action( 'wp_enqueue_scripts', 'ann_paid_memberships_pro_responsive_styles', 2000 );
            add_filter('ann_filter_merge_styles', 'ann_paid_memberships_pro_merge_styles');
            add_filter( 'ann_filter_merge_styles_responsive', 'ann_paid_memberships_pro_merge_styles_responsive' );
        }
        if ( is_admin() ) {
            add_filter( 'ann_filter_tgmpa_required_plugins', 'ann_paid_memberships_pro_tgmpa_required_plugins' );
        }
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ann_paid_memberships_pro_tgmpa_required_plugins' ) ) {    
    function ann_paid_memberships_pro_tgmpa_required_plugins( $list = array() ) {
        if ( ann_storage_isset( 'required_plugins', 'paid-memberships-pro' ) && ann_storage_get_array( 'required_plugins', 'paid-memberships-pro', 'install' ) !== false ) {
            $list[] = array(
                'name'     => ann_storage_get_array( 'required_plugins', 'paid-memberships-pro', 'title' ),
                'slug'     => 'paid-memberships-pro',
                'required' => false,
            );
        }
        return $list;
    }
}

// Check if plugin installed and activated
if ( ! function_exists( 'ann_exists_paid_memberships_pro' ) ) {
	function ann_exists_paid_memberships_pro() {
		return class_exists( 'PMPro_Membership_Level' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'ann_paid_memberships_pro_frontend_scripts' ) ) {
    //Handler of the add_action( 'wp_enqueue_scripts', 'ann_paid_memberships_pro_frontend_scripts', 1100 );
    function ann_paid_memberships_pro_frontend_scripts() {
        if ( ann_is_on( ann_get_theme_option( 'debug_mode' ) ) ) {
            $ann_url = ann_get_file_url( 'plugins/paid-memberships-pro/paid-memberships-pro.css' );
            if ( '' != $ann_url ) {
                wp_enqueue_style( 'ann-paid-memberships-pro', $ann_url, array(), null );
            }
        }
    }
}
// Enqueue responsive styles for frontend
if ( ! function_exists( 'ann_paid_memberships_pro_responsive_styles' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'ann_paid_memberships_pro_responsive_styles', 2000 );
	function ann_paid_memberships_pro_responsive_styles() {
		if ( ann_is_on( ann_get_theme_option( 'debug_mode' ) ) ) {
			$ann_url = ann_get_file_url( 'plugins/paid-memberships-pro/paid-memberships-pro-responsive.css' );
			if ( '' != $ann_url ) {
				wp_enqueue_style( 'ann-paid-memberships-pro-responsive', $ann_url, array(), null, ann_media_for_load_css_responsive( 'paid-memberships-pro' ) );
			}
		}
	}
}
// Merge custom styles
if ( ! function_exists( 'ann_paid_memberships_pro_merge_styles' ) ) {
    //Handler of the add_filter('ann_filter_merge_styles', 'ann_paid_memberships_pro_merge_styles');
    function ann_paid_memberships_pro_merge_styles( $list ) {
        $list[ 'plugins/paid-memberships-pro/paid-memberships-pro.css' ] = true;
        return $list;
    }
}
// Merge responsive styles
if ( ! function_exists( 'ann_paid_memberships_pro_merge_styles_responsive' ) ) {
	//Handler of the add_filter('ann_filter_merge_styles_responsive', 'ann_paid_memberships_pro_merge_styles_responsive');
	function ann_paid_memberships_pro_merge_styles_responsive( $list ) {
		$list[ 'plugins/paid-memberships-pro/paid-memberships-pro-responsive.css' ] = true;
		return $list;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( ann_exists_paid_memberships_pro() ) {
	require_once ann_get_file_dir( 'plugins/paid-memberships-pro/paid-memberships-pro-style.php' );
}

// One-click import support
//------------------------------------------------------------------------
// Check plugin in the required plugins
if ( !function_exists( 'ann_paid_memberships_pro_required_plugins' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'ann_paid_memberships_pro_required_plugins', 10, 2 );
    function ann_paid_memberships_pro_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'paid-memberships-pro')!==false && !ann_exists_paid_memberships_pro() )
            $not_installed .= '<br>' . esc_html__('Paid Memberships Pro', 'ann');
        return $not_installed;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'ann_paid_memberships_pro_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'ann_paid_memberships_pro_importer_set_options' );
	function ann_paid_memberships_pro_importer_set_options($options=array()) {
		if ( ann_exists_paid_memberships_pro()  ) {
			$options['additional_options'][]	= 'pmpro_%';

			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_paid-memberships-pro'] = str_replace('name.ext', 'paid-memberships-pro.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Prevent import plugin's specific options if plugin is not installed
if ( !function_exists( 'ann_paid_memberships_pro_check_options' ) ) {
	add_filter( 'trx_addons_filter_import_theme_options', 'ann_paid_memberships_pro_check_options', 10, 4 );
	function ann_paid_memberships_pro_check_options($allow, $k, $v, $options) {
		if ($allow && (strpos($k, 'pmpro_')===0) ) {
			$allow = ann_exists_paid_memberships_pro() && in_array('paid-memberships-pro', $options['required_plugins']);
		}
		return $allow;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'ann_paid_memberships_pro_show_params' ) ) {
	add_action( 'trx_addons_action_importer_params',	'ann_paid_memberships_pro_show_params', 10, 1 );
	function ann_paid_memberships_pro_show_params($importer) {
		if ( ann_exists_paid_memberships_pro() && in_array('paid-memberships-pro', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'paid-memberships-pro',
				'title' => esc_html__('Import Paid Memberships Pro', 'ann'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'ann_paid_memberships_pro_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import',	'ann_paid_memberships_pro_importer_import', 10, 2 );
	function ann_paid_memberships_pro_importer_import($importer, $action) {
		if ( ann_exists_paid_memberships_pro() && in_array('paid-memberships-pro', $importer->options['required_plugins']) ) {
			if ( $action == 'import_paid-memberships-pro' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('paid-memberships-pro', esc_html__('Paid Memberships Pro meta', 'ann'));
			}
		}
	}
}


// Display import progress
if ( !function_exists( 'ann_paid_memberships_pro_import_fields' ) ) {
	add_action( 'trx_addons_action_importer_import_fields',	'ann_paid_memberships_pro_import_fields', 10, 1 );
	function ann_paid_memberships_pro_import_fields($importer) {
		if ( ann_exists_paid_memberships_pro() && in_array('paid-memberships-pro', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
					'slug'=>'paid-memberships-pro',
					'title' => esc_html__('Paid Memberships Pro meta', 'ann')
				)
			);
		}
	}
}	

// Export posts
if ( !function_exists( 'ann_paid_memberships_pro_export' ) ) {
	add_action( 'trx_addons_action_importer_export',	'ann_paid_memberships_pro_export', 10, 1 );
	function ann_paid_memberships_pro_export($importer) {
		if ( ann_exists_paid_memberships_pro() && in_array('paid-memberships-pro', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir('paid-memberships-pro.txt'), serialize( array(
					"pmpro_discount_codes"				    => $importer->export_dump("pmpro_discount_codes"),
					"pmpro_discount_codes_levels"			=> $importer->export_dump("pmpro_discount_codes_levels"),
					"pmpro_discount_codes_uses"				=> $importer->export_dump("pmpro_discount_codes_uses"),
					"pmpro_memberships_categories"			=> $importer->export_dump("pmpro_memberships_categories"),
					"pmpro_memberships_pages"				=> $importer->export_dump("pmpro_memberships_pages"),
					"pmpro_memberships_users"				=> $importer->export_dump("pmpro_memberships_users"),
					"pmpro_membership_levelmeta"			=> $importer->export_dump("pmpro_membership_levelmeta"),
					"pmpro_membership_levels"				=> $importer->export_dump("pmpro_membership_levels"),
					"pmpro_membership_ordermeta"			=> $importer->export_dump("pmpro_membership_ordermeta"),
					"pmpro_membership_orders"				=> $importer->export_dump("pmpro_membership_orders")
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'ann_paid_memberships_pro_export_fields' ) ) {
	add_action( 'trx_addons_action_importer_export_fields',	'ann_paid_memberships_pro_export_fields', 10, 1 );
	function ann_paid_memberships_pro_export_fields($importer) {
		if ( ann_exists_paid_memberships_pro() && in_array('paid-memberships-pro', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
					'slug'	=> 'paid-memberships-pro',
					'title' => esc_html__('Paid Memberships Pro', 'ann')
				)
			);
		}
	}
}