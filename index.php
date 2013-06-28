<?php get_header(); ?>
<div id="main">
	<?php flo_part('bloghead') ?>
	<section class="blog">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php flo_part('post-listing') ?>
		<?php endwhile; else: ?>
			<?php flo_part('notfound')?>
		<?php endif; ?>
	</section>
	<?php flo_part('blogfoot') ?>
	<?php flo_part('blogtop') ?>
</div>
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>
