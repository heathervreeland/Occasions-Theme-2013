			<?php 
				$advertiser = new Flotheme_Advertiser(); 
				$eventID = (int) $_REQUEST['edit']; 
				$event = $advertiser->getEvent($eventID); 
			?>

			<?php if ( $event || isset($_REQUEST['new']) ) : ?>
			<form action="" method="post">
				<div class="b-events">
					<div id="profile-info" class="tab">
						<h3>Event<?php if (!isset($_REQUEST['new'])) : ?> <span>(status: <?php echo $event->post_status == 'publish' ? 'Approved' : 'In Progress' ?>)</span><?php endif; ?></h3>

						<fieldset>
							<p>
								<label for="flo_event_title">Event Title</label>
								<input type="text" value="<?php echo $event->post_title ?>" name="flo_event_title" id="flo_event_title" />
							</p>
							<p>
								<label for="flo_description">Description</label>
								<textarea name="flo_description" id="flo_description" /><?php flo_meta('description', true, $event->ID); ?></textarea>
							</p>							
							<p>
								<label for="flo_start_date">Start Date</label>
								<input type="text" value="<?php flo_meta('start_date', true, $event->ID) ?>" name="flo_start_date" id="flo_start_date" />
							</p>						
							<p>
								<label for="flo_end_date">End Date</label>
								<input type="text" value="<?php flo_meta('end_date', true, $event->ID) ?>" name="flo_end_date" id="flo_end_date" />
							</p>						
							<p>
								<label for="flo_hours">Hours</label>
								<input type="text" value="<?php flo_meta('hours', true, $event->ID) ?>" name="flo_hours" id="flo_hours" />
							</p>						
							<p>
								<label for="flo_event_address">Address</label>
								<input type="text" value="<?php flo_meta('event_address', true, $event->ID) ?>" name="flo_event_address" id="flo_event_address" />
							</p>						
							<p>
								<label for="flo_event_address_city">City</label>
								<input type="text" value="<?php flo_meta('event_address_city', true, $event->ID) ?>" name="flo_event_address_city" id="flo_event_address_city" />
							</p>	
							<p>
								<label for="flo_event_address_state">State</label>
								<input type="text" value="<?php flo_meta('event_address_state', true, $event->ID) ?>" name="flo_event_address_state" id="flo_event_address_state" />
							</p>		
							<p>
								<label for="flo_event_address_zip">ZIP</label>
								<input type="text" value="<?php flo_meta('event_address_zip', true, $event->ID) ?>" name="flo_event_address_zip" id="event_address_zip" />
							</p>							
							<p>
								<label for="flo_location">Location</label>
								<input type="text" value="<?php flo_meta('location', true, $event->ID) ?>" name="flo_location" id="flo_location" />
							</p>
							<p>
								<label for="flo_cost">Cost</label>
								<input type="text" value="<?php flo_meta('cost', true, $event->ID) ?>" name="flo_cost" id="flo_cost" />
							</p>

							<p>
								<label for="flo_more_url">More Info</label>
								<input type="text" value="<?php flo_meta('more_url', true, $event->ID) ?>" name="flo_more_url" id="flo_more_url" />
							</p>
						</fieldset>
					</div>							

					<div class="submit">
						<?php if (!isset($_REQUEST['new'])) : ?>
							<input type="hidden" value="<?php echo $event->ID; ?>" name="flo_event_id" id="flo_event_id" />
						<?php else: ?>
							<input type="hidden" value="0" name="flo_event_id" id="flo_event_id" />
						<?php endif; ?>						
						<a href="<?php echo home_url('advertisers/events'); ?>/?remove=<?php echo $event->ID; ?>" class="delete btn">DELETE</a>
						<input type="submit" value="Save Information" />
					</div>

				</div>
			</form>
			<?php else: ?>
				<p>Nothing here.</p>
			<?php endif; ?>