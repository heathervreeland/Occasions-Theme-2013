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
				<div class="share">
					<span>Share This Post</span>
					<div class="fb-like" data-href="<?php the_permalink()?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
					<div class="plus1"><g:plusone size="medium" href="<?php the_permalink()?>"></g:plusone></div>
					<div class="tweet"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink()?>" data-count="horizontal">Tweet</a></div>
					<div class="pin"><a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink() ?>&media=<?php flo_og_meta_image() ?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>
				</div>
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
