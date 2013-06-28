<article <?php post_class(); ?>>
	<dl class="cf">
		<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title();?></a></h2>
		<figure>
			<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
				<?php if (has_post_thumbnail()): ?>
					<?php the_post_thumbnail('event-preview')?>
				<?php else: ?>
					<?php $image = flo_get_event_venue_featured_image_src(get_the_ID(), 'post-cat-cover'); ?>
					<?php if ($image): ?>
						<img src="<?php echo $image ?>" alt="">
					<?php endif ?>
				<?php endif ?>
			</a>
		</figure>

		<div class="detail">
			<div class="descr">
				<?php echo apply_filters('the_content', flo_get_meta('description', true, get_the_ID())); ?>
			</div>
			<dt>Date(s)</dt>
			<dd>
				<?php echo flo_get_event_date('start', 'F d, Y', get_the_ID()) ?> 
				<?php if (flo_get_meta('date_end',get_the_ID())): ?>
					/ <?php echo flo_get_event_date('end', 'F d, Y', get_the_ID()) ?> 
				<?php endif ?>		
			</dd>			
			<dt>Hours:</dt>
			<dd>
				<?php flo_meta('hours', true, get_the_ID()) ?>
			</dd>			
			<dt>Address</dt>
			<dd>
				<?php flo_meta('event_address', true, get_the_ID()) ?>
				<?php if (flo_get_meta('event_address_city', true, get_the_ID())): ?>
					, <?php flo_meta('event_address_city', true, get_the_ID()) ?>
				<?php endif ?>
				<?php if (flo_get_meta('event_address_state', true, get_the_ID())): ?>
					, <?php flo_meta('event_address_state', true, get_the_ID()) ?>
				<?php endif ?>
				<?php if (flo_get_meta('event_address_zip', true, get_the_ID())): ?>
					, <?php flo_meta('event_address_zip', true, get_the_ID()) ?>
				<?php endif ?>
			</dd>						
			<?php if (flo_get_meta('location', true, get_the_ID())): ?>
				<dt>Location</dt>
				<dd><?php flo_meta('location', true, get_the_ID()) ?></dd>									
			<?php endif ?>
			
			<?php if (flo_get_meta('cost', true, get_the_ID())): ?>
				<dt>Cost</dt>
				<dd><?php flo_meta('cost', true, get_the_ID()) ?></dd>									
			<?php endif ?>

			<?php if (flo_get_meta('more_url', true, get_the_ID())): ?>
				<dt>More Info</dt>
				<dd><a href="<?php flo_meta('more_url', true, get_the_ID()) ?>" rel="external"><?php flo_meta('more_url', true, get_the_ID()) ?></a></dd>
			<?php endif ?>

		</div>
	</dl>
</article>