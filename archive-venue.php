<?php
	if (substr_count($_SERVER['REQUEST_URI'], '/profile')) {
		wp_redirect(site_url('/venues'));
	}

get_header(); ?>
<?php 
	$type = get_term_by('slug', get_query_var('venue-type'), 'venue-type');
?>
<div id="main">
	<div class="region-full">

		<?php flo_part('top-region'); ?>

		<?php $regions = flo_get_regions_links(false); ?>
		<section class="regions">
			<h3>View venues in </h3>
			<ul>
				<?php foreach ($regions as $state): ?>
					<?php if(count($state->cities)) : ?>
					<li class="region">
						<h4><?php echo $state->name ?></h4>
						<div class="cols">
							<?php foreach ($state->cities as $city): ?>
								<a href="<?php echo get_term_link($city); ?>" class="title"><?php echo $city->name ?></a>
							<?php endforeach ?>
						</div>
					</li>
					<?php endif; ?>
				<?php endforeach ?>
			</ul>
		</section>

		<?php flo_part('featured-vendors-venue') ?>

		<section class="vendors-list">
			<?php flo_part('venueshead') ?>
			<div class="list">
				<?php if (have_posts()): ?>
					<ul id="vendors-list">
						<?php while (have_posts()): the_post(); ?>
							<?php flo_part('venue-loop') ?>
						<?php endwhile; ?>
					</ul>
				<?php endif ?>
			</div>
			<?php flo_part('venuesfoot') ?>
		</section>
	</div>
</div>
<?php get_sidebar('region'); ?>
<?php get_footer(); ?>
