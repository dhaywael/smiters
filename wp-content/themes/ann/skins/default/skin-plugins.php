<?php
/**
 * Required plugins
 *
 * @package ANN
 * @since ANN 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$ann_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'ann' ),
	'page_builders' => esc_html__( 'Page Builders', 'ann' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'ann' ),
	'socials'       => esc_html__( 'Socials and Communities', 'ann' ),
	'events'        => esc_html__( 'Events and Appointments', 'ann' ),
	'content'       => esc_html__( 'Content', 'ann' ),
	'other'         => esc_html__( 'Other', 'ann' ),
);
$ann_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'ann' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'ann' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $ann_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'ann' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'ann' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $ann_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'ann' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'ann' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $ann_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'ann' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'ann' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $ann_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'ann' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'ann' ),
		'required'    => false,
		'logo'        => 'woocommerce.png',
		'group'       => $ann_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'ann' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'ann' ),
		'required'    => false,
		'logo'        => 'elegro-payment.png',
		'group'       => $ann_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'ann' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'ann' ),
		'required'    => false,
		'logo'        => 'instagram-feed.png',
		'group'       => $ann_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'ann' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'ann' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $ann_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'ann' ),
		'description' => '',
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'booked.png',
		'group'       => $ann_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'ann' ),
		'description' => '',
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'the-events-calendar.png',
		'group'       => $ann_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'ann' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'ann' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $ann_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'ann' ),
		'description' => '',
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => ann_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $ann_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'ann' ),
		'description' => '',
		'required'    => false,
		'logo'        => ann_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $ann_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'ann' ),
		'description' => '',
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => ann_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $ann_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'ann' ),
		'description' => '',
		'required'    => false,
		'logo'        => ann_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $ann_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'ann' ),
		'description' => '',
		'required'    => false,
		'logo'        => ann_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $ann_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'ann' ),
		'description' => '',
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => ann_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $ann_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'ann' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $ann_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'ann' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $ann_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'ann' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'ann' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $ann_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'ann' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'ann' ),
		'required'    => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $ann_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'ann' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'ann' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $ann_theme_required_plugins_groups['other'],
	),
);

if ( ANN_THEME_FREE ) {
	unset( $ann_theme_required_plugins['js_composer'] );
	unset( $ann_theme_required_plugins['booked'] );
	unset( $ann_theme_required_plugins['the-events-calendar'] );
	unset( $ann_theme_required_plugins['calculated-fields-form'] );
	unset( $ann_theme_required_plugins['essential-grid'] );
	unset( $ann_theme_required_plugins['revslider'] );
	unset( $ann_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $ann_theme_required_plugins['trx_updater'] );
	unset( $ann_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
ann_storage_set( 'required_plugins', $ann_theme_required_plugins );
