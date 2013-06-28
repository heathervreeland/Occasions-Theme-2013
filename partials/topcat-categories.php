<?php
	$cat_id = get_query_var('cat');
?>

<?php
	$subcats = get_categories(array(
		'hierarchial' => 0,
		'parent'	  => $cat_id,
	));
?>
<?php foreach ($subcats as $cat): ?>
	<?php
		$cat_query = new WP_Query(array(
			'cat'				=> $cat->term_id,
			'posts_per_page'	=> 3,
		));
	?>
	<?php if ($cat_query->have_posts()): ?>
		<div class="category-preview cf">
			<h3><a href="<?php echo get_category_link($cat); ?>"><?php echo $cat->name ?></a></h3>
			<div class="image">
				
			</div>
			<div class="listing">
				<ul>
					<?php while($cat_query->have_posts()): $cat_query->the_post(); ?>
					<?php flo_get_post_thumbnail_src('post-cat-cover', get_the_ID()) ?>
						<li data-image="<?php echo flo_get_post_thumbnail_src('post-cat-cover', get_the_ID()) ?>">
							<a href="<?php the_permalink() ?>">
								<span class="title"><?php the_title(); ?></span>
								<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time(get_option('date_format'));?></time>
								<span class="descr">
									<?php echo flo_truncate(get_the_excerpt(), 50) ?>
								</span>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
				<a href="" class="goto">View All</a>
			</div>
		</div>
	<?php endif ?>
<?php endforeach ?>