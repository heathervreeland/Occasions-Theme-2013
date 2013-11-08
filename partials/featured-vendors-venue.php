<?php 
	// grab object from general template page
	global $type; 
?>
<section class="featured-vendors featured-vendors-large">
	<h4>Featured Vendors</h4>
	<?php 
			$region = get_term_by('slug', $region, 'region');
	 ?>
	<?php echo flo_adrotate_block('local-venue', $region->term_id, $type->term_id, 4); ?>
</section>