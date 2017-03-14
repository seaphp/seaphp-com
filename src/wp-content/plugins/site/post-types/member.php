<?php

function member_init() {
	register_post_type( 'member', array(
		'labels'            => array(
			'name'                => __( 'Members', 'site-plugin' ),
			'singular_name'       => __( 'Member', 'site-plugin' ),
			'all_items'           => __( 'All Members', 'site-plugin' ),
			'new_item'            => __( 'New Member', 'site-plugin' ),
			'add_new'             => __( 'Add New', 'site-plugin' ),
			'add_new_item'        => __( 'Add New Member', 'site-plugin' ),
			'edit_item'           => __( 'Edit Member', 'site-plugin' ),
			'view_item'           => __( 'View Member', 'site-plugin' ),
			'search_items'        => __( 'Search Members', 'site-plugin' ),
			'not_found'           => __( 'No Members found', 'site-plugin' ),
			'not_found_in_trash'  => __( 'No Members found in trash', 'site-plugin' ),
			'parent_item_colon'   => __( 'Parent Member', 'site-plugin' ),
			'menu_name'           => __( 'Members', 'site-plugin' ),
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'page-attributes'
		),
		'has_archive'       => true,
		'rewrite'           => array(
			'with_front' => false,
		),
		'query_var'         => true,
		'menu_icon'         => 'dashicons-groups',
	) );

}
add_action( 'init', 'member_init' );

function member_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['member'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Member updated. <a target="_blank" href="%s">View Member</a>', 'site-plugin'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'site-plugin'),
		3 => __('Custom field deleted.', 'site-plugin'),
		4 => __('Member updated.', 'site-plugin'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Member restored to revision from %s', 'site-plugin'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Member published. <a href="%s">View Member</a>', 'site-plugin'), esc_url( $permalink ) ),
		7 => __('Member saved.', 'site-plugin'),
		8 => sprintf( __('Member submitted. <a target="_blank" href="%s">Preview Member</a>', 'site-plugin'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Member scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Member</a>', 'site-plugin'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'Y M j @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Member draft updated. <a target="_blank" href="%s">Preview Member</a>', 'site-plugin'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'member_updated_messages' );
