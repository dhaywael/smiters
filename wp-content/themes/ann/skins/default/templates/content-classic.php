<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package ANN
 * @since ANN 1.0
 */

$ann_template_args = get_query_var( 'ann_template_args' );

if ( is_array( $ann_template_args ) ) {
	$ann_columns    = empty( $ann_template_args['columns'] ) ? 2 : max( 1, $ann_template_args['columns'] );
	$ann_blog_style = array( $ann_template_args['type'], $ann_columns );
    $ann_columns_class = ann_get_column_class( 1, $ann_columns, ! empty( $ann_template_args['columns_tablet']) ? $ann_template_args['columns_tablet'] : '', ! empty($ann_template_args['columns_mobile']) ? $ann_template_args['columns_mobile'] : '' );
} else {
	$ann_template_args = array();
	$ann_blog_style = explode( '_', ann_get_theme_option( 'blog_style' ) );
	$ann_columns    = empty( $ann_blog_style[1] ) ? 2 : max( 1, $ann_blog_style[1] );
    $ann_columns_class = ann_get_column_class( 1, $ann_columns );
}
$ann_expanded   = ! ann_sidebar_present() && ann_get_theme_option( 'expand_content' ) == 'expand';

$ann_post_format = get_post_format();
$ann_post_format = empty( $ann_post_format ) ? 'standard' : str_replace( 'post-format-', '', $ann_post_format );

?><div class="<?php
	if ( ! empty( $ann_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( ann_is_blog_style_use_masonry( $ann_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $ann_columns ) : esc_attr( $ann_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $ann_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $ann_columns )
				. ' post_layout_' . esc_attr( $ann_blog_style[0] )
				. ' post_layout_' . esc_attr( $ann_blog_style[0] ) . '_' . esc_attr( $ann_columns )
	);
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
								: explode( ',', $ann_template_args['meta_parts'] )
								)
							: ann_array_get_keys_by_value( ann_get_theme_option( 'meta_parts' ) );

	ann_show_post_featured( apply_filters( 'ann_filter_args_featured',
		array(
			'thumb_size' => ! empty( $ann_template_args['thumb_size'] )
				? $ann_template_args['thumb_size']
				: ann_get_thumb_size(
					'classic' == $ann_blog_style[0]
						? ( strpos( ann_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $ann_columns > 2 ? 'big' : 'huge' )
								: ( $ann_columns > 2
									? ( $ann_expanded ? 'square' : 'square' )
									: ($ann_columns > 1 ? 'square' : ( $ann_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( ann_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $ann_columns > 2 ? 'masonry-big' : 'full' )
								: ($ann_columns === 1 ? ( $ann_expanded ? 'huge' : 'big' ) : ( $ann_columns <= 2 && $ann_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $ann_hover,
			'meta_parts' => $ann_components,
			'no_links'   => ! empty( $ann_template_args['no_links'] ),
        ),
        'content-classic',
        $ann_template_args
    ) );

	// Title and post meta
	$ann_show_title = get_the_title() != '';
	$ann_show_meta  = count( $ann_components ) > 0 && ! in_array( $ann_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $ann_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'ann_filter_show_blog_meta', $ann_show_meta, $ann_components, 'classic' ) ) {
				if ( count( $ann_components ) > 0 ) {
					do_action( 'ann_action_before_post_meta' );
					ann_show_post_meta(
						apply_filters(
							'ann_filter_post_meta_args', array(
							'components' => join( ',', $ann_components ),
							'seo'        => false,
							'echo'       => true,
						), $ann_blog_style[0], $ann_columns
						)
					);
					do_action( 'ann_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'ann_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'ann_action_before_post_title' );
				if ( empty( $ann_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'ann_action_after_post_title' );
			}

			if( !in_array( $ann_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'ann_filter_show_blog_readmore', ! $ann_show_title || ! empty( $ann_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $ann_template_args['no_links'] ) ) {
						do_action( 'ann_action_before_post_readmore' );
						ann_show_post_more_link( $ann_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'ann_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $ann_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('ann_filter_show_blog_excerpt', empty($ann_template_args['hide_excerpt']) && ann_get_theme_option('excerpt_length') > 0, 'classic')) {
			ann_show_post_content($ann_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $ann_template_args['more_button'] )) {
			if ( empty( $ann_template_args['no_links'] ) ) {
				do_action( 'ann_action_before_post_readmore' );
				ann_show_post_more_link( $ann_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'ann_action_after_post_readmore' );
			}
		}
		$ann_content = ob_get_contents();
		ob_end_clean();
		ann_show_layout($ann_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
