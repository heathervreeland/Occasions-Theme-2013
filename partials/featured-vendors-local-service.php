<?php 
	// grab object from general template page
	global $region; 
	global $cat;
?>
<section class="featured-vendors featured-vendors-large">
	<h4>Featured Vendors</h4>
	<?php echo flo_adrotate_block('local-service', $region->term_id, $cat->term_id, 4); ?>
</section>