<?php
/* 
Template Name: Vendors-City
*/
/*
  ok, so this page was /in-your-area/map.  
  I'm not sure how that uRL got to this page template.  Maybe simply because the name of the page was 'map' and it looked for a template that had the name?  I'm not sure that's normal behavior.

  I've moved the page to /vendors now and had to copy this page to page-vendors.php to make use of the correct template
*/
?>
<?php get_header(); ?>

<?php
	$city = $wp_query->query_vars["tag"];
	if($city == '')
		$city = 'Atlanta'; //default to Atlanta		
	$term = get_terms('region', array('slug' => $city));
	$state = get_state_from_region($term[0]);
?>
<div id="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="local" id="in-your-area-map">
		<div class="story">
			<div class="vendors-map-full <?php echo $city; ?>">
				<div class="location-star"></div>
				<div class="vendors-city-desc-right">
					<div class="vendors-map-title">
						<h1><?php echo $term[0]->name; ?></h1>
						<span>Venues &amp; Vendors</span>
					</div>
					<?php echo $term[0]->description; ?>
				</div>
			</div>
		
			<div class="vendors-services-list">
				<h1>Select by Service&hellip;</h1>
	
				<ul class="services-list">
					<li class="service-title"><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/planning-and-coordination">Planning & Coordination</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-planners"><?php echo $term[0]->name; ?> Wedding Planners</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-planners"><?php echo $term[0]->name; ?> Party Planners</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/event-planning-and-coordination"><?php echo $term[0]->name; ?> Day-Of Coordination</a></li>
					
					<li class="service-title"><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/photographers">Photographers</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-photographers"><?php echo $term[0]->name; ?> Wedding Photographers</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/bar-bat-mitzvah-photographers"><?php echo $term[0]->name; ?> Bar/Bat Mitzvah Photographers</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/photobooth"><?php echo $term[0]->name;; ?> Photobooths</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-videographers"><?php echo $term[0]->name;; ?> Wedding Videographers</a></li>
					
					<li class="service-title"><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/bands-and-musicians">Bands, DJs &amp; Musicians</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/djs"><?php echo $term[0]->name;; ?> DJs</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-ceremony-musicians"><?php echo $term[0]->name;; ?> Wedding Ceremony Musicians</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-bands"><?php echo $term[0]->name;; ?> Wedding Bands</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-cellists"><?php echo $term[0]->name;; ?> Wedding Cellists</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-guitarists"><?php echo $term[0]->name;; ?> Wedding Guitarists</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-harpists"><?php echo $term[0]->name;; ?> Wedding Harpists</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-jazz-musicians"><?php echo $term[0]->name;; ?> Wedding Jazz Musicians</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-pianists"><?php echo $term[0]->name;; ?> Wedding Pianists</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-string-quartets"><?php echo $term[0]->name;; ?> Wedding String Quartets</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-swing-bands"><?php echo $term[0]->name;; ?> Wedding Swing Bands</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-violinists"><?php echo $term[0]->name;; ?> Wedding Violinists</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-vocalists"><?php echo $term[0]->name;; ?> Wedding Vocalists</a></li>
					
					<li class="service-title">Catering &amp; Beverage</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-caterers"><?php echo $term[0]->name;; ?> Wedding Caterers</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-caterers"><?php echo $term[0]->name;; ?> Party Caterers</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/kosher-caterers"><?php echo $term[0]->name;; ?> Kosher Caterers</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/bartenders-2"><?php echo $term[0]->name;; ?> Bartenders</a></li>
					
					<li class="service-title">Stationery &amp; Invitations</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-invitations"><?php echo $term[0]->name;; ?> Wedding Invitations</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-invitations"><?php echo $term[0]->name;; ?> Party Invitations</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-calligraphy"><?php echo $term[0]->name;; ?> Wedding Calligraphy</a></li>
					
					<li class="service-title">Cakes &amp; Dessert</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-cakes-2"><?php echo $term[0]->name;; ?> Wedding Cakes</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/grooms-cakes"><?php echo $term[0]->name;; ?> Groom's Cakes</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-cakes"><?php echo $term[0]->name;; ?> Party Cakes</a></li>
				</ul>
				
				<ul class="services-list">
					<li class="service-title"><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/venues">Event Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-venues"><?php echo $term[0]->name;; ?> Wedding Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-ceremony-venues"><?php echo $term[0]->name;; ?> Wedding Ceremony Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/hotels"><?php echo $term[0]->name;; ?> Hotel Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/mitzvah-venues"><?php echo $term[0]->name;; ?> Mitzvah Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/rehearsal-dinner-venue"><?php echo $term[0]->name;; ?> Rehearsal Dinner Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/venues-with-amazing-views"><?php echo $term[0]->name;; ?> Venues with Amazing Views</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/country-club-venues"><?php echo $term[0]->name;; ?> Country Club Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/city-and-private-clubs-venues"><?php echo $term[0]->name;; ?> City and Private Club Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/antebellum-homes-venues"><?php echo $term[0]->name;; ?> Antebellum Home Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/ballroom-venues"><?php echo $term[0]->name;; ?> Ballroom Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/barn-venues"><?php echo $term[0]->name;; ?> Barn Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/banquet-halls"><?php echo $term[0]->name;; ?> Banquet Hall Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/conference-centers"><?php echo $term[0]->name;; ?> Conference Center Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/galleries-museums"><?php echo $term[0]->name;; ?> Galleries &amp; Museum Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/gardens-venues"><?php echo $term[0]->name;; ?> Garden Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/golf-course"><?php echo $term[0]->name;; ?> Golf Course Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/historic-venues"><?php echo $term[0]->name;; ?> Historic Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/outdoor-venues"><?php echo $term[0]->name;; ?> Outdoor Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/private-home-mansion-venues"><?php echo $term[0]->name;; ?> Private Home/Mansions Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/rooftop-venues"><?php echo $term[0]->name;; ?> Rooftop Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/waterfront-venues"><?php echo $term[0]->name;; ?> Waterfront Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/winery-vineyard-venues"><?php echo $term[0]->name;; ?> Wineries &amp; Vineyards</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/beachfront-venues"><?php echo $term[0]->name;; ?> Beach Venues</a></li>
					
					<li class="service-title"><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/floral-and-event-design">Floral and Event Design</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/event-lighting"><?php echo $term[0]->name;; ?> Event Lighting</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-rentals"><?php echo $term[0]->name;; ?> Party Rentals</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/tent-rentals"><?php echo $term[0]->name;; ?> Tent Rentals</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/chair-covers-and-linens"><?php echo $term[0]->name;; ?> Chair Covers &amp; Linens</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/event-drapery-2"><?php echo $term[0]->name;; ?> Event Drapery</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-florist"><?php echo $term[0]->name;; ?> Wedding Florist</a></li>
					
					<li class="service-title">Other Services</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/bridal-shows"><?php echo $term[0]->name;; ?> Bridal Shows</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-expos"><?php echo $term[0]->name;; ?> Party Expos</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/convention-visitor-bureaus"><?php echo $term[0]->name;; ?> Convention &amp; Visitor Bureaus</a></li>
				</ul>
				
			</div>
			
			<div class="vendors-apply">
				<h1>Browse Other Areas</h1>
				<ul>
			
					<li>
						<strong>Georgia</strong>
						<a href="/vendors/atlanta">Atlanta</a>
						<a href="/vendors/savannah">Savannah</a>
					</li>
					<li>
						<strong>Florida</strong>
						<a href="/vendors/orlando">Orlando</a>
						<a href="/vendors/tampa">Tampa</a>
						<a href="/vendors/south-florida">South Florida</a>
						<a href="/vendors/jacksonville">Jacksonville</a>
					</li>
				</ul>
			</div>
			
			
			<?php //the_content(); ?>
		</div>

		<?php //flo_part('featured-vendors') ?>
	</div>
<?php endwhile; endif; ?>
</div>
<?php get_sidebar('map'); ?>
<?php get_footer(); ?>
