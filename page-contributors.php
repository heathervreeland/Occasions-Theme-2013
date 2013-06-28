<?php get_header(); ?>
<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php $about = get_page_by_path('about'); ?>
		<div id="page-about">
			<?php flo_page_title($about->post_title) ?>
			<?php flo_part('about-nav') ?>
			<?php
				$authors = flo_all_authors();
			?>
			<section class="contributors">
				<ul class="cf">
					<?php foreach ($authors as $author): ?>
						<li>
							<figure>
								<?php 
									// the_author_image($author->ID); 
									echo get_avatar($author->ID, 205);
								?>
							</figure>
							<div class="detail">
								<h3><?php the_author_meta('first_name', $author->ID) ?> <?php the_author_meta('last_name', $author->ID) ?></h3>
								<p class="position">
									<?php echo get_the_author_meta('position', $author->ID) ?>
								</p>
								<p class="links">
									<a href="<?php echo get_author_posts_url($author->ID); ?>">Profile</a>
									<?php if (get_the_author_meta('url', $author->ID)): ?>
										|
										<a href="<?php the_author_meta('url', $author->ID) ?>">Website</a>
									<?php endif ?>
								</p>
							</div>
						</li>
					<?php endforeach ?>
				</ul>
			</section>
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