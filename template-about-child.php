<?php 
/**
 * Template Name: Template About Child
 */
get_header(); ?>
<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php $about = get_page_by_path('about'); ?>
		<div id="page-about">
			<?php flo_page_title($about->post_title) ?>
			<?php flo_part('about-nav') ?>
			<article <?php post_class(); ?>>
				<div class="story">
					<?php the_content(); ?>
				</div>
			</article>
		</div>
	<?php endwhile; else: ?>
		<?php flo_part('notfound')?>
	<?php endif; ?>
</div>
<?php get_sidebar('about'); ?>
<?php get_footer(); ?>