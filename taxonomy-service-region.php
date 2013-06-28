<?php get_header(); ?>
<?php 
	$cat 	= get_term_by('slug', get_query_var('service'), 'service');
	$region = get_term_by('slug', get_query_var('region'), 'region');
?>
<div id="main">
	<div class="region-full">

		<?php flo_part('top-region'); ?>
		
<!-- 		<header class="page-title">
			<hgroup>
				<h2>Services</h2>
				<span>&raquo;</span>
				<h3><a href="<?php echo get_term_link($cat) ?>"><?php echo $cat->name ?></a></h3>
				<span>&raquo;</span>
				<h3><a href="<?php echo get_term_link($region) ?>"><?php echo $region->name ?></a></h3>
			</hgroup>
		</header>
 -->
		<?php if ($cat): ?>
			<?php if ($cat->description): ?>
				<div class="story">
					<p><?php echo $cat->description ?></p>
				</div>
			<?php endif ?>
		<?php endif ?>

		<?php flo_part('featured-big') ?>
		
		<?php flo_part('featured-vendors-local-service') ?>

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