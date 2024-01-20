<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package ANN
 * @since ANN 1.0
 */

							do_action( 'ann_action_page_content_end_text' );
							
							// Widgets area below the content
							ann_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'ann_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'ann_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'ann_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'ann_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$ann_body_style = ann_get_theme_option( 'body_style' );
					$ann_widgets_name = ann_get_theme_option( 'widgets_below_page' );
					$ann_show_widgets = ! ann_is_off( $ann_widgets_name ) && is_active_sidebar( $ann_widgets_name );
					$ann_show_related = ann_is_single() && ann_get_theme_option( 'related_position' ) == 'below_page';
					if ( $ann_show_widgets || $ann_show_related ) {
						if ( 'fullscreen' != $ann_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $ann_show_related ) {
							do_action( 'ann_action_related_posts' );
						}

						// Widgets area below page content
						if ( $ann_show_widgets ) {
							ann_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $ann_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'ann_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'ann_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! ann_is_singular( 'post' ) && ! ann_is_singular( 'attachment' ) ) || ! in_array ( ann_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="ann_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'ann_action_before_footer' );

				// Footer
				$ann_footer_type = ann_get_theme_option( 'footer_type' );
				if ( 'custom' == $ann_footer_type && ! ann_is_layouts_available() ) {
					$ann_footer_type = 'default';
				}
				get_template_part( apply_filters( 'ann_filter_get_template_part', "templates/footer-" . sanitize_file_name( $ann_footer_type ) ) );

				do_action( 'ann_action_after_footer' );

			}
			?>

			<?php do_action( 'ann_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'ann_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'ann_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>