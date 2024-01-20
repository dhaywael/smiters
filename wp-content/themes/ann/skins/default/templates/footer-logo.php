<?php
/**
 * The template to display the site logo in the footer
 *
 * @package ANN
 * @since ANN 1.0.10
 */

// Logo
if ( ann_is_on( ann_get_theme_option( 'logo_in_footer' ) ) ) {
	$ann_logo_image = ann_get_logo_image( 'footer' );
	$ann_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $ann_logo_image['logo'] ) || ! empty( $ann_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $ann_logo_image['logo'] ) ) {
					$ann_attr = ann_getimagesize( $ann_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $ann_logo_image['logo'] ) . '"'
								. ( ! empty( $ann_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $ann_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'ann' ) . '"'
								. ( ! empty( $ann_attr[3] ) ? ' ' . wp_kses_data( $ann_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $ann_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $ann_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
