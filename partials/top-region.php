		<?php 
			$region = get_term_by('slug', get_query_var('region'), 'region');
			if ($region->parent) {
				$state = get_term($region->parent, 'region');
			} else {
				$state = $region;
				$region = false;
			}

			if (!$region && !$state) {
				$region = get_term_by('slug', get_query_var('_region'), 'region');
				$state = $region;
			}
		?>

		<?php if ($region || $state) : ?>

		<header class="page-title">
			<ul>
				<li class="head">
					<span><?php echo $state->name ?></span>
				</li>
				<li class="subhead">
					<?php if ($region) : ?>
					<a href="#"><?php echo $region->name; ?></a>
					<?php else : ?>
					<a href="#">City Guide</a>
					<?php endif; ?>
 					<ul class="sub">
						<?php $cities = get_state_cities($state); //var_dump($cities); ?>
						<?php foreach ($cities as $city) : if ($region->name == $city->name) continue; ?>
						<li><a href="<?php echo get_term_link( $city ); ?>"><?php echo $city->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
				<li>
					<a href="#">Venues</a>
					<ul class="sub">
						<?php 
							$venues = get_terms('venue-type', array(
								'hide_empty' => false,
							));
						?>
						<?php foreach ($venues as $venue): ?>
							<li>
								<a href="<?php echo flo_region_venue_permalink($state, $venue->slug, 'venues') ?>"><?php echo $venue->name ?></a>
							</li>
						<?php endforeach ?>						
					</ul>
				</li>
				<li>
					<a href="#">Vendors</a>
					<ul class="sub">
						<?php 
							$vendors = get_terms('service', array(
								'hide_empty' => false,
							));
						?>
						<?php foreach ($vendors as $vendor): ?>
							<li>
								<a href="<?php echo flo_region_venue_permalink($state, $vendor->slug, 'services') ?>"><?php echo $vendor->name ?></a>
							</li>
						<?php endforeach ?>						
					</ul>					
				</li>					
				<li>
					<a href="<?php echo flo_region_events_permalink($state); ?>">Events</a>				
				</li>							
			</ul>
		</header>

		<?php endif; ?>