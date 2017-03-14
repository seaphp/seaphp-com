<div id="home-sidebar" class="sidebar-home" role="complementary">


	<?php if ( is_active_sidebar( 'home_sidebar' ) ) : ?>

		<?php dynamic_sidebar( 'home_sidebar' ); ?>
	<?php else : ?>

		<?php // This content shows up if there are no widgets defined in the backend. ?>

		<div class="alert alert-help">
			<p><?php _e( 'Please activate some Widgets.', 'seaphp-theme' );  ?></p>
		</div>

	<?php endif; ?>

</div>
