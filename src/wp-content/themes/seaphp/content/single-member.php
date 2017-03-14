<?php 
	$post_id = get_the_ID();
	$seaphp = get_post_meta( $post_id, '_seaphp_info', true );
	$social_data = get_post_meta( $post_id, '_social_info', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'h-entry' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

	<?php if ( ! is_home() && ! is_front_page() ): ?>
	<h1 class="p-name" itemprop="headline"><?php the_title(); ?>
		<?php if ( ! empty($seaphp['featured']) ): ?>
			<span class="featured">featured</span>
		<?php endif; ?>
	</h1>
	<?php endif; ?>

	<section class="entry-content e-content" itemprop="articleBody">
		<?php the_content(); ?>
	</section>

	<div>
	<?php if ( ! empty($social_data['twitter']) ): ?>
		<strong>Twitter: <?php echo $social_data['twitter']; ?></strong><br />
	<?php endif; ?>

	<?php if ( ! empty($social_data['facebook']) ): ?>
		<strong>Facebook: <?php echo $social_data['facebook']; ?></strong><br />
	<?php endif; ?>

	<?php if ( ! empty($social_data['linkedin']) ): ?>
		<strong>LinkedIn: <?php echo $social_data['linkedin']; ?></strong><br />
	<?php endif; ?>

	<?php if ( ! empty($social_data['skype']) ): ?>
		<strong>Skype: <?php echo $social_data['skype']; ?></strong><br />
	<?php endif; ?>

	<?php if ( ! empty($social_data['website']) ): ?>
		<strong>Website: <?php echo $social_data['website']; ?></strong><br />
	<?php endif; ?>
	</div>


	<?php if ( ! empty($social['organizer']) ): ?>
		<strong>She is an organizer</strong>
	<?php endif; ?>


</article>
