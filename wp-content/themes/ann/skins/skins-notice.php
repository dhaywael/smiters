<?php
/**
 * The template to display Admin notices
 *
 * @package ANN
 * @since ANN 1.0.64
 */

$ann_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$ann_skins_args = get_query_var( 'ann_skins_notice_args' );
?>
<div class="ann_admin_notice ann_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins available', 'ann' ); ?>
	</h3>
	<?php

	// Description
	$ann_total      = $ann_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$ann_skins_msg  = $ann_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $ann_total, 'ann' ), $ann_total ) . '</strong>'
							: '';
	$ann_total      = $ann_skins_args['free'];
	$ann_skins_msg .= $ann_total > 0
							? ( ! empty( $ann_skins_msg ) ? ' ' . esc_html__( 'and', 'ann' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $ann_total, 'ann' ), $ann_total ) . '</strong>'
							: '';
	$ann_total      = $ann_skins_args['pay'];
	$ann_skins_msg .= $ann_skins_args['pay'] > 0
							? ( ! empty( $ann_skins_msg ) ? ' ' . esc_html__( 'and', 'ann' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $ann_total, 'ann' ), $ann_total ) . '</strong>'
							: '';
	?>
	<div class="ann_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'ann' ), $ann_skins_msg ) );
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
