<div class="front_page_section front_page_section_about<?php
	$ann_scheme = ann_get_theme_option( 'front_page_about_scheme' );
	if ( ! empty( $ann_scheme ) && ! ann_is_inherit( $ann_scheme ) ) {
		echo ' scheme_' . esc_attr( $ann_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( ann_get_theme_option( 'front_page_about_paddings' ) );
	if ( ann_get_theme_option( 'front_page_about_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$ann_css      = '';
		$ann_bg_image = ann_get_theme_option( 'front_page_about_bg_image' );
		if ( ! empty( $ann_bg_image ) ) {
			$ann_css .= 'background-image: url(' . esc_url( ann_get_attachment_url( $ann_bg_image ) ) . ');';
		}
		if ( ! empty( $ann_css ) ) {
			echo ' style="' . esc_attr( $ann_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$ann_anchor_icon = ann_get_theme_option( 'front_page_about_anchor_icon' );
	$ann_anchor_text = ann_get_theme_option( 'front_page_about_anchor_text' );
if ( ( ! empty( $ann_anchor_icon ) || ! empty( $ann_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_about"'
									. ( ! empty( $ann_anchor_icon ) ? ' icon="' . esc_attr( $ann_anchor_icon ) . '"' : '' )
									. ( ! empty( $ann_anchor_text ) ? ' title="' . esc_attr( $ann_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_about_inner
	<?php
	if ( ann_get_theme_option( 'front_page_about_fullheight' ) ) {
		echo ' ann-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$ann_css           = '';
			$ann_bg_mask       = ann_get_theme_option( 'front_page_about_bg_mask' );
			$ann_bg_color_type = ann_get_theme_option( 'front_page_about_bg_color_type' );
			if ( 'custom' == $ann_bg_color_type ) {
				$ann_bg_color = ann_get_theme_option( 'front_page_about_bg_color' );
			} elseif ( 'scheme_bg_color' == $ann_bg_color_type ) {
				$ann_bg_color = ann_get_scheme_color( 'bg_color', $ann_scheme );
			} else {
				$ann_bg_color = '';
			}
			if ( ! empty( $ann_bg_color ) && $ann_bg_mask > 0 ) {
				$ann_css .= 'background-color: ' . esc_attr(
					1 == $ann_bg_mask ? $ann_bg_color : ann_hex2rgba( $ann_bg_color, $ann_bg_mask )
				) . ';';
			}
			if ( ! empty( $ann_css ) ) {
				echo ' style="' . esc_attr( $ann_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$ann_caption = ann_get_theme_option( 'front_page_about_caption' );
			if ( ! empty( $ann_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo ! empty( $ann_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $ann_caption, 'ann_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$ann_description = ann_get_theme_option( 'front_page_about_description' );
			if ( ! empty( $ann_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo ! empty( $ann_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $ann_description ), 'ann_kses_content' ); ?></div>
				<?php
			}

			// Content
			$ann_content = ann_get_theme_option( 'front_page_about_content' );
			if ( ! empty( $ann_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo ! empty( $ann_content ) ? 'filled' : 'empty'; ?>">
					<?php
					$ann_page_content_mask = '%%CONTENT%%';
					if ( strpos( $ann_content, $ann_page_content_mask ) !== false ) {
						$ann_content = preg_replace(
							'/(\<p\>\s*)?' . $ann_page_content_mask . '(\s*\<\/p\>)/i',
							sprintf(
								'<div class="front_page_section_about_source">%s</div>',
								apply_filters( 'the_content', get_the_content() )
							),
							$ann_content
						);
					}
					ann_show_layout( $ann_content );
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
