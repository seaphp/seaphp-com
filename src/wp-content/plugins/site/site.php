<?php
/**
 * Plugin Name: SeaPHP Site
 * Version: 0.1
 * Description: Master plugin for SeaPHP
 * Author: Andrew Woods
 * Author URI: http://andrewwoods.net
 * Text Domain: site
 * Domain Path: /languages
 *
 * @package SeaPHP Site
 */

//
// Constants
//
define( 'CMB2_PATH',  dirname( plugin_dir_path( __FILE__ ) ) . 'cmb2/' );
define( 'SITE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

//
// Load Classes
//
if ( file_exists(  CMB2_PATH . '/init.php' ) ) {
	require_once  CMB2_PATH . '/init.php';
}

require_once "vendor/meetup-api-client/Meetup.php";


//
// Load Post Types
//
require_once "post-types/event.php";
require_once "post-types/member.php";

//
// Load Metaboxes
//
require_once "admin/event-metabox.php";
require_once "admin/member-metabox.php";


//
// Load Widgets
//
require_once "widgets/class-meetup-event-widget.php";

/*
 * Include this in your primary plugin file
 *
 * Create a 'classes' directory in your plugin directory.
 * To load a class named So_Awesome, it should be in classes/class-so-awesome.php
 */
function site_autoloader( $class_name ) {
	$slug = str_replace('\\', '/', $class_name);
	$slug = strtolower( $slug );
	$slug = str_replace('_', '/', $slug);

	$dir_name  = dirname( $slug );
	$file_name = basename( $slug );

	$file      = $file_name . '.php';
	$file_path = SITE_PLUGIN_DIR . 'library/classes/' . $dir_name . '/' . $file;
	// error_log( __FUNCTION__ . ' file_path=' . $file_path);

	if ( file_exists( $file_path ) ) {
		include_once $file_path;
	}
}


/*
 * Include this in your primary plugin file
 *
 * Create a 'classes' directory in your plugin directory.
 * To load a class named So_Awesome, it should be in classes/class-so-awesome.php
 */
function site_meetup_api_autoloader( $class_name ) {
	$file      = $class_name . '.class.php';

	if ( false !== strpos($class_name, '\\') ){
		$class_name = str_replace('\\', '/', $class_name);
		$class_name = ltrim($class_name, '/');
		$dir_name  = dirname($class_name);
		$file_name = basename($class_name);
		$file = $dir_name . '/' . $file_name . '.php';
	}

	$file_path = SITE_PLUGIN_DIR . 'vendor/meetup-api/' . $file;
	// error_log( __FUNCTION__ . ' file_path=' . $file_path);

	if ( file_exists( $file_path ) ) {
		include_once $file_path;
	}
}


spl_autoload_register( 'site_autoloader' );
spl_autoload_register( 'site_meetup_api_autoloader' );


