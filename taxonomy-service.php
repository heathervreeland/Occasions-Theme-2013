<?php get_header(); ?>
<?php 
	$cat = get_term_by('slug', get_query_var('service'), 'service');
  $cat_name = $cat->name;
?>
<div id="main">
	<div class="region-full">
		<header class="page-title top-region">
			<hgroup>
        <?php echo insert_venue_header_content(false); ?>
			</hgroup>
		</header>

		<?php if ($cat): ?>
			<?php if ($cat->description): ?>
				<div class="story">
					<p><?php echo $cat->description ?></p>
				</div>
			<?php endif ?>
		<?php endif ?>

		<?php flo_part('top-no-region'); ?>
		
		<?php flo_part('featured-vendors-service') ?>
		
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
