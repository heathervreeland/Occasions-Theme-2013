<?php 
/**
 * Template Name: Template Cart66
 */
get_header(); ?>
<div id="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="cart66-wrap">
		<?php the_content();?>
	</div>
<?php endwhile; else: ?>
	<?php flo_part('notfound')?>
<?php endif; ?>
</div>
<?php get_sidebar('subscribe'); ?>
<?php get_footer(); ?>