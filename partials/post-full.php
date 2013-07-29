
			<article <?php post_class(); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">

        <div class="title cf">
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

				<section class="story cf">
					<?php if ($_REQUEST['nggpage'] == '') : ?>
						<?php add_filter('the_content','flo_wrap_image_credits'); ?>
						<?php the_content(); ?>
						<?php remove_filter('the_content','flo_wrap_image_credits'); ?>
					<?php else: ?>
						<?php preg_match('/\[nggallery.+id=\d+\]/i', $post->post_content, $ngg); ?>
						<?php echo do_shortcode( $ngg[0] ); ?>
					<?php endif; ?>
				</section>

				<?php if (has_post_format('gallery')) : ?>
					<?php flo_part('post-gallery') ?>
				<?php endif; ?>

			</article>

      <?php flo_part('featured-vendors-home') ?>

