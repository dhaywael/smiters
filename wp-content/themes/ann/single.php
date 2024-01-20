<?php
/**
 * The template to display single post
 *
 * @package ANN
 * @since ANN 1.0
 */

// Full post loading
$full_post_loading          = ann_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = ann_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = ann_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$ann_related_position   = ann_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$ann_posts_navigation   = ann_get_theme_option( 'posts_navigation' );
$ann_prev_post          = false;
$ann_prev_post_same_cat = ann_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( ann_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	ann_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'ann_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $ann_posts_navigation ) {
		$ann_prev_post = get_previous_post( $ann_prev_post_same_cat );  // Get post from same category
		if ( ! $ann_prev_post && $ann_prev_post_same_cat ) {
			$ann_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $ann_prev_post ) {
			$ann_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $ann_prev_post ) ) {
		ann_sc_layouts_showed( 'featured', false );
		ann_sc_layouts_showed( 'title', false );
		ann_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $ann_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'ann_filter_get_template_part', 'templates/content', 'single-' . ann_get_theme_option( 'single_style' ) ), 'single-' . ann_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $ann_related_position, 'inside' ) === 0 ) {
		$ann_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'ann_action_related_posts' );
		$ann_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $ann_related_content ) ) {
			$ann_related_position_inside = max( 0, min( 9, ann_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $ann_related_position_inside ) {
				$ann_related_position_inside = mt_rand( 1, 9 );
			}

			$ann_p_number         = 0;
			$ann_related_inserted = false;
			$ann_in_block         = false;
			$ann_content_start    = strpos( $ann_content, '<div class="post_content' );
			$ann_content_end      = strrpos( $ann_content, '</div>' );

			for ( $i = max( 0, $ann_content_start ); $i < min( strlen( $ann_content ) - 3, $ann_content_end ); $i++ ) {
				if ( $ann_content[ $i ] != '<' ) {
					continue;
				}
				if ( $ann_in_block ) {
					if ( strtolower( substr( $ann_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$ann_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $ann_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $ann_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$ann_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $ann_content[ $i + 1 ] && in_array( $ann_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$ann_p_number++;
					if ( $ann_related_position_inside == $ann_p_number ) {
						$ann_related_inserted = true;
						$ann_content = ( $i > 0 ? substr( $ann_content, 0, $i ) : '' )
											. $ann_related_content
											. substr( $ann_content, $i );
					}
				}
			}
			if ( ! $ann_related_inserted ) {
				if ( $ann_content_end > 0 ) {
					$ann_content = substr( $ann_content, 0, $ann_content_end ) . $ann_related_content . substr( $ann_content, $ann_content_end );
				} else {
					$ann_content .= $ann_related_content;
				}
			}
		}

		ann_show_layout( $ann_content );
	}

	// Comments
	do_action( 'ann_action_before_comments' );
	comments_template();
	do_action( 'ann_action_after_comments' );

	// Related posts
	if ( 'below_content' == $ann_related_position
		&& ( 'scroll' != $ann_posts_navigation || ann_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || ann_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'ann_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $ann_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $ann_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $ann_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $ann_prev_post ) ); ?>"
			<?php do_action( 'ann_action_nav_links_single_scroll_data', $ann_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
