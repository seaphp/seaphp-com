<?php
/**
 * This is the core Seattle PHP file where most of the main functions & features
 * reside. If you have any custom functions, it's best to put them in the
 * functions.php file.
 *
 * - head cleanup (remove rsd, uri links, junk css, etc)
 * - enqueueing scripts & styles
 * - theme support functions
 * - custom menu output & fallbacks
 * - related post function
 * - page-navi function
 * - removing <p> from around images
 * - customizing the post excerpt
 * - custom google+ integration
 * - adding custom fields to user profiles
 *
 * @package Seattle PHP
 * @subpackage Subpackage name
 * @author firstname lastname <user@host.com>
 */


require_once "admin/admin.php";
require_once "admin/dashboard-widgets.php";

add_action( 'after_setup_theme', 'seaphp_ahoy', 16 );
add_filter( 'wp_title', 'seaphp_wp_title', 11, 3 );


/*
 * Launch SeaPHP
 *
 * Let's fire off all the functions and tools.
 * I put it up here so it's right up top and clean.
 *
 * @return void
 */
function seaphp_ahoy() {

	// launching operation cleanup
	add_action( 'init', 'seaphp_head_cleanup' );

	// enqueue base scripts and styles
	add_action( 'wp_enqueue_scripts', 'seaphp_scripts_and_styles', 999 );

	// launching this stuff after theme setup
	seaphp_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'seaphp_register_sidebars' );

	// adding the seaphp search form (created in functions.php)
	add_filter( 'get_search_form', 'seaphp_wpsearch' );

	// cleaning up random code around images
	// add_filter( 'the_content', 'seaphp_filter_ptags_on_images' );

	// Improves the excerpt more link
	add_filter( 'excerpt_more', 'seaphp_excerpt_more' );

}



/**
 * Improve on the default wordpress title
 *
 * The default wordpress title isn't sufficient. On the homepage, it add the
 * site description to the site name. On other pages, it add the site name to the
 * standard page title
 *
 * @since 0.1.0
 * @uses wp_title filter
 *
 * @param string $title the title of the page
 * @param string $sep a separator. one or more characters to divide the page title
 * @param string $sep_location can be 'left' or 'right'. default: left.
 * @return string
 */
function seaphp_wp_title( $title, $sep, $sep_location ) {

	// The Site Title under "Settings > General"
	$site_name = get_bloginfo( 'name' );

	// The Tagline under "Settings > General"
	$site_description = get_bloginfo( 'description', 'display' );

	// Add the blog description for the home/front page, if available.
	if ( is_home() || is_front_page() ) {
		$title = $site_name;
		if ( $site_description ) {
			$title = "$site_name $sep $site_description";
		}

		return $title;
	}

	if ( $sep_location == 'right' ) {
		$title = $title . $site_name;
	} else {
		$title = $site_name . $title;
	}

	return $title;
}



/**
 * Remove unwanted items
 *
 * Clean up the output of wp_head() by removing undesired functions
 *
 * @since 0.1.0
 * @uses {remove_action()}
 *
 * @return void
 */
function seaphp_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );

	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );

	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );

	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// index link
	remove_action( 'wp_head', 'index_rel_link' );

	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'rss_head', 'wp_generator' );
	remove_action( 'rss2_head', 'wp_generator' );

	// remove WP version from css
	add_filter( 'style_loader_src', 'seaphp_remove_wp_ver_css_js', 9999 );

	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'seaphp_remove_wp_ver_css_js', 9999 );

}



/**
 * remove WP version from scripts
 */
function seaphp_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ){
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}



//------------------------------------------------------------------------------
// SCRIPTS & ENQUEUEING
//

