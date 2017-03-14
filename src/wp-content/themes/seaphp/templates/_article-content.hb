{{#each posts}}
<article id="post-{{ the_id }}" class="h-entry article-content" role="article">

<div class="article-header">

	<h1><a href="{{ the_permalink }}" class="p-name" rel="bookmark">{{ the_title }}</a></h1>
	<p class="byline vcard">
		<time class="dt-published" datetime="{{ the_date_iso }}" pubdate>{{ the_date_human }}</time>

		<span class="author p-author">by {{ the_author_link }}</span>
		<span class="amp">&</span> filed under {{ the_category_list }}.
	</p>

</div>

<div class="entry-content e-content">
	{{ the_content }}
</div>

<div class="article-footer">
	<p class="tags">{{ the_tags }}</p>

</div>
</article>
{{/each}}
