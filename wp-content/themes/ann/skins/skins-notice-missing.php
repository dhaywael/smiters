<?php
/**
 * The template to display Admin notices
 *
 * @package ANN
 * @since ANN 1.98.0
 */

$ann_skins_url   = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$ann_active_skin = ann_skins_get_active_skin_name();
?>
<div class="ann_admin_notice ann_skins_notice notice notice-error">
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
		<?php esc_html_e( 'Active skin is missing!', 'ann' ); ?>
	</h3>
	<div class="ann_notice_text">
		<p>
			<?php
			// Translators: Add a current skin name to the message
			echo wp_kses_data( sprintf( __( "Your active skin <b>'%s'</b> is missing. Usually this happens when the theme is updated directly through the server or FTP.", 'ann' ), ucfirst( $ann_active_skin ) ) );
			?>
		</p>
		<p>
			<?php
			echo wp_kses_data( __( "Please use only <b>'ThemeREX Updater v.1.6.0+'</b> plugin for your future updates.", 'ann' ) );
			?>
		</p>
		<p>
			<?php
			echo wp_kses_data( __( "But no worries! You can re-download the skin via 'Skins Manager' ( Theme Panel - Theme Dashboard - Skins ).", 'ann' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="ann_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $ann_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'ann' );
			?>
		</a>
	</div>
</div>
