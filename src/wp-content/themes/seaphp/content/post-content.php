
<article id="post-<?php $record['the_id']; ?>" <?php post_class('h-entry clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

	<div class="article-header">
		<h1 class="entry-title single-title" itemprop="headline"><?php
			echo $record['the_title'];
		?></h1>
		<p class="byline vcard"><?php
			printf(
				/* Translators: 1: Link to the Author */
				__('by %1$s', 'the byline of the post says who wrote it', 'seaphp-theme'),
				'THE LINK GOES HERE'	
			);
		?></p>
		<p class="date-info">
			<?php

			printf( __( '<time class="dt-published" datetime="%1$s">%2$s</time>', 'seaphp-theme' ),
				$record['the_time_iso'],
				$record['the_time_human']
			);
			?>
			<br>
			<span class="label-category">
			<?php
			 _ex( 'Category', 'A label for 1 or more categories', 'seaphp-theme' );
			?>
			</span>
			<span class="p-category"><?php echo $record['the_category_list']; ?></span>
		</p>
	</div>

	<section class="entry-content clearfix" itemprop="articleBody">
		<?php echo $record['the_content']; ?>
	</section>

	<div class="article-footer">
		<?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'seaphp-theme' ) . '</span> ', ', ', '</p>' ); ?>
	</div>

	<?php comments_template(); ?>

</article>

