<?php

// hook the function to the cmb2_init action
add_action( 'cmb2_init', 'site_event_location_metabox' );
add_action( 'cmb2_init', 'site_event_metadata_metabox' );
//add_action( 'save_post', 'site_event_update', 20, 2 );

function site_event_location_metabox(){

	// set the prefix (start with an underscore to hide it from the custom fields list
	$prefix = '_event_';

	// create the metabox
	$cmb = new_cmb2_box( array(
		'id'            => $prefix . 'location_metabox',
		'title'         => __('Location', 'site-plugin'),
		'object_types'  => array( 'event' ), // post type
		'context'       => 'normal', // 'normal', 'advanced' or 'side'
		'priority'      => 'high', // 'high', 'core', 'default' or 'low'
		'show_names'    => true, // show field names on the left
		'cmb_styles'    => true, // false to disable the CMB stylesheet
		'closed'        => false, // keep the metabox closed by default
	) );

	// name, address, city, state, zipcode

	$cmb->add_field( array(
		'name' => __('Name', 'site-plugin'),
		'type' => 'text_medium',
		'id'   => $prefix . 'name',
	) );

	$cmb->add_field( array(
		'name' => __('Address', 'site-plugin'),
		'type' => 'text_medium',
		'id'   => $prefix . 'address',
	) );

	$cmb->add_field( array(
		'name' => __('Address 2', 'site-plugin'),
		'type' => 'text_medium',
		'id'   => $prefix . 'address2',
	) );

	$cmb->add_field( array(
		'name' => __('City', 'site-plugin'),
		'type' => 'text_medium',
		'id'   => $prefix . 'city',
	) );

	$cmb->add_field( array(
		'name' => __('Zipcode', 'site-plugin'),
		'type' => 'text_small',
		'id'   => $prefix . 'zipcode',
	) );
}

function site_event_metadata_metabox(){

	// set the prefix (start with an underscore to hide it from the custom fields list
	$prefix = '_event_';

	// create the metabox
	$cmb = new_cmb2_box( array(
		'id'            => $prefix . 'metadata_metabox',
		'title'         => __('Metadata', 'site-plugin'),
		'object_types'  => array( 'event' ), // post type
		'context'       => 'normal', // 'normal', 'advanced' or 'side'
		'priority'      => 'high', // 'high', 'core', 'default' or 'low'
		'show_names'    => true, // show field names on the left
		'cmb_styles'    => true, // false to disable the CMB stylesheet
		'closed'        => false, // keep the metabox closed by default
	) );

	$cmb->add_field( array(
		'name' => __('Meetup Event ID', 'site-plugin'),
		'type' => 'text_small',
		'id'   => $prefix . 'meetup_event_id',
	) );
	$cmb->add_field( array(
		'name' => __('Meetup link', 'site-plugin'),
		'type' => 'text_url',
		'id'   => $prefix . 'meetup_link',
	) );

	$cmb->add_field( array(
		'name' => __('Date', 'site-plugin'),
		'type' => 'text_date',
		'id'   => $prefix . 'date',
	) );

	$cmb->add_field( array(
		'name' => __('Start Time', 'site-plugin'),
		'type' => 'text_time',
		'id'   => $prefix . 'start_time',
	) );

	$cmb->add_field( array(
		'name' => __('End Time', 'site-plugin'),
		'type' => 'text_time',
		'id'   => $prefix . 'end_time',
	) );
}


