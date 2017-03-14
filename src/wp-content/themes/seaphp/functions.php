<?php
/**
 * This is where you can drop your custom functions or just edit things like 
 * thumbnail sizes, header images, sidebars, comments, ect.
 *
 * @package Seattle PHP
 */

define( 'ISO_8601_FORMAT', 'Y-m-d G:i:s' );   // 2016-08-23 15:55:05
define( 'ISO_8601_T_FORMAT', 'c' );           // 2016-08-23T15:55:05+00:00 note the T in the middle :)
define( 'SEAPHP_THEME_DIR', get_template_directory() );
define( 'SEAPHP_THEME_URL', get_template_directory_uri() );
define( 'SEAPHP_TEMPLATE_DIR',  SEAPHP_THEME_DIR . '/templates/');
define( 'COMPOSER_DIR', dirname( dirname( dirname( __FILE__ ) ) ) . '/composer/vendor' );
define( 'SEAPHP_VENDOR_DIR',  dirname( __FILE__ ) . '/vendor' );


//~~~~~~~~~~~~ INCLUDE NEEDED FILES ~~~~~~~~~~~~~~~~

require_once( SEAPHP_VENDOR_DIR . '/autoload.php' );

// if you remove this, seaphp will break
require_once( 'library/seaphp.php' );

// if you remove this, seaphp will break
require_once( 'library/classes/class-seaphp-customizer.php' );

/*
 * 2. library/custom-post-type.php
 * - an example custom post type
 * - example custom taxonomy (like categories)
 * - example custom taxonomy (like tags)
 *
 * Uncomment the line below to enable it.
 */
// require_once( 'library/custom-post-type.php' );

/*
 * 3. library/admin.php
 * - removing some default WordPress dashboard widgets
 * - an example custom dashboard widget
 * - adding custom login css
 * - changing text in footer of admin
 *
 * Uncomment the line below to enable it.
 */
// require_once( 'library/admin.php' );

/*
 * 4. library/translation/translation.php
 * - adding support for other languages
 *
 * Uncomment the line below to enable it.
 */
require_once( 'library/translation/translation.php' );


//~~~~~~~~~~~~ THUMBNAIL SIZE OPTIONS ~~~~~~~~~~~~~~

add_image_size( 'seaphp-thumb-600', 600, 150, true );
add_image_size( 'seaphp-thumb-300', 300, 100, true );

/*
 * to add more sizes, simply copy a line from above and change the dimensions &
 * name. As long as you upload a "featured image" as large as the biggest set
 * width or height, all the other sizes will be auto-cropped.
 *
 * To call a different size, simply change the text inside the thumbnail function.
 *
 * For example, to call the 300 x 300 sized image, we would use the function:
 * <?php the_post_thumbnail( 'seaphp-thumb-300' ); ?>
 * for the 600 x 100 image:
 * <?php the_post_thumbnail( 'seaphp-thumb-600' ); ?>
 *
 * You can change the names and dimensions to whatever you like. Enjoy!
 */

add_filter( 'image_size_names_choose', 'seaphp_custom_image_sizes' );

/**
 * Add custom image sizes
 *
 *
 * @since 0.1.0
 *
 * @param  array $sizes
 * @return array
 */
function seaphp_custom_image_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'seaphp-thumb-600' => __('600px by 150px'),
		'seaphp-thumb-300' => __('300px by 100px'),
	) );
}

/*
 * The function above adds the ability to use the dropdown menu to select
 * the new images sizes you have just created from within the media manager
 * when you add media to your content blocks. If you add more image sizes,
 * duplicate one of the lines in the array and name it according to your 
 * new image size.
 */


//~~~~~~~~~~~~ ACTIVE SIDEBARS ~~~~~~~~~~~~~~~~~~~~~

/**
 * Sidebars & Widgetizes Areas
 *
 * @since 0.1.0
 *
 * @return void
 */
function seaphp_register_sidebars() {
	register_sidebar(array(
		'id' => 'main_sidebar',
		'name' => __( 'Main Sidebar', 'seaphp-theme' ),
		'description' => __( 'The sidebar that appears on most pages', 'seaphp-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'home_sidebar',
		'name' => __( 'Home Sidebar', 'seaphp-theme' ),
		'description' => __( 'Used on homepage to show information.', 'seaphp-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
}


//~~~~~~~~~~~~ COMMENT LAYOUT ~~~~~~~~~~~~~~~~~~~~~~

/**
 * Display a single comment
 *
 *
 * @since 0.1.0
 *
 * @param  string $comment
 * @param  array $args
 * @param  int $depth
 * @return void
 */
function seaphp_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
			<?php
			/*
			 * this is the new responsive optimized comment image. It used the
			 * new HTML5 data-attribute to display comment gravatars on larger
			 * screens only. What this means is that on larger posts, mobile
			 * sites don't have a ton of requests for comment images. This
			 * makes load time incredibly fast! If you'd like to change it
			 * back, just replace it with the regular wordpress gravatar call:
			 *
			 * echo get_avatar($comment,$size='32',$default='<path_to_url>' );
			 */
			?>
			<?php
				$bgauthemail = get_comment_author_email();
			?>
			<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
			<?php // end custom gravatar call ?>
			<?php printf(__( '<cite class="fn">%s</cite>', 'seaphp-theme' ), get_comment_author_link()) ?>
			<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'seaphp-theme' )); ?> </a></time>
			<?php edit_comment_link(__( '(Edit)', 'seaphp-theme' ),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e( 'Your comment is awaiting moderation.', 'seaphp-theme' ) ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<?php // </li> is added by WordPress automatically ?>
<?php
}


//~~~~~~~~~~~~ SEARCH FORM LAYOUT ~~~~~~~~~~~~~~~~~~

/**
 * Search Form
 *
 * Edit the HTML of the search form
 *
 * @since 0.1.0
 *
 * @param  string $form search form HTML
 * @return string
 */
function seaphp_wpsearch( $form ) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __( 'Search for:', 'seaphp-theme' ) . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search the Site...', 'seaphp-theme' ) . '" />
	<input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
	</form>';
	return $form;
}

function seaphp_no_escape( $str ){
	return $str;
}

use Handlebars\Handlebars;
function seaphp_get_handlebars(){


	$opts = [
		'extension' => 'hb',
	];

	$hb_options = array();
	$hb_options['escape'] = 'seaphp_no_escape';
	$hb_options['loader'] = new \Handlebars\Loader\FilesystemLoader(
		SEAPHP_TEMPLATE_DIR,
		$opts
	);

	$opts['prefix'] = '_';
	$hb_options['partials_loader'] = new \Handlebars\Loader\FilesystemLoader(
		SEAPHP_TEMPLATE_DIR,
		$opts
	);

	$engine = new Handlebars( $hb_options );

	return $engine;
}



