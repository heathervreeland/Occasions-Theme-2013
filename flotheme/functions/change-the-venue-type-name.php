<?php
/* 
 * Manual switch to set new phrase for venue
 *
 * @param string $name - human readable name of venue taxonomy
 * @param $city - city location
 * @return string
 *
 */

function set_venue_type_name( $name, $city='', $tax_type = null, $slug = null ) {

  if ($name == null ) {
    return 'BAD NAME';
  }

  $phrase = $name;

  // STARTING WITH VENUE TYPES

  if ( $phrase == 'Amazing Views' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Venues with Amazing Views</a>';
    return $phrase;
  } elseif( $phrase == 'Antebellum Homes' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Antebellum Home Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Ballroom' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Ballroom Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Banquet Halls' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Banquet Halls and Wedding Reception Facilities</a>';
    return $phrase;
  } elseif( $phrase == 'City and Private Clubs' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">City Club Wedding Venues</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Private Club Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Conference Centers' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Conference Centers, ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Meeting Facilities</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Convention Centers</a>';
    return $phrase;
  } elseif( $phrase == 'Country Clubs' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Country Club Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Galleries &amp; Museums' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Gallery Wedding Venues</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Museum Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Garden' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Garden Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Golf Course' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Golf Club Wedding Venues</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Weddings on the Golf Course</a>';
    return $phrase;
  } elseif( $phrase == 'Historic Locations' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Historic Wedding Venues</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Reception Sites</a>';
    return $phrase;
  } elseif( $phrase == 'Hotels' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Hotel Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Outdoor' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Outdoor Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Private Home/Mansion' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Private Home Wedding Venues</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Mansion Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Rooftop' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Rooftop Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Unique' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Unique Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Urban' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Urban Wedding Venues</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Venues</a> in the City';
    return $phrase;
  } elseif( $phrase == 'Waterfront' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Waterfront Wedding Venues</a>';
    return $phrase;
  } elseif( $phrase == 'Wineries &amp; Vineyards' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Winery Wedding Venues</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Vineyard Wedding Venues</a>';
    return $phrase;

  // MOVING ON TO SERVICE TYPES
  } elseif( $phrase == 'Bands &amp; Musicians' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Bands</a>, and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Ceremony Musicians</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Party Bands</a>';
    return $phrase;
  } elseif( $phrase == 'Cakes' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Cakes</a>, ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Birthday Party Cakes</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Bar/Bat Mitzvah Cakes, Dessert Bars, Candy Bars</a>';
    return $phrase;
  } elseif( $phrase == 'Caterers' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Catering</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Offsite Catering, Party Caterers, Event Staffing</a>';
    return $phrase;
  } elseif( $phrase == 'Ceremony' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Ceremony Venues</a>';
    return $phrase;
  } elseif( $phrase == 'DJS' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding DJ</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Bar/Bat Mitzvah DJ, Party Entertainment</a>';
    return $phrase;
  } elseif( $phrase == 'Dresses' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Dresses</a>'; 
    return $phrase;
  } elseif( $phrase == 'Favors' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Favors</a>'; 
    return $phrase;
  } elseif( $phrase == 'Flowers and Decor' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Flowers</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Event Design, Party Decor</a>';
    return $phrase;
  } elseif( $phrase == 'Hair &amp; Makeup' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Makeup Artist and Hairstylists, Event Makeup Artist & Hair Stylst</a>';
    return $phrase;
  } elseif( $phrase == 'Invitations' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Invitations</a>, ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Party Invitations</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Custom Stationery</a>';
    return $phrase;
  } elseif( $phrase == 'Lighting' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Lighting</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Party Lighting, Custom Wedding Gobos and Uplighting</a>';
    return $phrase;
  } elseif( $phrase == 'Photobooth' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Photobooth Rental</a>, ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Photobooths</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Bar/Bat Mitzvah Photobooths</a>';
    return $phrase;
  } elseif( $phrase == 'Photographers' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Photographers</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Bar/Bat MItzvah Photographers, Event Photographers</a>';
    return $phrase;
  } elseif( $phrase == 'Planners' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Planner</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Party Planner, Wedding Coordinator</a>';
    return $phrase;
  } elseif( $phrase == 'Registries' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Registries</a>'; 
    return $phrase;
  } elseif( $phrase == 'Rentals' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Party Rentals</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Rentals, Tent Rentals</a>';
    return $phrase;
  } elseif( $phrase == 'Rehearsal Dinners' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Rehearsal Dinners</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Private Dinning Venues, Restaurants with Rehearsal Dinner Space</a>';
    return $phrase;
  } elseif( $phrase == 'Venues' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Venues</a>, ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Reception Sites and</a> ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Banquet Halls</a>';
    return $phrase;
  } elseif( $phrase == 'Videographers' ) {
    $phrase = $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Videographers</a> and ' . $city . ' <a href="/' . $tax_type . '/' . $slug . '/">Wedding Cinematography</a>';
    return $phrase;
  } else {
    return $city . ' <a href="/' . $tax_type . '/' . $slug . '/">' . $phrase . '</a>';
  }
}

?>
