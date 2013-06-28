<?php 
/**
 * Template Name: Template EXPO Sponsors
 */
get_header(); ?>
<div id="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="expo">
		<?php flo_part('expo-nav') ?>
		<article <?php post_class(); ?>>
			<section class="story">
				<?php the_content();?>
			</section>
		</article>
		<?php flo_part('expo-footer') ?>
	</div>
<?php endwhile; else: ?>
	<?php flo_part('notfound')?>
<?php endif; ?>
</div>
<?php get_sidebar('general-page'); ?>
<?php get_footer(); ?>