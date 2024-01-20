<?php
/**
 * Skin Setup
 *
 * @package ANN
 * @since ANN 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'ann_theme_defaults' ) ) {
	function ann_theme_defaults( $name='', $value='' ) {
		$defaults = array(
			'page_width'          => 1290,
			'page_boxed_extra'  => 60,
			'page_fullwide_max' => 1920,
			'page_fullwide_extra' => 60,
			'sidebar_width'       => 410,
			'sidebar_gap'       => 40,
			'grid_gap'          => 30,
			'rad'               => 0
		);
		if ( empty( $name ) ) {
			return $defaults;
		} else {
			if ( $value === '' && isset( $defaults[ $name ] ) ) {
				$value = $defaults[ $name ];
			}
			return $value;
		}
	}
}


// WOOCOMMERCE SETUP
//--------------------------------------------------

// Allow extended layouts for WooCommerce
if ( ! function_exists( 'ann_skin_woocommerce_allow_extensions' ) ) {
	add_filter( 'ann_filter_load_woocommerce_extensions', 'ann_skin_woocommerce_allow_extensions' );
	function ann_skin_woocommerce_allow_extensions( $allow ) {
		return true;
	}
}


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


//--------------------------------------------
// SKIN SETTINGS
//--------------------------------------------
if ( ! function_exists( 'ann_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'ann_skin_setup', 1 );
	function ann_skin_setup() {

		$GLOBALS['ANN_STORAGE'] = array_merge( $GLOBALS['ANN_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-axiom',

			'theme_doc_url'       => '//ann.axiomthemes.com/doc',

			'theme_demofiles_url' => '//demofiles.axiomthemes.com/ann/',
			
			'theme_rate_url'      => '//themeforest.net/download',

			'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

			'theme_download_url'  => '//themeforest.net/user/axiomthemes/portfolio',         // Axiom

            'theme_video_url'     => '//www.youtube.com/channel/UCBjqhuwKj3MfE3B6Hg2oA8Q',   // Axiom

            'theme_privacy_url'   => '//axiomthemes.com/privacy-policy/',                    // Axiom

            'portfolio_url'       => '//themeforest.net/user/axiomthemes/portfolio',         // Axiom



			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'ann_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'ann_skin_setup_settings', 1 );
	function ann_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		ann_storage_set_array( 'settings', 'thumbs_in_navigation', false );
		// Add Skin Specific Plugins
		ann_storage_set_array( 'required_plugins', 'paid-memberships-pro', array(
            'title'       => esc_html__( 'Paid Memberships Pro', 'ann' ),
            'description' => esc_html__( "The most complete member management and membership subscriptions plugin for WordPress", 'ann' ),
            'required'    => false,
            'logo'        => ann_get_file_url( 'plugins/paid-memberships-pro/paid-memberships-pro.png' ),
            'group'       => 'other',
        ) );
		$ann_skin_path = ann_get_file_dir( ann_skins_get_current_skin_dir() . 'plugins/paid-memberships-pro/paid-memberships-pro.php' );
        if ( ! empty( $ann_skin_path ) ) {
            require_once $ann_skin_path;
        }

	}
}

// Enqueue extra styles for frontend
if ( ! function_exists( 'ann_trx_addons_extra_styles' ) ) {
    add_action( 'wp_enqueue_scripts', 'ann_trx_addons_extra_styles', 2060 );
    function ann_trx_addons_extra_styles() {
        $ann_url = ann_get_file_url( 'extra-styles.css' );
        if ( '' != $ann_url ) {
            wp_enqueue_style( 'ann-trx-addons-extra-styles', $ann_url, array(), null );
        }
    }
}
// Custom styles
$ann_skin_path = ann_get_file_dir( ann_skins_get_current_skin_dir() . 'extra-styles.php' );
if ( ! empty( $ann_skin_path ) ) {
    require_once $ann_skin_path;
}

//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'ann_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'ann_skin_setup_fonts', 1 );
	function ann_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		ann_storage_set(
			'load_fonts', array(
				array(
					'name'   => 'DM Sans',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'ital,wght@0,400;0,500;0,700;1,400;1,500;1,700'
				),
				array(
					'name'   => 'Plus Jakarta Sans',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800'
				),
				array(
					'name'   => 'europa',											 // do not delete font, used in skin
					'family' => 'sans-serif',
					'link'   => 'https://use.typekit.net/qmj1tmx.css',
					'styles' => ''
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		ann_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags.
		// Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
		// or as comma-separated string.
		// In the second case (if 'font-family' is specified manually as comma-separated string):
		//    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		//    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
		// example:
		// Correct:   'font-family' => ann_get_load_fonts_family_string( $load_fonts[0] )
		// Correct:   'font-family' => 'Roboto,sans-serif'
		// Correct:   'font-family' => '"PT Serif",sans-serif'
		// Incorrect: 'font-family' => 'Roboto, sans-serif'
		// Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'ann' );

		ann_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'ann' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.62em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.57em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'ann' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'ann' ) ),
					'font-family'     => '"Plus Jakarta Sans",sans-serif',
					'font-size'       => '3.353em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-1.7px',
					'margin-top'      => '1.04em',
					'margin-bottom'   => '0.46em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'ann' ) ),
					'font-family'     => '"Plus Jakarta Sans",sans-serif',
					'font-size'       => '2.765em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-1.4px',
					'margin-top'      => '0.67em',
					'margin-bottom'   => '0.56em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'ann' ) ),
					'font-family'     => '"Plus Jakarta Sans",sans-serif',
					'font-size'       => '2.059em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-1px',
					'margin-top'      => '0.94em',
					'margin-bottom'   => '0.72em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'ann' ) ),
					'font-family'     => '"Plus Jakarta Sans",sans-serif',
					'font-size'       => '1.647em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.214em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.6px',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.83em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'ann' ) ),
					'font-family'     => '"Plus Jakarta Sans",sans-serif',
					'font-size'       => '1.412em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.417em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.5px',
					'margin-top'      => '1.3em',
					'margin-bottom'   => '0.84em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'ann' ) ),
					'font-family'     => '"Plus Jakarta Sans",sans-serif',
					'font-size'       => '1.118em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.474em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.5px',
					'margin-top'      => '1.75em',
					'margin-bottom'   => '1.1em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'ann' ) ),
					'font-family'     => '"Plus Jakarta Sans",sans-serif',
					'font-size'       => '1.8em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.6px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'ann' ) ),
					'font-family'     => '"Plus Jakarta Sans",sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '21px',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'ann' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '16px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'ann' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '14px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'ann' ) ),
					'font-family'     => '"Plus Jakarta Sans",sans-serif',
					'font-size'       => '16px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'ann' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'other' => array(
					'title'           => esc_html__( 'Other', 'ann' ),
					'description'     => sprintf( $font_description, esc_html__( 'specific elements', 'ann' ) ),  
					'font-family'     => 'europa,sans-serif',  
				)
			)
		);

		// Font presets
		ann_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'ann' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Dancing Script',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
													// Google font
													array(
														'name'   => 'Sansita Swashed',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Dancing Script",fantasy',
														'font-size'       => '1.25rem',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
														'font-size'       => '4em',
													),
													'h2'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h3'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h4'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h5'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h6'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'logo'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'button'  => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'submenu' => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
												),
							),
				'roboto' => array(
								'title'  => esc_html__( 'Roboto', 'ann' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Noto Sans JP',
														'family' => 'serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
													// Google font
													array(
														'name'   => 'Merriweather',
														'family' => 'sans-serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Noto Sans JP",serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
												),
							),
				'garamond' => array(
								'title'  => esc_html__( 'Garamond', 'ann' ),
								'load_fonts' => array(
													// Adobe font
													array(
														'name'   => 'Europe',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
													// Adobe font
													array(
														'name'   => 'Sofia Pro',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Sofia Pro",sans-serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Europe,sans-serif',
													),
												),
							),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'ann_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'ann_skin_setup_schemes', 1 );
	function ann_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		ann_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'ann' ),
					'description' => esc_html__( 'Colors of the main content area', 'ann' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'ann' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'ann' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'ann' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'ann' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'ann' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'ann' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'ann' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'ann' ),
				),
			)
		);

		ann_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'ann' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'ann' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'ann' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'ann' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'ann' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'ann' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'ann' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'ann' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'ann' ),
					'description' => esc_html__( 'Color of the text inside this block', 'ann' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'ann' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'ann' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'ann' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'ann' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'ann' ),
					'description' => esc_html__( 'Color of the links inside this block', 'ann' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'ann' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'ann' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'ann' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'ann' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'ann' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'ann' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'ann' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'ann' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'ann' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'ann' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#E4F1F5', //ok +
					'bd_color'         => '#CDD9DE', //ok +

					// Text and links colors
					'text'             => '#656565', //ok +
					'text_light'       => '#86878B', //ok +
					'text_dark'        => '#070219', //ok +
					'text_link'        => '#5EC900', //ok +
					'text_hover'       => '#4FA801', //ok +
					'text_link2'       => '#6600FF', //ok +
					'text_hover2'      => '#5700D9', //ok +
					'text_link3'       => '#FFD03E', //ok +
					'text_hover3'      => '#FCBA06', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#D9E8EE', //ok +
					'alter_bd_color'   => '#CDD9DE', //ok +
					'alter_bd_hover'   => '#B8CAD2', //ok +
					'alter_text'       => '#656565', //ok +
					'alter_light'      => '#86878B', //ok +
					'alter_dark'       => '#070219', //ok +
					'alter_link'       => '#5EC900', //ok +
					'alter_hover'      => '#4FA801', //ok +
					'alter_link2'      => '#6600FF', //ok +
					'alter_hover2'     => '#5700D9', //ok +
					'alter_link3'      => '#FFD03E', //ok +
					'alter_hover3'     => '#FCBA06', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#5EC900', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#6600FF',
					'extra_hover2'     => '#5700D9',
					'extra_link3'      => '#FFD03E',
					'extra_hover3'     => '#FCBA06',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#CDD9DE', //ok +
					'input_bd_hover'   => '#B8CAD2', //ok +
					'input_text'       => '#656565', //ok +
					'input_light'      => '#86878B', //ok +
					'input_dark'       => '#070219', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#070219', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#070219', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#050913', //ok +
					'bd_color'         => '#2A2E36', //ok +

					// Text and links colors
					'text'             => '#A9A7B0', //ok +
					'text_light'       => '#74727B', //ok +
					'text_dark'        => '#FDFDFD', //ok +
					'text_link'        => '#5EC900', //ok +
					'text_hover'       => '#4FA801', //ok +
					'text_link2'       => '#6600FF', //ok +
					'text_hover2'      => '#5700D9', //ok +
					'text_link3'       => '#FFD03E', //ok +
					'text_hover3'      => '#FCBA06', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#0D111A', //ok +
					'alter_bg_hover'   => '#171A24', //ok +
					'alter_bd_color'   => '#2A2E36', //ok +
					'alter_bd_hover'   => '#3F424A', //ok +
					'alter_text'       => '#A9A7B0', //ok +
					'alter_light'      => '#74727B', //ok +
					'alter_dark'       => '#FDFDFD', //ok +
					'alter_link'       => '#5EC900', //ok +
					'alter_hover'      => '#4FA801', //ok +
					'alter_link2'      => '#6600FF', //ok +
					'alter_hover2'     => '#5700D9', //ok +
					'alter_link3'      => '#FFD03E', //ok +
					'alter_hover3'     => '#FCBA06', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#2A2E36',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#5EC900', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#6600FF', 
					'extra_hover2'     => '#5700D9', 
					'extra_link3'      => '#FFD03E', 
					'extra_hover3'     => '#FCBA06', 

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#2A2E36', //ok +
					'input_bd_hover'   => '#3F424A', //ok +
					'input_text'       => '#A9A7B0', //ok +
					'input_light'      => '#74727B', //ok +
					'input_dark'       => '#FDFDFD', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FDFDFD', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#070219', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#070219', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'light'
			'light' => array(
				'title'    => esc_html__( 'Light', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#CDD9DE', //ok +

					// Text and links colors
					'text'             => '#656565', //ok +
					'text_light'       => '#86878B', //ok +
					'text_dark'        => '#070219', //ok +
					'text_link'        => '#5EC900', //ok +
					'text_hover'       => '#4FA801', //ok +
					'text_link2'       => '#6600FF', //ok +
					'text_hover2'      => '#5700D9', //ok +
					'text_link3'       => '#FFD03E', //ok +
					'text_hover3'      => '#FCBA06', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#E4F1F5', //ok +
					'alter_bg_hover'   => '#C2D8E1', //ok +
					'alter_bd_color'   => '#CDD9DE', //ok +
					'alter_bd_hover'   => '#B8CAD2', //ok +
					'alter_text'       => '#656565', //ok +
					'alter_light'      => '#86878B', //ok +
					'alter_dark'       => '#070219', //ok +
					'alter_link'       => '#5EC900', //ok +
					'alter_hover'      => '#4FA801', //ok +
					'alter_link2'      => '#6600FF', //ok +
					'alter_hover2'     => '#5700D9', //ok +
					'alter_link3'      => '#FFD03E', //ok +
					'alter_hover3'     => '#FCBA06', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#5EC900', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#6600FF',
					'extra_hover2'     => '#5700D9',
					'extra_link3'      => '#FFD03E',
					'extra_hover3'     => '#FCBA06',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#CDD9DE', //ok +
					'input_bd_hover'   => '#B8CAD2', //ok +
					'input_text'       => '#656565', //ok +
					'input_light'      => '#86878B', //ok +
					'input_dark'       => '#070219', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#070219', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#070219', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'sunny_default'
			'sunny_default' => array(
				'title'    => esc_html__( 'Sunny Default', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F7F7F7', //ok +
					'bd_color'         => '#E8E5DD', //ok +

					// Text and links colors
					'text'             => '#656565', //ok +
					'text_light'       => '#86878B', //ok +
					'text_dark'        => '#070219', //ok +
					'text_link'        => '#FAC733', //ok +
					'text_hover'       => '#F1A610', //ok +
					'text_link2'       => '#FF2E57', //ok +
					'text_hover2'      => '#E91B43', //ok +
					'text_link3'       => '#5EC900', //ok +
					'text_hover3'      => '#4FA801', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#F2EFE8', //ok +
					'alter_bd_color'   => '#E8E5DD', //ok +
					'alter_bd_hover'   => '#DBD7CC', //ok +
					'alter_text'       => '#656565', //ok +
					'alter_light'      => '#86878B', //ok +
					'alter_dark'       => '#070219', //ok +
					'alter_link'       => '#FAC733', //ok +
					'alter_hover'      => '#F1A610', //ok +
					'alter_link2'      => '#FF2E57', //ok +
					'alter_hover2'     => '#E91B43', //ok +
					'alter_link3'      => '#5EC900', //ok +
					'alter_hover3'     => '#4FA801', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#FAC733', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#FF2E57',
					'extra_hover2'     => '#E91B43',
					'extra_link3'      => '#5EC900',
					'extra_hover3'     => '#4FA801',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#E8E5DD', //ok +
					'input_bd_hover'   => '#DBD7CC', //ok +
					'input_text'       => '#656565', //ok +
					'input_light'      => '#86878B', //ok +
					'input_dark'       => '#070219', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#070219', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#070219', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'sunny_dark'
			'sunny_dark'    => array(
				'title'    => esc_html__( 'Sunny Dark', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#131622', //ok +
					'bd_color'         => '#2A2E36', //ok +

					// Text and links colors
					'text'             => '#A9A7B0', //ok +
					'text_light'       => '#74727B', //ok +
					'text_dark'        => '#FDFDFD', //ok +
					'text_link'        => '#FAC733', //ok +
					'text_hover'       => '#F1A610', //ok +
					'text_link2'       => '#FF2E57', //ok +
					'text_hover2'      => '#E91B43', //ok +
					'text_link3'       => '#5EC900', //ok +
					'text_hover3'      => '#4FA801', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#0A0D1A', //ok +
					'alter_bg_hover'   => '#171A24', //ok +
					'alter_bd_color'   => '#2A2E36', //ok +
					'alter_bd_hover'   => '#3F424A', //ok +
					'alter_text'       => '#A9A7B0', //ok +
					'alter_light'      => '#74727B', //ok +
					'alter_dark'       => '#FDFDFD', //ok +
					'alter_link'       => '#FAC733', //ok +
					'alter_hover'      => '#F1A610', //ok +
					'alter_link2'      => '#FF2E57', //ok +
					'alter_hover2'     => '#E91B43', //ok +
					'alter_link3'      => '#5EC900', //ok +
					'alter_hover3'     => '#4FA801', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#2A2E36',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#FAC733', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#FF2E57', 
					'extra_hover2'     => '#E91B43', 
					'extra_link3'      => '#5EC900', 
					'extra_hover3'     => '#4FA801', 

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#2A2E36', //ok +
					'input_bd_hover'   => '#3F424A', //ok +
					'input_text'       => '#A9A7B0', //ok +
					'input_light'      => '#74727B', //ok +
					'input_dark'       => '#FDFDFD', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FDFDFD', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#070219', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#070219', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'sunny_light'
			'sunny_light' => array(
				'title'    => esc_html__( 'Sunny Light', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#E8E5DD', //ok +

					// Text and links colors
					'text'             => '#656565', //ok +
					'text_light'       => '#86878B', //ok +
					'text_dark'        => '#070219', //ok +
					'text_link'        => '#FAC733', //ok +
					'text_hover'       => '#F1A610', //ok +
					'text_link2'       => '#FF2E57', //ok +
					'text_hover2'      => '#E91B43', //ok +
					'text_link3'       => '#5EC900', //ok +
					'text_hover3'      => '#4FA801', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F7F7F7', //ok +
					'alter_bg_hover'   => '#DFDFDF', //ok +
					'alter_bd_color'   => '#E8E5DD', //ok +
					'alter_bd_hover'   => '#DBD7CC', //ok +
					'alter_text'       => '#656565', //ok +
					'alter_light'      => '#86878B', //ok +
					'alter_dark'       => '#070219', //ok +
					'alter_link'       => '#FAC733', //ok +
					'alter_hover'      => '#F1A610', //ok +
					'alter_link2'      => '#FF2E57', //ok +
					'alter_hover2'     => '#E91B43', //ok +
					'alter_link3'      => '#5EC900', //ok +
					'alter_hover3'     => '#4FA801', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#FAC733', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#FF2E57',
					'extra_hover2'     => '#E91B43',
					'extra_link3'      => '#5EC900',
					'extra_hover3'     => '#4FA801',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#E8E5DD', //ok +
					'input_bd_hover'   => '#DBD7CC', //ok +
					'input_text'       => '#656565', //ok +
					'input_light'      => '#86878B', //ok +
					'input_dark'       => '#070219', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#070219', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#070219', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'cerulean_default'
			'cerulean_default' => array(
				'title'    => esc_html__( 'Сerulean Default', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F9F8F4', //ok +
					'bd_color'         => '#E8E5DD', //ok +

					// Text and links colors
					'text'             => '#656565', //ok +
					'text_light'       => '#86878B', //ok +
					'text_dark'        => '#070219', //ok +
					'text_link'        => '#87D1F1', //ok +
					'text_hover'       => '#69C2E8', //ok +
					'text_link2'       => '#7967FA', //ok +
					'text_hover2'      => '#614EE9', //ok +
					'text_link3'       => '#FAC733', //ok +
					'text_hover3'      => '#F1A610', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#F2EFE8', //ok +
					'alter_bd_color'   => '#E8E5DD', //ok +
					'alter_bd_hover'   => '#DBD7CC', //ok +
					'alter_text'       => '#656565', //ok +
					'alter_light'      => '#86878B', //ok +
					'alter_dark'       => '#070219', //ok +
					'alter_link'       => '#87D1F1', //ok +
					'alter_hover'      => '#69C2E8', //ok +
					'alter_link2'      => '#7967FA', //ok +
					'alter_hover2'     => '#614EE9', //ok +
					'alter_link3'      => '#FAC733', //ok +
					'alter_hover3'     => '#F1A610', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#87D1F1', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#7967FA',
					'extra_hover2'     => '#614EE9',
					'extra_link3'      => '#FAC733',
					'extra_hover3'     => '#F1A610',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#E8E5DD', //ok +
					'input_bd_hover'   => '#DBD7CC', //ok +
					'input_text'       => '#656565', //ok +
					'input_light'      => '#86878B', //ok +
					'input_dark'       => '#070219', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#070219', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#070219', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'cerulean_dark'
			'cerulean_dark'    => array(
				'title'    => esc_html__( 'Cerulean Dark', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#131622', //ok +
					'bd_color'         => '#2A2E36', //ok +

					// Text and links colors
					'text'             => '#A9A7B0', //ok +
					'text_light'       => '#74727B', //ok +
					'text_dark'        => '#FDFDFD', //ok +
					'text_link'        => '#87D1F1', //ok +
					'text_hover'       => '#69C2E8', //ok +
					'text_link2'       => '#7967FA', //ok +
					'text_hover2'      => '#614EE9', //ok +
					'text_link3'       => '#FAC733', //ok +
					'text_hover3'      => '#F1A610', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#0A0D1A', //ok +
					'alter_bg_hover'   => '#171A24', //ok +
					'alter_bd_color'   => '#2A2E36', //ok +
					'alter_bd_hover'   => '#3F424A', //ok +
					'alter_text'       => '#A9A7B0', //ok +
					'alter_light'      => '#74727B', //ok +
					'alter_dark'       => '#FDFDFD', //ok +
					'alter_link'       => '#87D1F1', //ok +
					'alter_hover'      => '#69C2E8', //ok +
					'alter_link2'      => '#7967FA', //ok +
					'alter_hover2'     => '#614EE9', //ok +
					'alter_link3'      => '#FAC733', //ok +
					'alter_hover3'     => '#F1A610', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#2A2E36',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#87D1F1', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#7967FA', 
					'extra_hover2'     => '#614EE9', 
					'extra_link3'      => '#FAC733', 
					'extra_hover3'     => '#F1A610', 

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#2A2E36', //ok +
					'input_bd_hover'   => '#3F424A', //ok +
					'input_text'       => '#A9A7B0', //ok +
					'input_light'      => '#74727B', //ok +
					'input_dark'       => '#FDFDFD', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FDFDFD', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#070219', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#070219', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
			// Color scheme: 'cerulean_light'
			'cerulean_light' => array(
				'title'    => esc_html__( 'Сerulean Light', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#E8E5DD', //ok +

					// Text and links colors
					'text'             => '#656565', //ok +
					'text_light'       => '#86878B', //ok +
					'text_dark'        => '#070219', //ok +
					'text_link'        => '#87D1F1', //ok +
					'text_hover'       => '#69C2E8', //ok +
					'text_link2'       => '#7967FA', //ok +
					'text_hover2'      => '#614EE9', //ok +
					'text_link3'       => '#FAC733', //ok +
					'text_hover3'      => '#F1A610', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F9F8F4', //ok +
					'alter_bg_hover'   => '#F2EFE8', //ok +
					'alter_bd_color'   => '#E8E5DD', //ok +
					'alter_bd_hover'   => '#DBD7CC', //ok +
					'alter_text'       => '#656565', //ok +
					'alter_light'      => '#86878B', //ok +
					'alter_dark'       => '#070219', //ok +
					'alter_link'       => '#87D1F1', //ok +
					'alter_hover'      => '#69C2E8', //ok +
					'alter_link2'      => '#7967FA', //ok +
					'alter_hover2'     => '#614EE9', //ok +
					'alter_link3'      => '#FAC733', //ok +
					'alter_hover3'     => '#F1A610', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#87D1F1', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#7967FA',
					'extra_hover2'     => '#614EE9',
					'extra_link3'      => '#FAC733',
					'extra_hover3'     => '#F1A610',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#E8E5DD', //ok +
					'input_bd_hover'   => '#DBD7CC', //ok +
					'input_text'       => '#656565', //ok +
					'input_light'      => '#86878B', //ok +
					'input_dark'       => '#070219', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#070219', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#070219', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'coldy_default'
			'coldy_default' => array(
				'title'    => esc_html__( 'Coldy Default', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F2F8FD', //ok +
					'bd_color'         => '#CFD8E0', //ok +

					// Text and links colors
					'text'             => '#5F686F', //ok +
					'text_light'       => '#86878B', //ok +
					'text_dark'        => '#091625', //ok +
					'text_link'        => '#0146FF', //ok +
					'text_hover'       => '#003AD5', //ok +
					'text_link2'       => '#31A6DB', //ok +
					'text_hover2'      => '#238BBA', //ok +
					'text_link3'       => '#62BDBA', //ok +
					'text_hover3'      => '#51A5A2', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#E4EEF7', //ok +
					'alter_bd_color'   => '#CFD8E0', //ok +
					'alter_bd_hover'   => '#B6C0C9', //ok +
					'alter_text'       => '#5F686F', //ok +
					'alter_light'      => '#86878B', //ok +
					'alter_dark'       => '#091625', //ok +
					'alter_link'       => '#0146FF', //ok +
					'alter_hover'      => '#003AD5', //ok +
					'alter_link2'      => '#31A6DB', //ok +
					'alter_hover2'     => '#238BBA', //ok +
					'alter_link3'      => '#62BDBA', //ok +
					'alter_hover3'     => '#51A5A2', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#050D15', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#0146FF', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#31A6DB',
					'extra_hover2'     => '#238BBA',
					'extra_link3'      => '#62BDBA',
					'extra_hover3'     => '#51A5A2',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#CFD8E0', //ok +
					'input_bd_hover'   => '#B6C0C9', //ok +
					'input_text'       => '#5F686F', //ok +
					'input_light'      => '#86878B', //ok +
					'input_dark'       => '#091625', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#091625', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#091625', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'coldy_dark'
			'coldy_dark'    => array(
				'title'    => esc_html__( 'Coldy Dark', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#000306', //ok +
					'bd_color'         => '#262A2F', //ok +

					// Text and links colors
					'text'             => '#8F96A1', //ok +
					'text_light'       => '#707680', //ok +
					'text_dark'        => '#FDFDFD', //ok +
					'text_link'        => '#0146FF', //ok +
					'text_hover'       => '#003AD5', //ok +
					'text_link2'       => '#31A6DB', //ok +
					'text_hover2'      => '#238BBA', //ok +
					'text_link3'       => '#62BDBA', //ok +
					'text_hover3'      => '#51A5A2', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#020810', //ok +
					'alter_bg_hover'   => '#0B1420', //ok +
					'alter_bd_color'   => '#262A2F', //ok +
					'alter_bd_hover'   => '#343940', //ok +
					'alter_text'       => '#8F96A1', //ok +
					'alter_light'      => '#707680', //ok +
					'alter_dark'       => '#FDFDFD', //ok +
					'alter_link'       => '#0146FF', //ok +
					'alter_hover'      => '#003AD5', //ok +
					'alter_link2'      => '#31A6DB', //ok +
					'alter_hover2'     => '#238BBA', //ok +
					'alter_link3'      => '#62BDBA', //ok +
					'alter_hover3'     => '#51A5A2', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#050D15', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#2A2E36',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#5EC900', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#31A6DB', 
					'extra_hover2'     => '#238BBA', 
					'extra_link3'      => '#62BDBA', 
					'extra_hover3'     => '#51A5A2', 

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#262A2F', //ok +
					'input_bd_hover'   => '#343940', //ok +
					'input_text'       => '#8F96A1', //ok +
					'input_light'      => '#707680', //ok +
					'input_dark'       => '#FDFDFD', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FDFDFD', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#091625', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#091625', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
			// Color scheme: 'coldy_light'
			'coldy_light' => array(
				'title'    => esc_html__( 'Coldy Light', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#CFD8E0', //ok +

					// Text and links colors
					'text'             => '#5F686F', //ok +
					'text_light'       => '#86878B', //ok +
					'text_dark'        => '#091625', //ok +
					'text_link'        => '#0146FF', //ok +
					'text_hover'       => '#003AD5', //ok +
					'text_link2'       => '#31A6DB', //ok +
					'text_hover2'      => '#238BBA', //ok +
					'text_link3'       => '#62BDBA', //ok +
					'text_hover3'      => '#51A5A2', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F2F8FD', //ok +
					'alter_bg_hover'   => '#D5DFE8', //ok +
					'alter_bd_color'   => '#CFD8E0', //ok +
					'alter_bd_hover'   => '#B6C0C9', //ok +
					'alter_text'       => '#5F686F', //ok +
					'alter_light'      => '#86878B', //ok +
					'alter_dark'       => '#091625', //ok +
					'alter_link'       => '#0146FF', //ok +
					'alter_hover'      => '#003AD5', //ok +
					'alter_link2'      => '#31A6DB', //ok +
					'alter_hover2'     => '#238BBA', //ok +
					'alter_link3'      => '#62BDBA', //ok +
					'alter_hover3'     => '#51A5A2', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#050D15', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#0146FF', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#31A6DB',
					'extra_hover2'     => '#238BBA',
					'extra_link3'      => '#62BDBA',
					'extra_hover3'     => '#51A5A2',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#CFD8E0', //ok +
					'input_bd_hover'   => '#B6C0C9', //ok +
					'input_text'       => '#5F686F', //ok +
					'input_light'      => '#86878B', //ok +
					'input_dark'       => '#091625', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#091625', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#091625', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'greeny_default'
			'greeny_default' => array(
				'title'    => esc_html__( 'Greeny Default', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F3F4F4', //ok +
					'bd_color'         => '#DDDEE0', //ok +

					// Text and links colors
					'text'             => '#696969', //ok +
					'text_light'       => '#898989', //ok +
					'text_dark'        => '#191D22', //ok +
					'text_link'        => '#38A068', //ok +
					'text_hover'       => '#268050', //ok +
					'text_link2'       => '#346CB9', //ok +
					'text_hover2'      => '#24508E', //ok +
					'text_link3'       => '#223748', //ok +
					'text_hover3'      => '#14232F', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#E8EBEB', //ok +
					'alter_bd_color'   => '#DDDEE0', //ok +
					'alter_bd_hover'   => '#C7C9CC', //ok +
					'alter_text'       => '#696969', //ok +
					'alter_light'      => '#898989', //ok +
					'alter_dark'       => '#191D22', //ok +
					'alter_link'       => '#38A068', //ok +
					'alter_hover'      => '#268050', //ok +
					'alter_link2'      => '#346CB9', //ok +
					'alter_hover2'     => '#24508E', //ok +
					'alter_link3'      => '#223748', //ok +
					'alter_hover3'     => '#14232F', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#020202', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#8F96A1', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#38A068', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#346CB9',
					'extra_hover2'     => '#24508E',
					'extra_link3'      => '#223748',
					'extra_hover3'     => '#14232F',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#DDDEE0', //ok +
					'input_bd_hover'   => '#C7C9CC', //ok +
					'input_text'       => '#696969', //ok +
					'input_light'      => '#898989', //ok +
					'input_dark'       => '#191D22', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#191D22', //ok +
					'inverse_light'    => '#898989', //ok +
					'inverse_dark'     => '#191D22', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
			// Color scheme: 'greeny_dark'
			'greeny_dark'    => array(
				'title'    => esc_html__( 'Greeny Dark', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#13181D', //ok +
					'bd_color'         => '#262A2F', //ok +

					// Text and links colors
					'text'             => '#8F96A1', //ok +
					'text_light'       => '#707680', //ok +
					'text_dark'        => '#FDFDFD', //ok +
					'text_link'        => '#38A068', //ok +
					'text_hover'       => '#268050', //ok +
					'text_link2'       => '#346CB9', //ok +
					'text_hover2'      => '#24508E', //ok +
					'text_link3'       => '#223748', //ok +
					'text_hover3'      => '#14232F', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#06080A', //ok +
					'alter_bg_hover'   => '#282E35', //ok + 
					'alter_bd_color'   => '#262A2F', //ok +
					'alter_bd_hover'   => '#3C4248', //ok +
					'alter_text'       => '#8F96A1', //ok +
					'alter_light'      => '#707680', //ok +
					'alter_dark'       => '#FDFDFD', //ok +
					'alter_link'       => '#38A068', //ok +
					'alter_hover'      => '#268050', //ok +
					'alter_link2'      => '#346CB9', //ok +
					'alter_hover2'     => '#24508E', //ok +
					'alter_link3'      => '#223748', //ok +
					'alter_hover3'     => '#14232F', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#020202', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#2A2E36',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#8F96A1', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#38A068', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#346CB9', 
					'extra_hover2'     => '#24508E', 
					'extra_link3'      => '#223748', 
					'extra_hover3'     => '#14232F', 

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#262A2F', //ok +
					'input_bd_hover'   => '#3C4248', //ok +
					'input_text'       => '#8F96A1', //ok +
					'input_light'      => '#707680', //ok +
					'input_dark'       => '#FDFDFD', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FDFDFD', //ok +
					'inverse_light'    => '#898989', //ok +
					'inverse_dark'     => '#191D22', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#191D22', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),	
			// Color scheme: 'greeny_light'
			'greeny_light' => array(
				'title'    => esc_html__( 'Greeny Light', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#DDDEE0', //ok +

					// Text and links colors
					'text'             => '#696969', //ok +
					'text_light'       => '#898989', //ok +
					'text_dark'        => '#191D22', //ok +
					'text_link'        => '#38A068', //ok +
					'text_hover'       => '#268050', //ok +
					'text_link2'       => '#346CB9', //ok +
					'text_hover2'      => '#24508E', //ok +
					'text_link3'       => '#223748', //ok +
					'text_hover3'      => '#14232F', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F3F4F4', //ok +
					'alter_bg_hover'   => '#D8DBDB', //ok +
					'alter_bd_color'   => '#DDDEE0', //ok +
					'alter_bd_hover'   => '#C7C9CC', //ok +
					'alter_text'       => '#696969', //ok +
					'alter_light'      => '#898989', //ok +
					'alter_dark'       => '#191D22', //ok +
					'alter_link'       => '#38A068', //ok +
					'alter_hover'      => '#268050', //ok +
					'alter_link2'      => '#346CB9', //ok +
					'alter_hover2'     => '#24508E', //ok +
					'alter_link3'      => '#223748', //ok +
					'alter_hover3'     => '#14232F', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#020202', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#8F96A1', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#38A068', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#346CB9',
					'extra_hover2'     => '#24508E',
					'extra_link3'      => '#223748',
					'extra_hover3'     => '#14232F',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#DDDEE0', //ok +
					'input_bd_hover'   => '#C7C9CC', //ok +
					'input_text'       => '#696969', //ok +
					'input_light'      => '#898989', //ok +
					'input_dark'       => '#191D22', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#191D22', //ok +
					'inverse_light'    => '#898989', //ok +
					'inverse_dark'     => '#191D22', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'grassy_default'
			'grassy_default' => array(
				'title'    => esc_html__( 'Grassy Default', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F5F7F0', //ok +
					'bd_color'         => '#D8DDD0', //ok +

					// Text and links colors
					'text'             => '#5F625D', //ok +
					'text_light'       => '#898989', //ok +
					'text_dark'        => '#191D22', //ok +
					'text_link'        => '#38A068', //ok +
					'text_hover'       => '#268050', //ok +
					'text_link2'       => '#346CB9', //ok +
					'text_hover2'      => '#24508E', //ok +
					'text_link3'       => '#C0DD92', //ok +
					'text_hover3'      => '#AAC480', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#E7EAE1', //ok +
					'alter_bd_color'   => '#D8DDD0', //ok +
					'alter_bd_hover'   => '#C8CBC2', //ok +
					'alter_text'       => '#5F625D', //ok +
					'alter_light'      => '#898989', //ok +
					'alter_dark'       => '#191D22', //ok +
					'alter_link'       => '#38A068', //ok +
					'alter_hover'      => '#268050', //ok +
					'alter_link2'      => '#346CB9', //ok +
					'alter_hover2'     => '#24508E', //ok +
					'alter_link3'      => '#C0DD92', //ok +
					'alter_hover3'     => '#AAC480', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#020202', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#8F96A1', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#38A068', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#346CB9',
					'extra_hover2'     => '#24508E',
					'extra_link3'      => '#C0DD92',
					'extra_hover3'     => '#AAC480',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#D8DDD0', //ok +
					'input_bd_hover'   => '#C8CBC2', //ok +
					'input_text'       => '#5F625D', //ok +
					'input_light'      => '#898989', //ok +
					'input_dark'       => '#191D22', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#191D22', //ok +
					'inverse_light'    => '#898989', //ok +
					'inverse_dark'     => '#191D22', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'grassy_dark'
			'grassy_dark'    => array(
				'title'    => esc_html__( 'Grassy Dark', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#06080A', //ok +
					'bd_color'         => '#333940', //ok +

					// Text and links colors
					'text'             => '#8F96A1', //ok +
					'text_light'       => '#707680', //ok +
					'text_dark'        => '#FDFDFD', //ok +
					'text_link'        => '#38A068', //ok +
					'text_hover'       => '#268050', //ok +
					'text_link2'       => '#346CB9', //ok +
					'text_hover2'      => '#24508E', //ok +
					'text_link3'       => '#C0DD92', //ok +
					'text_hover3'      => '#AAC480', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#191F26', //ok +
					'alter_bg_hover'   => '#2A2E35', //ok +
					'alter_bd_color'   => '#333940', //ok +
					'alter_bd_hover'   => '#3F464E', //ok +
					'alter_text'       => '#8F96A1', //ok +
					'alter_light'      => '#707680', //ok +
					'alter_dark'       => '#FDFDFD', //ok +
					'alter_link'       => '#38A068', //ok +
					'alter_hover'      => '#268050', //ok +
					'alter_link2'      => '#346CB9', //ok +
					'alter_hover2'     => '#24508E', //ok +
					'alter_link3'      => '#C0DD92', //ok +
					'alter_hover3'     => '#AAC480', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#020202', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#2A2E36',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#8F96A1', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#38A068', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#346CB9', 
					'extra_hover2'     => '#24508E', 
					'extra_link3'      => '#C0DD92', 
					'extra_hover3'     => '#AAC480', 

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#333940', //ok +
					'input_bd_hover'   => '#3F464E', //ok +
					'input_text'       => '#8F96A1', //ok +
					'input_light'      => '#707680', //ok +
					'input_dark'       => '#FDFDFD', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FDFDFD', //ok +
					'inverse_light'    => '#898989', //ok +
					'inverse_dark'     => '#191D22', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#191D22', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'grassy_light'
			'grassy_light' => array(
				'title'    => esc_html__( 'Grassy Light', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#D8DDD0', //ok +

					// Text and links colors
					'text'             => '#5F625D', //ok +
					'text_light'       => '#898989', //ok +
					'text_dark'        => '#191D22', //ok +
					'text_link'        => '#38A068', //ok +
					'text_hover'       => '#268050', //ok +
					'text_link2'       => '#346CB9', //ok +
					'text_hover2'      => '#24508E', //ok +
					'text_link3'       => '#C0DD92', //ok +
					'text_hover3'      => '#AAC480', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F5F7F0', //ok +
					'alter_bg_hover'   => '#EBEEE7', //ok +
					'alter_bd_color'   => '#D8DDD0', //ok +
					'alter_bd_hover'   => '#C8CBC2', //ok +
					'alter_text'       => '#5F625D', //ok +
					'alter_light'      => '#898989', //ok +
					'alter_dark'       => '#191D22', //ok +
					'alter_link'       => '#38A068', //ok +
					'alter_hover'      => '#268050', //ok +
					'alter_link2'      => '#346CB9', //ok +
					'alter_hover2'     => '#24508E', //ok +
					'alter_link3'      => '#C0DD92', //ok +
					'alter_hover3'     => '#AAC480', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#020202', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#8F96A1', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#38A068', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#346CB9',
					'extra_hover2'     => '#24508E',
					'extra_link3'      => '#C0DD92',
					'extra_hover3'     => '#AAC480',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#D8DDD0', //ok +
					'input_bd_hover'   => '#C8CBC2', //ok +
					'input_text'       => '#5F625D', //ok +
					'input_light'      => '#898989', //ok +
					'input_dark'       => '#191D22', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#191D22', //ok +
					'inverse_light'    => '#898989', //ok +
					'inverse_dark'     => '#191D22', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'violet_default'
			'violet_default' => array(
				'title'    => esc_html__( 'Violet Default', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F4F8FA', //ok +
					'bd_color'         => '#D3DCE0', //ok +

					// Text and links colors
					'text'             => '#5A5A67', //ok +
					'text_light'       => '#898A8E', //ok +
					'text_dark'        => '#181D4E', //ok +
					'text_link'        => '#7569FF', //ok +
					'text_hover'       => '#5245EA', //ok +
					'text_link2'       => '#5FBAE7', //ok +
					'text_hover2'      => '#3C97C4', //ok +
					'text_link3'       => '#3AC97C', //ok +
					'text_hover3'      => '#2FA867', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#EAEFF2', //ok +
					'alter_bd_color'   => '#D3DCE0', //ok +
					'alter_bd_hover'   => '#B5BDC1', //ok +
					'alter_text'       => '#5A5A67', //ok +
					'alter_light'      => '#898A8E', //ok +
					'alter_dark'       => '#181D4E', //ok +
					'alter_link'       => '#7569FF', //ok +
					'alter_hover'      => '#5245EA', //ok +
					'alter_link2'      => '#5FBAE7', //ok +
					'alter_hover2'     => '#3C97C4', //ok +
					'alter_link3'      => '#3AC97C', //ok +
					'alter_hover3'     => '#2FA867', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#060117', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#9BA2AD', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#7569FF', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#5FBAE7',
					'extra_hover2'     => '#3C97C4',
					'extra_link3'      => '#3AC97C',
					'extra_hover3'     => '#2FA867',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#D3DCE0', //ok +
					'input_bd_hover'   => '#B5BDC1', //ok +
					'input_text'       => '#5A5A67', //ok +
					'input_light'      => '#898A8E', //ok +
					'input_dark'       => '#181D4E', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#181D4E', //ok +
					'inverse_light'    => '#898A8E', //ok +
					'inverse_dark'     => '#181D4E', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'violet_dark'
			'violet_dark'    => array(
				'title'    => esc_html__( 'Violet Dark', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#0A0321', //ok +
					'bd_color'         => '#2B253F', //ok +

					// Text and links colors
					'text'             => '#9BA2AD', //ok +
					'text_light'       => '#A3A7AD', //ok +
					'text_dark'        => '#FFFFFF', //ok +
					'text_link'        => '#7569FF', //ok +
					'text_hover'       => '#5245EA', //ok +
					'text_link2'       => '#5FBAE7', //ok +
					'text_hover2'      => '#3C97C4', //ok +
					'text_link3'       => '#3AC97C', //ok +
					'text_hover3'      => '#2FA867', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#13102B', //ok +
					'alter_bg_hover'   => '#1D1A36', //ok +
					'alter_bd_color'   => '#2B253F', //ok +
					'alter_bd_hover'   => '#4C475D', //ok +
					'alter_text'       => '#9BA2AD', //ok +
					'alter_light'      => '#A3A7AD', //ok +
					'alter_dark'       => '#FFFFFF', //ok +
					'alter_link'       => '#7569FF', //ok +
					'alter_hover'      => '#5245EA', //ok +
					'alter_link2'      => '#5FBAE7', //ok +
					'alter_hover2'     => '#3C97C4', //ok +
					'alter_link3'      => '#3AC97C', //ok +
					'alter_hover3'     => '#2FA867', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#060117', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#2A2E36',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#9BA2AD', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#7569FF', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#5FBAE7', 
					'extra_hover2'     => '#3C97C4', 
					'extra_link3'      => '#3AC97C', 
					'extra_hover3'     => '#2FA867', 

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#2B253F', //ok +
					'input_bd_hover'   => '#4C475D', //ok +
					'input_text'       => '#9BA2AD', //ok +
					'input_light'      => '#A3A7AD', //ok +
					'input_dark'       => '#FFFFFF', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FFFFFF', //ok +
					'inverse_light'    => '#898A8E', //ok +
					'inverse_dark'     => '#181D4E', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#181D4E', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'violet_light'
			'violet_light' => array(
				'title'    => esc_html__( 'Violet Light', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#D3DCE0', //ok +

					// Text and links colors
					'text'             => '#5A5A67', //ok +
					'text_light'       => '#898A8E', //ok +
					'text_dark'        => '#181D4E', //ok +
					'text_link'        => '#7569FF', //ok +
					'text_hover'       => '#5245EA', //ok +
					'text_link2'       => '#5FBAE7', //ok +
					'text_hover2'      => '#3C97C4', //ok +
					'text_link3'       => '#3AC97C', //ok +
					'text_hover3'      => '#2FA867', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F4F8FA', //ok +
					'alter_bg_hover'   => '#DDE2E6', //ok +
					'alter_bd_color'   => '#D3DCE0', //ok +
					'alter_bd_hover'   => '#B5BDC1', //ok +
					'alter_text'       => '#5A5A67', //ok +
					'alter_light'      => '#898A8E', //ok +
					'alter_dark'       => '#181D4E', //ok +
					'alter_link'       => '#7569FF', //ok +
					'alter_hover'      => '#5245EA', //ok +
					'alter_link2'      => '#5FBAE7', //ok +
					'alter_hover2'     => '#3C97C4', //ok +
					'alter_link3'      => '#3AC97C', //ok +
					'alter_hover3'     => '#2FA867', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#060117', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#9BA2AD', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#7569FF', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#5FBAE7',
					'extra_hover2'     => '#3C97C4',
					'extra_link3'      => '#3AC97C',
					'extra_hover3'     => '#2FA867',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#D3DCE0', //ok +
					'input_bd_hover'   => '#B5BDC1', //ok +
					'input_text'       => '#5A5A67', //ok +
					'input_light'      => '#898A8E', //ok +
					'input_dark'       => '#181D4E', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#181D4E', //ok +
					'inverse_light'    => '#898A8E', //ok +
					'inverse_dark'     => '#181D4E', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
			
			// Color scheme: 'indigo_default'
			'indigo_default' => array(
				'title'    => esc_html__( 'Indigo Default', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F4F8FA', //ok +
					'bd_color'         => '#D3DCE0', //ok +

					// Text and links colors
					'text'             => '#5A5A67', //ok +
					'text_light'       => '#898A8E', //ok +
					'text_dark'        => '#181D4E', //ok +
					'text_link'        => '#4C3AC9', //ok +
					'text_hover'       => '#35269F', //ok +
					'text_link2'       => '#3A98C9', //ok +
					'text_hover2'      => '#1A7CAF', //ok +
					'text_link3'       => '#3AC97C', //ok +
					'text_hover3'      => '#2FA867', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#EAEFF2', //ok +
					'alter_bd_color'   => '#D3DCE0', //ok +
					'alter_bd_hover'   => '#B5BDC1', //ok +
					'alter_text'       => '#5A5A67', //ok +
					'alter_light'      => '#898A8E', //ok +
					'alter_dark'       => '#181D4E', //ok +
					'alter_link'       => '#4C3AC9', //ok +
					'alter_hover'      => '#35269F', //ok +
					'alter_link2'      => '#3A98C9', //ok +
					'alter_hover2'     => '#1A7CAF', //ok +
					'alter_link3'      => '#3AC97C', //ok +
					'alter_hover3'     => '#2FA867', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1C22', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#9BA2AD', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#4C3AC9', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#3A98C9',
					'extra_hover2'     => '#1A7CAF',
					'extra_link3'      => '#3AC97C',
					'extra_hover3'     => '#2FA867',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#D3DCE0', //ok +
					'input_bd_hover'   => '#B5BDC1', //ok +
					'input_text'       => '#5A5A67', //ok +
					'input_light'      => '#898A8E', //ok +
					'input_dark'       => '#181D4E', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#181D4E', //ok +
					'inverse_light'    => '#898A8E', //ok +
					'inverse_dark'     => '#181D4E', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'indigo_dark'
			'indigo_dark'    => array(
				'title'    => esc_html__( 'Indigo Dark', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#21212B', //ok +
					'bd_color'         => '#383942', //ok +

					// Text and links colors
					'text'             => '#9BA2AD', //ok +
					'text_light'       => '#A3A7AD', //ok +
					'text_dark'        => '#FFFFFF', //ok +
					'text_link'        => '#4C3AC9', //ok +
					'text_hover'       => '#35269F', //ok +
					'text_link2'       => '#3A98C9', //ok +
					'text_hover2'      => '#1A7CAF', //ok +
					'text_link3'       => '#3AC97C', //ok +
					'text_hover3'      => '#2FA867', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#292933', //ok +
					'alter_bg_hover'   => '#22222B', //ok +
					'alter_bd_color'   => '#383942', //ok +
					'alter_bd_hover'   => '#454650', //ok +
					'alter_text'       => '#9BA2AD', //ok +
					'alter_light'      => '#A3A7AD', //ok +
					'alter_dark'       => '#FFFFFF', //ok +
					'alter_link'       => '#4C3AC9', //ok +
					'alter_hover'      => '#35269F', //ok +
					'alter_link2'      => '#3A98C9', //ok +
					'alter_hover2'     => '#1A7CAF', //ok +
					'alter_link3'      => '#3AC97C', //ok +
					'alter_hover3'     => '#2FA867', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1C22', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#2A2E36',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#9BA2AD', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#4C3AC9', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#3A98C9', 
					'extra_hover2'     => '#1A7CAF', 
					'extra_link3'      => '#3AC97C', 
					'extra_hover3'     => '#2FA867', 

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#383942', //ok +
					'input_bd_hover'   => '#454650', //ok +
					'input_text'       => '#9BA2AD', //ok +
					'input_light'      => '#A3A7AD', //ok +
					'input_dark'       => '#FFFFFF', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FFFFFF', //ok +
					'inverse_light'    => '#898A8E', //ok +
					'inverse_dark'     => '#181D4E', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#181D4E', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'indigo_light'
			'indigo_light' => array(
				'title'    => esc_html__( 'Indigo Light', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#D3DCE0', //ok +

					// Text and links colors
					'text'             => '#5A5A67', //ok +
					'text_light'       => '#898A8E', //ok +
					'text_dark'        => '#181D4E', //ok +
					'text_link'        => '#4C3AC9', //ok +
					'text_hover'       => '#35269F', //ok +
					'text_link2'       => '#3A98C9', //ok +
					'text_hover2'      => '#1A7CAF', //ok +
					'text_link3'       => '#3AC97C', //ok +
					'text_hover3'      => '#2FA867', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F4F8FA', //ok +
					'alter_bg_hover'   => '#D5DDE1', //ok +
					'alter_bd_color'   => '#D3DCE0', //ok +
					'alter_bd_hover'   => '#B5BDC1', //ok +
					'alter_text'       => '#5A5A67', //ok +
					'alter_light'      => '#898A8E', //ok +
					'alter_dark'       => '#181D4E', //ok +
					'alter_link'       => '#4C3AC9', //ok +
					'alter_hover'      => '#35269F', //ok +
					'alter_link2'      => '#3A98C9', //ok +
					'alter_hover2'     => '#1A7CAF', //ok +
					'alter_link3'      => '#3AC97C', //ok +
					'alter_hover3'     => '#2FA867', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1C22', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#9BA2AD', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#4C3AC9', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#3A98C9',
					'extra_hover2'     => '#1A7CAF',
					'extra_link3'      => '#3AC97C',
					'extra_hover3'     => '#2FA867',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#D3DCE0', //ok +
					'input_bd_hover'   => '#B5BDC1', //ok +
					'input_text'       => '#5A5A67', //ok +
					'input_light'      => '#898A8E', //ok +
					'input_dark'       => '#181D4E', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#181D4E', //ok +
					'inverse_light'    => '#898A8E', //ok +
					'inverse_dark'     => '#181D4E', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'azure_default'
			'azure_default' => array(
				'title'    => esc_html__( 'Azure Default', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F2F8FD', //ok +
					'bd_color'         => '#CDD9DE', //ok +

					// Text and links colors
					'text'             => '#60616C', //ok +
					'text_light'       => '#86878B', //ok +
					'text_dark'        => '#000662', //ok +
					'text_link'        => '#3468F0', //ok +
					'text_hover'       => '#2252D1', //ok +
					'text_link2'       => '#6E5CF7', //ok +
					'text_hover2'      => '#4F3DD5', //ok +
					'text_link3'       => '#74B8FF', //ok +
					'text_hover3'      => '#5BA1EB', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#E5EEF6', //ok +
					'alter_bd_color'   => '#CDD9DE', //ok +
					'alter_bd_hover'   => '#B8CAD2', //ok +
					'alter_text'       => '#60616C', //ok +
					'alter_light'      => '#86878B', //ok +
					'alter_dark'       => '#000662', //ok +
					'alter_link'       => '#3468F0', //ok +
					'alter_hover'      => '#2252D1', //ok +
					'alter_link2'      => '#6E5CF7', //ok +
					'alter_hover2'     => '#4F3DD5', //ok +
					'alter_link3'      => '#74B8FF', //ok +
					'alter_hover3'     => '#5BA1EB', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#3468F0', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#6E5CF7',
					'extra_hover2'     => '#4F3DD5',
					'extra_link3'      => '#74B8FF',
					'extra_hover3'     => '#5BA1EB',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#CDD9DE', //ok +
					'input_bd_hover'   => '#B8CAD2', //ok +
					'input_text'       => '#60616C', //ok +
					'input_light'      => '#86878B', //ok +
					'input_dark'       => '#000662', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#000662', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#000662', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'azure_dark'
			'azure_dark'    => array(
				'title'    => esc_html__( 'Azure Dark', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#050913', //ok +
					'bd_color'         => '#2A2E36', //ok +

					// Text and links colors
					'text'             => '#A9A7B0', //ok +
					'text_light'       => '#74727B', //ok +
					'text_dark'        => '#FDFDFD', //ok +
					'text_link'        => '#3468F0', //ok +
					'text_hover'       => '#2252D1', //ok +
					'text_link2'       => '#6E5CF7', //ok +
					'text_hover2'      => '#4F3DD5', //ok +
					'text_link3'       => '#74B8FF', //ok +
					'text_hover3'      => '#5BA1EB', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#0D111A', //ok +
					'alter_bg_hover'   => '#171A24', //ok +
					'alter_bd_color'   => '#2A2E36', //ok +
					'alter_bd_hover'   => '#3F424A', //ok +
					'alter_text'       => '#A9A7B0', //ok +
					'alter_light'      => '#74727B', //ok +
					'alter_dark'       => '#FDFDFD', //ok +
					'alter_link'       => '#3468F0', //ok +
					'alter_hover'      => '#2252D1', //ok +
					'alter_link2'      => '#6E5CF7', //ok +
					'alter_hover2'     => '#4F3DD5', //ok +
					'alter_link3'      => '#74B8FF', //ok +
					'alter_hover3'     => '#5BA1EB', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#2A2E36',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#3468F0', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#6E5CF7', 
					'extra_hover2'     => '#4F3DD5', 
					'extra_link3'      => '#74B8FF', 
					'extra_hover3'     => '#5BA1EB', 

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#2A2E36', //ok +
					'input_bd_hover'   => '#3F424A', //ok +
					'input_text'       => '#A9A7B0', //ok +
					'input_light'      => '#74727B', //ok +
					'input_dark'       => '#FDFDFD', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FDFDFD', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#000662', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#000662', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'azure_light'
			'azure_light' => array(
				'title'    => esc_html__( 'Azure Light', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#CDD9DE', //ok +

					// Text and links colors
					'text'             => '#60616C', //ok +
					'text_light'       => '#86878B', //ok +
					'text_dark'        => '#000662', //ok +
					'text_link'        => '#3468F0', //ok +
					'text_hover'       => '#2252D1', //ok +
					'text_link2'       => '#6E5CF7', //ok +
					'text_hover2'      => '#4F3DD5', //ok +
					'text_link3'       => '#74B8FF', //ok +
					'text_hover3'      => '#5BA1EB', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F2F8FD', //ok +
					'alter_bg_hover'   => '#D7E2EC', //ok +
					'alter_bd_color'   => '#CDD9DE', //ok +
					'alter_bd_hover'   => '#B8CAD2', //ok +
					'alter_text'       => '#60616C', //ok +
					'alter_light'      => '#86878B', //ok +
					'alter_dark'       => '#000662', //ok +
					'alter_link'       => '#3468F0', //ok +
					'alter_hover'      => '#2252D1', //ok +
					'alter_link2'      => '#6E5CF7', //ok +
					'alter_hover2'     => '#4F3DD5', //ok +
					'alter_link3'      => '#74B8FF', //ok +
					'alter_hover3'     => '#5BA1EB', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#3468F0', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#6E5CF7',
					'extra_hover2'     => '#4F3DD5',
					'extra_link3'      => '#74B8FF',
					'extra_hover3'     => '#5BA1EB',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#CDD9DE', //ok +
					'input_bd_hover'   => '#B8CAD2', //ok +
					'input_text'       => '#60616C', //ok +
					'input_light'      => '#86878B', //ok +
					'input_dark'       => '#000662', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#000662', //ok +
					'inverse_light'    => '#86878B', //ok +
					'inverse_dark'     => '#000662', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'orange_default'
			'orange_default' => array(
				'title'    => esc_html__( 'Orange Default', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F8F6F4', //ok +
					'bd_color'         => '#EBE8E5', //ok +

					// Text and links colors
					'text'             => '#757575', //ok +
					'text_light'       => '#9DA0A1', //ok +
					'text_dark'        => '#06131D', //ok +
					'text_link'        => '#EB5D3D', //ok +
					'text_hover'       => '#E3401B', //ok +
					'text_link2'       => '#A3CB53', //ok +
					'text_hover2'      => '#95BC47', //ok +
					'text_link3'       => '#71ABF9', //ok +
					'text_hover3'      => '#4C95F8', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#F1EEEC', //ok +
					'alter_bd_color'   => '#EBE8E5', //ok +
					'alter_bd_hover'   => '#DFDDDB', //ok +
					'alter_text'       => '#757575', //ok +
					'alter_light'      => '#9DA0A1', //ok +
					'alter_dark'       => '#06131D', //ok +
					'alter_link'       => '#EB5D3D', //ok +
					'alter_hover'      => '#E3401B', //ok +
					'alter_link2'      => '#A3CB53', //ok +
					'alter_hover2'     => '#95BC47', //ok +
					'alter_link3'      => '#71ABF9', //ok +
					'alter_hover3'     => '#4C95F8', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#EB5D3D', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#A3CB53',
					'extra_hover2'     => '#95BC47',
					'extra_link3'      => '#71ABF9',
					'extra_hover3'     => '#4C95F8',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#EBE8E5', //ok +
					'input_bd_hover'   => '#DFDDDB', //ok +
					'input_text'       => '#757575', //ok +
					'input_light'      => '#9DA0A1', //ok +
					'input_dark'       => '#06131D', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#06131D', //ok +
					'inverse_light'    => '#9DA0A1', //ok +
					'inverse_dark'     => '#06131D', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'orange_dark'
			'orange_dark'    => array(
				'title'    => esc_html__( 'Orange Dark', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#04060C', //ok +
					'bd_color'         => '#2A2E36', //ok +

					// Text and links colors
					'text'             => '#A9A7B0', //ok +
					'text_light'       => '#74727B', //ok +
					'text_dark'        => '#FFFFFF', //ok +
					'text_link'        => '#EB5D3D', //ok +
					'text_hover'       => '#E3401B', //ok +
					'text_link2'       => '#A3CB53', //ok +
					'text_hover2'      => '#95BC47', //ok +
					'text_link3'       => '#71ABF9', //ok +
					'text_hover3'      => '#4C95F8', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#0D111A', //ok +
					'alter_bg_hover'   => '#171A24', //ok +
					'alter_bd_color'   => '#2A2E36', //ok +
					'alter_bd_hover'   => '#3F424A', //ok +
					'alter_text'       => '#A9A7B0', //ok +
					'alter_light'      => '#74727B', //ok +
					'alter_dark'       => '#FFFFFF', //ok +
					'alter_link'       => '#EB5D3D', //ok +
					'alter_hover'      => '#E3401B', //ok +
					'alter_link2'      => '#A3CB53', //ok +
					'alter_hover2'     => '#95BC47', //ok +
					'alter_link3'      => '#71ABF9', //ok +
					'alter_hover3'     => '#4C95F8', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#2A2E36',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#EB5D3D', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#A3CB53', 
					'extra_hover2'     => '#95BC47', 
					'extra_link3'      => '#71ABF9', 
					'extra_hover3'     => '#4C95F8', 

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#2A2E36', //ok +
					'input_bd_hover'   => '#3F424A', //ok +
					'input_text'       => '#A9A7B0', //ok +
					'input_light'      => '#74727B', //ok +
					'input_dark'       => '#FFFFFF', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FFFFFF', //ok +
					'inverse_light'    => '#9DA0A1', //ok +
					'inverse_dark'     => '#06131D', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#06131D', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'orange_light'
			'orange_light' => array(
				'title'    => esc_html__( 'Orange Light', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#EBE8E5', //ok +

					// Text and links colors
					'text'             => '#757575', //ok +
					'text_light'       => '#9DA0A1', //ok +
					'text_dark'        => '#06131D', //ok +
					'text_link'        => '#EB5D3D', //ok +
					'text_hover'       => '#E3401B', //ok +
					'text_link2'       => '#A3CB53', //ok +
					'text_hover2'      => '#95BC47', //ok +
					'text_link3'       => '#71ABF9', //ok +
					'text_hover3'      => '#4C95F8', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F8F6F4', //ok +
					'alter_bg_hover'   => '#DBD9D8', //ok +
					'alter_bd_color'   => '#EBE8E5', //ok +
					'alter_bd_hover'   => '#DFDDDB', //ok +
					'alter_text'       => '#757575', //ok +
					'alter_light'      => '#9DA0A1', //ok +
					'alter_dark'       => '#06131D', //ok +
					'alter_link'       => '#EB5D3D', //ok +
					'alter_hover'      => '#E3401B', //ok +
					'alter_link2'      => '#A3CB53', //ok +
					'alter_hover2'     => '#95BC47', //ok +
					'alter_link3'      => '#71ABF9', //ok +
					'alter_hover3'     => '#4C95F8', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1C1F28', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#1D212B',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A9A7B0', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#EB5D3D', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#A3CB53',
					'extra_hover2'     => '#95BC47',
					'extra_link3'      => '#71ABF9',
					'extra_hover3'     => '#4C95F8',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#EBE8E5', //ok +
					'input_bd_hover'   => '#DFDDDB', //ok +
					'input_text'       => '#757575', //ok +
					'input_light'      => '#9DA0A1', //ok +
					'input_dark'       => '#06131D', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#06131D', //ok +
					'inverse_light'    => '#9DA0A1', //ok +
					'inverse_dark'     => '#06131D', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'royal_default'
			'royal_default' => array(
				'title'    => esc_html__( 'Royal Default', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F7FAFD', //ok +
					'bd_color'         => '#DEE7F0', //ok +

					// Text and links colors
					'text'             => '#5A566A', //ok +
					'text_light'       => '#807E8D', //ok +
					'text_dark'        => '#0F023C', //ok +
					'text_link'        => '#6040ED', //ok +
					'text_hover'       => '#3617CC', //ok +
					'text_link2'       => '#4096ED', //ok +
					'text_hover2'      => '#2882DD', //ok +
					'text_link3'       => '#1FA713', //ok +
					'text_hover3'      => '#118807', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#ECF4FC', //ok +
					'alter_bd_color'   => '#DEE7F0', //ok +
					'alter_bd_hover'   => '#CCD5DE', //ok +
					'alter_text'       => '#5A566A', //ok +
					'alter_light'      => '#807E8D', //ok +
					'alter_dark'       => '#0F023C', //ok +
					'alter_link'       => '#6040ED', //ok +
					'alter_hover'      => '#3617CC', //ok +
					'alter_link2'      => '#4096ED', //ok +
					'alter_hover2'     => '#2882DD', //ok +
					'alter_link3'      => '#1FA713', //ok +
					'alter_hover3'     => '#118807', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#08041A', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#3A344E',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A5A1B7', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#6040ED', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#4096ED',
					'extra_hover2'     => '#2882DD',
					'extra_link3'      => '#1FA713',
					'extra_hover3'     => '#118807',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#DEE7F0', //ok +
					'input_bd_hover'   => '#CCD5DE', //ok +
					'input_text'       => '#5A566A', //ok +
					'input_light'      => '#807E8D', //ok +
					'input_dark'       => '#0F023C', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#0F023C', //ok +
					'inverse_light'    => '#807E8D', //ok +
					'inverse_dark'     => '#0F023C', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'royal_dark'
			'royal_dark'    => array(
				'title'    => esc_html__( 'Royal Dark', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#070121', //ok +
					'bd_color'         => '#3A344E', //ok +

					// Text and links colors
					'text'             => '#9693A1', //ok +
					'text_light'       => '#6C687B', //ok +
					'text_dark'        => '#FFFFFF', //ok +
					'text_link'        => '#6040ED', //ok +
					'text_hover'       => '#3617CC', //ok +
					'text_link2'       => '#4096ED', //ok +
					'text_hover2'      => '#2882DD', //ok +
					'text_link3'       => '#1FA713', //ok +
					'text_hover3'      => '#118807', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#181130', //ok +
					'alter_bg_hover'   => '#251E3B', //ok +
					'alter_bd_color'   => '#3A344E', //ok +
					'alter_bd_hover'   => '#534E65', //ok +
					'alter_text'       => '#9693A1', //ok +
					'alter_light'      => '#6C687B', //ok +
					'alter_dark'       => '#FFFFFF', //ok +
					'alter_link'       => '#6040ED', //ok +
					'alter_hover'      => '#3617CC', //ok +
					'alter_link2'      => '#4096ED', //ok +
					'alter_hover2'     => '#2882DD', //ok +
					'alter_link3'      => '#1FA713', //ok +
					'alter_hover3'     => '#118807', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#08041A', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#2A2E36',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A5A1B7', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#6040ED', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#4096ED', 
					'extra_hover2'     => '#2882DD', 
					'extra_link3'      => '#1FA713', 
					'extra_hover3'     => '#118807', 

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#3A344E', //ok +
					'input_bd_hover'   => '#534E65', //ok +
					'input_text'       => '#9693A1', //ok +
					'input_light'      => '#6C687B', //ok +
					'input_dark'       => '#FFFFFF', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FFFFFF', //ok +
					'inverse_light'    => '#807E8D', //ok +
					'inverse_dark'     => '#0F023C', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#0F023C', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'royal_light'
			'royal_light' => array(
				'title'    => esc_html__( 'Royal Light', 'ann' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#DEE7F0', //ok +

					// Text and links colors
					'text'             => '#5A566A', //ok +
					'text_light'       => '#807E8D', //ok +
					'text_dark'        => '#0F023C', //ok +
					'text_link'        => '#6040ED', //ok +
					'text_hover'       => '#3617CC', //ok +
					'text_link2'       => '#4096ED', //ok +
					'text_hover2'      => '#2882DD', //ok +
					'text_link3'       => '#1FA713', //ok +
					'text_hover3'      => '#118807', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F7FAFD', //ok +
					'alter_bg_hover'   => '#E0E3E8', //ok +
					'alter_bd_color'   => '#DEE7F0', //ok +
					'alter_bd_hover'   => '#CCD5DE', //ok +
					'alter_text'       => '#5A566A', //ok +
					'alter_light'      => '#807E8D', //ok +
					'alter_dark'       => '#0F023C', //ok +
					'alter_link'       => '#6040ED', //ok +
					'alter_hover'      => '#3617CC', //ok +
					'alter_link2'      => '#4096ED', //ok +
					'alter_hover2'     => '#2882DD', //ok +
					'alter_link3'      => '#1FA713', //ok +
					'alter_hover3'     => '#118807', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#08041A', //ok +
					'extra_bg_hover'   => '#101521',
					'extra_bd_color'   => '#3A344E',
					'extra_bd_hover'   => '#333844',
					'extra_text'       => '#A5A1B7', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#6040ED', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#4096ED',
					'extra_hover2'     => '#2882DD',
					'extra_link3'      => '#1FA713',
					'extra_hover3'     => '#118807',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#DEE7F0', //ok +
					'input_bd_hover'   => '#CCD5DE', //ok +
					'input_text'       => '#5A566A', //ok +
					'input_light'      => '#807E8D', //ok +
					'input_dark'       => '#0F023C', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#0F023C', //ok +
					'inverse_light'    => '#807E8D', //ok +
					'inverse_dark'     => '#0F023C', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

		);
		ann_storage_set( 'schemes', $schemes );
		ann_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> ann_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'ann' ),
		//---> 	'description' => __( 'Description of the new color 1', 'ann' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		ann_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bg_hover_08' => array(
					'color' => 'alter_bg_hover',
					'alpha' => 0.8,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_dark_015'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.15,
                ),
                'alter_dark_02'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.2,
                ),
				'alter_dark_03'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.3,
                ),
                'alter_dark_05'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.5,
                ),
                'alter_dark_08'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.8,
                ),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_003'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.03,
                ),
                'text_dark_005'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.05,
                ),
                'text_dark_008'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.08,
                ),
				'text_dark_01'      => array(
					'color' => 'text_dark',
					'alpha' => 0.1,
				),
				'text_dark_015'      => array(
					'color' => 'text_dark',
					'alpha' => 0.15,
				),
				'text_dark_02'      => array(
					'color' => 'text_dark',
					'alpha' => 0.2,
				),
                'text_dark_03'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
                'text_link_007'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.07,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_03'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.3,
                ),
				'text_link_04'      => array(
					'color' => 'text_link',
					'alpha' => 0.4,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link2_08'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.8,
                ),
                'text_link2_007'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.07,
                ),
				'text_link2_02'      => array(
					'color' => 'text_link2',
					'alpha' => 0.2,
				),
                'text_link2_03'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.3,
                ),
				'text_link2_05'      => array(
					'color' => 'text_link2',
					'alpha' => 0.5,
				),
                'text_link3_007'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.07,
                ),
				'text_link3_02'      => array(
					'color' => 'text_link3',
					'alpha' => 0.2,
				),
                'text_link3_03'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.3,
                ),
                'inverse_text_03'      => array(
                    'color' => 'inverse_text',
                    'alpha' => 0.3,
                ),
                'inverse_link_08'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.8,
                ),
                'inverse_hover_08'      => array(
                    'color' => 'inverse_hover',
                    'alpha' => 0.8,
                ),
				'text_dark_blend'   => array(
					'color'      => 'text_dark',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		ann_storage_set(
			'schemes_simple', array(
				'text_link'        => array(),
				'text_hover'       => array(),
				'text_link2'       => array(),
				'text_hover2'      => array(),
				'text_link3'       => array(),
				'text_hover3'      => array(),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
			)
		);

		// Parameters to set order of schemes in the css
		ann_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		ann_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'ann' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	),
												'dark' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	)
												)
							),
				'green' => array(
								'title'  => esc_html__( 'Natural Green', 'ann' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	),
												'dark' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	)
												)
							),
			)
		);
	}
}
