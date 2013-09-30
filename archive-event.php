<?php get_header(); ?>
<div id="main">
	<div class="region-full">
    <header class="page-title top-region">
      <?php echo insert_venue_header_content(); ?>
    </header>
	</div>

	<!-- <header class="page-title page-title-container cf">
		<hgroup>
			<h2><?php flo_post_state(); ?></h2>	
			<span>»</span>
			<h3><?php flo_post_city(); ?></h3>
			<span>»</span>
			<h3>Events</h3>
		</hgroup>
	</header> -->

	<section class="blog b-events">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php flo_part('event-loop') ?>
		<?php endwhile; else: ?>
			<?php flo_part('notfound')?>
		<?php endif; ?>
	</section>
	<footer class="page-foot page-foot-container cf">
		<div class="pagination">
			<?php wp_pagenavi(); ?>
		</div>
	</footer>
</div>
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>
