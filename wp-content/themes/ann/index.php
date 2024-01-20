<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package ANN
 * @since ANN 1.0
 */

$ann_template = apply_filters( 'ann_filter_get_template_part', ann_blog_archive_get_template() );

if ( ! empty( $ann_template ) && 'index' != $ann_template ) {

	get_template_part( $ann_template );

} else {

	ann_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$ann_stickies   = is_home()
								|| ( in_array( ann_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) ann_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$ann_post_type  = ann_get_theme_option( 'post_type' );
		$ann_args       = array(
								'blog_style'     => ann_get_theme_option( 'blog_style' ),
								'post_type'      => $ann_post_type,
								'taxonomy'       => ann_get_post_type_taxonomy( $ann_post_type ),
								'parent_cat'     => ann_get_theme_option( 'parent_cat' ),
								'posts_per_page' => ann_get_theme_option( 'posts_per_page' ),
								'sticky'         => ann_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $ann_stickies )
															&& count( $ann_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		ann_blog_archive_start();

		do_action( 'ann_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'ann_action_before_page_author' );
			get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'ann_action_after_page_author' );
		}

		if ( ann_get_theme_option( 'show_filters' ) ) {
			do_action( 'ann_action_before_page_filters' );
			ann_show_filters( $ann_args );
			do_action( 'ann_action_after_page_filters' );
		} else {
			do_action( 'ann_action_before_page_posts' );
			ann_show_posts( array_merge( $ann_args, array( 'cat' => $ann_args['parent_cat'] ) ) );
			do_action( 'ann_action_after_page_posts' );
		}

		do_action( 'ann_action_blog_archive_end' );

		ann_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
