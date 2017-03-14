<?php
// Grab the metadata from the database
$prefix = '_member_';
$role = get_post_meta( get_the_ID(), $prefix . 'organizer_role', true );
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('h-entry'); ?> role="article">

	<header class="article-header">
		<h3 class="member-name"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
		<?php if ($role): ?>
		<div class="member-role"><?php echo $role; ?></div>
		<?php endif; ?>
		<?php the_post_thumbnail(); ?>
	</header>

	<section class="entry-summary p-summary">
		<?php the_excerpt(); ?>
	</section>

</div>
