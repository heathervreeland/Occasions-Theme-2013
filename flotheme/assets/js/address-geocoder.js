

jQuery(document).ready(function($) {

	var geocode = $('#geocode');

	if (!geocode.length) {
		return;
	}

	var reset = $('#geocode-reset');
	var mapcanvas = document.getElementById('geocodepreview');

	var geocoder;
	var map, latlng, marker;

	var mapOptions = {
		backgroundColor: '#EAEAEA',
		mapTypeControl: false,
		zoom: 14,
		center: new google.maps.LatLng(-34.397, 150.644),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};


	var address = $('#flogeoaddress');
	var lat = $('#flogeolat');
	var lng = $('#flogeolng');

	geocoder = new google.maps.Geocoder();

	map = new google.maps.Map(mapcanvas, mapOptions);
	marker = new google.maps.Marker({
		map: map,
		draggable:true,
		visible:false
	});

	google.maps.event.addListener(marker, 'dragend', function() {
		address.val('');
		var position = marker.getPosition();

		lat.val(position.lat());
		lng.val(position.lng());
		marker.setVisible(true);
	});

	if (lat.val() && lng.val()) {
		latlng = new google.maps.LatLng(lat.val(), lng.val());
		map.setCenter(latlng);
		marker.setPosition(latlng);
		marker.setVisible(true);
	}

	function code_address() {
		var _address = address.val();
		if (!_address) {
			lat.val('');
			lng.val('');
			marker.setVisible(true);
			return;
		}
		geocoder.geocode( { 'address': _address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {

				map.setCenter(results[0].geometry.location);
				marker.setPosition(results[0].geometry.location);

				lat.val(results[0].geometry.location.lat());
				lng.val(results[0].geometry.location.lng());

				marker.setVisible(true);
			} else {
				marker.setVisible(false);
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}

	geocode.click(function(e){
		e.preventDefault();
		code_address();
	});

	reset.click(function(e){
		e.preventDefault();
		address.val('');
		lat.val('');
		lng.val('');
		marker.setVisible(false);
	});
});