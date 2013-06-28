<li class="cf <?php flo_meta('upgrade_type') ?>" <?php flo_vendor_geoaddress(); ?>>
	<figure>
		<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('venue-thumbnail') ?></a>
	</figure>
	<div class="detail">
		<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
		<?php if (flo_get_meta('contact_address_show')): ?>
			<address>
				<?php flo_meta('contact_address') ?>
				<?php flo_meta('contact_address_city') ?>
				<?php flo_meta('contact_address_state') ?>,
				<?php flo_meta('contact_address_zip') ?>
				<?php if (flo_meta('contact_address_county')): ?>
					, <?php flo_meta('contact_address_county') ?>
				<?php endif ?>
			</address>
		<?php endif ?>
		<?php if (flo_get_meta('short_info')): ?>
			<div class="descr">
				<?php flo_meta('short_info') ?>
			</div>
		<?php endif ?>
		<p class="more">
			<a href="<?php the_permalink() ?>">View Profile</a>
		</p>
		<div class="rating">
			<span class="reviews"><?php comments_number('no reviews', '1 review', '% reviews') ?></span>
			<span class="stars stars<?php flo_venue_rating() ?>"></span>
		</div>
	</div>
</li>