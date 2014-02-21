<aside id="sidebar" class="region-sidebar region-top">
	<?php flo_part('side-top-ad') ?>

	<?php 
	
		$venues_term = get_terms('service', array('slug' => "venues"));
		$venues_term = $venues_term[0];
	
		$region = get_term_by('slug', get_query_var('region'), 'region');
		if ($region->parent) {
			$state = get_term($region->parent, 'region');
		} else {
			$state = $region;
			$region = false;
		}
	?>

	<?php 
	
		$venues_term = get_terms('service', array('slug' => "venues"));
		$venues_term = $venues_term[0];
		
	
		// $venues = get_terms('service', array(
			// 'hide_empty' => false,
		// ));

		$venues = get_terms('service', array(
		'hide_empty' => false,
		'parent' => $venues_term->term_id
		));
  
	?>
	
	<?php if (count($venues) && $state) : ?>
	<div class="block services">
		<h3 class="a">Venues in <?php echo $state->name ?></h3>
		<ul>
			<?php foreach ($venues as $venue): ?>
				<li>
					<a href="<?php echo flo_get_service_permalink($state, $venue->slug) ?>"><?php echo $venue->name ?></a>
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
					'terms'		=> $state->slug,
				),
			),
			'ignore_filter_changes'	=> true,
			'norewrite'			=> true,
		));
	?>
	<?php if ($cat_query->have_posts()) : ?>	
	<div class="block s-events">
		<h3 class="a">Events in <?php echo $state->name ?></h3>
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
		<!-- <a href="<?php flo_region_events_permalink($state); ?>" class="goto">View All</a> -->
	</div>
	<?php endif; ?>

	
	
	<div class="block services">
		<h3 class="a">Services in <?php echo $state->name ?></h3>
		<ul>
			<?php 
				$services = get_terms('service', array(
					'hide_empty' => false,
				));
			?>
			<?php foreach ($services as $service): ?>
				<?php if($service->parent == $venues_term->term_id || $service->slug == "venues") continue; ?>
				<li>
					<a href="<?php echo flo_get_service_permalink($state, $service->slug) ?>"><?php echo $service->name ?></a>
				</li>
			<?php endforeach ?>
		</ul>		
	</div>	

	<?php flo_part('side-newsletter') ?>
	<?php flo_part('side-ads') ?>	
</aside>