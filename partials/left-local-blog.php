<?php 
/* 
Pulls a list of states with cities
*/

// pull the various taxonomies that we'll need
$tax_service = get_term_by('slug', get_query_var('service'), 'service');
$tax_venue_type = get_term_by('slug', get_query_var('venue-type'), 'venue-type');

// variable used for URL creation
$cat_name;

if ( $tax_venue_type ) {

  // if there is a venue-type taxonomy pull the human readable name
  $cat_name = $tax_venue_type->name;

} else {

  // otherwise pull the service taxonomy human readable name
  $cat_name = $tax_service->name;

}

// pull all region links
$regions = flo_get_regions_links(false); 

?>
<section class="regions">
  <h3>View <?php echo $cat_name ?> in </h3>
  <ul>
    <?php foreach ($regions as $state): ?>
      <?php if(count($state->cities)) : ?>
      <li class="region">
        <h4><?php echo $state->name ?></h4>
        <div class="cols">
          <ol>
            <?php 
            $i = 1;
            foreach ($state->cities as $city): 
              if ( $tax_venue_type ) {

                // if we are looking at a venue-type taxonomy search
                //echo '<li class="gradient' . $i . '"><a href="' . flo_get_region_venue_permalink($city, $tax_venue_type->slug, "venues") . '" class="title">' . $city->name . '</a></li>';
                echo '<li class="gradient' . $i . '"><a href="/' . strtolower($state->slug . '/' . $city->slug) . '" class="title">' . $city->name . '</a></li>';

              } else {
              
                // otherwise we are looking at a service taxonomy search
                //echo '<li class="gradient' . $i . '"><a href="' . flo_get_region_venue_permalink($city, $tax_service->slug, "services") . '" class="title">' . $city->name . '</a></li>';
                echo '<li class="gradient' . $i . '"><a href="/' . strtolower($state->slug . '/' . $city->slug) . '" class="title">' . $city->name . '</a></li>';

              }

              $i++;
            endforeach;
            $i = 1;
            ?>
          </ol>
        </div>
      </li>
      <?php endif; ?>
    <?php endforeach ?>
  </ul>
</section>
