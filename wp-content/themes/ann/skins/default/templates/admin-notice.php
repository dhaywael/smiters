<?php
/**
 * The template to display Admin notices
 *
 * @package ANN
 * @since ANN 1.0.1
 */

$ann_theme_slug = get_option( 'template' );
$ann_theme_obj  = wp_get_theme( $ann_theme_slug );
?>
<div class="ann_admin_notice ann_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$ann_theme_img = ann_get_file_url( 'screenshot.jpg' );
	if ( '' != $ann_theme_img ) {
		?>
		<div class="ann_notice_image"><img src="<?php echo esc_url( $ann_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'ann' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="ann_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'ann' ),
				$ann_theme_obj->get( 'Name' ) . ( ANN_THEME_FREE ? ' ' . __( 'Free', 'ann' ) : '' ),
				$ann_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="ann_notice_text">
		<p class="ann_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $ann_theme_obj->description ) );
			?>
		</p>
		<p class="ann_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'ann' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="ann_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=ann_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'ann' );
			?>
		</a>
	</div>
</div>
