<?php
/**
 * The template to display the socials in the footer
 *
 * @package ANN
 * @since ANN 1.0.10
 */


// Socials
if ( ann_is_on( ann_get_theme_option( 'socials_in_footer' ) ) ) {
	$ann_output = ann_get_socials_links();
	if ( '' != $ann_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php ann_show_layout( $ann_output ); ?>
			</div>
		</div>
		<?php
	}
}
