
<article id="post-<?php the_ID(); ?>" <?php post_class( 'h-entry article-content' ); ?> role="article">

	<div class="article-header">

		<h1><a href="<?php the_permalink() ?>" class="p-name" rel="bookmark"><?php the_title(); ?></a></h1>
		<p class="byline vcard">
		<?php
			$time_tag = '<time class="dt-published" datetime="%1$s" pubdate>%2$s</time>';

			printf( __( "Posted $time_tag", 'seaphp-theme' ),
				get_the_time( 'c' ),
				get_the_time( get_option( 'date_format' ) )
			);
			printf( __( '<span class="author p-author">%1$s</span>
				<span class="amp">&</span> filed under %2$s.', 'seaphp-theme' ),
				seaphp_get_the_author_posts_link(),
				get_the_category_list(', ')
			);
		?>
		</p>

	</div>

	<div class="entry-content e-content">
		<?php the_content(); ?>
	</div>

	<div class="article-footer">
		<p class="tags"><?php the_tags( '<span class="tags-title">' . __( 'Tags:', 'seaphp-theme' ) . '</span> ', ', ', '' ); ?></p>

	</div>

	<?php // comments_template(); // uncomment if you want to use them ?>
</article>
