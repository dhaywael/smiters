<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package ANN
 * @since ANN 1.0.50
 */

$ann_template_args = get_query_var( 'ann_template_args' );
if ( is_array( $ann_template_args ) ) {
	$ann_columns    = empty( $ann_template_args['columns'] ) ? 2 : max( 1, $ann_template_args['columns'] );
	$ann_blog_style = array( $ann_template_args['type'], $ann_columns );
} else {
	$ann_template_args = array();
	$ann_blog_style = explode( '_', ann_get_theme_option( 'blog_style' ) );
	$ann_columns    = empty( $ann_blog_style[1] ) ? 2 : max( 1, $ann_blog_style[1] );
}
$ann_blog_id       = ann_get_custom_blog_id( join( '_', $ann_blog_style ) );
$ann_blog_style[0] = str_replace( 'blog-custom-', '', $ann_blog_style[0] );
$ann_expanded      = ! ann_sidebar_present() && ann_get_theme_option( 'expand_content' ) == 'expand';
$ann_components    = ! empty( $ann_template_args['meta_parts'] )
							? ( is_array( $ann_template_args['meta_parts'] )
								? join( ',', $ann_template_args['meta_parts'] )
								: $ann_template_args['meta_parts']
								)
							: ann_array_get_keys_by_value( ann_get_theme_option( 'meta_parts' ) );
$ann_post_format   = get_post_format();
$ann_post_format   = empty( $ann_post_format ) ? 'standard' : str_replace( 'post-format-', '', $ann_post_format );

$ann_blog_meta     = ann_get_custom_layout_meta( $ann_blog_id );
$ann_custom_style  = ! empty( $ann_blog_meta['scripts_required'] ) ? $ann_blog_meta['scripts_required'] : 'none';

if ( ! empty( $ann_template_args['slider'] ) || $ann_columns > 1 || ! ann_is_off( $ann_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $ann_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( ann_is_off( $ann_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $ann_custom_style ) ) . "-1_{$ann_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $ann_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $ann_columns )
					. ' post_layout_' . esc_attr( $ann_blog_style[0] )
					. ' post_layout_' . esc_attr( $ann_blog_style[0] ) . '_' . esc_attr( $ann_columns )
					. ( ! ann_is_off( $ann_custom_style )
						? ' post_layout_' . esc_attr( $ann_custom_style )
							. ' post_layout_' . esc_attr( $ann_custom_style ) . '_' . esc_attr( $ann_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'ann_action_show_layout', $ann_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $ann_template_args['slider'] ) || $ann_columns > 1 || ! ann_is_off( $ann_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
