<?php 
flo_advertiser_logged_in();
get_header(); ?>
<div id="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php flo_page_title(get_the_title()) ?>
	<div id="buy-featured-placement">
			<section class="story">
				<?php the_content();?>
			</section>
			<ul class="active-placements">

				<?php
					$advertiser = new Flotheme_Advertiser();
					$venue_id = $advertiser->getMeta('venue_id');
					// $leads = flo_get_featured_by_vendor($venue_id);
					$report = adrotate_prepare_advertiser_report($advertiser->user()->ID);
				?>

				<?php if (count($report['ads'])): ?>
					<?php foreach ($report['ads'] as $ad): ?>
						<li>
							<dl class="cf">
								<dt>Title:</dt>
								<dd><?php echo $ad['title'] ?></dd>
								<dt>Date Created:</dt>
								<dd><?php echo date('F d, Y', $ad['startshow']) ?></dd>
								<dt>Impressions:</dt>
								<dd><?php echo $ad['impressions'] ?></dd>
								<dt>Clicks:</dt>
								<dd><?php echo $ad['clicks'] ?></dd>
							</dl>
						</li>
					<?php endforeach ?>
				<?php else : ?>
					<p>You have no active featured subscriptions.</p>	
				<?php endif ?>
			</ul>
			<p><?php echo do_shortcode('[gravityform id="'.FLO_FEATURED_SUBSCRIPTION_ID.'" name="Featured Subscription" field_values="venue-id='.$venue_id.'&venue-title='.get_the_title($venue_id).'"]'); ?></p>
	</div>
<?php endwhile; else: ?>
	<?php flo_part('notfound')?>
<?php endif; ?>
</div>
<?php get_sidebar('advertisers'); ?>
<?php get_footer(); ?>