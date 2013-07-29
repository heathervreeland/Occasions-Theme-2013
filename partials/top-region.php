		<header class="page-title top-region">
<?php 

    echo insert_venue_header_content();

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

    if ($region || $state) : 


    ?>

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
						<?php 
                  foreach ($cities as $city) : if ($region->name == $city->name) continue; 
                    if ( $service_taxonomy_slug != 'region' ) {
            ?>
						<li><a href="<?php echo get_term_link( $city ) . $service_taxonomy_slug . '/' . $service_taxonomy_type_slug; ?>"><?php echo $city->name; ?></a></li>
						<?php 
                    } else {
            ?>
						<li><a href="<?php echo get_term_link( $city );  ?>"><?php echo $city->name; ?></a></li>
						<?php 
                    }
                  endforeach; 
            ?>
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
                <?php
                // test to see if we are in a city.  if so, then toss the city in the url
                if ( $region ) { 
                ?>
								<a href="<?php echo flo_region_venue_permalink($region, $venue->slug, 'venues') ?>"><?php echo $venue->name ?></a>
                <?php
                // else only have the state in the url
                } else { 
                ?>
								<a href="<?php echo flo_region_venue_permalink($state, $venue->slug, 'venues') ?>"><?php echo $venue->name ?></a>
                <? } ?>
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
                <?php 
                // test to see if we are in a city.  if so, then toss the city in the url
                if ( $region ) { 
                ?>
								<a href="<?php echo flo_region_venue_permalink($region, $vendor->slug, 'services') ?>"><?php echo $vendor->name ?></a>
                <?php 
                // else only have the state in the url
                } else { 
                ?>
								<a href="<?php echo flo_region_venue_permalink($state, $vendor->slug, 'services') ?>"><?php echo $vendor->name ?></a>
                <?php } ?>
							</li>
						<?php endforeach ?>						
					</ul>					
				</li>					
				<li>
					<a href="<?php echo flo_region_events_permalink($state); ?>">Events</a>				
				</li>							
			</ul>
		</header>

		<?php 
    
    else: 

		flo_part('top-no-region'); 

		endif; 
    
    ?>
