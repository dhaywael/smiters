<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package ANN
 * @since ANN 1.0
 */

$ann_template_args = get_query_var( 'ann_template_args' );
$ann_columns = 1;
if ( is_array( $ann_template_args ) ) {
	$ann_columns    = empty( $ann_template_args['columns'] ) ? 1 : max( 1, $ann_template_args['columns'] );
	$ann_blog_style = array( $ann_template_args['type'], $ann_columns );
	if ( ! empty( $ann_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $ann_columns > 1 ) {
	    $ann_columns_class = ann_get_column_class( 1, $ann_columns, ! empty( $ann_template_args['columns_tablet']) ? $ann_template_args['columns_tablet'] : '', ! empty($ann_template_args['columns_mobile']) ? $ann_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $ann_columns_class ); ?>">
		<?php
	}
} else {
	$ann_template_args = array();
}
$ann_expanded    = ! ann_sidebar_present() && ann_get_theme_option( 'expand_content' ) == 'expand';
$ann_post_format = get_post_format();
$ann_post_format = empty( $ann_post_format ) ? 'standard' : str_replace( 'post-format-', '', $ann_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $ann_post_format ) );
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
			'thumb_size' => ! empty( $ann_template_args['thumb_size'] )
							? $ann_template_args['thumb_size']
							: ann_get_thumb_size( strpos( ann_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $ann_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$ann_template_args
	) );

	// Title and post meta
	$ann_show_title = get_the_title() != '';
	$ann_show_meta  = count( $ann_components ) > 0 && ! in_array( $ann_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $ann_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'ann_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'ann_action_before_post_title' );
				if ( empty( $ann_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'ann_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'ann_filter_show_blog_excerpt', empty( $ann_template_args['hide_excerpt'] ) && ann_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'ann_filter_show_blog_meta', $ann_show_meta, $ann_components, 'excerpt' ) ) {
				if ( count( $ann_components ) > 0 ) {
					do_action( 'ann_action_before_post_meta' );
					ann_show_post_meta(
						apply_filters(
							'ann_filter_post_meta_args', array(
								'components' => join( ',', $ann_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'ann_action_after_post_meta' );
				}
			}

			if ( ann_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'ann_action_before_full_post_content' );
					the_content( '' );
					do_action( 'ann_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'ann' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'ann' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				ann_show_post_content( $ann_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'ann_filter_show_blog_readmore',  ! isset( $ann_template_args['more_button'] ) || ! empty( $ann_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $ann_template_args['no_links'] ) ) {
					do_action( 'ann_action_before_post_readmore' );
					if ( ann_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						ann_show_post_more_link( $ann_template_args, '<p>', '</p>' );
					} else {
						ann_show_post_comments_link( $ann_template_args, '<p>', '</p>' );
					}
					do_action( 'ann_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $ann_template_args ) ) {
	if ( ! empty( $ann_template_args['slider'] ) || $ann_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