// loading modernizr and jquery, and reply script
function seaphp_scripts_and_styles() {
	global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
	if ( ! is_admin() ) {

		// modernizr (without media query polyfill)
		wp_register_script( 'seaphp-modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

		// register main stylesheet
		wp_register_style( 'seaphp-stylesheet', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );

		// ie-only style sheet
		wp_register_style( 'seaphp-ie-only', get_stylesheet_directory_uri() . '/library/css/ie.css', array(), '' );

		// comment reply script for threaded comments
		if ( is_singular() AND comments_open() AND ( get_option('thread_comments') == 1 ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		//adding scripts file in the footer
		wp_register_script( 'seaphp-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );

		// enqueue styles and scripts
		wp_enqueue_script( 'seaphp-modernizr' );
		wp_enqueue_style( 'seaphp-stylesheet' );
		wp_enqueue_style( 'seaphp-ie-only' );

		$wp_styles->add_data( 'seaphp-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

		/*
		I recommend using a plugin to call jQuery
		using the google cdn. That way it stays cached
		and your site will load faster.
		*/
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'seaphp-js' );

	}
}



/**
 * Adding Theme Support
 *
 * There are many options for theme support availale. Thumbnails, feed links,
 * post formats, and color options are just a few options available. To add header
 * image support visit the header background image link in this comment
 *
 * @since 0.1.0
 * @uses add_theme_support()
 * @link http://themble.com/support/adding-header-background-image-support/
 *
 * @return void
 */
function seaphp_theme_support() {


	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );

	// default thumb size
	set_post_thumbnail_size( 125, 125, true );

	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
		array(
		'default-image' => '',  // background image default
		'default-color' => '', // background color default (dont add the #)
		'wp-head-callback' => '_custom_background_cb',
		'admin-head-callback' => '',
		'admin-preview-callback' => ''
		)
	);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	);

	// wp menus
	add_theme_support( 'menus' );

	// registering menu locations
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'seaphp-theme' ),
			'social-nav' => __( 'Social Media Menu', 'seaphp-theme' ),
			'footer-links' => __( 'Footer Links', 'seaphp-theme' )
		)
	);
}



//------------------------------------------------------------------------------
// MENUS & NAVIGATION
//

/**
 * Main navigation menu for Seattle PHP
 *
 * Registers a main menu
 *
 * @since 0.1.0
 * @uses wp_nav_menu()
 *
 * @return void
 */
function seaphp_main_nav() {

	wp_nav_menu( array(
		'container' => false,
		'container_class' => 'menu clearfix',
		'menu' => __( 'The Main Menu', 'seaphp-theme' ),
		'menu_class' => 'nav main-menu clearfix',
		'theme_location' => 'main-nav',
		'before' => '',
		'after' => '',
		'link_before' => '',
		'link_after' => '',
		'depth' => 0,
		'fallback_cb' => 'seaphp_main_nav_fallback'
	) );
}



/**
 * Social navigation menu for Seattle PHP
 *
 * Registers a main menu
 *
 * @since 0.1.0
 * @uses wp_nav_menu()
 *
 * @return void
 */
function seaphp_social_nav() {

	wp_nav_menu( array(
		'container' => false,
		'container_class' => 'menu clearfix',
		'menu' => __( 'Social Media Menu', 'seaphp-theme' ),
		'menu_class' => 'nav social-menu clearfix',
		'theme_location' => 'social-nav',
		'before' => '',
		'after' => '',
		'link_before' => '',
		'link_after' => '',
		'depth' => 0,
		'fallback_cb' => 'seaphp_main_nav_fallback'
	) );
}



/**
 * the footer menu (should you choose to use one)
 *
 * Registers a footer menu.
 *
 * @since 0.1.0
 * @uses wp_nav_menu()
 *
 * @return void
 */
function seaphp_footer_links() {

	wp_nav_menu( array(
		'container' => '',
		'container_class' => 'footer-links clearfix',
		'menu' => __( 'Footer Links', 'seaphp-theme' ),
		'menu_class' => 'nav footer-menu clearfix',
		'theme_location' => 'footer-links',
		'before' => '',
		'after' => '',
		'link_before' => '',
		'link_after' => '',
		'depth' => 0,
		'fallback_cb' => 'seaphp_footer_links_fallback'
	) );
}


/**
 * Footer menu fallback
 *
 * Do just enough so that the layout doesn't break
 * If someone removes all the items from the social menu
 *
 * @since 0.1.0
 * @uses {wp_page_menu()}
 *
 * @return void
 */
