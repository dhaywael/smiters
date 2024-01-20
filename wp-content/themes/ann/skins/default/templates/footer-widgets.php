<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package ANN
 * @since ANN 1.0.10
 */

// Footer sidebar
$ann_footer_name    = ann_get_theme_option( 'footer_widgets' );
$ann_footer_present = ! ann_is_off( $ann_footer_name ) && is_active_sidebar( $ann_footer_name );
if ( $ann_footer_present ) {
	ann_storage_set( 'current_sidebar', 'footer' );
	$ann_footer_wide = ann_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $ann_footer_name ) ) {
		dynamic_sidebar( $ann_footer_name );
	}
	$ann_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $ann_out ) ) {
		$ann_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $ann_out );
		$ann_need_columns = true;   //or check: strpos($ann_out, 'columns_wrap')===false;
		if ( $ann_need_columns ) {
			$ann_columns = max( 0, (int) ann_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $ann_columns ) {
				$ann_columns = min( 4, max( 1, ann_tags_count( $ann_out, 'aside' ) ) );
			}
			if ( $ann_columns > 1 ) {
				$ann_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $ann_columns ) . ' widget', $ann_out );
			} else {
				$ann_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $ann_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'ann_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $ann_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $ann_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'ann_action_before_sidebar', 'footer' );
				ann_show_layout( $ann_out );
				do_action( 'ann_action_after_sidebar', 'footer' );
				if ( $ann_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $ann_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'ann_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
