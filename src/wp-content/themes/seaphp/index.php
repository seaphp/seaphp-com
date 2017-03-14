<?php get_header(); ?>

<div id="content">
	<div id="inner-content" class="wrap clearfix">
		<div id="main" class="clearfix" role="main">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
			get_template_part( 'content/excerpt' );
		?>
			<?php endwhile; ?>

			<?php if ( function_exists( 'seaphp_page_navi' ) ) { ?>
				<?php seaphp_page_navi(); ?>
			<?php } else { ?>
				<nav class="wp-prev-next">
					<ul class="clearfix">
						<li class="prev-link"><?php next_posts_link( __( '&laquo; Older Entries', 'seaphp-theme' )) ?></li>
						<li class="next-link"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'seaphp-theme' )) ?></li>
					</ul>
				</nav>
			<?php } ?>

		<?php else : ?>

			<article id="post-not-found" class="hentry clearfix">
				<section class="entry-content">
					<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'seaphp-theme' ); ?></p>
				</section>

			</article>

		<?php endif; ?>

		</div>
	</div>
</div>

<?php get_footer(); ?>
