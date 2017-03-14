
{{#each posts}}
<article id="post-{{ the_id }}" class="h-entry" role="article" itemscope itemtype="http://schema.org/BlogPosting">

	{{#if is_front}}
		<h1 class="p-name entry-title single-title screen-reader-text" itemprop="headline">{{ the_title }}</h1>
	{{else}}
		<h1 class="p-name entry-title single-title" itemprop="headline">{{ the_title }}</h1>
	{{/if}}

	<section class="entry-content e-content" itemprop="articleBody">
		{{#if is_event  }}
			{{#if the_image }}
			<div>
				<img src="{{ the_image }}" alt="featured image">
			</div>
			{{/if}}
		{{/if}}

		{{the_content}}
	</section>

	{{#unless is_front}}
		{{#if is_blog}}
			{{!-- do nothing --}}
		{{#else}}
			<p><a href="{{the_link}}">Continue Reading <span class="screen-reader-text">{{the_title}}</span></a></p>
		{{/if}}
	{{/unless}}

</article>
{{/each}}
