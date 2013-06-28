<?php
	global $post;
	$siblings = array();

	$query = new WP_Query(array(
		'post_parent' 	=> $post->post_parent,
		'post_type'		=> 'page',
		'orderby'		=> 'menu_order',
		'order'			=> 'ASC',
		'posts_per_page'=> -1,
	));
?>
<?php if ($query->have_posts()): ?>
	<nav class="cf">
		<ul>
			<?php while($query->have_posts()) : $query->the_post(); ?>
				<li <?php echo is_page(get_the_ID()) ? 'class="current"' : '' ?>>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</li>
			<?php endwhile; ?>
		</ul>
	</nav>
<?php endif; wp_reset_query(); ?>

			
