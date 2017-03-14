<?php
get_header();

/**
 * The loop content for a single blog post
 *
 * @package Seattle PHP
 * @subpackage Templates
 */
$engine    = seaphp_get_handlebars();
$main_loop = seaphp_main_loop_data();
$is_front  = ( is_home() || is_front_page() ) ;

$data = array(
	'post_class' => get_post_class( 'h-entry' ),
	'is_front' => $is_front,
	'is_blog' => true,
	'posts' => $main_loop
);

echo $engine->render( 'layout-main', $data );

?>

</div> <!-- /.page-content -->

<?php get_footer(); ?>