function seaphp_footer_links_fallback() {
	echo '&nbsp;';
}



/**
 * Social Media menu fallback
 *
 * Do just enough so that the layout doesn't break
 * If someone removes all the items from the social menu
 *
 * @since 0.1.0
 * @uses {wp_page_menu()}
 *
 * @return void
 */
function seaphp_social_links_fallback() {
	echo '&nbsp;';
}



/**
 * Related Posts Function
 *
 * @since 0.1.0
 *
 * @global WP_Post $post the current post
 *
 * @return void
 */
function seaphp_related_posts() {
	global $post;

	echo '<ul id="seaphp-related-posts">';

	$tags = wp_get_post_tags( $post->ID );
	$tag_arr = '';
	if( $tags ) {
		foreach( $tags as $tag ) {
			$tag_arr .= $tag->slug . ',';
		}

		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if( $related_posts ) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach;
		}
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'seaphp-theme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_query();

	echo '</ul>';
}



/**
 * Display multi-page navigation
 *
 * Use the WP_Query object to determine the number of items in page results
 * and create page navigation if necessary
 *
 * @since 0.1.0
 *
 * @global WP_Query $query
 * @return void
 */
function seaphp_page_navi() {
	global $wp_query;
	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 ){
		return;
	}

	echo '<nav class="pagination">';

	echo paginate_links( array(
		'base' 			=> str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
		'format' 		=> '',
		'current' 		=> max( 1, get_query_var('paged') ),
		'total' 		=> $wp_query->max_num_pages,
		'prev_text' 	=> '&larr;',
		'next_text' 	=> '&rarr;',
		'type'			=> 'list',
		'end_size'		=> 3,
		'mid_size'		=> 3
	) );

	echo '</nav>';
}



/**
 * remove the p tag from around images
 *
 * Content filter - examines the content for images wrapped in paragraph "p"
 * tags and removes the p tags.
 *
 * @since 0.1.0
 * @see http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/
 *
 * @param  string $content
 * @return string
 */
function seaphp_filter_ptags_on_images( $content ){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}



/**
 * Changes the text of the 'Read More' link to include title of content
 *
 * Makes the link text more useful to search engines and screen readers.
 *
 * @global object $post
 *
 * @param string $more
 * @return string
 */
function seaphp_excerpt_more( $more ) {
	global $post;

	$url   = get_permalink( $post->ID );
	$title = get_the_title( $post->ID );

	// the inclusion of the space prevents the link from hitting the end of the excerpt text
	$more = '  ' . sprintf(
		/* translators: 1: URL 2: Title of the Post */
		__( '<a class="excerpt-read-more" href="%1$s">Read more <span class="screen-reader-text">%2$s</span></a>', 'seaphp-theme' ),
		$url,
		$title
	);

	return $more;
}



/**
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 *
 * @global object $authordata
 *
 * @return string $link a formatted html anchor
 */
function seaphp_get_the_author_posts_link() {
	global $authordata;

	if ( ! is_object( $authordata ) ) {
		return false;
	}


	$link = sprintf(
		'<a  class="p-author h-card" rel="author" href="%1$s" >%2$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		get_the_author()
	);
	return $link;
}

/**
 * Retrieve an array of post content for the main loop
 *
 * @return array
 */
