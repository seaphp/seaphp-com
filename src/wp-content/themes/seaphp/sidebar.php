<div id="main-sidebar" class="sidebar fourcol last clearfix" role="complementary">

	<?php if ( is_active_sidebar( 'main_sidebar' ) ) : ?>

		<?php dynamic_sidebar( 'main_sidebar' ); ?>

	<?php else : ?>

		<?php // This content shows up if there are no widgets defined in the backend. ?>

		<div class="alert alert-help">
			<p><?php _e( 'Please activate some Widgets.', 'seaphp-theme' );  ?></p>
		</div>

	<?php endif; ?>

</div>
