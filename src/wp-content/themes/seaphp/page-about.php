<?php get_header();

$engine = seaphp_get_handlebars();

$main_results      = seaphp_main_loop_data();

$organizer_results = seaphp_get_organizer_data();


?>
	<?php
	echo $engine->render( 'layout-main',
		array(
			'post_class' => get_post_class('h-entry'),
			'is_front' => false,
			'posts' => $main_results,
			'organizers' => ($organizer_results) ? $organizer_results : []
		) );
		wp_reset_postdata();
	?>
</div> <!-- /.page-content -->

<?php get_footer(); ?>
