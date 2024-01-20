<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'ann_memberships_get_css' ) ) {
	add_filter( 'ann_filter_get_css', 'ann_memberships_get_css', 10, 2 );
	function ann_memberships_get_css( $css, $args ) {
		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS

.pmpro_member_log_out a,	
.pmpro_btn, 
.pmpro_btn:link, 
.pmpro_content_message a, 
.pmpro_content_message a:link {
	{$fonts['button_font-family']}
 	{$fonts['button_font-size']} 
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}
.pmpro_actions_nav a,
.pmpro_actionlinks a#pmpro_actionlink-levels,
.pmpro_login_wrap #loginform label,
#pmpro_account .pmpro_box#pmpro_account-profile > p {
	{$fonts['h5_font-family']}
}
#pmpro_form .pmpro_checkout h2 span.pmpro_checkout-h2-msg {
	{$fonts['p_font-family']}
}


CSS;
		}

		return $css;
	}
}
