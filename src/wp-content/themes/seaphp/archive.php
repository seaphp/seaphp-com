<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap clearfix">

		<div id="main" class="eightcol first clearfix" role="main">

			<h1 class="archive-title">
			<?php if (is_category()) { ?>
					<span><?php _e( 'Posts Categorized:', 'seaphp-theme' ); ?></span>
					<?php single_cat_title(); ?>

			<?php } elseif (is_tag()) { ?>
					<span><?php _e( 'Posts Tagged:', 'seaphp-theme' ); ?></span>
					<?php single_tag_title(); ?>

			<?php } elseif (is_author()) {
				global $post;
				$author_id = $post->post_author;
				?>
					<span><?php _e( 'Posts By:', 'seaphp-theme' ); ?></span>
					<?php the_author_meta('display_name', $author_id); ?>
			<?php } elseif (is_day()) { ?>
					<span><?php _e( 'Daily Archives:', 'seaphp-theme' ); ?></span>
					<?php the_time('l, F j, Y'); ?>

			<?php } elseif (is_month()) { ?>
					<span><?php _e( 'Monthly Archives:', 'seaphp-theme' ); ?></span>
					<?php the_time('F Y'); ?>

			<?php } elseif (is_year()) { ?>
				<span><?php _e( 'Yearly Archives:', 'seaphp-theme' ); ?></span> <?php the_time('Y'); ?>
			<?php } ?>
			</h1>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

					<header class="article-header">

						<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
						<p class="byline vcard"><?php
							printf(__( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'seaphp-theme' ), get_the_time('c'), get_the_time( get_option( 'date_format' )), seaphp_get_the_author_posts_link(), get_the_category_list(', '));
						?></p>

					</header>

					<section class="entry-content clearfix">
						<?php the_post_thumbnail( 'seaphp-thumb-300' ); ?>
						<?php the_excerpt(); ?>
					</section>

					<footer class="article-footer">

					</footer>

				</article>

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
					<header class="article-header">
						<h1><?php _e( 'Oops, Post Not Found!', 'seaphp-theme' ); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'seaphp-theme' ); ?></p>
					</section>
					<footer class="article-footer">
						<p><?php _e( 'This is the error message in the archive.php template.', 'seaphp-theme' ); ?></p>
					</footer>
				</article>

			<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
