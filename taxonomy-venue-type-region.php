<?php get_header(); ?>
<?php 
	$type 	= get_term_by('slug', get_query_var('venue-type'), 'venue-type');
	$region = get_term_by('slug', get_query_var('region'), 'region');
?>
<div id="main">
	<div class="region-full">
		<header class="page-title">
			<hgroup>
				<h2>Venues</h2>
				<span>&raquo;</span>
				<h3><a href="<?php echo get_term_link($type) ?>"><?php echo $type->name ?></a></h3>
				<span>&raquo;</span>
				<h3><a href="<?php echo get_term_link($region) ?>"><?php echo $region->name ?></a></h3>
			</hgroup>
		</header>

		<?php if ($type): ?>
			<?php if ($type->description): ?>
				<div class="story">
					<p><?php echo $type->description ?></p>
				</div>
			<?php endif ?>
		<?php endif ?>

		<?php flo_part('featured-vendors-local-venue') ?>

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
