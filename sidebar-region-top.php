<aside id="sidebar" class="region-sidebar region-top">
	<?php flo_part('side-top-ad') ?>

	<?php 
		$region = get_term_by('slug', get_query_var('region'), 'region');
		if ($region->parent) {
			$state = get_term($region->parent, 'region');
		} else {
			$state = $region;
			$region = false;
		}
	?>

	<?php 
		$venues = get_terms('venue-type', array(
			'hide_empty' => false,
		));
	?>
	<?php if (count($venues) && $state) : ?>
	<div class="block services">
		<h3 class="a">Venues in <?php echo $state->name ?></h3>
		<ul>
			<?php foreach ($venues as $venue): ?>
				<li>
					<a href="<?php echo flo_region_venue_permalink($state, $venue->slug, 'venues') ?>"><?php echo $venue->name ?></a>
				</li>
			<?php endforeach ?>
		</ul>		
	</div>
	<?php endif; ?>

	<div class="block vmap">
		<h3 class="a">Map</h3>
		<div class="geo-map" id="region-geomap" data-region-id="<?php echo $state->term_id ?>" data-marker-image="<?php echo THEME_URL ?>/img/map-marker.png" data-marker-shadow="<?php echo THEME_URL ?>/img/map-marker-shadow.png"></div>
	</div>

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
				<li>
					<a href="<?php echo flo_region_venue_permalink($state, $service->slug, 'services') ?>"><?php echo $service->name ?></a>
				</li>
			<?php endforeach ?>
		</ul>		
	</div>	

	<?php flo_part('side-newsletter') ?>
	<?php flo_part('side-ads') ?>	
</aside>