<?php
/**
 * The template to display default site footer
 *
 * @package ANN
 * @since ANN 1.0.10
 */

$ann_footer_id = ann_get_custom_footer_id();
$ann_footer_meta = get_post_meta( $ann_footer_id, 'trx_addons_options', true );
if ( ! empty( $ann_footer_meta['margin'] ) ) {
	ann_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( ann_prepare_css_value( $ann_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $ann_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $ann_footer_id ) ) ); ?>
						<?php
						$ann_footer_scheme = ann_get_theme_option( 'footer_scheme' );
						if ( ! empty( $ann_footer_scheme ) && ! ann_is_inherit( $ann_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $ann_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'ann_action_show_layout', $ann_footer_id );
	?>
</footer><!-- /.footer_wrap -->
