<?php
/**
 * The template to display default site footer
 *
 * @package ANN
 * @since ANN 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$ann_footer_scheme = ann_get_theme_option( 'footer_scheme' );
if ( ! empty( $ann_footer_scheme ) && ! ann_is_inherit( $ann_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $ann_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
