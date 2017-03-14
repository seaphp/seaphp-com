<?php get_header();

$engine    = seaphp_get_handlebars();
$main_loop = seaphp_main_loop_data();
$is_front  = ( is_home() || is_front_page() ) ;

$data = array(
	'post_class' => get_post_class( 'h-entry' ),
	'is_front' => $is_front,
	'posts' => $main_loop
);

if ( $is_front ){
	$latest_post = seaphp_get_latest_blog_post();
	$latest_post[ 'the_excerpt' ] = seaphp_get_num_words($latest_post['the_excerpt'], 10);

	$next_event  = seaphp_get_next_event();
	$next_event[ 'the_excerpt' ] = seaphp_get_num_words($next_event['the_excerpt'], 10);

	$event_data = seaphp_get_event_data_by_id( $next_event['the_id'] );
	$event_data['event_date'] = seaphp_reformat_us_date( $event_data['event_date'] );

	$next_event = $next_event + $event_data;

	$panels_data = [];
	$panels_data[ 'latest_post' ] = $latest_post;
	$panels_data[ 'next_event' ]  = $next_event;

	$data['panels'] = $engine->render( '_panels', $panels_data );
}

if ( is_page( 'about' ) ) {
	$data['organizers'] = seaphp_get_organizer_data();
}


echo $engine->render( 'layout-main', $data );
?>

</div> <!-- /.page-content -->

<?php get_footer(); ?>
