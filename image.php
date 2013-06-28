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
					<p><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'full' ); ?></a></p>
					<?php the_content(); ?>
				</section>
				<div class="share">
					<span>Share This Image</span>
					<div class="fb-like" data-href="<?php the_permalink()?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
					<div class="plus1"><g:plusone size="medium" href="<?php the_permalink()?>"></g:plusone></div>
					<div class="tweet"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink()?>" data-count="horizontal">Tweet</a></div>
					<div class="pin"><a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink() ?>&media=<?php flo_og_meta_image() ?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>
				</div>
				<footer>
					<nav class="prev-next-links cf">
						<span class="prev"><?php previous_image_link() ?></span>
						<span class="next"><?php next_image_link() ?></span>
					</nav>
				</footer>
			</article>
		</section>
	<?php endwhile; else: ?>
		<?php flo_part('notfound')?>
	<?php endif; ?>
</div>
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>