function seaphp_main_loop_data(){
	$data = array();
	$types = [ 'city', 'abstract' ];
	$image_url = seaphp_get_random_lorempixel_url( $types );

	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();

			$seaphp_post = [];
			$seaphp_post['the_id']            = get_the_ID();
			$seaphp_post['the_content']       = seaphp_get_the_content();
			$seaphp_post['the_excerpt']       = get_the_excerpt();
			$seaphp_post['the_title']         = get_the_title();
			$seaphp_post['the_author']        = get_the_author();
			$seaphp_post['the_author_link']   = seaphp_get_the_author_posts_link();
			$seaphp_post['the_date_iso']      = get_the_time( ISO_8601_T_FORMAT );
			$seaphp_post['the_date_human']    = get_the_time( get_option( 'date_format' ) );
			$seaphp_post['the_category_list'] = get_the_category_list(', ');
			$seaphp_post['the_link']          = get_the_permalink();
			$seaphp_post['the_tags']          = get_the_tags( '<span class="tags-title">' . __( 'Tags:', 'seaphp-theme' ) . '</span> ', ', ', '' );
			$seaphp_post['the_image']         = $image_url;

			$seaphp_post['is_event']          = false;
			$seaphp_post['is_front']          = is_front_page();
			$seaphp_post['is_blog']           = is_page('blog');

			$the_post_type                    = get_post_type();

			if ( get_the_post_thumbnail_url() ) {
				$seaphp_post['the_image']  = get_the_post_thumbnail_url( $seaphp_post['the_id'], 'full' );
			}

			if ( false !== $the_post_type ){
				$seaphp_post['the_post_type'] = $the_post_type;

				if ($the_post_type == 'event'){
					$seaphp_post['is_event'] = true;
				}
			}

			$data[] = $seaphp_post;
		endwhile;
	endif;

	return $data;
}


function seaphp_get_organizer_data(){

	$prefix = '_member_';
	$data = array();
	$alt_params = [
		'posts_per_page' => 5,
		'post_type' => 'member',
		'meta_key' => $prefix . 'is_organizer',
		'meta_value' => 'yes',
		'orderby' => 'menu_order',
		'order' => 'ASC'

	];
	$alt = new WP_Query( $alt_params );
	if ($alt->have_posts()) :
		while ($alt->have_posts()) : $alt->the_post();

			$organizer = [];
			$organizer['the_id']          = get_the_ID();
			$organizer['the_content']     = seaphp_get_the_content();
			$organizer['the_excerpt']     = get_the_excerpt();
			$organizer['the_title']       = get_the_title();
			$organizer['the_author']      = get_the_author();
			$organizer['the_author_link'] = seaphp_get_the_author_posts_link();
			$organizer['the_date_iso']    = get_the_time( ISO_8601_T_FORMAT );
			$organizer['the_date_human']  = get_the_time( get_option( 'date_format' ) );
			$organizer['role']            = get_post_meta( get_the_ID(), $prefix . 'organizer_role', true );
			if (get_the_post_thumbnail_url()) {
				$organizer['the_image']  = get_the_post_thumbnail_url();
			}
			$data[] = $organizer;

		endwhile;
	endif;
	wp_reset_postdata();

	return $data;
}

function seaphp_get_blog_posts($total_posts = 5){
	$data = [];
	$types = [ 'city', 'business', 'abstract' ];
	$image_url = seaphp_get_random_lorempixel_url( $types );

	$alt_params = [
		'posts_per_page' => $total_posts,
		'post_type' => 'post'
	];
	$alt = new WP_Query( $alt_params );
	if ($alt->have_posts()) :
		while ($alt->have_posts()) : $alt->the_post();

			$seaphp_post = [];
			$seaphp_post['the_id']            = get_the_ID();
			$seaphp_post['the_content']       = seaphp_get_the_content();
			$seaphp_post['the_excerpt']       = get_the_excerpt();
			$seaphp_post['the_title']         = get_the_title();
			$seaphp_post['the_author']        = get_the_author();
			$seaphp_post['the_author_link']   = seaphp_get_the_author_posts_link();
			$seaphp_post['the_date_iso']      = get_the_time( ISO_8601_T_FORMAT );
			$seaphp_post['the_date_human']    = get_the_time( get_option( 'date_format' ) );
			$seaphp_post['the_category_list'] = get_the_category_list(', ');
			$seaphp_post['the_link']          = get_the_permalink();
			$seaphp_post['the_image']         = $image_url;

			if (get_the_post_thumbnail_url()) {
				$seaphp_post['the_image']  = get_the_post_thumbnail_url();
			}

			$data[] = $seaphp_post;
		endwhile;
	endif;
	wp_reset_postdata();

	return $data;
}

function seaphp_get_latest_blog_post(){
	$data = seaphp_get_blog_posts( 1 );

	return array_shift( $data );
}

function seaphp_get_random_lorempixel_url( $types ){

	$i = array_rand( $types );
	$type = $types[ $i ];
	$image_url = 'http://lorempixel.com/250/250/' . $type . '/';

	return $image_url;
}

