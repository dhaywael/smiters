<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package ANN
 * @since ANN 1.71.0
 */

$ann_template_args = get_query_var( 'ann_template_args' );
if ( ! is_array( $ann_template_args ) ) {
	$ann_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$ann_columns       = 1;

$ann_expanded      = ! ann_sidebar_present() && ann_get_theme_option( 'expand_content' ) == 'expand';

$ann_post_format   = get_post_format();
$ann_post_format   = empty( $ann_post_format ) ? 'standard' : str_replace( 'post-format-', '', $ann_post_format );

if ( is_array( $ann_template_args ) ) {
	$ann_columns    = empty( $ann_template_args['columns'] ) ? 1 : max( 1, $ann_template_args['columns'] );
	$ann_blog_style = array( $ann_template_args['type'], $ann_columns );
	if ( ! empty( $ann_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $ann_columns > 1 ) {
	    $ann_columns_class = ann_get_column_class( 1, $ann_columns, ! empty( $ann_template_args['columns_tablet']) ? $ann_template_args['columns_tablet'] : '', ! empty($ann_template_args['columns_mobile']) ? $ann_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $ann_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $ann_post_format ) );
	ann_add_blog_animation( $ann_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$ann_hover      = ! empty( $ann_template_args['hover'] ) && ! ann_is_inherit( $ann_template_args['hover'] )
							? $ann_template_args['hover']
							: ann_get_theme_option( 'image_hover' );
	$ann_components = ! empty( $ann_template_args['meta_parts'] )
							? ( is_array( $ann_template_args['meta_parts'] )
								? $ann_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $ann_template_args['meta_parts'] ) )
								)
							: ann_array_get_keys_by_value( ann_get_theme_option( 'meta_parts' ) );
	ann_show_post_featured( apply_filters( 'ann_filter_args_featured',
		array(
			'no_links'   => ! empty( $ann_template_args['no_links'] ),
			'hover'      => $ann_hover,
			'meta_parts' => $ann_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $ann_template_args['thumb_size'] )
								? $ann_template_args['thumb_size']
								: ann_get_thumb_size( 
								in_array( $ann_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( ann_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $ann_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$ann_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$ann_show_title = get_the_title() != '';
		$ann_show_meta  = count( $ann_components ) > 0 && ! in_array( $ann_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $ann_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'ann_filter_show_blog_categories', $ann_show_meta && in_array( 'categories', $ann_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'ann_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						ann_show_post_meta( apply_filters(
															'ann_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $ann_hover, 1
															)
											);
						?>
					</div>
					<?php
					$ann_components = ann_array_delete_by_value( $ann_components, 'categories' );
					do_action( 'ann_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'ann_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'ann_action_before_post_title' );
					if ( empty( $ann_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'ann_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $ann_template_args['excerpt_length'] ) && ! in_array( $ann_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$ann_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'ann_filter_show_blog_excerpt', empty( $ann_template_args['hide_excerpt'] ) && ann_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				ann_show_post_content( $ann_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'ann_filter_show_blog_meta', $ann_show_meta, $ann_components, 'band' ) ) {
			if ( count( $ann_components ) > 0 ) {
				do_action( 'ann_action_before_post_meta' );
				ann_show_post_meta(
					apply_filters(
						'ann_filter_post_meta_args', array(
							'components' => join( ',', $ann_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'ann_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'ann_filter_show_blog_readmore', ! $ann_show_title || ! empty( $ann_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $ann_template_args['no_links'] ) ) {
				do_action( 'ann_action_before_post_readmore' );
				ann_show_post_more_link( $ann_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'ann_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $ann_template_args ) ) {
	if ( ! empty( $ann_template_args['slider'] ) || $ann_columns > 1 ) {
		?>
		</div>
		<?php
	}
}