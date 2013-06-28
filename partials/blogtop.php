<ul class="blog-top cf">
	<?php $most_commented = new WP_Query(array(
		'posts_per_page' => 1,
		'meta_key'			=> 'featured_story',
		'meta_value'		=> 1,
	)) ?>
	<?php if ($most_commented->have_posts()): ?>
	<li class="featured">
		<h3>Featured</h3>
			<?php while($most_commented->have_posts()) : $most_commented->the_post();?>
				<figure>
					<?php the_post_thumbnail('post-thumbnail'); ?>
				</figure>
				<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
				<time datetime="<?php the_time('Y-m-d') ?>"><?php the_time('F d, Y') ?></time>
				<span class="more">
					<a href="<?php the_permalink(); ?>">View More</a>
				</span>
			<?php endwhile;?>
		</li>		
	<?php endif; wp_reset_query(); ?>

	<?php 
		$most_popular = wmp_get_popular(array(
			'limit' => 1,
			'range' => 'monthly',
		));
	?> 
	<?php foreach ($most_popular as $entry): ?>
		<li class="popular">
			<h3>Most <span>Popular</span></h3>
				<figure>
					<img src="<?php flo_post_thumbnail_src('post-thumbnail', $entry->ID); ?>" alt="" />
				</figure>
				<h4><a href="<?php echo get_permalink($entry->ID); ?>"><?php echo get_the_title($entry->ID); ?></a></h4>
				<time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_time('F d, Y', $entry->ID) ?></time>
				<span class="more">
					<a href="<?php echo get_permalink($entry->ID); ?>">View More</a>
				</span>
		</li>
	<?php endforeach ?>

	<?php $most_commented = new WP_Query(array(
		'posts_per_page' => 1,
		'orderby'		 => 'comment_count',
		'order'			 => 'DESC',
	)) ?>
	<?php if ($most_commented->have_posts()): ?>
		<li class="commented">
			<h3>Most <span>Commented</span></h3>
			<?php while($most_commented->have_posts()) : $most_commented->the_post();?>
				<figure>
					<?php the_post_thumbnail('post-thumbnail'); ?>
				</figure>
				<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
				<time datetime="<?php the_time('Y-m-d') ?>"><?php the_time('F d, Y') ?></time>
				<span class="more">
					<a href="<?php the_permalink(); ?>">View More</a>
				</span>
			<?php endwhile;?>
		</li>		
	<?php endif; wp_reset_query(); ?>
</ul>