<?php get_header(); ?>
<div id="main">
	<section id="top-category">
		<header class="page-title">
			<h2><?php echo single_cat_title(); ?></h2>
		</header>
		<?php flo_part('topcat-cover') ?>
		<?php flo_part('topcat-latest') ?>
		<?php flo_part('featured-vendors-section') ?>
		<?php flo_part('topcat-categories') ?>
	</section>
</div>
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>
