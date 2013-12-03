<?php
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
			<?php the_content(); ?>
		</div>
		<div class="map">
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
		</section>
		<?php //flo_part('featured-vendors') ?>
	</div>
<?php endwhile; endif; ?>
</div>
<?php get_sidebar('map'); ?>
<?php get_footer(); ?>
