<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<section id="venue-side-info" class="short-info cf">
		<figure>
			<?php the_post_thumbnail('venue-thumbnail') ?>
		</figure>
		<div class="detail">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
			<?php if (flo_get_meta('contact_address_show')): ?>
				<address>
					<?php flo_meta('contact_address') ?>
					<?php flo_meta('contact_address_city') ?>,
					<?php flo_meta('contact_address_state') ?>
					<?php flo_meta('contact_address_zip') ?>
					<?php if (flo_meta('contact_address_county')): ?>
						, <?php flo_meta('contact_address_county') ?>
				</address>
      <?php endif ?>
				<address>
        <?php for($i = 1; $i <= 3; $i++): ?>
          <?php if (flo_get_meta('contact_address_phone' . $i)): ?>
            <p>
              <?php echo flo_get_meta('contact_address_phone' . $i . '_type') ? flo_get_meta('contact_address_phone' . $i . '_type') : 'General' ?>: 
              <?php flo_meta('contact_address_phone' . $i) ?>
            </p>
          <?php endif ?>
        <?php endfor;?>
        <a href="<?php flo_meta('website'); ?>" target="_blank">View Website</a>
				</address>
			<?php endif ?>
			<div class="rating">
				<span class="stars stars<?php flo_venue_rating() ?>"></span>
				<span class="reviews"><?php comments_number('no reviews', '1 review', '% reviews') ?></span>
			</div>
		</div>
		<div class="descr box">
			<?php echo apply_filters('the_content', flo_get_meta('short_info')) ?>
		</div>
		<div class="share box">
			<div class="fb-like" data-href="<?php the_permalink()?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
			<div class="plus1"><g:plusone size="medium" href="<?php the_permalink()?>"></g:plusone></div>
			<div class="tweet"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink()?>" data-count="horizontal">Tweet</a></div>
		</div>

		<?php
			// $advertiser = new Flotheme_Advertiser();
			$vid = get_the_ID();		
		?>

		<?php if (flo_get_meta('contact_info')): ?>
			<div class="contact box">
				<h4>Contact</h4>
				<p><?php flo_meta('contact_info') ?></p>
				<a href="#" class="send">Send a message</a>
			</div>				
		<?php endif ?>

		<?php if (flo_get_meta('upgrade_type') == 'upgraded') : ?>
			<?php if (flo_get_meta('website') || flo_get_meta('blog')): ?>
				<div class="links box">
					<h4>Links</h4>				
					<?php if (flo_get_meta('website')): ?>
						<p>Website: <a href="http://maglink.us/?vid=<?php echo $vid; ?>&type=0&url=<?php echo urlencode(flo_get_meta('website')); ?>"><?php flo_meta('website') ?></a></p>
					<?php endif ?>
					<?php if (flo_get_meta('blog')): ?>
						<p>Blog: <a href="http://maglink.us/?vid=<?php echo $vid; ?>&type=1&url=<?php echo urlencode(flo_get_meta('blog')); ?>"><?php flo_meta('blog') ?></a></p>
					<?php endif ?>
				</div>	
			<?php endif; ?>
		
			<div class="elsewhere box">
				<h4>Elsewhere</h4>
				<ul class="cf">
					<?php foreach (array('facebook' => 2, 'twitter' => 3, 'tumblr' => 4, 'vimeo' => 5, 'youtube' => 6) as $link => $k): ?>
						<li>
							<?php if (flo_get_meta($link)): ?>
								<a href="http://maglink.us/?vid=<?php echo $vid; ?>&type=<?php echo $k; ?>&url=<?php echo urlencode(flo_get_meta($link)); ?>" class="<?php echo $link ?>"><?php echo $link ?></a>
							<?php else: ?>
								<span class="<?php echo $link ?>"></span>
							<?php endif ?>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
		
			<?php if (flo_get_meta('geolng') && flo_get_meta('geolat')): ?>
				<div class="map box">
					<h4>On the map</h4>

					<div class="geo-map" id="venue-geomap" data-marker-image="<?php echo THEME_URL ?>/img/map-marker.png" data-marker-shadow="<?php echo THEME_URL ?>/img/map-marker-shadow.png" data-lng=<?php flo_meta('geolng') ?> data-lat="<?php flo_meta('geolat') ?>">
					</div>
				</div>
			<?php endif ?>
		<?php endif; ?>

	</section>
<?php endwhile;endif; ?>
