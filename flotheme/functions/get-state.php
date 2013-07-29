<?php

function get_state_from_region( $region ) {

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

    // testing to make sure there are not overlaps between city names across states ????? this is a guess
    if (!$region && !$state) {

      $region = get_term_by('slug', get_query_var('_region'), 'region');

      $state = $region;

    }

    return $state;

}
?>
