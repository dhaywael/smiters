<div class="front_page_section front_page_section_testimonials<?php
	$ann_scheme = ann_get_theme_option( 'front_page_testimonials_scheme' );
	if ( ! empty( $ann_scheme ) && ! ann_is_inherit( $ann_scheme ) ) {
		echo ' scheme_' . esc_attr( $ann_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( ann_get_theme_option( 'front_page_testimonials_paddings' ) );
	if ( ann_get_theme_option( 'front_page_testimonials_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$ann_css      = '';
		$ann_bg_image = ann_get_theme_option( 'front_page_testimonials_bg_image' );
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
	$ann_anchor_icon = ann_get_theme_option( 'front_page_testimonials_anchor_icon' );
	$ann_anchor_text = ann_get_theme_option( 'front_page_testimonials_anchor_text' );
if ( ( ! empty( $ann_anchor_icon ) || ! empty( $ann_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_testimonials"'
									. ( ! empty( $ann_anchor_icon ) ? ' icon="' . esc_attr( $ann_anchor_icon ) . '"' : '' )
									. ( ! empty( $ann_anchor_text ) ? ' title="' . esc_attr( $ann_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_testimonials_inner
	<?php
	if ( ann_get_theme_option( 'front_page_testimonials_fullheight' ) ) {
		echo ' ann-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$ann_css      = '';
			$ann_bg_mask  = ann_get_theme_option( 'front_page_testimonials_bg_mask' );
			$ann_bg_color_type = ann_get_theme_option( 'front_page_testimonials_bg_color_type' );
			if ( 'custom' == $ann_bg_color_type ) {
				$ann_bg_color = ann_get_theme_option( 'front_page_testimonials_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_testimonials_content_wrap content_wrap">
			<?php
			// Caption
			$ann_caption = ann_get_theme_option( 'front_page_testimonials_caption' );
			if ( ! empty( $ann_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_testimonials_caption front_page_block_<?php echo ! empty( $ann_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $ann_caption, 'ann_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$ann_description = ann_get_theme_option( 'front_page_testimonials_description' );
			if ( ! empty( $ann_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_testimonials_description front_page_block_<?php echo ! empty( $ann_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $ann_description ), 'ann_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_testimonials_output">
				<?php
				if ( is_active_sidebar( 'front_page_testimonials_widgets' ) ) {
					dynamic_sidebar( 'front_page_testimonials_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! ann_exists_trx_addons() ) {
						ann_customizer_need_trx_addons_message();
					} else {
						ann_customizer_need_widgets_message( 'front_page_testimonials_caption', 'ThemeREX Addons - Testimonials' );
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
