<?php 

/* a fucntion that outputs the secondary navigation
**********************************************************/

function show_secondary_nav() {

  // a variable that prevents the display of the secondary navigation
  $in_region = false;

  $terms = get_the_terms( $post->ID, 'region' );

  if ( is_archive() ) {
    $terms = false;
  }

  // let's see if we are in a region
  $region = get_term_by('slug', get_query_var('region'), 'region');

  // if we are, then let's dsiplay the secondary navigation

  if ( $region || $terms ) {

    $in_region = true;

  }

  if ( $in_region || is_page('vendors-in-city')) {
    echo '<div class="nav-secondary-wrapper">';
    echo flo_part('nav-secondary-top-region'); 
    echo '</div>';
  }
}
?>

