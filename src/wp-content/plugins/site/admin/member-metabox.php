<?php


// hook the function to the cmb2_init action
add_action( 'cmb2_init', 'site_member_social_metabox' );
add_action( 'cmb2_init', 'site_member_ops_metabox' );

// create the function that creates metaboxes and populates them with fields
function site_member_social_metabox() {

	// set the prefix (start with an underscore to hide it from the custom fields list
	$prefix = '_member_';


	// create the metabox
	$cmb = new_cmb2_box( array(
		'id'            => $prefix . 'social_metabox',
		'title'         => __('Social', 'site-plugin'),
		'object_types'  => array( 'member' ), // post type
		'context'       => 'normal', // 'normal', 'advanced' or 'side'
		'priority'      => 'high', // 'high', 'core', 'default' or 'low'
		'show_names'    => true, // show field names on the left
		'cmb_styles'    => true, // false to disable the CMB stylesheet
		'closed'        => false, // keep the metabox closed by default
	) );

	$cmb->add_field( array(
		'name' => __('Website URL', 'site-plugin'),
		'type' => 'text_url',
		'id'   => $prefix . 'main_website',
		'sanitization_cb' => 'site_url_sanitizer',
	) );

	$cmb->add_field( array(
		'name' => __('Twitter', 'site-plugin'),
		'before_field' => '@',
		'type' => 'text_medium',
		'id'   => $prefix . 'twitter',
		'sanitization_cb' => 'site_twitter_username_sanitizer',
	) );

	$cmb->add_field( array(
		'name' => __('Skype', 'site-plugin'),
		'type' => 'text_medium',
		'id'   => $prefix . 'skype'
	) );

	$cmb->add_field( array(
		'name' => __('Facebook URL', 'site-plugin'),
		'type' => 'text_url',
		'id'   => $prefix . 'facebook',
		'sanitization_cb' => 'site_url_sanitizer',
	) );

	$cmb->add_field( array(
		'name' => __('LinkedIn URL', 'site-plugin'),
		'type' => 'text_url',
		'id'   => $prefix . 'linkedin',
		'sanitization_cb' => 'site_url_sanitizer',
	) );

}

function site_member_ops_metabox() {

	// start prefix with an underscore to hide it from the custom fields list
	$prefix = '_member_';

	// create the metabox
	$cmb = new_cmb2_box( array(
		'id'            => $prefix . 'ops_metabox',
		'title'         => __('Operations', 'site-plugin'),
		'object_types'  => array( 'member' ), // post type
		'context'       => 'normal', // 'normal', 'advanced' or 'side'
		'priority'      => 'high', // 'high', 'core', 'default' or 'low'
		'show_names'    => true, // show field names on the left
		'cmb_styles'    => true, // false to disable the CMB stylesheet
		'closed'        => false, // keep the metabox closed by default
	) );

	$cmb->add_field( array(
		'name'    => __('Speaker', 'site-plugin'),
		'type'    => 'radio_inline',
		'id'      => $prefix . 'is_speaker',
		'options' => array(
			'no'  => __( 'No', 'cmb2' ),
			'yes' => __( 'Yes', 'cmb2' ),
		),
	) );

	$cmb->add_field( array(
		'name'    => __('Organizer', 'site-plugin'),
		'type'    => 'radio_inline',
		'id'      => $prefix . 'is_organizer',
		'options' => array(
			'no'  => __( 'No', 'cmb2' ),
			'yes' => __( 'Yes', 'cmb2' ),
		),
	) );

	$cmb->add_field( array(
		'name'    => __('Organizer Role', 'site-plugin'),
		'type'    => 'text_medium',
		'id'      => $prefix . 'organizer_role',
	) );

}

function site_twitter_username_sanitizer( $value, $field_args, $field ) {
	if ( ! is_string($value)) {
		Debug::log_write(__METHOD__ . ' Not a String. return early');
		return '';
	}

	$username = '';
	if ( 0 === strpos( $value, '@') ) {
		$value = substr( $value, 1 );
	}

	if (preg_match('/^(\w+)$/', $value, $matches)) {
		$username = $matches[1];
	}

	return $username;
}

function site_url_sanitizer( $value, $field_args, $field ) {
	if ( ! is_string( $value )) {
		Debug::log_write( __METHOD__ . ' Not a String. return early');
		return '';
	}

	$url = '';

	$value = esc_url_raw( $value, [ 'http', 'https' ] );

	if ( wp_parse_url( $value ) ) {
		$url = $value;
	}

	return $url;
}


