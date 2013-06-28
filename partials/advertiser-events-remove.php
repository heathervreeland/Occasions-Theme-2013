			<?php 
				if (isset($_REQUEST['remove']) && is_numeric($_REQUEST['remove'])) {
					$advertiser = new Flotheme_Advertiser();
					$advertiser->removeEvent($_GET);

					wp_redirect(home_url('advertisers/events'),'301');	
				} 
			?>
