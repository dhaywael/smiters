<div class="front_page_section front_page_section_contacts<?php
	$ann_scheme = ann_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $ann_scheme ) && ! ann_is_inherit( $ann_scheme ) ) {
		echo ' scheme_' . esc_attr( $ann_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( ann_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( ann_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$ann_css      = '';
		$ann_bg_image = ann_get_theme_option( 'front_page_contacts_bg_image' );
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
	$ann_anchor_icon = ann_get_theme_option( 'front_page_contacts_anchor_icon' );
	$ann_anchor_text = ann_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $ann_anchor_icon ) || ! empty( $ann_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $ann_anchor_icon ) ? ' icon="' . esc_attr( $ann_anchor_icon ) . '"' : '' )
									. ( ! empty( $ann_anchor_text ) ? ' title="' . esc_attr( $ann_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( ann_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' ann-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$ann_css      = '';
			$ann_bg_mask  = ann_get_theme_option( 'front_page_contacts_bg_mask' );
			$ann_bg_color_type = ann_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $ann_bg_color_type ) {
				$ann_bg_color = ann_get_theme_option( 'front_page_contacts_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$ann_caption     = ann_get_theme_option( 'front_page_contacts_caption' );
			$ann_description = ann_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $ann_caption ) || ! empty( $ann_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $ann_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $ann_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $ann_caption, 'ann_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $ann_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $ann_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $ann_description ), 'ann_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$ann_content = ann_get_theme_option( 'front_page_contacts_content' );
			$ann_layout  = ann_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $ann_layout && ( ! empty( $ann_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $ann_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $ann_content ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $ann_content, 'ann_kses_content' );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $ann_layout && ( ! empty( $ann_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$ann_sc = ann_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $ann_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $ann_sc ) ? 'filled' : 'empty'; ?>">
					<?php
					ann_show_layout( do_shortcode( $ann_sc ) );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $ann_layout && ( ! empty( $ann_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>
