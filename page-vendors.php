<?php
/* 
Template Name: Vendors
*/
/*
  ok, so this page was /in-your-area/map.  
  I'm not sure how that uRL got to this page template.  Maybe simply because the name of the page was 'map' and it looked for a template that had the name?  I'm not sure that's normal behavior.

  I've moved the page to /vendors now and had to copy this page to page-vendors.php to make use of the correct template
*/
?>
<?php get_header(); ?>
<div id="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="local" id="in-your-area-map">
		<?php flo_page_title(get_the_title()) ?>
		<div class="story">
			<div class="vendors-map-full">
				<div class="vendors-list-left">
					<strong>Select by location&hellip;</strong>
					
					<ul>
						
						<li>
							<strong>Georgia</strong>
							<a href="#">Atlanta</a>
							<a href="#">Savannah</a>
						</li>
						<li>
							<strong>Florida</strong>
							<a href="#">Orlando</a>
							<a href="#">Tampa</a>
							<a href="#">South Florida</a>
							<a href="#">Jacksonville</a>
						</li>
					</ul>
				</div>
				<div class="vendors-desc-right">
					<div class="vendors-map-title">
						The Celebration Society
					</div>
					<p>
						So that you can quickly find that trustworthy team of event vendors without worry of their reputation and skills, we created the Celebration Society, a carefully curated network of only the most talented, quality-centric wedding venues and party services in the special events industry. The businesses invited to join are chosen with careful consideration for their impeccable reputation, innate talent, commitment to their craft, keen sense of style, quality of work, professionalism and unmatched customer service.
					</p>
					<p>
						All of this, so you can trust your vendors and have a worry-free party planning experience!
					</p>
				</div>
			</div>
		
			<div class="vendors-apply">
				<strong>Vendors, not listed?&hellip; Apply for membership!</strong>
				<p>Will give you text to add here..</p>
			</div>
			<?php //the_content(); ?>
		</div>
<!--		<div class="map">
			<?php foreach (array('florida', 'georgia') as $state): ?>
				<?php $cities = get_state_cities($state); ?>
				<div class="<?php echo $state ?>">
					<span class="hover"></span>
					<ul>
						<?php foreach ($cities as $city): ?>
							<li>
								<a href="<?php echo get_term_link($city, 'region') ?>"><?php echo $city->name ?></a>
							</li>	
						<?php endforeach ?>
					</ul>
				</div>
			<?php endforeach ?>
		</div> 
		<?php $regions = flo_get_regions_links(); ?>
		<section class="regions">
			<ul>
				<?php foreach ($regions as $state): ?>
					<?php if(count($state->cities)) : ?>
					<li class="region">
						<h3><a href="<?php echo get_term_link($state) ?>"><?php echo $state->name ?></a></h3>
						<div class="cols">
							<?php foreach ($state->cities as $city): ?>
								<h4><a href="<?php echo get_term_link($city) ?>"><?php echo $city->name ?></a></h4>
								<?php if (isset($city->services) && count($city->services)): ?>
								<ol>
									<?php foreach ($city->services as $service): ?>
										<li><a href="<?php echo flo_region_venue_permalink($city, $service->slug, 'services') ?>"><?php echo $service->name ?></a></li>
									<?php endforeach ?>
								</ol>
								<?php endif ?>
							<?php endforeach ?>
						</div>
					</li>
					<?php endif; ?>
				<?php endforeach ?>
			</ul>
		</section>-->
		<?php //flo_part('featured-vendors') ?>
	</div>
<?php endwhile; endif; ?>
</div>
<?php get_sidebar('map'); ?>
<?php get_footer(); ?>
