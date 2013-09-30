<?php
flo_advertiser_logged_in();
get_header(); ?>
<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="advertisers">

			<?php if ( is_numeric($_REQUEST['edit']) || isset($_REQUEST['new']) ) : ?>
				<?php flo_part('advertiser-events-edit'); ?>
			<?php elseif ( is_numeric($_REQUEST['remove'])) : ?>
				<?php flo_part('advertiser-events-remove'); ?>
			<?php else: ?>
				<?php flo_part('advertiser-events'); ?>
			<?php endif; ?>

		</div>
	<?php endwhile; else: ?>
		<?php flo_part('notfound')?>
	<?php endif; ?>
</div>
<?php get_sidebar('advertisers'); ?>
<?php get_footer(); ?>