function seaphp_get_next_event(){

	$types = [ 'nightlife', 'people', 'abstract' ];
	$image_url = seaphp_get_random_lorempixel_url( $types );

	$alt_params = [
		'posts_per_page' => 1,
		'post_type' => 'event'
	];

	$seaphp_post = [];
	$alt = new WP_Query( $alt_params );
	if ($alt->have_posts()) :
		while ($alt->have_posts()) : $alt->the_post();

			$seaphp_post['the_id']         = get_the_ID();
			$seaphp_post['the_excerpt']    = get_the_excerpt();
			$seaphp_post['the_title']      = get_the_title();
			$seaphp_post['the_date_iso']   = get_the_time( ISO_8601_T_FORMAT );
			$seaphp_post['the_date_human'] = get_the_time( get_option( 'date_format' ) );
			$seaphp_post['the_link']       = get_the_permalink();
			$seaphp_post['the_image']      = $image_url;

			if (get_the_post_thumbnail_url()) {
				$seaphp_post['the_image']  = get_the_post_thumbnail_url( $seaphp_post['the_id'], 'full' );
			}

		endwhile;
	endif;
	wp_reset_postdata();

	return $seaphp_post;
}

function seaphp_get_event_data_by_id( $id ){
	$data = [];

	if ( empty( $id ) ) {
		return $data;
	}

	$prefix = '_event_';

	$data['location_name']    = get_post_meta($id, $prefix . 'name', true);
	$data['location_address'] = get_post_meta($id, $prefix . 'address', true);
	$data['location_address2'] = get_post_meta($id, $prefix . 'address2', true);
	$data['location_city']    = get_post_meta($id, $prefix . 'city', true);
	$data['location_zipcode'] = get_post_meta($id, $prefix . 'zipcode', true);

	$data['event_date']       = get_post_meta($id, $prefix . 'date', true);
	$data['event_start_time'] = get_post_meta($id, $prefix . 'start_time', true);
	$data['event_end_time']   = get_post_meta($id, $prefix . 'end_time', true);
	$data['event_link']       = get_post_meta($id, $prefix . 'meetup_link', true);


	return $data;
}

function seaphp_reformat_us_date( $date ){
	$date = DateTime::createFromFormat( 'm/d/Y', $date );

	return $date->format( get_option( 'date_format' ) );
}

function seaphp_get_map_link( $address, $city, $zipcode ){
	$location = $address . ' ' . $city . ', ' . $zipcode;
	$location = trim( $location );
	$location = urlencode( $location );

	$map_link = 'https://www.google.com/maps/place/' . $location;

	return $map_link;
}


function seaphp_get_num_words( $str, $num ){
	$temp = explode(' ', $str);

	$temp = array_slice($temp, 0, $num);
	$data = implode(" ", $temp);

	return $data;
}

function seaphp_get_the_content($more_link_text = null, $strip_teaser = false){
	$content = get_the_content( $more_link_text, $strip_teaser );

	/**
	 * Filter the post content.
	 *
	 * @since 0.71
	 *
	 * @param string $content Content of the current post.
	 */
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );

	return $content;
}




/**
 * Autoloader function for SeaPHP theme
 *
 * Create a 'library/classes' directory in your theme directory.
 * To load a class named So_Awesome, it should be in library/classes/so-awesome.php
 */
function seaphp_autoloader( $class_name ) {
	$slug = str_replace('\\', '/', $class_name);
	$slug = strtolower( $slug );
	$slug = str_replace('_', '-', $slug);

	$dir_name  = dirname( $slug );
	$file_name = basename( $slug );

	$file      = $file_name . '.php';
	$file_path = SEAPHP_THEME_DIR . '/library/classes/' . $dir_name . '/' . $file;
	error_log('autoloader file_path=' . $file_path);

	if ( file_exists( $file_path ) ) {
		include_once $file_path;
	}
}

spl_autoload_register( 'seaphp_autoloader' );


$site_rewrites = new \Seaphp\Rewrites();
$site_rewrites->init();


