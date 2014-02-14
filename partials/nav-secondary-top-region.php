		<header class="page-title top-region">
<?php 

    echo insert_venue_header_content();

    $region = false;

    if ( is_single() ) {

      // if we are looking at a single post

      $terms = get_the_terms( $post->ID, 'region' );

      if( $terms ) {
        $i = 1;
        foreach ( $terms as $term ) {
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
					<a href="/vendors/<?php echo $region ? strtolower($region->slug) : ""; ?>">Vendors &amp; Venues</a>
				</li>					
				<li>
					<a href="<?php echo flo_region_events_permalink($state); ?>">Events</a>				
				</li>							
			</ul>
		</header>

		<?php 
    
    else: 

		endif; 
    
    ?>
