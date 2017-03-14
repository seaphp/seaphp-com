<?php
/**
 * Theme Customizer for SeaPHP
 *
 * @package Seaphp
 * @author Andrew Woods <user@host.com>
 * @version 0.1
 */
class SeattlePHP_Customizer {

	/**
	 * Add new items to the customizer
	 *
	 *
	 * @since 0.1.0
	 * @param WP_Customize_Manager $wp_customize
	 * @return void
	 */
	public static function register( $wp_customize ) {

		self::seaphp_settings( $wp_customize );
		self::update_default_settings( $wp_customize );

	}

	public static function update_default_settings( $wp_customize ) {

		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'background_image' );


		error_log( 'Updating Background color label' );
        // Input type: Color
        // With sanitize_callback
        $wp_customize->add_setting( 'background_color', array(
            'default'        => get_theme_support( 'custom-background', 'default-color' ),
            'theme_supports' => 'custom-background',
            'sanitize_callback'    => 'sanitize_hex_color_no_hash',
            'sanitize_js_callback' => 'maybe_hash_hex_color',
        ) );

        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'background_color', array(
            'label'   => __( 'Background Color' ),
			'type'    => 'select',
            'section' => 'colors',
        ) ) );



		// 4. We can also change built-in settings by 
		// modifying properties. For instance, let's make some stuff use live 
		// preview JS...
		// $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		// $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		// $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}

	public static function seaphp_settings( $wp_customize ) {

		// 1. Define a new section (if desired) to the Theme Customizer
		$wp_customize->add_section( 'seaphp-theme_options',
			array(
				'title' => __( 'Seattle PHP Options', 'seaphp-theme' ),
				'priority' => 35,
				'capability' => 'edit_theme_options',
				'description' => __('Customize settings for SeaPHP.', 'seaphp-theme'),
			)
		);

		// 2. Register new settings to the WP database...
		$wp_customize->add_setting( 'link_textcolor',
			array(
				'default' => '#2BA6CB',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport' => 'postMessage',
			)
		);


		// 3. Finally, we define the control itself (which 
		//    links a setting to a section and renders the HTML controls)...
		$color_control = new WP_Customize_Color_Control(
			$wp_customize,
			'mytheme_link_textcolor',
			array(
				'label' => __( 'Link Color', 'seaphp-theme' ),
				'section' => 'seaphp-theme_options', // 'colors'
				'settings' => 'link_textcolor',
				'priority' => 10,
			)
		);
		$wp_customize->add_control( $color_control );
	}
	


	public static function live_preview() {
		wp_enqueue_script( 
			'mytheme-themecustomizer', // Give the script a unique ID
			get_template_directory_uri() . '/assets/js/theme-customizer.js', // Define the path to the JS file
			array(  'jquery', 'customize-preview' ), // Define dependencies
			'', // Define a version (optional) 
			true // Specify whether to put in footer (leave this true)
		);
	}


}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'SeattlePHP_Customizer' , 'register' ) );

// Output custom CSS to live site
// add_action( 'wp_head' , array( 'MyTheme_Customize' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'SeattlePHP_Customizer' , 'live_preview' ) );



