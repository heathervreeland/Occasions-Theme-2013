<header class="preview">
	<?php if (!is_single() && has_post_thumbnail()):?>
		<figure>
			<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_post_thumbnail('post-preview')?></a>
		</figure>
	<?php endif;?>
	<div class="title cf">
    <? // commented out by Ben Kaplan 5/31/13 - removed gravatar from display ?>
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
	<?php if (!is_single()): ?>
		<div class="excerpt">
			<?php the_excerpt(); ?>
		</div>
	<?php endif ?>
</header>
