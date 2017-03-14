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

$the_id     = (isset($main_loop[0]['the_id'])) ? $main_loop[0]['the_id'] : 0;
$event_data = null;

if ( $the_id ){
	$event_data = seaphp_get_event_data_by_id( $the_id );
	$event_data = $main_loop[0] + $event_data;
	$event_data['event_map'] = seaphp_get_map_link(
		$event_data['location_address'],
		$event_data['location_city'],
		$event_data['location_zipcode']
	);
	$event_data['event_date'] = seaphp_reformat_us_date( $event_data['event_date'] );

	$event_content = $engine->render( '_event-content', [ 'event_data' => $event_data ] );
}


$data = array(
	'post_class' => get_post_class( 'h-entry' ),
	'is_front' => $is_front,
	'is_blog' => false,
	'is_event' => true,
	'posts' => $main_loop,
	'event_content' => $event_content
);

echo $engine->render( 'layout-main', $data );

?>

</div> <!-- /.page-content -->

<?php get_footer(); ?>
