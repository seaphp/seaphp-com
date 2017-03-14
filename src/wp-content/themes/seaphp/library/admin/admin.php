<?php
/**
 * This file handles the admin area and functions.  You can use this file to
 * make changes to the dashboard. Updates to this page are coming soon. It's
 * turned off by default, but you can call it via the functions file.
 *
 * @package Seattle PHP
 * @subpackage Admin
 *
 *
 */


//~~~~~~~~~~~~ ACTIONS AND FILTERS ~~~~~~~~~~~~~~~~~~


// calling it only on the login page
add_action( 'login_enqueue_scripts', 'seaphp_login_css', 10 );
add_filter( 'login_headerurl', 'seaphp_login_url' );
add_filter( 'login_headertitle', 'seaphp_login_title' );

// adding it to the admin area
add_filter( 'admin_footer_text', 'seaphp_custom_admin_footer' );

//~~~~~~~~~~~~ CUSTOM LOGIN PAGE ~~~~~~~~~~~~~~~~~~


/**
 * enqueue your custom login page css
 *
 * @since 0.1.0
 * @see http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
 *
 * @return void
 */
function seaphp_login_css() {
	wp_enqueue_style( 'seaphp_login_css', get_template_directory_uri() . '/library/css/login.css', false );
}


/**
 * changing the logo link from wordpress.org to your site
 *
 * @since 0.1.0
 * @see http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
 *
 * @return string
 */
function seaphp_login_url() {
	return home_url();
}


/**
 * changing the alt text on the logo to show your site name
 *
 * @since 0.1.0
 * @see http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
 *
 * @return string
 */
function seaphp_login_title() {
	return get_option( 'blogname' );
}


//~~~~~~~~~~~~ CUSTOMIZE ADMIN ~~~~~~~~~~~~~~~~~~~~

/**
 * Customize Backend Footer
 *
 * {@see 'admin_footer_text'}
 *
 * @return void
 */
function seaphp_custom_admin_footer() {
	$url = 'http://andrewwoods.net';
	$name = 'Andrew Woods';

	echo '<span id="footer-developed-by">';
	printf(
		__( 'Developed by <a href="%1$s" target="_blank">%2$s</a>', 'seaphp-theme' ),
		$url,
		$name
	);
	echo '</span>';
}



