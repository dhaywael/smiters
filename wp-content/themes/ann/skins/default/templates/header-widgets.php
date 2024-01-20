<?php
/**
 * The template to display the widgets area in the header
 *
 * @package ANN
 * @since ANN 1.0
 */

// Header sidebar
$ann_header_name    = ann_get_theme_option( 'header_widgets' );
$ann_header_present = ! ann_is_off( $ann_header_name ) && is_active_sidebar( $ann_header_name );
if ( $ann_header_present ) {
	ann_storage_set( 'current_sidebar', 'header' );
	$ann_header_wide = ann_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $ann_header_name ) ) {
		dynamic_sidebar( $ann_header_name );
	}
	$ann_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $ann_widgets_output ) ) {
		$ann_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $ann_widgets_output );
		$ann_need_columns   = strpos( $ann_widgets_output, 'columns_wrap' ) === false;
		if ( $ann_need_columns ) {
			$ann_columns = max( 0, (int) ann_get_theme_option( 'header_columns' ) );
			if ( 0 == $ann_columns ) {
				$ann_columns = min( 6, max( 1, ann_tags_count( $ann_widgets_output, 'aside' ) ) );
			}
			if ( $ann_columns > 1 ) {
				$ann_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $ann_columns ) . ' widget', $ann_widgets_output );
			} else {
				$ann_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $ann_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'ann_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $ann_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $ann_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'ann_action_before_sidebar', 'header' );
				ann_show_layout( $ann_widgets_output );
				do_action( 'ann_action_after_sidebar', 'header' );
				if ( $ann_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $ann_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'ann_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
