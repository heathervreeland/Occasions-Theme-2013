<?php

function insert_venue_header_content( $has_region = true ) {
  // pull the region taxonomy object
  $region = get_term_by('slug', get_query_var('region'), 'region');
  
  $state = get_state_from_region($region);


    // Get the city or state human readable title
    $region_name = $region->name; 
    if ( $region_name == '' ) {
      $region_name = $state->name; 
    }

    // pull the region taxonomy slug
    $region_taxonomy = $region->taxonomy;

  // get the service taxonomy obj
  $tax_service = get_term_by('slug', get_query_var('service'), 'service');

    // pull the service human readable name
    $service_name = $tax_service->name;

    // pull the service taxonomy slug 
    $service_taxonomy_slug = $tax_service->taxonomy;

    // pull the service slug
    $service_taxonomy_type_slug = $tax_service->slug;

  // pull the venue-type taxonomy obj
  $tax_venue_type = get_term_by('slug', get_query_var('venue-type'), 'venue-type');

    // pull the venue-type human readable name
    $venue_name = $tax_venue_type->name;

    // pull the venue-type slug
    $venue_taxonomy = $tax_venue_type->taxonomy;

    // pull the venue slug
    $tax_venue_type_slug = $tax_venue_type->slug;

    // set a boolean
    $has_venue_type = false;
    /*
    echo '<pre>';
    var_dump($tax_venue_type);
    echo '</pre>';
    */

    // if there is a venue-type taxoomony set boolean to true
    if ( $tax_venue_type ) { $has_venue_type = true; }

  // Create a variable to hold the header and intro paragraph output

  $header;

  // test if the region taxonomy is a state
  if ( $region_taxonomy == 'florida' || $region_taxonomy == 'georgia' ) {

    // output the page title 
    if ( $service_name == '' || $service_name == null ) {
      $header .= '<h1>' . $region_name .  ' Weddings</h1>';
    } else {
      $header .= '<h1>' . $region_name .  ' ' . $service_name . '</h1>';
    }

    if ( $has_venue_type ) {
      $phrase = 'trusted Wedding' . $service_name;
    } else {
      $phrase = 'trusted Wedding vendors';
    }

    // out put the page description
    $header .= '<h2 class="description">Occasions is the best source to find the most ' . $phrase . ' in ' . $state->name . '.  Plus, explore wedding inspiration, party ideas, and the best local vendors for your upcoming occasion.</h2>';

  } else {

    // output the page title 
    if ( $service_name == '' || $service_name == null ) {
      $header .= '<h1>' . $region_name .  ' Weddings</h1>';
    } else {
      $header .= '<h1>' . $region_name .  ' ' . $service_name . '</h1>';
    }

    /********************************************************/
    /* testing to see what type of search we are looking at */
    /********************************************************/

    // if a search with no venue-type or service taxonomies
    if ( $venue_name == null && $service_name == null ) {

      $phrase = ' vendors ';

    // if a search for service taxomony
    } elseif ( $venue_name == null ) {
      
      $tax_type = 'services';

      $phrase = set_venue_type_name( $service_name, $region_name, $tax_type, $service_taxonomy_type_slug  );

    // otherwise are looking at a search for a venue-type taxonomy
    } else {

      $tax_type = 'venues';
      $phrase = set_venue_type_name( $venue_name, $region_name, $tax_type, $tax_venue_type_slug );

    }

    if ( $has_region ) {

      $header .= '<h2 class="description">Occasions is the best source to find the most trusted ' . $phrase . ' in ' . $state->name . '.  Plus, explore wedding inspiration, party ideas, and the best local vendors for your upcoming occasion.</h2>';

    } else { 

      $header .= '<h2 class="description">Occasions is the best source to find the most trusted ' . $phrase . '.  Plus, explore wedding inspiration, party ideas, and the best local vendors for your upcoming occasion.</h2>';

    }

  }

  // if the taxonomy is 'service', change the type to plural for URL purposes
  if ( $service_taxonomy_slug == 'service' ) {
    $service_taxonomy_slug = 'services';
  }
?>

		<?php 
    
    return $header;

}
?>
