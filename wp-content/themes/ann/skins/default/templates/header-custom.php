<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package ANN
 * @since ANN 1.0.06
 */

$ann_header_css   = '';
$ann_header_image = get_header_image();
$ann_header_video = ann_get_header_video();
if ( ! empty( $ann_header_image ) && ann_trx_addons_featured_image_override( is_singular() || ann_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$ann_header_image = ann_get_current_mode_image( $ann_header_image );
}

$ann_header_id = ann_get_custom_header_id();
$ann_header_meta = get_post_meta( $ann_header_id, 'trx_addons_options', true );
if ( ! empty( $ann_header_meta['margin'] ) ) {
	ann_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( ann_prepare_css_value( $ann_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $ann_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $ann_header_id ) ) ); ?>
				<?php
				echo ! empty( $ann_header_image ) || ! empty( $ann_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
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

	// Custom header's layout
	do_action( 'ann_action_show_layout', $ann_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
