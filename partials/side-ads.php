<?php if (flo_get_option('google_ad') && flo_get_option('sidebar_ad_count')): ?>
	<div class="zone">	
		<?php for ($i = 1; $i <= flo_get_option('sidebar_ad_count'); $i++): ?>
			<div class="spot"><script type='text/javascript'>GA_googleFillSlot("300x125_spot_<?php echo $i ?>");</script></div>
		<?php endfor;?>
	</div>
<?php endif ?>