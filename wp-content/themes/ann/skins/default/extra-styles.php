<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'ann_extra_styles_get_css' ) ) {
	add_filter( 'ann_filter_get_css', 'ann_extra_styles_get_css', 10, 2 );
	function ann_extra_styles_get_css( $css, $args ) {
		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS
			
		
.trx_addons_bg_text.trx_addons_marquee_wrap .trx_addons_marquee_element .trx_addons_bg_text_char {
	{$fonts['h1_font-family']}
}
.plug_wrap .plug_button {
	{$fonts['button_font-family']}
}

CSS;
		}

		return $css;
	}
}

