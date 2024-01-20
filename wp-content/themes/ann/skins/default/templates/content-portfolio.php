<?php
/**
 * The Portfolio template to display the content
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

$ann_post_format = get_post_format();
$ann_post_format = empty( $ann_post_format ) ? 'standard' : str_replace( 'post-format-', '', $ann_post_format );

?><div class="
<?php
if ( ! empty( $ann_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( ann_is_blog_style_use_masonry( $ann_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $ann_columns ) : esc_attr( $ann_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $ann_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $ann_columns )
		. ( 'portfolio' != $ann_blog_style[0] ? ' ' . esc_attr( $ann_blog_style[0] )  . '_' . esc_attr( $ann_columns ) : '' )
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

	$ann_hover   = ! empty( $ann_template_args['hover'] ) && ! ann_is_inherit( $ann_template_args['hover'] )
								? $ann_template_args['hover']
								: ann_get_theme_option( 'image_hover' );

	if ( 'dots' == $ann_hover ) {
		$ann_post_link = empty( $ann_template_args['no_links'] )
								? ( ! empty( $ann_template_args['link'] )
									? $ann_template_args['link']
									: get_permalink()
									)
								: '';
		$ann_target    = ! empty( $ann_post_link ) && false === strpos( $ann_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$ann_components = ! empty( $ann_template_args['meta_parts'] )
							? ( is_array( $ann_template_args['meta_parts'] )
								? $ann_template_args['meta_parts']
								: explode( ',', $ann_template_args['meta_parts'] )
								)
							: ann_array_get_keys_by_value( ann_get_theme_option( 'meta_parts' ) );

	// Featured image
	ann_show_post_featured( apply_filters( 'ann_filter_args_featured',
        array(
			'hover'         => $ann_hover,
			'no_links'      => ! empty( $ann_template_args['no_links'] ),
			'thumb_size'    => ! empty( $ann_template_args['thumb_size'] )
								? $ann_template_args['thumb_size']
								: ann_get_thumb_size(
									ann_is_blog_style_use_masonry( $ann_blog_style[0] )
										? (	strpos( ann_get_theme_option( 'body_style' ), 'full' ) !== false || $ann_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( ann_get_theme_option( 'body_style' ), 'full' ) !== false || $ann_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => ann_is_blog_style_use_masonry( $ann_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $ann_components,
			'class'         => 'dots' == $ann_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $ann_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $ann_post_link )
												? '<a href="' . esc_url( $ann_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $ann_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $ann_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $ann_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!