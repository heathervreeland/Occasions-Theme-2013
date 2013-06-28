<?php get_header(); ?>

<div id="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="homepage">
		<section class="featured cf">
			<?php $cover_query = new WP_Query(array(
				'posts_per_page' 	=> 6,
				'meta_key'			=> 'cover_story',
				'meta_value'		=> 1,
			)); ?>
			<?php if ($cover_query->have_posts()): ?>
				<?php while($cover_query->have_posts()) : $cover_query->the_post(); ?>
					<div class="poster">
						<div class="wrap">
							<figure><?php the_post_thumbnail('post-cover'); ?></figure>
							<div class="detail">
								<p class="category"><?php flo_post_section() ?></p>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<div class="descr"><?php 
									add_filter('excerpt_length', 'flo_custom_excerpt_length', 999);
									the_excerpt(); 
									remove_filter('excerpt_length', 'flo_custom_excerpt_length', 999);
								?></div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				<div class="arrows">
					<a href="#" class="prev">Prev</a>
					<a href="#" class="next">Next</a>
				</div>
				<ul>
					<?php while($cover_query->have_posts()) : $cover_query->the_post(); ?>
						<li class="cf">
							<figure data-source="<?php echo flo_post_thumbnail_src('post-cover'); ?>">
								<?php the_post_thumbnail('post-gthumbnail'); ?>
							</figure>
							<div class="detail">
								<span class="cat"><?php flo_post_section() ?></span>
								<h3><a href="<?php the_permalink(); ?>"><?php echo flo_truncate(get_the_title(), 30); ?></a></h3>
								<time datetime="<?php the_time('Y-m-d') ?>"><?php the_time('F d, Y') ?></time>
							</div>
							<span class="arrow"></span>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
			<?php wp_reset_query(); ?>
		</section>

		<section class="zone">
			<div class="spot"><script type='text/javascript'>GA_googleFillSlot("660x90_spot_1");</script></div>
		</section>

		<section class="latest">
			<ul class="cf">
				<?php $sections = flo_get_sections(); ?>
				<?php foreach ($sections as $section): ?>
					<?php 
						$latest = new WP_Query(array(
							'posts_per_page' 	=> 1,
							'cat'				=> $section->id,
						));
					?>
					<?php if ($latest->have_posts()): ?>
						<?php while($latest->have_posts()) : $latest->the_post(); ?>
							<li>
								<h4><a href="<?php echo get_category_link($section->id)?>"><?php echo $section->name ?></a></h4>
								<a href="<?php the_permalink(); ?>" class="entry">
									<span class="image">
										<?php the_post_thumbnail('post-thumbnail'); ?>
									</span>
									<span class="title">
										<?php the_title(); ?>
									</span>
									<time datetime="<?php the_time('Y-m-d') ?>"><?php the_time('F d, Y') ?></time>
								</a>
								<a href="<?php echo get_category_link($section->id)?>" class="goto">View All</a>
							</li>
						<?php endwhile; ?>
					<?php endif; ?>
					<?php wp_reset_query(); ?>
				<?php endforeach ?>
			</ul>
		</section>
		<?php flo_part('featured-vendors-home') ?>

		<?php 
			$cat = get_category_by_slug( 'from-the-editor' );
			$posts_query = new WP_Query(array(
				'posts_per_page' 	=> 3,
				'cat'				=> $cat->term_id,
			)); 
      $turnoff = false;
		?>
		<?php //if (count($posts_query->posts)) : 
		if ( $turnoff ) : ?>
			<section class="from-editor blog-preview">
				<h3><a href="<?php echo get_category_link( $cat ) ?>">From the Editor</a></h3>			
				<?php while($posts_query->have_posts()): $posts_query->the_post(); ?>
					<?php flo_part('post-loop2') ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</section>
		<?php endif; ?>

	</div>
<?php endwhile; endif; ?>
</div>
<?php get_sidebar('homepage'); ?>
<?php get_footer(); ?>
