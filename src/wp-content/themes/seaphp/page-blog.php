<?php get_header();

$engine  = seaphp_get_handlebars();

$results    = seaphp_main_loop_data();
$blog_posts = seaphp_get_blog_posts();


$blog_content = $engine->render( '_loop-excerpt',
	array(
		'posts' => $blog_posts
	)
);

echo $engine->render( 'layout-main',
	array(
		'post_class' => get_post_class('h-entry'),
		'is_front' => false,
		'posts' => $results,
		'blog_content' => $blog_content
	)
);

wp_reset_postdata();
?>

</div> <!-- /.page-content -->

<?php get_footer(); ?>
