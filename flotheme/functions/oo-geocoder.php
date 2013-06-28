<?php
add_action( 'admin_init', 'flo_oo_geo_admin_init' );

function flo_oo_geo_admin_init() {
	$gcode = flo_get_option('google_api');

	wp_register_script( 'googlemaps', 'http://maps.googleapis.com/maps/api/js?key=' . $gcode . '&sensor=false' );
	wp_enqueue_script( 'googlemaps' );

	wp_register_script( 'flo_geocode_js', FLOTHEME_URL.'/assets/js/address-geocoder.js');
	wp_enqueue_script( 'flo_geocode_js' );

	add_meta_box('flogeo', 'Geocoder', 'flo_oo_geo_setup', 'venue', 'normal', 'high');
	add_action('save_post','flo_oo_geo_save');

}

function flo_oo_geo_setup() {
	global $post;
	$address = get_post_meta($post->ID,'flo_geoaddress',TRUE);
	$lat = get_post_meta($post->ID,'flo_geolat',TRUE);
	$long = get_post_meta($post->ID,'flo_geolng',TRUE); ?>

	<div style="overflow: hidden; width: 100%;">
		<div id="geocodepreview" style="float: right; width: 400px; height: 220px; border: 1px solid #DFDFDF;"></div>

		<div style="margin-right: 415px">
		<p>
			<label for="flogeoaddress">Address</label>
			<input type="text" class="widefat" id="flogeoaddress" name="flogeoaddress" value="<?php if(!empty($address)) echo $address; ?>"/>
		</p>
		<p>
			<label for="flogeolatlng">Latitude</label>
			<input type="text" class="widefat" id="flogeolat" name="flogeolat" value="<?php if(!empty($lat)) echo $lat; ?>"/>
		</p>
		<p>
			<label for="flogeolatlng">Longtitude</label>
			<input type="text" class="widefat" id="flogeolng" name="flogeolng" value="<?php if(!empty($long)) echo $long; ?>"/>
		</p>
		<p>&nbsp;</p>
		<p>
			<a id="geocode" class="button-primary">Geocode Address</a>
			<a id="geocode-reset" class="button">Clear Address</a>
		</p>
		</div>
	</div>
	<?php echo '<input type="hidden" name="flo_oo_geo_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}

function flo_oo_geo_save($post_id) {
		if (!wp_verify_nonce($_POST['flo_oo_geo_noncename'],__FILE__)) return $post_id;

		if ($_POST['post_type'] == 'page') {
			if (!current_user_can('edit_page', $post_id)) return $post_id;
		} else {
			if (!current_user_can('edit_post', $post_id)) return $post_id;
		}

		$address = (string) $_POST['flogeoaddress'];
		$lat = $_POST['flogeolat'];
		$lng = $_POST['flogeolng'];

		update_post_meta($post_id, 'flo_geoaddress', $address);
		update_post_meta($post_id, 'flo_geolat', $lat);
		update_post_meta($post_id, 'flo_geolng', $lng);

		return $post_id;
}