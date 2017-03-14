<div class="panels clearfix">
	<div class="panel panel-left">
		<h2>Latest Post</h2>
		<img src="{{ latest_post.the_image }}">
		<div class="text latest-post">
			<h3><a href="{{ latest_post.the_link }}">{{ latest_post.the_title }}</a></h3>
			<p>{{ latest_post.the_excerpt }}</p>
		</div>
	</div>

	<div class="panel panel-right">
		<h2>Next Event</h2>
		<img src="{{ next_event.the_image }}">
		<div class="text next-event">
			<h3><a href="{{ next_event.the_link }}">{{ next_event.the_title }}</a></h3>
			<span>{{ next_event.event_date  }}</span>
			<p>{{ next_event.the_excerpt }}</p>
		</div>
	</div>
</div>
