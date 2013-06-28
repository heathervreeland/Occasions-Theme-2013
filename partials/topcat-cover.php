<?php 
	$cover_query = new WP_Query(array(
		'posts_per_page' 	=> 5,
		'cat'				=> get_query_var('cat'),
	)); 
?>
<?php if ($cover_query->have_posts()): ?>
	<section class="cover">
		<div class="flexslider">
			<ul class="slides">
				<?php while($cover_query->have_posts()): $cover_query->the_post(); ?>
					<li>
						<figure><?php the_post_thumbnail('post-cat-cover') ?></figure>
						<div class="detail">
							<h2><a href="<?php the_permalink() ?>"><?php echo flo_truncate(get_the_title(), 30) ?></a></h2>
							<time datetime="<?php the_time('Y-m-d') ?>"><?php the_time('F d, Y') ?></time>
							<p><?php echo flo_truncate(get_the_excerpt(), 110) ?></p>
						</div>
					</li>
				<?php endwhile;?>
			</ul>
		</div>
	</section>
<?php endif ?>