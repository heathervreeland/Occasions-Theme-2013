<article <?php post_class(); ?>>
	<div class="cf">
		<figure>
			<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_post_thumbnail('post-preview')?></a>
		</figure>

		<div class="detail">
			<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title();?></a></h2>
			<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time(get_option('date_format'));?></time>
			<div class="excerpt">
				<?php 
					add_filter('excerpt_length', 'flo_custom_excerpt_length', 999);
					the_excerpt(); 
					remove_filter('excerpt_length', 'flo_custom_excerpt_length', 999);
				?>
			</div>
		</div>
	</div>
</article>