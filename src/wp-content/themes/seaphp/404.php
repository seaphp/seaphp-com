<?php get_header(); ?>

<div id="content">
	<div id="inner-content" class="wrap clearfix">
		<div id="main" class="eightcol first clearfix" role="main">

			<article id="post-not-found" class="hentry">

				<h1><?php _e( 'Epic 404 - Article Not Found', 'seaphp-theme' ); ?></h1>

				<p><?php _e( 'The content you were looking for was not found, but maybe try looking again!', 'seaphp-theme' ); ?></p>

				<p><?php get_search_form(); ?></p>

			</article>

		</div>
	</div>
</div>

<?php get_footer(); ?>
