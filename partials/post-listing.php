<article <?php post_class(); ?>>
	<header class="listing-preview">


		<?php
		    $images = get_children(array(
		        'post_parent' => get_the_ID(),
		        'post_status' => null,
		        'post_type' => 'attachment',
		        'post_mime_type' => 'image',
		        'order' => 'ASC',
		        'numberposts' => 3,
		        'orderby' => 'menu_order',
		    ));
		?>

		<div class="title cf">
      <? // commented out by Ben Kaplan 5/31/13 - removed gravatar photo ?>
			<!--span class="by-author">
				<a href="<?php echo get_author_posts_url(get_the_author_ID()) ?>" rel="author"><?php echo get_avatar(get_the_author_meta('email'), 58 ); ?></a>
			</span-->
			<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title();?></a></h2>
			<div class="meta">
				Posted 
				<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time(get_option('date_format'));?></time>
				by 
				<a href="<?php echo get_author_posts_url(get_the_author_ID()) ?>" rel="author"><?php the_author() ?></a>
				|
				<span class="categories"><?php the_category(', '); ?></span>
				|
				<a href="<?php comments_link(); ?>"><?php comments_number( 'Post the First Comment', 'One Comment' );?></a>
			</div>
		</div>
		<div class="images">
			<ul class="cf">
				<?php foreach ($images as $img): ?>
					<li>
						<figure>
							<?php echo wp_get_attachment_image( $img->ID, 'post-thumbnail' ) ?>
						</figure>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
		<?php if (!is_single()): ?>
			<div class="excerpt">
				<?php the_excerpt(); ?>
			</div>
		<?php endif ?>
	</header>
</article>
