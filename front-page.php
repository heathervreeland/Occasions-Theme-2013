<?php 
/*
 * Standard front page for wordpress site
 */
get_header(); 
?>

<div id="main">

	<div id="homepage">

<?php 
  //$args = array( 'post_type' => 'post', 'posts_per_page' => '2', 'cat' => '-5199,-5167,-5185,-5186,-5169,-5168'  );
  //$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $paged; 
  if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
  elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
  else { $paged = 1; }
  $args = array( 'post_type' => 'post', 'cat' => '-5199,-5167,-5185,-5186,-5169,-5168', 'paged' => $paged, 'posts_per_page' => '5' );
  query_posts($args);
  $i = 1;
  if (have_posts()) : while (have_posts()) : the_post(); 

    //flo_part('post-full');
    get_template_part( 'content', 'home' );
  
    insert_snippet($i);

    $i++;
  endwhile; endif; 
  $i = 1;

  //wp_reset_query();
?>

    <?php // leaving this here as reference incase ads are required between posts ?>
		<!--section class="zone">
			<div class="spot"><script type='text/javascript'>GA_googleFillSlot("660x90_spot_1");</script></div>
		</section-->

		<?php //flo_part('featured-vendors-home') ?>

		<?php 
			$cat = get_category_by_slug( 'from-the-editor' );
			$posts_query = new WP_Query(array(
				'posts_per_page' 	=> 3,
				'cat'				=> $cat->term_id,
			)); 
      $turnoff = false;
		?>
		<?php //if (count($posts_query->posts)) : 
		if ( $turnoff ) : ?>
			<section class="from-editor blog-preview">
				<h3><a href="<?php echo get_category_link( $cat ) ?>">From the Editor</a></h3>			
				<?php while($posts_query->have_posts()): $posts_query->the_post(); ?>
					<?php flo_part('post-loop2') ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</section>
		<?php endif; 
    ?>

	</div>
</div>
<?php get_sidebar('homepage'); ?>
<?php get_footer(); ?>
