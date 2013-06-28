<?php get_header(); ?>
<div id="main">
	<header class="page-title cf">
		<h2><?php echo get_the_title($post->post_parent) ?></h2>	
	</header>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<section class="blog" id="post">
			<article <?php post_class(); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
				<header>
					<h3><?php the_title(); ?></h3>
				</header>
				<section class="story cf">
					<p class="attachment">
						<a href="<?php echo wp_get_attachment_url($post->ID); ?>" rel="external"><?php the_title(); ?></a>
					</p>
					<?php the_content(); ?>
				</section>
			</article>
		</section>
	<?php endwhile; else: ?>
		<?php flo_part('notfound')?>
	<?php endif; ?>
</div>
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>