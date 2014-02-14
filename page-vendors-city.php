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
						<h1><?php echo ucfirst($city) ?></h1>
						<span>Venues &amp; Vendors</span>
					</div>
					<?php echo $term[0]->description; ?>
				</div>
			</div>
		
			<div class="vendors-services-list">
				<h1>Select by Service&hellip;</h1>
	
				<ul class="services-list">
					<li class="service-title">Planning & Coordination</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-planners"><?php echo ucfirst($city); ?> Wedding Planners</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-planners"><?php echo ucfirst($city); ?> Party Planners</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/event-planning-and-coordination"><?php echo ucfirst($city); ?> Day-Of Coordination</a></li>
					
					<li class="service-title">Photographers</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-photographers"><?php echo ucfirst($city); ?> Wedding Photographers</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/bar-bat-mitzvah-photographers"><?php echo ucfirst($city); ?> Bar/Bat Mitzvah Photographers</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/photobooth"><?php echo ucfirst($city); ?> Photobooths</a></li>
					
					<li class="service-title">Bands, DJs &amp; Musicians</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/djs"><?php echo ucfirst($city); ?> DJs</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-ceremony-musicians"><?php echo ucfirst($city); ?> Wedding Ceremony Musicians</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-bands"><?php echo ucfirst($city); ?> Wedding Bands</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-cellists"><?php echo ucfirst($city); ?> Wedding Cellists</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-guitarists"><?php echo ucfirst($city); ?> Wedding Guitarists</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-harpists"><?php echo ucfirst($city); ?> Wedding Harpists</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-jazz-musicians"><?php echo ucfirst($city); ?> Wedding Jazz Musicians</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-pianists"><?php echo ucfirst($city); ?> Wedding Pianists</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-string-quartets"><?php echo ucfirst($city); ?> Wedding String Quartets</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-swing-bands"><?php echo ucfirst($city); ?> Wedding Swing Bands</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-violinists"><?php echo ucfirst($city); ?> Wedding Violinists</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-vocalists"><?php echo ucfirst($city); ?> Wedding Vocalists</a></li>
					
					<li class="service-title">Catering &amp; Beverage</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-caterers"><?php echo ucfirst($city); ?> Wedding Caterers</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-caterers"><?php echo ucfirst($city); ?> Party Caterers</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/kosher-caterers"><?php echo ucfirst($city); ?> Kosher Caterers</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/bartenders-2"><?php echo ucfirst($city); ?> Bartenders</a></li>
					
					<li class="service-title">Stationery &amp; Invitations</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-invitations"><?php echo ucfirst($city); ?> Wedding Invitations</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-invitations"><?php echo ucfirst($city); ?> Party Invitations</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-calligraphy"><?php echo ucfirst($city); ?> Wedding Calligraphy</a></li>
					
					<li class="service-title">Cakes &amp; Dessert</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-cakes-2"><?php echo ucfirst($city); ?> Wedding Cakes</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/grooms-cakes"><?php echo ucfirst($city); ?> Groom's Cakes</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-cakes"><?php echo ucfirst($city); ?> Party Cakes</a></li>
				</ul>
				
				<ul class="services-list">
					<li class="service-title">Event Venues</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-venues-venues"><?php echo ucfirst($city); ?> Wedding Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/hotels"><?php echo ucfirst($city); ?> Hotel Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/rehearsal"><?php echo ucfirst($city); ?> Rehearsal Dinner Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/amazing-views"><?php echo ucfirst($city); ?> Venues with Amazing Views</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/country-club-venues"><?php echo ucfirst($city); ?> Country Club Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/city-and-private-clubs"><?php echo ucfirst($city); ?> City and Private Club Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/antebellum-homes"><?php echo ucfirst($city); ?> Antebellum Home Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/ballroom-venues"><?php echo ucfirst($city); ?> Ballroom Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/banquet-halls"><?php echo ucfirst($city); ?> Banquet Hall Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/conference-centers"><?php echo ucfirst($city); ?> Conference Center Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/galleries-museums"><?php echo ucfirst($city); ?> Galleries &amp; Museum Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/gardens"><?php echo ucfirst($city); ?> Garden Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/golf-course"><?php echo ucfirst($city); ?> Golf Course Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/historic-venues"><?php echo ucfirst($city); ?> Historic Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/outdoor-venues"><?php echo ucfirst($city); ?> Outdoor Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/private-home-mansion-venues"><?php echo ucfirst($city); ?> Private Home/Mansions Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/rooftop-venues"><?php echo ucfirst($city); ?> Rooftop Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/waterfront-venues"><?php echo ucfirst($city); ?> Waterfront Venues</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/winery-vineyard-venues"><?php echo ucfirst($city); ?> Wineries &amp; Vineyards</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/beachfront-venues"><?php echo ucfirst($city); ?> Beach Venues</a></li>
					
					<li class="service-title">Florals and Event Design</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/event-lighting"><?php echo ucfirst($city); ?> Event Lighting</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-rentals"><?php echo ucfirst($city); ?> Party Rentals</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/tent-rentals"><?php echo ucfirst($city); ?> Tent Rentals</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/chair-covers-and-linens"><?php echo ucfirst($city); ?> Chair Covers &amp; Linens</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/event-drapery-2"><?php echo ucfirst($city); ?> Event Drapery</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/wedding-florist"><?php echo ucfirst($city); ?> Wedding Florist</a></li>
					
					<li class="service-title">Other Services</li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/bridal-shows"><?php echo ucfirst($city); ?> Bridal Shows</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/party-expos"><?php echo ucfirst($city); ?> Party Expos</a></li>
					<li><a href="/<?php echo $state->slug; ?>/<? echo $city; ?>-weddings/convention-visitor-bureaus"><?php echo ucfirst($city); ?> Convention &amp; Visitor Bureaus</a></li>
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
