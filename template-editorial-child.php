<?php 
/**
 * Template Name: Template Editorial Child
 */
get_header(); ?>
<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php $this_page = get_page_by_path('editorial'); ?>
		<div id="page-about">
			<?php flo_page_title($this_page->post_title) ?>
			<?php flo_part('nav-w-short-titles') ?>
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
