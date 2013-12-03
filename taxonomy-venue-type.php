<?php get_header(); ?>
<?php 
	$type = get_term_by('slug', get_query_var('venue-type'), 'venue-type');
?>
<div id="main">
	<div class="region-full">
		<header class="page-title">
			<hgroup>
				<h2><a href="<?php echo site_url('/venues') ?>">Venues</a></h2>
				<span>&raquo;</span>
				<h3><?php echo $type->name ?></h3>
			</hgroup>
		</header>

		<?php if ($type): ?>
			<?php if ($type->description): ?>
				<div class="story">
					<p><?php echo $type->description ?></p>
				</div>
			<?php endif ?>
		<?php endif ?>

		<?php $regions = flo_get_regions_links(false); ?>
		<section class="regions">
			<h3>View <?php echo $type->name ?> in </h3>
			<ul>
				<?php foreach ($regions as $state): ?>
					<?php if(count($state->cities)) : ?>
					<li class="region">
						<h4><?php echo $state->name ?></h4>
						<div class="cols">
							<ol>
								<?php foreach ($state->cities as $city): ?>
									<li><a href="<?php echo flo_region_venue_permalink($city, $type->slug, 'venues') ?>" class="title"><?php echo $city->name ?></a></li>
								<?php endforeach ?>
							</ol>
						</div>
					</li>
					<?php endif; ?>
				<?php endforeach ?>
			</ul>
		</section>

		<?php //flo_part('featured-vendors-venue') ?>

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
