<aside id="sidebar" class="region-sidebar">
  <?php

	flo_part('side-top-ad');

		
		$venues_term = get_terms('service', array('slug' => "venues"));
		$venues_term = $venues_term[0];


  $region = get_term_by('slug', get_query_var('region'), 'region');
  if ($region->parent) {
    $state = get_term($region->parent, 'region');
  } else {
    $state = $region;
    $region = false;
  }
// 
  // $venues = get_terms('venue-type', array(
    // 'hide_empty' => false,
  // ));

  
	$venues = get_terms('service', array(
		'hide_empty' => false,
		'parent' => $venues_term->term_id
	));
  
  if (count($venues) && $region) : 

  ?>
	<div class="block services">
		<h3 class="a">Venues in <?php echo $region->name ?></h3>
		<ul>
			<?php foreach ($venues as $venue): ?>
				<li>
					<a href="<?php echo flo_get_service_permalink($region, $venue->slug) ?>"><?php echo $venue->name ?></a>
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
				<?php if($service->parent == $venues_term->term_id || $service->slug == "venues") continue; ?>
				<li>
					<a href="<?php echo flo_get_service_permalink($region, $service->slug) ?>"><?php echo $service->name ?></a>
				</li>
			<?php endforeach ?>
		</ul>		
	</div>		
	<?php endif; ?>

  <?php dynamic_sidebar('flotheme-upper'); ?>
	<?php flo_part('side-newsletter') ?>
  <?php dynamic_sidebar('flotheme-middle'); ?>
	<?php flo_part('side-ads') ?>
  <?php dynamic_sidebar('flotheme-lower'); ?>
</aside>
