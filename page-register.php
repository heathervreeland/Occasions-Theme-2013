<?php
$advertiser = new Flotheme_Advertiser();
get_header(); ?>
<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="advertisers">
			<div class="page-title page-title-container cf">
				<h2><?php the_title()?></h2>
				<div class="box">
					<a href="<?php flo_permalink('login'); ?>" class="btn">Login</a>
				</div>
			</div>
			<?php the_content(); ?>
		</div>
	<?php endwhile; else: ?>
		<?php flo_part('notfound')?>
	<?php endif; ?>
</div>
<?php get_sidebar('advertisers'); ?>
<?php get_footer(); ?>