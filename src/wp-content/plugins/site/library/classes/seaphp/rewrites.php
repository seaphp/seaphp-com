<?php

namespace Seaphp;

/**
 * Modify URL rewrites
 *
 * @package Seaphp
 */
class Rewrites
{
	public function init() {
		add_action( 'generate_rewrite_rules', array( $this, 'site_add_static_rewrites' ));
	}

	/**
	 * Add rewrite urls for static assets
	 *
	 * These urls are inherited from the original site structure.  They're used to
	 * map the to subdirectories of the active theme. Your SEO plugin will manage the
	 * sitemap.xml file for you. No need to handle that here. FYI, the non_wp_rules
	 * are handled by Apache's .htaccess instead of WordPress. In WP-CLI `wp rewrite
	 * flush --hard` will update the .htaccess
	 *
	 * @uses WP_Rewrite
	 * @see http://wp-cli.org/commands/rewrite/flush/
	 *
	 * @param object $wp_rewrite an object of type WP_Rewrite that contains all the rules
	 * @return void
	 */
	public function site_add_static_rewrites( $wp_rewrite ) {
		// Establish your new static rules
		$path = 'wp-content/plugins/site';
		$static_rules = array();
		$static_rules['humans\.txt$'] = $path . '/humans.txt';

		$wp_rewrite->non_wp_rules = $wp_rewrite->non_wp_rules + $static_rules;
	}

	function flush() {
		global $wp_rewrite;

		$wp_rewrite->flush_rules();
	}



}
