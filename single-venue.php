<?php get_header(); ?>
<?php 
	$type 	= get_term_by('slug', get_query_var('type'), 'venue-type');
	$region = get_term_by('slug', get_query_var('region'), 'region');
	flo_vendor_profile_view();
?>
<header class="venue-title cf">
	<?php /*
	<a href="" class="back">Back to search results</a>
	*/?>
	<nav>
		<?php while (have_posts()) : the_post(); ?>
		<ul>
			<?php 
				be_previous_post_link('<li class="prev">%link</li>', 'Prev Vendor', true, '', array('region', 'venue-type'));
				be_next_post_link('<li class="next">%link</li>', 'Next Vendor', true, '', array('region', 'venue-type'));
			?>
		</ul>
		<?php endwhile; ?>
		<?php rewind_posts(); ?>
	</nav>
	<?php
		$city = flo_get_venue_city();
		$service = flo_get_venue_service();
	?>
	<hgroup>
		<h2>Services</h2>
		<span>&raquo;</span>
		<h3><a href="<?php echo get_term_link($service) ?>"><?php echo $service->name?></a></h3>
		<span>&raquo;</span>
		<h3><a href="<?php echo get_term_link($city) ?>"><?php echo $city->name?></a></h3>
	</hgroup>
</header>
<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<aside id="venue-mobile-sidebar" class="venue-sidebar"></aside>
		<section id="venue" class="venue-full">

			<?php $gallery_images = flo_get_attached_images(get_the_ID(), false);?>

			<?php if (count($gallery_images)): ?>
				<div class="gallery">
					<div id="venue-gallery" class="flexslider cf">
						<ul class="slides">
							<?php foreach($gallery_images as $image):?>
								<li>
									<figure>
										<?php echo wp_get_attachment_image($image->ID, 'venue-preview')?>
									</figure>
								</li>
							<?php endforeach;?>
						</ul>
					</div>
				</div>
				<div class="thumbs">
					<div id="venue-thumbnails" class="flexslider cf">
						<ul class="slides">
							<?php foreach($gallery_images as $image):?>
								<li><?php echo wp_get_attachment_image($image->ID, 'venue-gthumbnail')?></li>
							<?php endforeach;?>
						</ul>
					</div>
				</div>
			<?php endif ?>

			<?php
				$video_url = flo_get_meta('video_url');
				$downloads = flo_get_vendor_attached_files();
				$from_the_blog = array();
				$events = array();
			?>

			<div id="vendor-tabs-information" class="information">
				<ul>
					<li><a href="#venue-information">Information</a></li>
					<li><a href="#venue-services">Services</a></li>
					<?php if ($video_url): ?>
						<li><a href="#venue-video">Video</a></li>
					<?php endif ?>
					<?php if (count($downloads)): ?>
						<li><a href="#venue-downloads">Downloads</a></li>
					<?php endif ?>
					<?php if (count($events)): ?>
						<li><a href="#venue-events">Events</a></li>
					<?php endif ?>
					<?php if ($from_the_blog): ?>
						<li><a href="#venue-blog">From the blog</a></li>
					<?php endif ?>
				</ul>
				<div class="clear"></div>
				<div id="venue-information" class="tab">
					<h3><?php the_title('About ') ?></h3>
					<?php echo wpautop(strip_tags(htmlspecialchars_decode(flo_get_meta('description')))); ?>
					<?php //echo apply_filters('the_content', html_entity_decode(flo_get_meta('description'))) ?>
				</div>
				<div id="venue-services" class="tab">
					<h3><?php the_title('', ' Services') ?></h3>
					
					<div class="service phone">
						<h4>Phone</h4>
						<p><?php flo_meta('contact_name') ?></p>
						<?php for($i = 1; $i <= 3; $i++): ?>
							<?php if (flo_get_meta('contact_address_phone' . $i)): ?>
								<p>
									<?php echo flo_get_meta('contact_address_phone' . $i . '_type') ? flo_get_meta('contact_address_phone' . $i . '_type') : 'General' ?>: 
									<?php flo_meta('contact_address_phone' . $i) ?>
								</p>
							<?php endif ?>
						<?php endfor;?>
					</div>

					<div class="service website">
						<h4>Website</h4>
						<p><a href="<?php flo_meta('website'); ?>" target="_blank"><?php flo_meta('website'); ?></a></p>
					</div>

					<div class="service details">
						<h4>Venue Details</h4>
						
						<dl class="cf">
							<dt>
								Spaces Available
							</dt>
							<dd>
								<?php flo_meta('additional_spaces'); ?>
							</dd>
							<dt>
								Capacity
							</dt>
							<dd>
								<?php flo_meta('additional_capacity'); ?>
							</dd>
							<dt>
								Square Footage
							</dt>
							<dd>
								<?php flo_meta('additional_footage'); ?>
							</dd>
							<dt>
								Catering Policy
							</dt>
							<dd>
								<?php flo_meta('additional_cathering'); ?>
							</dd>

							<dt>
								Alcohol Policy
							</dt>
							<dd>
								<?php echo flo_get_meta('additional_alcohool') ? 'Yes, outside alcohol vendors are permitted' : 'No' ?>
							</dd>
							<dt>
								Onsite Accommodations
							</dt>
							<dd>
								<?php echo flo_get_meta('additional_accomodations') ? 'Yes' : 'No' ?>
							</dd>

							<dt>
								Handicap Accessible
							</dt>
							<dd>
								<?php echo flo_get_meta('additional_handicap') ? 'Yes' : 'No' ?>
							</dd>

							<dt>
								We Accept
							</dt>
							<dd>
								<?php foreach (flo_get_meta('additional_accepted_payments', false) as $payment): ?>
									<span>
										<img src="<?php echo get_template_directory_uri() . '/img/payments/logo-' . strtolower($payment) . '.jpg' ?>" alt="<?php $payment ?>" />
									</span>
								<?php endforeach ?>
							</dd>

						</dl>
					</div>
				</div>

				<?php if ($video_url): ?>
					<div id="venue-video" class="tab">
						<h3>Video</h3>
						<?php echo wp_oembed_get($video_url, array('width' => '600', 'height' => '400')) ?>
					</div>
				<?php endif ?>
				<?php if (count($downloads)): ?>
					<div id="venue-downloads" class="tab">
						<h3>Downloads</h3>
						<?php foreach($downloads as $file):?>
							<li>
								<a href="<?php echo $file->guid; ?>" rel="external"><strong><?php echo $file->post_title; ?></strong></a> 
							</li>
						<?php endforeach; ?>
					</div>
				<?php endif ?>
				<?php if (count($events)): ?>
					<div id="venue-events" class="tab">
						<h3>Events</h3>
					</div>					
				<?php endif ?>
				<?php if (count($from_the_blog)): ?>
					<div id="venue-blog" class="tab">
						<h3>From The Blog</h3>
					</div>
				<?php endif ?>
			</div>
      <?php comments_template('/venue-reviews.php'); ?>
		</section>
	<?php endwhile; else: ?>
		<?php flo_part('notfound')?>
	<?php endif; ?>
</div>
<?php get_sidebar('venue'); ?>
<?php get_footer(); ?>
