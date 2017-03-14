
{{#each posts}}
<article id="post-{{ the_id }}" class="h-entry" role="article" itemscope itemtype="http://schema.org/BlogPosting">

	{{#if is_front}}
		<h2 class="p-name entry-title single-title screen-reader-text" itemprop="headline">
			<a href="{{ the_link }}">
				{{ the_title }}
			</a>
		</h2>
	{{else}}
		<h2 class="p-name entry-title single-title" itemprop="headline">
			<a href="{{ the_link }}">
				{{ the_title }}
			</a>
		</h2>
	{{/if}}

	<section class="entry-content e-content" itemprop="articleBody">
		{{the_excerpt}}
	</section>
		<p><a href="{{the_link}}">Continue Reading <span class="screen-reader-text">{{the_title}}</span></a></p>
</article>
{{/each}}
