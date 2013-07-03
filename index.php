<?php get_header(); ?>
<div id="main">
	<?php flo_part('bloghead') ?>
	<section class="blog">
		<?php 
    if (have_posts()) : 

      // a counter to test for the 'paged' number
      $i = 1;

      // grab the number of posts to display set in the WP admin gui
      global $posts_per_page;

      while (have_posts()) : the_post(); ?>
      <?php

      // if we are on the home page, then show full posts
      if ( is_home() ) { 

        // an empty variable for tossing a css class into
        $last = '';

        // if we only have three blog
        if ( $i == $posts_per_page ) $last = ' last';
      ?>

      <article <?php post_class($last); ?> id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>">

        <div class="title cf">
          <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title();?></a></h2>
          <div class="meta">
            Posted 
            <time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time(get_option('date_format')); ?></time>
            by 
            <a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" rel="author"><?php the_author(); ?></a>
            |
            <span class="categories"><?php the_category(', '); ?></span>
            |
            <a href="<?php comments_link(); ?>"><?php comments_number( 'Post the First Comment', 'One Comment' ); ?></a>
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
          <?php flo_part('post-gallery'); ?>
        <?php endif; ?>

      </article>

      <?php
        if ( $i != $posts_per_page ) {

          // if we are not on the last post display of the page
          flo_part('featured-vendors-home');

        }

        $i++;

      // if we are on some other archive page, then show excerpts
      } else {

        flo_part('post-listing');

      }
      ?>
		<?php endwhile; else: ?>
			<?php flo_part('notfound')?>
		<?php endif; ?>
	</section>
	<?php flo_part('blogfoot') ?>
	<?php flo_part('blogtop') ?>
</div>
<?php 
  if ( is_home() ) {

    // if we are on the home page
    get_sidebar('homepage'); 

  } else {

    // if we are elsewhere displaying blog or archives
    get_sidebar('blog'); 

  }
?>
<?php get_footer(); ?>
