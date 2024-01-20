<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package ANN
 * @since ANN 1.0
 */

$ann_args = get_query_var( 'ann_logo_args' );

// Site logo
$ann_logo_type   = isset( $ann_args['type'] ) ? $ann_args['type'] : '';
$ann_logo_image  = ann_get_logo_image( $ann_logo_type );
$ann_logo_text   = ann_is_on( ann_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$ann_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $ann_logo_image['logo'] ) || ! empty( $ann_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $ann_logo_image['logo'] ) ) {
			if ( empty( $ann_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($ann_logo_image['logo']) && (int) $ann_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$ann_attr = ann_getimagesize( $ann_logo_image['logo'] );
				echo '<img src="' . esc_url( $ann_logo_image['logo'] ) . '"'
						. ( ! empty( $ann_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $ann_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $ann_logo_text ) . '"'
						. ( ! empty( $ann_attr[3] ) ? ' ' . wp_kses_data( $ann_attr[3] ) : '' )
						. '>';
			}
		} else {
			ann_show_layout( ann_prepare_macros( $ann_logo_text ), '<span class="logo_text">', '</span>' );
			ann_show_layout( ann_prepare_macros( $ann_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
