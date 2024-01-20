<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ANN
 * @since ANN 1.0
 */

if ( ann_sidebar_present() ) {
	
	$ann_sidebar_type = ann_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $ann_sidebar_type && ! ann_is_layouts_available() ) {
		$ann_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $ann_sidebar_type ) {
		// Default sidebar with widgets
		$ann_sidebar_name = ann_get_theme_option( 'sidebar_widgets' );
		ann_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $ann_sidebar_name ) ) {
			dynamic_sidebar( $ann_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$ann_sidebar_id = ann_get_custom_sidebar_id();
		do_action( 'ann_action_show_layout', $ann_sidebar_id );
	}
	$ann_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $ann_out ) ) {
		$ann_sidebar_position    = ann_get_theme_option( 'sidebar_position' );
		$ann_sidebar_position_ss = ann_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $ann_sidebar_position );
			echo ' sidebar_' . esc_attr( $ann_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $ann_sidebar_type );

			$ann_sidebar_scheme = apply_filters( 'ann_filter_sidebar_scheme', ann_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $ann_sidebar_scheme ) && ! ann_is_inherit( $ann_sidebar_scheme ) && 'custom' != $ann_sidebar_type ) {
				echo ' scheme_' . esc_attr( $ann_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="ann_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'ann_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $ann_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$ann_title = apply_filters( 'ann_filter_sidebar_control_title', 'float' == $ann_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'ann' ) : '' );
				$ann_text  = apply_filters( 'ann_filter_sidebar_control_text', 'above' == $ann_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'ann' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $ann_title ); ?>"><?php echo esc_html( $ann_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'ann_action_before_sidebar', 'sidebar' );
				ann_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $ann_out ) );
				do_action( 'ann_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'ann_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
