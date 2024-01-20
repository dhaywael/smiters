<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package ANN
 * @since ANN 1.0
 */

// Page (category, tag, archive, author) title

if ( ann_need_page_title() ) {
	ann_sc_layouts_showed( 'title', true );
	ann_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								ann_show_post_meta(
									apply_filters(
										'ann_filter_post_meta_args', array(
											'components' => join( ',', ann_array_get_keys_by_value( ann_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', ann_array_get_keys_by_value( ann_get_theme_option( 'counters' ) ) ),
											'seo'        => ann_is_on( ann_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$ann_blog_title           = ann_get_blog_title();
							$ann_blog_title_text      = '';
							$ann_blog_title_class     = '';
							$ann_blog_title_link      = '';
							$ann_blog_title_link_text = '';
							if ( is_array( $ann_blog_title ) ) {
								$ann_blog_title_text      = $ann_blog_title['text'];
								$ann_blog_title_class     = ! empty( $ann_blog_title['class'] ) ? ' ' . $ann_blog_title['class'] : '';
								$ann_blog_title_link      = ! empty( $ann_blog_title['link'] ) ? $ann_blog_title['link'] : '';
								$ann_blog_title_link_text = ! empty( $ann_blog_title['link_text'] ) ? $ann_blog_title['link_text'] : '';
							} else {
								$ann_blog_title_text = $ann_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $ann_blog_title_class ); ?>">
								<?php
								$ann_top_icon = ann_get_term_image_small();
								if ( ! empty( $ann_top_icon ) ) {
									$ann_attr = ann_getimagesize( $ann_top_icon );
									?>
									<img src="<?php echo esc_url( $ann_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'ann' ); ?>"
										<?php
										if ( ! empty( $ann_attr[3] ) ) {
											ann_show_layout( $ann_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $ann_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $ann_blog_title_link ) && ! empty( $ann_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $ann_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $ann_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'ann_action_breadcrumbs' );
						$ann_breadcrumbs = ob_get_contents();
						ob_end_clean();
						ann_show_layout( $ann_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
