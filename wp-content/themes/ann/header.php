<?php
/**
 * The Header: Logo and main menu
 *
 * @package ANN
 * @since ANN 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( ann_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'ann_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'ann_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('ann_action_body_wrap_attributes'); ?>>

		<?php do_action( 'ann_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'ann_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('ann_action_page_wrap_attributes'); ?>>

			<?php do_action( 'ann_action_page_wrap_start' ); ?>

			<?php
			$ann_full_post_loading = ( ann_is_singular( 'post' ) || ann_is_singular( 'attachment' ) ) && ann_get_value_gp( 'action' ) == 'full_post_loading';
			$ann_prev_post_loading = ( ann_is_singular( 'post' ) || ann_is_singular( 'attachment' ) ) && ann_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $ann_full_post_loading && ! $ann_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="ann_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'ann_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'ann' ); ?></a>
				<?php if ( ann_sidebar_present() ) { ?>
				<a class="ann_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'ann_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'ann' ); ?></a>
				<?php } ?>
				<a class="ann_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'ann_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'ann' ); ?></a>

				<?php
				do_action( 'ann_action_before_header' );

				// Header
				$ann_header_type = ann_get_theme_option( 'header_type' );
				if ( 'custom' == $ann_header_type && ! ann_is_layouts_available() ) {
					$ann_header_type = 'default';
				}
				get_template_part( apply_filters( 'ann_filter_get_template_part', "templates/header-" . sanitize_file_name( $ann_header_type ) ) );

				// Side menu
				if ( in_array( ann_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'ann_action_after_header' );

			}
			?>

			<?php do_action( 'ann_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( ann_is_off( ann_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $ann_header_type ) ) {
						$ann_header_type = ann_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $ann_header_type && ann_is_layouts_available() ) {
						$ann_header_id = ann_get_custom_header_id();
						if ( $ann_header_id > 0 ) {
							$ann_header_meta = ann_get_custom_layout_meta( $ann_header_id );
							if ( ! empty( $ann_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$ann_footer_type = ann_get_theme_option( 'footer_type' );
					if ( 'custom' == $ann_footer_type && ann_is_layouts_available() ) {
						$ann_footer_id = ann_get_custom_footer_id();
						if ( $ann_footer_id ) {
							$ann_footer_meta = ann_get_custom_layout_meta( $ann_footer_id );
							if ( ! empty( $ann_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'ann_action_page_content_wrap_class', $ann_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'ann_filter_is_prev_post_loading', $ann_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( ann_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'ann_action_page_content_wrap_data', $ann_prev_post_loading );
			?>>
				<?php
				do_action( 'ann_action_page_content_wrap', $ann_full_post_loading || $ann_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'ann_filter_single_post_header', ann_is_singular( 'post' ) || ann_is_singular( 'attachment' ) ) ) {
					if ( $ann_prev_post_loading ) {
						if ( ann_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'ann_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$ann_path = apply_filters( 'ann_filter_get_template_part', 'templates/single-styles/' . ann_get_theme_option( 'single_style' ) );
					if ( ann_get_file_dir( $ann_path . '.php' ) != '' ) {
						get_template_part( $ann_path );
					}
				}

				// Widgets area above page
				$ann_body_style   = ann_get_theme_option( 'body_style' );
				$ann_widgets_name = ann_get_theme_option( 'widgets_above_page' );
				$ann_show_widgets = ! ann_is_off( $ann_widgets_name ) && is_active_sidebar( $ann_widgets_name );
				if ( $ann_show_widgets ) {
					if ( 'fullscreen' != $ann_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					ann_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $ann_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'ann_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $ann_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'ann_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'ann_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="ann_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( ann_is_singular( 'post' ) || ann_is_singular( 'attachment' ) )
							&& $ann_prev_post_loading 
							&& ann_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'ann_action_between_posts' );
						}

						// Widgets area above content
						ann_create_widgets_area( 'widgets_above_content' );

						do_action( 'ann_action_page_content_start_text' );
