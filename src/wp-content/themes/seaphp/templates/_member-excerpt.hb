{{#each organizers}}
<div id="post-{{ the_ID }}" class="member clearfix"  role="article">

<header class="article-header">
	<h3 class="member-name"><a href="{{ the_permalink }}" rel="bookmark">{{ the_title }} </a>
	{{#if role}}
		<span class="member-role">{{ role }}</span>
	{{/if}}
	</h3>

</header>

<section class="entry-summary p-summary">
	{{#if the_image }}
		<img class="photo photo-member" src="{{ the_image }}" alt="Photo of {{the_title}}">
	{{/if}}
	{{ the_excerpt }}
</section>

</div>
{{/each}}
