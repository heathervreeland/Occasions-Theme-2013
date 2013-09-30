<?php

/* a function that outputs the fixed left navigation
***********************************************************/
function show_fixed_left_nav() {

  // a variable that sets a class to set the correct placement of the fixed left navigation
  $no_secondary = 'no-secondary';

  // let's see if we are in a region
  $region = get_term_by('slug', get_query_var('region'), 'region');

  // and the alternative way to see if we are on a blog post in a region
  $terms = get_the_terms( $post->ID, 'region' );

  if ( $region || $terms ) {

    $no_secondary = '';

  }

  echo '<nav id="fixed-left-nav" class="sticky ' .  $no_secondary . '">';
  echo flo_part('nav-left-fixed'); 
  echo '</nav>';

}
?>
