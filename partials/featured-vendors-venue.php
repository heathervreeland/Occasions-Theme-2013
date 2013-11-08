<?php 
	// grab object from general template page
	global $type; 
?>
<section class="featured-vendors featured-vendors-large">
	<h4>Featured Vendors</h4>
	<?php 
			$region = get_term_by('slug', $region, 'region');
	 ?>
	<?php echo flo_adrotate_block('venue', $type->term_id, 0, 4); ?>
</section>