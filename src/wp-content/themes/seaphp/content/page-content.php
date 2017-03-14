
<article id="post-<?php echo $record['the_id']; ?>" <?php post_class( 'h-entry' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
	
	<?php if ( is_home() || is_front_page() ): ?>
		<h1 class="p-name entry-title single-title screen-reader-text" itemprop="headline">
	<?php else: ?>
		<h1 class="p-name entry-title single-title" itemprop="headline">
	<?php endif; ?>
	<?php echo 'the_title'; ?></h1>

	<section class="entry-content e-content" itemprop="articleBody">
		<?php  echo $record['the_title']; ?>
	</section>

</article>
