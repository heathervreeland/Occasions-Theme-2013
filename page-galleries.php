<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
	<div id="galleries">
		<div class="coming-soon"></div>
	</div>
<?php endwhile; ?>
<?php get_footer(); ?>