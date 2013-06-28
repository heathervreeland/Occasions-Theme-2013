			<?php $advertiser = new Flotheme_Advertiser(); ?>

			<header class="page-title page-title-container cf">
				<h2><?php the_title() ?></h2>
				<div class="box">
					<a href="?new" class="btn">Add New Event</a>
				</div>
			</header>


			<div class="b-events">
				<ul>
					<?php foreach ($advertiser->events() as $event): ?>
						<li class="cf">
							<h2><?php echo $event->post_title ?> <span>(<a href="?edit=<?php echo $event->ID; ?>">edit</a>)</span></h2>
							<div class="status">
								<?php echo $event->post_status == 'publish' ? 'Approved' : 'In Progress' ?>
							</div>
							<div class="descr">
								<?php echo apply_filters('the_content', flo_get_meta('description', true, $event->ID)); ?>
							</div>
							<dl class="cf">
								<dt>Date(s)</dt>
								<dd>
									<?php echo flo_get_event_date('start', 'F d, Y', $event->ID) ?> 
									<?php if (flo_get_meta('date_end')): ?>
										/ <?php echo flo_get_event_date('end', 'F d, Y', $event->ID) ?> 
									<?php endif ?>
								</dd>

								<?php if (flo_get_meta('hours', true, $event->ID)): ?>
									<dt>Hours</dt>
									<dd><?php flo_meta('hours', true, $event->ID) ?></dd>									
								<?php endif ?>

								<dt>Address</dt>
								<dd>
									<?php flo_meta('event_address', true, $event->ID) ?>
									<?php if (flo_get_meta('event_address_city', true, $event->ID)): ?>
										, <?php flo_meta('event_address_city', true, $event->ID) ?>
									<?php endif ?>
									<?php if (flo_get_meta('event_address_state', true, $event->ID)): ?>
										, <?php flo_meta('event_address_state', true, $event->ID) ?>
									<?php endif ?>
									<?php if (flo_get_meta('event_address_zip', true, $event->ID)): ?>
										, <?php flo_meta('event_address_zip', true, $event->ID) ?>
									<?php endif ?>
								</dd>
								
								<?php if (flo_get_meta('location', true, $event->ID)): ?>
									<dt>Location</dt>
									<dd><?php flo_meta('location', true, $event->ID) ?></dd>									
								<?php endif ?>
								
								<?php if (flo_get_meta('cost', true, $event->ID)): ?>
									<dt>Cost</dt>
									<dd><?php flo_meta('cost', true, $event->ID) ?></dd>									
								<?php endif ?>

								<?php if (flo_get_meta('more_url', true, $event->ID)): ?>
									<dt>More Info</dt>
									<dd><a href="<?php flo_meta('more_url', true, $event->ID) ?>" rel="external"><?php flo_meta('more_url', true, $event->ID) ?></a></dd>
								<?php endif ?>
							</dl>



						</li>
					<?php endforeach ?>
				</ul>
			</div>