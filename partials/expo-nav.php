<?php
	global $post;

	$expo = get_page_by_path('expo');

	$query = new WP_Query(array(
		'post_parent' 	=> $expo->ID,
		'post_type'		=> 'page',
		'orderby'		=> 'menu_order',
		'order'			=> 'ASC',
		'posts_per_page'=> -1,
	));
?>

<?php flo_page_title($expo->post_title) ?>

<?php flo_part('featured-big') ?>

<?php if ($query->have_posts()): ?>
	<nav class="cf">
		<ul>
			<?php while($query->have_posts()) : $query->the_post(); ?>
				<li class="<?php echo basename(get_permalink()) ?><?php echo is_page(get_the_ID()) ? ' current' : '' ?>">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</li>
			<?php endwhile; ?>
			<?php
				$category = get_category_by_slug( 'expo-updates' );
			?>
			<li class="expo <?php echo is_category('expo-updates') ? ' current' : '' ?>">
				<a href="<?php echo get_category_link( $category ) ?>">From the Blog</a>
			</li>
		</ul>
	</nav>
<?php endif; wp_reset_query(); ?>