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
      <?php

        // need to set a custom field on the page/post titled 'nav-title' in order to create short menus

        $post_id = get_the_ID();

        // the key value of the custom field
        $key = 'nav-title';

        // grab the value of the custom field above 
        $nav_title = get_post_meta( $post_id, $key );

        // if there is now custom field with nav-title, then skip it :)
        if ( $nav_title[0] == '' ) continue;
      ?>
				<li <?php echo is_page(get_the_ID()) ? 'class="current"' : '' ?>>
					<a href="<?php the_permalink(); ?>"><?php echo $nav_title[0]; ?></a>
          <? //var_dump($nav_title); ?>
				</li>
			<?php endwhile; ?>
		</ul>
	</nav>
<?php endif; wp_reset_query(); ?>

			
