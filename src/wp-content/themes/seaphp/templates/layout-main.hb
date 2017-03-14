
<div id="main">
	<div id="main-content" class="content clearfix" role="main">
		{{#if is_blog}}
			{{> article-content }}
		{{else}}
			{{#if panels}}
				{{ panels }}
				<hr>
			{{/if}}
			{{> loop-content }}
		{{/if}}

	</div>

	{{#if event_content}}
	<div id="event-content" class="supplemental-content">
		{{ event_content }}
	</div>
	{{/if}}

	{{#if organizers}}
	<div id="organizers-content" class="supplemental-content">
		<h2>Organizers</h2>
		{{> member-excerpt }}
	</div>
	{{/if}}

	{{#if blog_content}}
	<div id="blog-content" class="supplemental-content">
		{{ blog_content }}
	</div>
	{{/if}}
</div>
