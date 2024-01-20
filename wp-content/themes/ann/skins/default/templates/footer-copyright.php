<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package ANN
 * @since ANN 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$ann_copyright_scheme = ann_get_theme_option( 'copyright_scheme' );
if ( ! empty( $ann_copyright_scheme ) && ! ann_is_inherit( $ann_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $ann_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$ann_copyright = ann_get_theme_option( 'copyright' );
			if ( ! empty( $ann_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$ann_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $ann_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$ann_copyright = ann_prepare_macros( $ann_copyright );
				// Display copyright
				echo wp_kses( nl2br( $ann_copyright ), 'ann_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
