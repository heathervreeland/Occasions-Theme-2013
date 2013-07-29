<?php get_header(); ?>
<div id="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="page">
		<?php flo_page_title(get_the_title()) ?>
		<article <?php post_class(); ?>>
			<section class="story">
				<?php the_content();?>
			</section>
		</article>
	</div>
<?php endwhile; else: ?>
	<?php flo_part('notfound')?>
<?php endif; ?>
</div>
<?php get_sidebar('general-page'); ?>
<?php get_footer(); ?>
