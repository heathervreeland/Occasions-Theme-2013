<aside id="sidebar">
	<?php flo_part('side-expo') ?>
	<?php flo_part('side-subscribe') ?>
	<?php flo_part('side-top-ad') ?>
  <?php

	flo_part('side-top-ad');

    if ( is_single() ) {

      // if we are looking at a single post

      $terms = get_the_terms( $post->ID, 'region' );

      if( $terms ) {

        $i = 1;

        foreach( $terms as $term ) {
          if ( $i == 1 ) {
            $state = $term;
          } else if ( $i == 2 ) {
            $region = $term;
          } else {
            $region == null;
            $state == null;
          }
          $i++;
        }
        
        $i = 1;

      }


    } else {

      // if we are looking at an advertiser or something else

      $region = get_term_by('slug', get_query_var('region'), 'region');

      // test if this is a parent ( aka a state )
      if ($region->parent) {

        // if it is a state, then set the $state variable to the parent taxonomy
        $state = get_term($region->parent, 'region');

      } else {

        // otherwise we assume that we are in a city

        // set the $state object to the $region object
        $state = $region;

        // set the $region object to false
        $region = false;

      }

    }

  $venues = get_terms('venue-type', array(
    'hide_empty' => false,
  ));

  if ( false && count($venues) && $region) : 

  ?>
	<div class="block services">
		<h3 class="a">Venues in <?php echo $region->name ?></h3>
		<ul>
			<?php foreach ($venues as $venue): ?>
				<li>
					<a href="<?php echo flo_region_venue_permalink($region, $venue->slug, 'venues') ?>"><?php echo $venue->name ?></a>
				</li>
			<?php endforeach ?>
		</ul>		
	</div>
	<?php endif; ?>

	<?php
		$cat_query = new WP_Query(array(
			'posts_per_page'	=> 5,
			'post_type'			=> 'event',
			'tax_query'			=> array(
				array(
					'taxonomy'	=> 'region',
					'field'		=> 'slug',
					'terms'		=> $region->slug,
				),
			),
			'ignore_filter_changes'	=> true,
			'norewrite'			=> true,
		));
	  if ($cat_query->have_posts()) : 
  ?>	
	<div class="block s-events">
		<h3 class="a">Events in <?php echo $region->name ?></h3>
		<ul>
			<?php while($cat_query->have_posts()): $cat_query->the_post(); ?>
				<?php
					if (has_post_thumbnail()) {
						$image = flo_get_post_thumbnail_src('event-preview');
					} else {
						$image = flo_get_event_venue_featured_image_src(get_the_ID(), 'post-cat-cover');
					}
				?>
				<li data-image="<?php echo $image ?>">
					<a href="<?php the_permalink() ?>">
						<span class="title"><?php the_title(); ?></span>
						<time datetime="<?php the_time('Y-m-d'); ?>"><?php echo flo_get_event_date() ?></time>
					</a>
				</li>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</ul>
		<!-- <a href="<?php flo_region_events_permalink($region); ?>" class="goto">View All</a> -->
	</div>
	<?php 

    endif;
	
		$services = get_terms('service', array(
			'hide_empty' => false,
		));
	?>	
	<?php if (count($services) && $region) : ?>
	<div class="block services">
		<h3 class="a">Services in <?php echo $region->name ?></h3>
		<ul>
			<?php foreach ($services as $service): ?>
				<li>
					<a href="<?php echo flo_region_venue_permalink($region, $service->slug, 'services') ?>"><?php echo $service->name ?></a>
				</li>
			<?php endforeach ?>
		</ul>		
	</div>		
	<?php endif; ?>
  <?php dynamic_sidebar('flotheme-upper'); ?>
	<?php flo_part('side-newsletter') ?>
  <?php dynamic_sidebar('flotheme-middle'); ?>
	<?php flo_part('side-top-ads') ?>
	<?php flo_part('side-follow') ?>
	<?php flo_part('side-ads') ?>
  <?php dynamic_sidebar('flotheme-lower'); ?>
</aside>

					
					
