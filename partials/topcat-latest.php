<section class="latest">
	<ul class="cf">
		<?php
			$categories = get_weddings_top_categories();
		?>
		<?php foreach ($categories as $cat): ?>
			<?php 
				$latest = new WP_Query(array(
					'posts_per_page' 	=> 1,
					'cat'				=> $cat->id,
				)); 
			?>
			<?php if ($latest->have_posts()): ?>
				<?php while($latest->have_posts()) : $latest->the_post(); ?>
					<li>
						<h4><a href="<?php echo get_category_link($cat->id)?>"><?php echo $cat->name ?></a></h4>
						<a href="<?php the_permalink(); ?>" class="entry">
							<span class="image"><?php the_post_thumbnail('post-thumbnail'); ?></span>
							<span class="title"><?php the_title(); ?></span>
							<time datetime="<?php the_time('Y-m-d') ?>"><?php the_time('F d, Y') ?></time>
						</a>
						<a href="<?php echo get_category_link($cat->id)?>" class="goto">GO TO <?php echo $cat->name ?></a>
					</li>
				<?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_query(); ?>
		<?php endforeach ?>
	</ul>
</section>