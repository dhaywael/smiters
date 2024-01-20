<?php
/**
 * The template to display the background video in the header
 *
 * @package ANN
 * @since ANN 1.0.14
 */
$ann_header_video = ann_get_header_video();
$ann_embed_video  = '';
if ( ! empty( $ann_header_video ) && ! ann_is_from_uploads( $ann_header_video ) ) {
	if ( ann_is_youtube_url( $ann_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $ann_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php ann_show_layout( ann_get_embed_video( $ann_header_video ) ); ?></div>
		<?php
	}
}
