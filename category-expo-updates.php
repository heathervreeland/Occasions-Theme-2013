<?php get_header(); ?>
<div id="main">
	<div id="expo" class="expo-blog">
		<?php flo_part('expo-nav') ?>
	</div>
	<section class="blog">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php flo_part('post-loop') ?>
		<?php endwhile; else: ?>
			<?php flo_part('notfound')?>
		<?php endif; ?>
	</section>
	<?php flo_part('blogfoot') ?>
	<?php flo_part('expo-footer') ?>
</div>
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>