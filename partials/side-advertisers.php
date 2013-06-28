<?php if (flo_check_advertiser_logged_in()): ?>
	<?php
		$advertiser = new Flotheme_Advertiser();
	?>
	<div class="widget profile-control">
		<?php if (flo_get_meta('upgrade_type') == 'simple') : //(!$advertiser->live()): ?>
			<div class="upgrade">
				<h4>Upgrade Your Profile!</h4>
				<p>Your courtesy account has been created. Your profile information won't display live on the site until you upgrade to a business profile!</p>
				<div class="button">
					<a href="<?php echo Flotheme_Advertiser::url('upgrade'); ?>" class="btn">Upgrade to a Business Profile NOW!</a>
				</div>
			</div>
		<?php endif ?>
		<h3>Hello, <?php echo $advertiser->user()->user_nicename ?>.</h3>
		<ul>
			<li <?php echo Flotheme_Advertiser::isUrl('dashboard') ? 'class="selected"' : '' ?>>
				<a href="<?php echo Flotheme_Advertiser::url('dashboard'); ?>">Dashboard</a>
			</li>
			<li <?php echo Flotheme_Advertiser::isUrl('business-profile') ? 'class="selected"' : '' ?>>
				<a href="<?php echo Flotheme_Advertiser::url('business-profile'); ?>">Business Profile</a>
			</li>
			<li <?php echo Flotheme_Advertiser::isUrl('buy-featured-placement') ? 'class="selected"' : '' ?>>
				<a href="<?php echo Flotheme_Advertiser::url('buy-featured-placement'); ?>">Buy Featured Placement</a>
			</li>
			<li <?php echo Flotheme_Advertiser::isUrl('stats') ? 'class="selected"' : '' ?>>
				<a href="<?php echo Flotheme_Advertiser::url('stats'); ?>">Statistics</a>
			</li>
			<li <?php echo Flotheme_Advertiser::isUrl('events') ? 'class="selected"' : '' ?>>
				<a href="<?php echo Flotheme_Advertiser::url('events'); ?>">Events</a>
			</li>
			<?php /*
			<li <?php echo Flotheme_Advertiser::isUrl('leads') ? 'class="selected"' : '' ?>>
				<a href="<?php echo Flotheme_Advertiser::url('leads'); ?>">Leads</a>
			</li>
			*/ ?>
			<li <?php echo Flotheme_Advertiser::isUrl('faq') ? 'class="selected"' : '' ?>>
				<a href="<?php echo Flotheme_Advertiser::url('faq'); ?>">Frequently Asked Questions </a>
			</li>
			<li <?php echo Flotheme_Advertiser::isUrl('contact-us') ? 'class="selected"' : '' ?>>
				<a href="<?php echo Flotheme_Advertiser::url('contact-us'); ?>">Contact Us</a>
			</li>
			<li <?php echo Flotheme_Advertiser::isUrl('account') ? 'class="selected"' : '' ?>>
				<a href="<?php echo Flotheme_Advertiser::url('account'); ?>">Account Settings</a>
			</li>
			<li class="logout">
				<a href="<?php echo wp_logout_url() ?>">Logout</a>
			</li>
		</ul>
	</div>
<?php endif ?>