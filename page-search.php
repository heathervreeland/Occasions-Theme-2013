<?php get_header(); ?>
<div id="main" class="search">
	<?php flo_part('bloghead') ?>
	<section class="blog">
		<!-- Put the following javascript before the closing </head> tag. -->
		<script>
		(function() {
			var cx = '006251671436250040014:02mnuelawn0';
			var gcse = document.createElement('script'); gcse.type = 'text/javascript'; gcse.async = true;
			gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
			    '//www.google.com/cse/cse.js?cx=' + cx;
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
		})();
		</script>

		<!-- Place this tag where you want both of the search box and the search results to render -->
		<gcse:search></gcse:search>
		  
	</section>
</div>
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>      