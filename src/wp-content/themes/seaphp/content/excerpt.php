
<article id="post-<?php the_ID(); ?>" <?php post_class('h-entry'); ?> role="article">

	<header class="article-header">
		<h2 class="search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

		<p class="byline vcard"><?php
			printf(
				/* Translators: 1: Link to the Author */
				__('by %1$s', 'the byline of the post says who wrote it', 'seaphp-theme'),
				seaphp_get_the_author_posts_link()
			);
		?></p>
	</header>

	<section class="entry-summary p-summary">
		<?php the_excerpt(); ?>
	</section>

</article>
