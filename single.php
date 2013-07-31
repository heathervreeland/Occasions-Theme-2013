<?php get_header(); ?>
<div id="main">
	<?php flo_part('bloghead') ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<section class="blog" id="post" data-post-id="<?php the_ID(); ?>">
			<article <?php post_class(); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
				<?php flo_part('postpreview' );?>
				<section class="story cf">
					<?php if ($_REQUEST['nggpage'] == '') : ?>
						<?php add_filter('the_content','flo_wrap_image_credits'); ?>
						<?php the_content(); ?>
						<?php remove_filter('the_content','flo_wrap_image_credits'); ?>
					<?php else: ?>
						<?php preg_match('/\[nggallery.+id=\d+\]/i', $post->post_content, $ngg); ?>
						<?php echo do_shortcode( $ngg[0] ); ?>
					<?php endif; ?>
				</section>
				<?php if (has_post_format('gallery')) : ?>
					<?php flo_part('post-gallery') ?>
				<?php endif; ?>
				<?php wp_link_pages(array(
					'before' => '<section class="story-pages"><p>' . __('Pages:', 'flotheme'),
					'after'	 => '</p></section>',
				)) ?>
				<?php flo_part('share-this-post') ?>
				<?php flo_part('featured-vendors-home') ?>
				<?php comments_template(); ?>
			</article>
		</section>
	<?php endwhile; else: ?>
		<?php flo_part('notfound')?>
	<?php endif; ?>
</div>
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>
