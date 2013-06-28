			<?php 
				if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST' && count($_POST)) {
					$advertiser = new Flotheme_Advertiser();
					$advertiser->saveEventData($_POST);

					if (isset($_REQUEST['new'])) wp_redirect(home_url('advertisers/events'),'301');
				}
			?>

			<header class="page-title page-title-container cf">
				<h2><?php the_title() ?></h2>
				<div class="box">
					<a href="<?php echo home_url('advertisers/events'); ?>" class="btn">All Events</a>
				</div>
			</header>

			<?php flo_part('advertiser-events-edit-form'); ?>
