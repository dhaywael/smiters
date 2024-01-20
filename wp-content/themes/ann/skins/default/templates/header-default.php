<?php
/**
 * The template to display default site header
 *
 * @package ANN
 * @since ANN 1.0
 */

$ann_header_css   = '';
$ann_header_image = get_header_image();
$ann_header_video = ann_get_header_video();
if ( ! empty( $ann_header_image ) && ann_trx_addons_featured_image_override( is_singular() || ann_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$ann_header_image = ann_get_current_mode_image( $ann_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $ann_header_image ) || ! empty( $ann_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $ann_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $ann_header_image ) {
		echo ' ' . esc_attr( ann_add_inline_css_class( 'background-image: url(' . esc_url( $ann_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( ann_is_on( ann_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight ann-full-height';
	}
	$ann_header_scheme = ann_get_theme_option( 'header_scheme' );
	if ( ! empty( $ann_header_scheme ) && ! ann_is_inherit( $ann_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $ann_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $ann_header_video ) ) {
		get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( ann_is_on( ann_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
