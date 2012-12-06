<?php
/*
Plugin Name: Genesis Post navigation
Plugin URI: http://iniyan.in/plugins/genesis-post-navigation/
Description: This plugin adds a previous and next post links on a single post in a conventional way. This plugin creates a new Genesis settings page (Genesis Post Navigation) that allows you to Customize the post navigation colors. Requires the Genesis framework.

Animations- On mouseover the previous and next links can travel from north pole to south pole :) But, I put just 20px.
Version: 1.0.1
Author: Iniyan
Author URI: http://iniyan.in
*/
/** Define our constants */
define( 'GPN_SETTINGS_FIELD', 'gpn-settings' );
define( 'GPN_PLUGIN_DIR', dirname( __FILE__ ) );
register_activation_hook( __FILE__, 'gpn_activation' );

/**
 * This function runs on plugin activation. It checks to make sure Genesis
 * or a Genesis child theme is active. If not, it deactivates itself.
 *
 * @since 0.1.0
 */
function gpn_activation() {

	if ( 'genesis' != basename( TEMPLATEPATH ) ) {

		gpn_deactivate( '1.8.0', '3.3' );

	}

}
/**
 * Deactivate GS Design.
 *
 *
 * @since 1.8.0.2
 */

function gpn_deactivate( $genesis_version = '1.8.0', $wp_version = '3.3' ) {

	deactivate_plugins( plugin_basename( __FILE__ ) );

	wp_die( sprintf( __( 'Sorry, you cannot run Genesis Post Navigation without WordPress %s and <a href="%s">Genesis %s</a> or greater.', 'gsdesign' ), $wp_version, 'http://mobiuztech.com/', $genesis_version ) );
}

add_action( 'genesis_init', 'gpn_init', 20 );

/**

 * Load admin menu and helper functions. Hooked to `genesis_init`.

 *

 * @since 1.8.0

 */

function gpn_init() {
	/** Deactivate if not running Genesis 1.8.0 or greater */

	if ( ! class_exists( 'Genesis_Admin_Boxes' ) )

		add_action( 'admin_init', 'gpn_deactivate', 10, 0 );

	/** Admin Menu */

	if ( is_admin() )

	require_once( GPN_PLUGIN_DIR . '/gpn-design.php' );

	/** CSS generator function */

	require_once( GPN_PLUGIN_DIR . '/gpn-deploy.php' );

}

//Adds Post Navigation Below every single post page	

add_action( 'genesis_after_post_content', 'gpn_after_post' );

function gpn_after_post() {

   if ( ! is_singular( 'post' ) )

return;?>

					<div id="after-post-nav">

						<span class="gps-nav-prev"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'gpn' ) . '</span> %title' ); ?></span>

						<span class="gps-nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'gpn`' ) . '</span>' ); ?></span>

					</div><!-- #nav-single -->

<?php }

