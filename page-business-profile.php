<?php
flo_advertiser_logged_in();

$advertiser = new Flotheme_Advertiser();

if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST' && count($_POST)) {
	$advertiser->saveProfileData($_POST);
}

get_header(); ?>
<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="advertisers">

			<header class="page-title page-title-container cf">
				<h2><?php the_title()?></h2>
				<?php if ($advertiser->live()): ?>
					<div class="box">
						<a href="<?php echo get_permalink($advertiser->profile()->id()) ?>" rel="external">View Public Page</a>
					</div>
				<?php endif ?>
			</header>
			<form action="" method="post">
				<div class="b-profile">

					<?php if ($advertiser->hasErrors()): ?>
						<div class="errors">
							<?php foreach ($advertiser->errors() as $error): ?>
								<p><?php echo $error ?></p>
							<?php endforeach ?>
						</div>
					<?php endif ?>
					<ul class="tabs">
						<li><a href="#profile-info">Profile</a></li>
						<li><a href="#profile-descriptions">Descriptions</a></li>
						<li><a href="#profile-video">Video</a></li>
						<li><a href="#profile-socials">Socials</a></li>
						<li><a href="#profile-contact">Contact</a></li>
						<li><a href="#profile-venues">Venues</a></li>
						<li><a href="#profile-gallery">Gallery</a></li>
						<li><a href="#profile-files">Files</a></li>
						<!-- <li><a href="#profile-admin">Admin</a></li> -->
					</ul>
					<div class="clear"></div>

					<div id="profile-info" class="tab">
						<h3>Profile</h3>
						<fieldset>
							<p>
								<label for="flo_profile_name">Profile Name</label>
								<input type="text" value="<?php echo $advertiser->profile()->name() ?>" name="flo_profile_name" id="flo_profile_name" />
							</p>
							<p>
								<?php
									$services = get_terms('service', array(
										'hide_empty' => false,
									));
								?>
								<label for="flo_profile_category">Category</label>
								<select name="flo_profile_category" id="flo_profile_category">
									<?php foreach ($services as $cat): ?>
										<option value="<?php echo $cat->term_id ?>" <?php echo $advertiser->profile()->service()->term_id == $cat->term_id ? 'selected="selected"' : '' ?>><?php echo $cat->name ?></option>
									<?php endforeach ?>
								</select>
							</p>
							<p>
								<?php
									$payment_types = $advertiser->profile()->paymentTypes();
								?>
								<label for="flo_additional_accepted_payments">Payment Acceptance</label>
								<span class="checkboxes">
									<?php foreach (flo_accepted_payments() as $val => $title): ?>
										<label><input type="checkbox" name="flo_additional_accepted_payments[]" value="<?php echo $val ?>" <?php echo in_array($title, $payment_types) ? 'checked="checked"' : '' ?>> <?php echo $title ?></label>
									<?php endforeach ?>
								</span>
							</p>
						</fieldset>
					</div>

					<div id="profile-descriptions" class="tab">
						<h3>Descriptions</h3>
						<fieldset>
							<p>
								<label for="flo_short_info">Short Information</label>
								<textarea name="flo_short_info" id="flo_short_info" cols="30" rows="10"><?php echo $advertiser->profile()->field('short_info') ?></textarea>
							</p>
							<p>
								<label for="flo_description">Profile Description</label>
								<span class="desc">Use this area to describe your services or business.</span>
								<textarea name="flo_description" id="flo_description" cols="30" rows="10"><?php echo $advertiser->profile()->field('description') ?></textarea>
							</p>
							<p>
								<label for="flo_promo">Promotional Offer</label>
								<span class="desc">Enter an optional promotional offer or incentive you are currently offering. It is helpful for determining the effectiveness of your profile if you ask the client to mention Occasions Magazine when inquiring about your offer.</span>
								<textarea name="flo_promo" id="flo_promo" cols="30" rows="10"><?php echo $advertiser->profile()->field('promo') ?></textarea>
							</p>
						</fieldset>
					</div>
					<div id="profile-video" class="tab">
						<h3>Embed Video</h3>
						<p>
							Enter the URL to the video below and we will automatically embed the video in your profile.<br/>
							Supported video services: YouTube, Vimeo, Viddler, Google Video, Qik, and Animoto.
							<br/>
							Simply enter the website address for your video, for example:<br/>
							<br/>• YouTube: http://www.youtube.com/watch?v=FRscebgg5C0
							<br/>• Vimeo: http://vimeo.com/7809605
							<br/>• DO NOT enter the address of a page on your website containing video(s). It must be a video service.
						</p>
						<fieldset>
							<p>
								<label for="flo_video_url">Video URL</label>
								<input type="text" name="flo_video_url" id="flo_video_url" value="<?php echo $advertiser->profile()->field('video_url') ?>">
							</p>
						</fieldset>
						<?php if ($advertiser->profile()->field('video_url')): ?>
							<div class="video"><?php echo wp_oembed_get($advertiser->profile()->field('video_url'), array('width' => 500, 'height' => 300) ) ?></div>
						<?php endif ?>
					</div>

					<div id="profile-socials" class="tab">
						<h3>Social Services</h3>
						<fieldset>
							<p>
								<label for="flo_facebook">Facebook</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('facebook') ?>" name="flo_facebook" id="flo_facebook" />
							</p>
							<p>
								<label for="flo_twitter">Twitter</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('twitter') ?>" name="flo_twitter" id="flo_twitter" />
							</p>
							<p>
								<label for="flo_tumblr">Tumblr</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('tumblr') ?>" name="flo_tumblr" id="flo_tumblr" />
							</p>
							<p>
								<label for="flo_vimeo">Vimeo</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('vimeo') ?>" name="flo_vimeo" id="flo_vimeo" />
							</p>
							<p>
								<label for="flo_youtube">Youtube</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('youtube') ?>" name="flo_youtube" id="flo_youtube" />
							</p>
						</fieldset>
					</div>
					<div id="profile-contact" class="tab">
						<h3>Contact</h3>
						<fieldset>
							<p>
								<label for="flo_contact_name">Contact Name</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('contact_name') ?>" name="flo_contact_name" id="flo_contact_name" />
							</p>
							<p>
								<label for="flo_contact_title">Contact Title</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('contact_title') ?>" name="flo_contact_title" id="flo_contact_title" />
							</p>
							<p>
								<label for="flo_contact_email">Contact Email</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('contact_email') ?>" name="flo_contact_email" id="flo_contact_email" />
							</p>
						</fieldset>
						<fieldset>
							<p>
								<label for="flo_website">Website</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('website') ?>" name="flo_website" id="flo_website" />
							</p>
							<p>
								<label for="flo_blog">Blog</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('blog') ?>" name="flo_blog" id="flo_blog" />
							</p>
						</fieldset>
						<fieldset>
							<label>Show address in profile</label>
							<p>
								<label class="desc"><input type="checkbox" value="1" name="flo_contact_address_show" <?php echo $advertiser->profile()->field('contact_address_show') ? 'checked="checked"' : '' ?> /> If checked, the address you specify below will appear in your public profile.</label>
							</p>
							<p>
								<label for="flo_contact_address">Address</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('contact_address') ?>" name="flo_contact_address" id="flo_contact_address" />
							</p>
							<p>
								<label for="flo_contact_address_city">City / State / Zip</label>
								<input type="text" class="medium" value="<?php echo $advertiser->profile()->field('contact_address_city') ?>" name="flo_contact_address_city" id="flo_contact_address_city" />
								<input type="text" class="small" value="<?php echo $advertiser->profile()->field('contact_address_state') ?>" name="flo_contact_address_state" id="flo_contact_address_state" />
								<input type="text" class="small" value="<?php echo $advertiser->profile()->field('contact_address_zip') ?>" name="flo_contact_address_zip" id="flo_contact_address_zip" />
							</p>
							<p>
								<label for="flo_contact_address_county">County</label>
								<input type="text" value="<?php echo $advertiser->profile()->field('contact_address_county') ?>" name="flo_contact_address_county" id="flo_contact_address_county" />
							</p>


							<p>
								<label for="flo_contact_address_travel_policy">Travel Policy</label>
								<select name="flo_contact_address_travel_policy" id="flo_contact_address_travel_policy">
									<?php foreach (flo_travel_policies() as $policy): ?>
										<option value="<?php echo $policy['value'] ?>" <?php echo $advertiser->profile()->field('contact_address_travel_policy') == $policy['value'] ? 'selected="selected"' : '' ?>><?php echo $policy['name'] ?></option>
									<?php endforeach ?>
								</select>
							</p>
							<p>
								<label>Phone Numbers</label>
								<span class="desc">
									Enter the number and select the type of number for each. These will appear in your profile in the order they are listed here.
								</span>
								<?php for($i = 1; $i <=3; $i++): ?>
									<span class="phone">
										<input type="text" class="medium" value="<?php echo $advertiser->profile()->field('contact_address_phone' . $i) ?>" name="flo_contact_address_phone<?php echo $i ?>" id="flo_contact_address_phone<?php echo $id ?>">
										<select name="flo_contact_address_phone<?php echo $i ?>_type" id="<?php echo $id ?>">
											<?php foreach (flo_phone_types() as $type): ?>
												<option value="<?php echo $type['value'] ?>" <?php echo $advertiser->profile()->field('contact_address_phone' . $i . '_type') == $type['value'] ? 'selected="selected"' : '' ?>><?php echo $type['name'] ?></option>
											<?php endforeach ?>
										</select>
									</span>
								<?php endfor;?>
							</p>
						</fieldset>
					</div>
					<div id="profile-venues" class="tab">
						<h3>Venues</h3>
						<fieldset>
							<p>
								<label for="">Location</label>
								<?php
									$regions = flo_get_regions_hierarchial();
								?>
								<select name="flo_profile_region" id="">
									<?php foreach ($regions as $region): ?>
										<optgroup label="<?php echo $region->name ?>">
											<?php foreach ($region->cities as $city): ?>
												<option value="<?php echo $city->term_id ?>" <?php echo $city->term_id == $advertiser->profile()->city()->term_id ? 'selected="selected"' : '' ?>><?php echo $city->name ?></option>
											<?php endforeach ?>
										</optgroup>
									<?php endforeach ?>
								</select>
							</p>
							<?php
								$types = get_terms('venue-type', array(
									'hide_empty' => false,
								));
								$ad_types = $advertiser->profile()->types();
							?>
							<p>
								<label>Venue Type</label>
								<span class="select">
									<select name="flo_profile_types[1]" id="flo_profile_types1">
										<?php foreach ($types as $type): ?>
											<option value="<?php echo $type->term_id ?>" <?php echo isset($ad_types[0]) && $ad_types[0]->term_id == $type->term_id ? 'selected="selected"' : '' ?>><?php echo $type->name ?></option>
										<?php endforeach ?>
									</select>
								</span>
								<span class="select">
									<select name="flo_profile_types[2]" id="flo_profile_types2">
										<?php foreach ($types as $type): ?>
											<option value="<?php echo $type->term_id ?>" <?php echo isset($ad_types[1]) && $ad_types[1]->term_id == $type->term_id ? 'selected="selected"' : '' ?>><?php echo $type->name ?></option>
										<?php endforeach ?>
									</select>
								</span>
								<span class="select">
									<select name="flo_profile_types[3]" id="flo_profile_types3">
										<?php foreach ($types as $type): ?>
											<option value="<?php echo $type->term_id ?>" <?php echo isset($ad_types[2]) && $ad_types[2]->term_id == $type->term_id ? 'selected="selected"' : '' ?>><?php echo $type->name ?></option>
										<?php endforeach ?>
									</select>
								</span>
							</p>
						</fieldset>

						<fieldset>
							<p>
								<label for="flo_additional_spaces">Number of Spaces Available</label>
								<input type="text" class="small" value="<?php echo $advertiser->profile()->field('additional_spaces') ?>" name="flo_additional_spaces" id="flo_additional_spaces" />
							</p>

							<p>
								<label for="flo_additional_capacity">Capacity</label>
								<input type="text" class="small" value="<?php echo $advertiser->profile()->field('additional_capacity') ?>" name="flo_additional_capacity" id="flo_additional_capacity" />
							</p>

							<p>
								<label for="flo_additional_footage">Square Footage</label>
								<input type="text" class="small" value="<?php echo $advertiser->profile()->field('additional_footage') ?>" name="flo_additional_footage" id="flo_additional_footage" />
							</p>

							<p>
								<label for="flo_additional_cathering">Catering Policy</label>
								<input type="text" class="medium" value="<?php echo $advertiser->profile()->field('additional_cathering') ?>" name="flo_additional_cathering" id="flo_additional_cathering" />
							</p>

							<p>
								<label for="flo_additional_alcohool">Alcohol Policy</label>
								<label class="desc"><input type="checkbox" value="1" name="flo_additional_alcohool" <?php echo $advertiser->profile()->field('additional_alcohool') ? 'checked="checked"' : '' ?> /> Yes, outside alcohol vendors are permitted</label>
							</p>

							<p>
								<label for="flo_additional_accomodations">Onsite Accomodations</label>
								<label class="desc"><input type="checkbox" value="1" name="flo_additional_accomodations" <?php echo $advertiser->profile()->field('additional_accomodations') ? 'checked="checked"' : '' ?> /> Yes, onsite accommodations are available at this venue</label>
							</p>

							<p>
								<label for="flo_additional_handicap">Handicap Accessible</label>
								<label class="desc"><input type="checkbox" value="1" name="flo_additional_handicap" <?php echo $advertiser->profile()->field('additional_handicap') ? 'checked="checked"' : '' ?> /> Yes, onsite accommodations are available at this venue</label>
							</p>
						</fieldset>
					</div>

					<div id="profile-gallery" class="tab">
						<h3>Gallery</h3>

						<div class="story">
							<p>Main Image &amp; Profile Images</p>
							<p>All images must meet the following specifications:</p>
							<ul>
								<li><strong>JPG/JPEG, GIF or PNG</strong> format</li>
								<li>No larger than <strong>4000</strong> pixels on the longest side</li>
								<li>Less than <strong>4MB</strong> in file size</li>
							</ul>
							<p><strong>NOTE</strong>: Changes to your images will appear in your profile <strong>IMMEDIATELY</strong> after upload.</p>
							<p>&nbsp;</p>
						</div>


						<div class="gallery">
							<ul class="cf">
								<?php
									$thumb_id = get_post_thumbnail_id($advertiser->profile()->id());
								?>
								<?php foreach(flo_get_attached_images($advertiser->profile()->id()) as $image ): ?>
									<li <?php echo $thumb_id == $image->ID ? 'class="main"' : '' ?>>
										<?php echo wp_get_attachment_image($image->ID, 'venue-thumbnail'); ?>
										<a href="#" class="delete" data-id="<?php echo $image->ID ?>">delete</a>
										<a href="#" class="set-main" data-id="<?php echo $image->ID ?>">set main image</a>
									</li>
								<?php endforeach;?>
							</ul>
						</div>
						<div class="uploader"></div>
					</div>

					<div id="profile-files" class="tab">
						<h3>Files</h3>

						<div class="story">
							<p>Profile Files</p>
							<p>All files must meet the following specifications:</p>
							<ul>
								<li><strong>PDF, RTF, DOC, TXT or XML</strong> format</li>
								<li>Less than <strong>4MB</strong> in file size</li>
							</ul>
							<p>&nbsp;</p>
						</div>


						<div class="files">
							<ul class="cf">
								<?php foreach(flo_get_attached_files($advertiser->profile()->id()) as $file ): ?>
									<?php if ($file->post_mime_type == 'image/jpeg') continue; ?>
									<li>
										<a href="#" class="delete" data-id="<?php echo $file->ID ?>">delete</a> <a href="<?php echo $file->guid; ?>" rel="external"><strong><?php echo $file->post_title; ?></strong></a>
									</li>
								<?php endforeach;?>
							</ul>
						</div>
						<div class="uploader"></div>
					</div>

					<!-- <div id="profile-admin" class="tab">
						<h3>QR Code</h3>

						<?php
						$vid = $advertiser->profile()->id();
						$oldid = get_post_meta($vid,'flo_oldid', true);
						if (is_numeric($oldid)) $vid = $oldid;
						?>

						<p>Below is a small and large QR Code for your Occasions profile page: </p>
						<?php $link = urlencode('http://maglink.us/p'.$vid); ?>
						<p><img src="http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl=<?php echo $link ?>&chld=H|0" /></p>
						<p><img src="http://chart.apis.google.com/chart?cht=qr&chs=500x500&chl=<?php echo $link ?>&chld=H|0" /></p>

						<h3>Mobile QR Code</h3>
						<p>Below is a small and large QR Code for your Occasions profile page <strong>designed for mobile devices</strong>:</p>
						<?php $mobile_link = urlencode('http://maglink.us/m'.$vid); ?>
						<p><img src="http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl=<?php echo $link ?>&chld=H|0" /></p>
						<p><img src="http://chart.apis.google.com/chart?cht=qr&chs=500x500&chl=<?php echo $link ?>&chld=H|0" /></p>
					</div>			 -->

					<div class="submit">
						<input type="submit" value="Save Information" />

					</div>
				</div>
			</form>
		</div>
	<?php endwhile; else: ?>
		<?php flo_part('notfound')?>
	<?php endif; ?>
</div>
<?php get_sidebar('advertisers'); ?>
<?php get_footer(); ?>