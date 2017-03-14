{{#if event_data}}
<article id="post-{{ event.the_id }}" class="h-entry article-content" role="article">

<div class="article-header">

	<h2><a href="{{ the_permalink }}" class="p-name" rel="bookmark">{{ event_data.location_name }}</a></h2>
	<p>

		<a href="{{ event_data.event_link }}">Meetup Link</a><br>
		{{ event_data.event_date }} &nbsp;&nbsp;&nbsp;
		{{ event_data.event_start_time }}
		- {{ event_data.event_end_time }} <br>
	</p>

	<p>
		<time class="dt-published" datetime="{{ the_date_iso }}" pubdate>{{ event_data.the_date }}</time>
		{{ event_data.location_address }} <br>
		{{#if event_data.location_address2 }}
		    {{ event_data.location_address2 }} <br>
		{{/if}}
		{{ event_data.location_city }}, {{ event_data.location_zipcode }}<br>
		<a href="{{ event_data.event_map }}">Map Link</a> <br>
	</p>


</div>

<div class="entry-content e-content">
	{{ the_content }}
</div>

<div class="article-footer">
	<p class="tags">{{ the_tags }}</p>

</div>
</article>
{{/if}}
