<?php

add_action( 'init', 'site_event_init' );
add_filter( 'post_updated_messages', 'site_event_updated_messages' );

function site_event_init() {
	register_post_type( 'event', array(
		'labels'            => array(
			'name'                => __( 'Events', 'site-plugin' ),
			'singular_name'       => __( 'Event', 'site-plugin' ),
			'all_items'           => __( 'All Events', 'site-plugin' ),
			'new_item'            => __( 'New Event', 'site-plugin' ),
			'add_new'             => __( 'Add New', 'site-plugin' ),
			'add_new_item'        => __( 'Add New Event', 'site-plugin' ),
			'edit_item'           => __( 'Edit Event', 'site-plugin' ),
			'view_item'           => __( 'View Event', 'site-plugin' ),
			'search_items'        => __( 'Search Events', 'site-plugin' ),
			'not_found'           => __( 'No Events found', 'site-plugin' ),
			'not_found_in_trash'  => __( 'No Events found in trash', 'site-plugin' ),
			'parent_item_colon'   => __( 'Parent Event', 'site-plugin' ),
			'menu_name'           => __( 'Events', 'site-plugin' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'has_archive'       => true,
		'rewrite'           => array( 'with_front' => false ),
		'query_var'         => true,
		'menu_icon'         => 'dashicons-admin-post',
	) );

}


function site_event_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['event'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Event updated. <a target="_blank" href="%s">View Event</a>', 'site-plugin'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'site-plugin'),
		3 => __('Custom field deleted.', 'site-plugin'),
		4 => __('Event updated.', 'site-plugin'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Event restored to revision from %s', 'site-plugin'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Event published. <a href="%s">View Event</a>', 'site-plugin'), esc_url( $permalink ) ),
		7 => __('Event saved.', 'site-plugin'),
		8 => sprintf( __('Event submitted. <a target="_blank" href="%s">Preview Event</a>', 'site-plugin'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Event</a>', 'site-plugin'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Event draft updated. <a target="_blank" href="%s">Preview Event</a>', 'site-plugin'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
