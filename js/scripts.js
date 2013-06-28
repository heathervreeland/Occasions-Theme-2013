// add your custom scripts here
// as the page loads, call these scripts
jQuery(function($) {
	$.issue_button_transform = function (formId, ajaxurl, productName, productUrl, addingText) {
		var buttonText = $('#issue-addtocart-' + formId).val();
		$('#issue-addtocart-' + formId).attr('disabled', 'disabled')
									.addClass('disabled')
									.val(addingText);
		$.issue_add_to_cart_ajax(formId, ajaxurl, productName, productUrl, buttonText);
	};

	$.issue_add_to_cart_ajax = function(formId, ajaxurl, productName, productUrl, buttonText) {
		var itemQuantity = $('#issue-quantity-' + formId).val();
		var cleanProductId = formId.split('_');
		cleanProductId = cleanProductId[0];

		var data = {
			cart66ItemId: cleanProductId,
			itemName: productName,
			options_1: '',
			options_2: '',
			item_quantity: itemQuantity,
			item_user_price: '',
			product_url: productUrl
		};

		ajaxManager.addReq({
			type: "POST",
			url: ajaxurl + '=2',
			data: data,
			dataType: 'json',
			success: function(response) {
				$.pnotify({
					title: 'Item added',
					text: '<div>"<span>' + data.itemName + '</span>" - added to cart</div><div><a href="' + flo.site_url +  '/store/cart/">View Cart</a></div>',
					type: 'success',
					shadow: false
				});

				$('#issue-addtocart-' + formId).removeAttr('disabled')
											.removeClass('disabled')
											.val(buttonText);
				ajaxUpdateCartWidgets(ajaxurl);
				
				if($('.customAjaxAddToCartMessage').length > 0) {
					$('.customAjaxAddToCartMessage').show().html(response.msg);
					$.hookExecute('customAjaxAddToCartMessage', response);
				} else {
					if(parseInt(response.msgId, 10) === 0){
						$('.success_' + formId).fadeIn(300);
						$('.success_message_' + formId).html(response.msg);
						$('.success_' + formId).delay(2000).fadeOut(300);
					}
					if((response.msgId) == -1){
						$('.warning_' + formId).fadeIn(300);
						$('.warning_message_' + formId).html(response.msg);
					}
					if((response.msgId) == -2){
						$('.error_' + formId).fadeIn(300);
						$('.error_message_' + formId).html(response.msg);
					}
				}
			}
		});
	};
});

// Modernizr.load loading the right scripts only if you need them
Modernizr.load([
	{
		// Let's see if we need to load selectivizr
		test : Modernizr.borderradius,
		// Modernizr.load loads selectivizr and Respond.js for IE6-8
		nope : [flo.template_dir + '/js/libs/selectivizr.min.js', flo.template_dir + '/js/libs/respond.min.js']
	},{
		test: Modernizr.touch,
		yep:flo.template_dir + '/css/touch.css'
	}
]);

jQuery(function($) {
	
	var _window = $(window);

	$.global_init = function() {
		// open external links in new window
		$("a[rel$=external]").each(function(){
			$(this).attr('target', '_blank');
		});

		var page_title_container = $('#main .page-title-container');
		var page_foot_container = $('#main .page-foot-container');

		var regions_select = $('#services-venues .regions');

		if (page_title_container.size()) {
			page_title_container.find('.categories select').dxSelect({
				hide_first:true,
				clicked:function() {
					window.location.href = $(this).prop('title');
				}
			});
		}
		if (page_foot_container.size()) {
			page_foot_container.find('.categories select').dxSelect({
				hide_first:true,
				clicked:function() {
					window.location.href = $(this).prop('title');
				}
			});
		}

		function _equal_heights() {
			$('#main .featured-vendors ul').featuredEqHeights();
		}

		_equal_heights();

		function _init_regions() {
			var list = $('.list', regions_select);
			var states = $('ul > li span',  list);

			$('.select', regions_select).click(function(){
				if (list.is(':visible')) {
					$(this).removeClass('active');
					list.slideUp('fast');
				} else {
					$(this).addClass('active');
					list.slideDown('fast');
				}
			});

			states.click(function(){
				var span = $(this);
				var parent = span.parent();
				// var cities = $('ol', cities);

				if (parent.hasClass('active')) {
					parent.removeClass('active');
				} else {
					parent.addClass('active').siblings().removeClass('active');
				}
			});
		}

		_init_regions();


		function _init_responsive() {

			var head_main = $('#head-main');
			var serv_venues = $('#services-venues');
			var responsive_foot = $('#responsive-footer');

			_window.setBreakpoints({
				distinct: true,
				breakpoints: [
					320,
					768,
					990
				]
			});
			_window.bind('enterBreakpoint990',function() {
				head_main.append(serv_venues);
			});
			_window.bind('enterBreakpoint768',function() {
				head_main.append(serv_venues);
			});
			_window.bind('enterBreakpoint320',function() {
				responsive_foot.append(serv_venues);
			});


			$('#nav-main > ul').floTinyNav({
				header:'Navigation'
			});

			$('#tinynav1').dxSelect();
		}

		_init_responsive();

	};

	$.global_init();


	
	$.fn.init_post = function() {

		var init_comments = function(post) {
			var respond = $('section.respond', post);
			var respond_form = $('form', respond);
			var respond_form_error = $('p.error', respond_form);
			var respond_cancel = $('.cancel-comment-reply a', respond);
			var comments = $('section.comments', post);
			
			$('a.comment-reply-link', post).on('click', function(e){
				e.preventDefault();
				var comment = $(this).parents('li.comment');
				comment.append(respond);
				respond_cancel.show();
				respond.find('input[name=comment_post_ID]').val(post.data('post-id'));
				respond.find('input[name=comment_parent]').val(comment.data('comment-id'));
				respond.find('input:first').focus();
			}).attr('onclick', '');
			
			respond_cancel.on('click', function(e){
				e.preventDefault();
				comments.after(respond);
				respond.find('input[name=comment_post_ID]').val(post.data('post-id'));
				respond.find('input[name=comment_parent]').val(0);
				$(this).hide();
			});
			
			respond_form.ajaxForm({
				'beforeSubmit':function(){
					respond_form_error.text('').hide();
				},
				'success':function(_data){
					var data = $.parseJSON(_data);
					if (data.error) {
						respond_form_error.html(data.msg).slideDown('fast');
						return;
					}
					var comment_parent_id = parseInt(respond.find('input[name=comment_parent]').val(), 10);
					var _comment = $(data.html);
					var list;
					_comment.hide();
					
					if (comment_parent_id === 0) {
						list = comments.find('ol');
						if (!list.length) {
							list = $('<ol class="commentlist"></ol>');
							comments.append(list);
						}
					} else {
						list = $('#comment-' + comment_parent_id).parent().find('ul');
						if (!list.length) {
							list = $('<ul class="children"></ul>');
							$('#comment-' + comment_parent_id).parent().append(list);
						}
						respond_cancel.trigger('click');
					}
					list.append(_comment);
					_comment.fadeIn('fast').scrollTo();
					respond.find('textarea').clearFields();
				},
				'error':function(response){
					var error = response.responseText.match(/<p\>(.*)<\/p\>/)[1];
					if (typeof(error) == 'undefined') {
						error = 'Something went wrong. Please reload the page and try again.';
					}
					respond_form_error.html(error).slideDown('fast');
				}
			});
		};
		$(this).each(function(){
			var post = $(this);
			_window.load(function(){

				var gallery = $('.gallery .flexslider', post);
				var thumbs = $('#post-thumbnails');

				thumbs.flexslider({
					animation: "slide",
					slideshow: false,
					controlNav: false,
					smoothHeight:false,
					// asNavFor:'#post-gallery',
					keyboard:false,
					itemWidth:81,
					itemMargin:0
				});
				// $('#post-gallery').flexslider({
				// 	animation: "fade",
				// 	slideshow: false,
				// 	controlNav: false,
				// 	smoothHeight:false,
				// 	sync:'#post-thumbnails'
				// });
			});
			init_comments(post);
			$('p, .video', post).fitVids();

		});
	};
	$('#post').init_post();

	$.fn.init_homepage = function() {
		$(this).each(function(){
			var homepage = $(this);
			var featured = $('.featured', homepage);
			var links = $('ul li', featured);
			var posters = $('.poster', featured);
			var arrows = $('.arrows', featured);

			var featured_interval, featured_interval_next;
			$('a', links).click(function(e){e.preventDefault();});
			links.click(function(e) {
				e.preventDefault();
				var li = $(this);
				if (li.hasClass('active')) {
					return;
				}
				var visible = posters.filter('.active');
				var current = $(posters[li.index()]);
				if (visible.length) {
					visible.fadeOut('fast', function(){
						visible.removeClass('active');
					});
				}
				current.fadeIn('fast', function(){
					current.addClass('active');
				});
				li.addClass('active').siblings('.active').removeClass('active');
				if ('undefined' == typeof(e.isTrigger)) {
					clearInterval(featured_interval);

				}
			}).filter(':first').trigger('click');
			featured_interval = setInterval(function(){
				featured_interval_next = links.filter('.active').next();
				if (!featured_interval_next.length) {
					featured_interval_next = links.filter(':first');
				}
				featured_interval_next.trigger('click');
			}, 5000);

			$('a', arrows).click(function(e){
				e.preventDefault();
				var link = $(this);
				var current = links.filter('.active');
				var updated;
				if (link.hasClass('next')) {
					updated = current.next();
					if (!updated.length) {
						updated = links.filter(':first');
					}
				} else {
					updated = current.prev();
					if (!updated.length) {
						updated = links.filter(':last');
					}
				}

				updated.find('a').trigger('click');

			});

			_window.bind('enterBreakpoint320',function() {
				clearInterval(featured_interval);
			});
		});
	};
	$('#homepage').init_homepage();


	$.fn.init_topcat = function() {
		$(this).each(function(){
			var cat = $(this);
			
			var previews = $('.category-preview');

			previews.each(function(){
				_init_preview_category($(this));
			});

			function _init_preview_category(box) {
				var posts = box.find('li');
				posts.hover(function(){
					_cat_hover($(this), box);
				});
				_cat_hover(posts.filter(':first'), box);
			}

			function _cat_hover(li, box) {
				li.addClass('selected').siblings().removeClass('selected');
				$('.image', box).css('background-image', 'url("' + li.data('image') + '")');
			}

		});
	};
	$('#top-category').init_topcat();

	
	$.fn.init_gallery = function() {
		$(this).each(function(){
			var gallery = $(this);
			_window.load(function(){
				$('.flexslider', gallery).flexslider({
					animation: "fade",
					slideshow: false,
					controlNav: false,
					smoothHeight:true
				});
			});
		});
	};
	$('#gallery').init_gallery();

	$.fn.init_topcat = function() {
		$(this).each(function(){
			var category = $(this);

			category.find('.cover .flexslider').flexslider({
				animation: "fade",
				slideshow: false,
				controlNav: true,
				directionNav: false,
				smoothHeight:true
			});
		});
	};
	$('#top-category').init_topcat();


	$.fn.init_venue = function() {
		$(this).each(function(){

			var venue = $(this);
			var sidebar = $('#sidebar');
			var gmap = $('#venue-geomap');

			var gallery, thumbs;

			if (gmap.length) {
				initialize_map();
			}

			function initialize_map() {
				var lat = gmap.data('lat');
				var lng = gmap.data('lng');
				var image = gmap.data('marker-image');
				var shadow = gmap.data('marker-shadow');

				gmap.gmap({
					backgroundColor: '#EAEAEA',
					mapTypeControl: false,
					zoom: 16,
					center: lat + ',' + lng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}).bind('init', function(){
					gmap.gmap('addMarker', {
						'position': lat + ',' + lng,
						'icon':image,
						'shadow':shadow
					}).click(function() {
						gmap.gmap('openInfoWindow', {'content': 'Hello World!'}, this);
					});
				});
			}

			_window.load(function(){
				gallery = $('.gallery .flexslider', venue);
				thumbs = $('.thumbs .flexslider', venue);
				thumbs.flexslider({
					animation: "slide",
					slideshow: false,
					controlNav: false,
					smoothHeight:false,
					asNavFor:'#venue-gallery',
					keyboard:false,
					itemWidth:81,
					itemMargin:0
				});
				gallery.flexslider({
					animation: "fade",
					slideshow: false,
					controlNav: false,
					smoothHeight:false,
					sync:'#venue-thumbnails',
					prevText: "Prev",
					nextText: "Next"
				});
			});

			$('#vendor-tabs-information').easytabs({
				animationSpeed:'fast'
			});


			var reviews = $('.reviews', venue);
			var respond = $('.respond', reviews);
			$('#venue-leave-a-review').click(function(e){
				e.preventDefault();

				reviews.find(respond).slideToggle(function(){
					if (reviews.is(':visible')) {
						reviews.scrollTo();
					}
				});
			});



			var side_info = $('#venue-side-info');
			var venue_sidebar = $('#venue-mobile-sidebar');
			_window.bind('enterBreakpoint990',function() {
				sidebar.prepend(side_info);
			});
			_window.bind('enterBreakpoint768',function() {
				venue_sidebar.append(side_info);
			});
			_window.bind('enterBreakpoint320',function() {
				venue_sidebar.append(side_info);
			});

		});
	};
	$('#venue').init_venue();


	$.fn.init_region = function() {
		$(this).each(function(){
			var region = $(this);

			var gmap = $('#region-geomap');

			var image = gmap.data('marker-image');
			var shadow = gmap.data('marker-shadow');


			gmap.gmap({
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				backgroundColor: '#EAEAEA',
				mapTypeControl: false,
				zoom: 10,
				callback: function() {
					$.getJSON(flo.ajax_load_url, {
						'action': 'flo_local_geoprofiles',
						'region_id': gmap.data('region-id'),
						'nonce' : gmap.data('nonce')
					}, function(data) {
						if (data.markers.length > 0) {
							$.each( data.markers, function(i, m) {
								gmap.gmap('addMarker', {
									'position': new google.maps.LatLng(m.lat, m.lng),
									'icon':image,
									'shadow':shadow
								}).click(function() {
									gmap.gmap('openInfoWindow', {'content': m.html}, this);
								});
							});
						}

						gmap.gmap('search', {'address': region.data('place') }, function(results) {
							gmap.gmap('option', 'center', results[0].geometry.location);
						});
					});
				}
			});


			_init_preview_event($('.events', region));

			function _init_preview_event(box) {
				var posts = box.find('li');
				posts.hover(function(){
					_cat_hover($(this), box);
				});
				_cat_hover(posts.filter(':first'), box);
			}
			function _cat_hover(li, box) {
				li.addClass('selected').siblings().removeClass('selected');
				$('.image', box).css('background-image', 'url("' + li.data('image') + '")');
			}
		});
	};
	$('#region').init_region();


	$.fn.init_venues_map = function() {
		$(this).each(function(){
			var gmap = $(this);
			var list = $('#vendors-list li');

			var addresses = [];

			function load_addresses() {
				var item;
				$.each(list, function(){
					item = $(this);
					if (item.data('geolat')) {
						addresses.push({
							'position':item.data('geolat') + ',' + item.data('geolng'),
							'html':get_marker_html(item)
						});
					}
				});
			}

			function get_marker_html(item) {
				var html = '';
				var a = item.find('.detail h2 a');
				html += '<h3><a href="' + a.prop('href') + '">' + a.text()  + '</a></h3>';
				html += '<p>' + item.find('.detail .descr').text() + '</p>';
				return html;
			}

			function initialize_map() {
				var image = gmap.data('marker-image');
				var shadow = gmap.data('marker-shadow');
				load_addresses();
				gmap.gmap({
					backgroundColor: '#EAEAEA',
					mapTypeControl: false,
					zoom: 10,
					center: 'undefined' == typeof(addresses[0]) ? '' : addresses[0].position,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}).bind('init', function() {
					$.each(addresses, function(k, v){
						gmap.gmap('addMarker', {
							'position': v.position,
							'icon':image,
							'shadow':shadow
						}).click(function() {
							gmap.gmap('openInfoWindow', {'content': v.html}, this);
						});
					});
				});
			}
			initialize_map();
		});
	};
	$('#venues-geomap').init_venues_map();

	$.fn.init_venues_list = function() {
		$(this).each(function(){
			var list = $(this);
			var searchbox = $('.searchbox', list);

			$('.refine a', list).click(function(e){
				e.preventDefault();
				searchbox.slideToggle('fast');
				if ($(this).parent().parent().get(0).tagName == 'FOOTER') {
					searchbox.scrollTo();
				}
			});
		});
	};
	$('#content-main .vendors-list').init_venues_list();

	$.fn.init_area_map = function() {
		$(this).each(function(){
			var area_map = $(this);
			var map = $('.map', area_map);

		});
	};
	$('#in-your-area-map').init_area_map();
	

	$.fn.init_advertisers = function() {
		$(this).each(function(){
			var advertisers = $(this);
			var bprofile = $('.b-profile', advertisers);
			var bevents = $('.b-events', advertisers);
			var bevent = $('.b-event', advertisers);

			function init_bprofile() {

				bprofile.easytabs({
					animationSpeed:'fast'
				});

				$('div.video', bprofile).fitVids();
				
				var uploader_gallery = $('#profile-gallery .uploader', bprofile);
				var uploader_files = $('#profile-files .uploader', bprofile);
				var gallery = $('.gallery ul', bprofile);

				var uploader_settings_gallery = {
					runtimes : 'html5,flash,gears,silverlight,browserplus',
					buttons: { browse: true, start: false, stop: false },
					multipart: false,
					url : flo.template_dir + '/flotheme/upload/destination.php',
					headers : {
					//     'hash' : FEU_VARS.hash,
					//     'feu' : FEU_VARS.uploadflag
					},
					max_file_size :'4mb',
					chunk_size : '1mb',
					unique_names : false,
					filters : [
						{title : "Image files", extensions : "jpg,jpeg,gif,png"}
					],
					flash_swf_url : flo.template_dir + '/js/libs/plupload/js/plupload.flash.swf',
					silverlight_xap_url : flo.template_dir + '/js/libs/plupload/js/plupload.silverlight.xap',
					// Post init events, bound after the internal events
					init : {
						FileUploaded: function(up, file, info) {
							// Called when a file has finished uploading
							// console.log('FileUploaded');
							// console.log(arguments);

							var data = $.parseJSON(info.response);
							var html = '<li><img src="' + data.preview + '" alt="" /><a href="#" class="delete" data-id="' + data.id + '">delete</a><a href="#" class="set-main" data-id="' + data.id + '">set main image</a></li>';
							gallery.append(html);

						},
						QueueChanged: function(up) {},
						Error:function() {}
					}
				};

				var uploader_settings_files = {
					runtimes : 'html5,flash,gears,silverlight,browserplus',
					buttons: { browse: true, start: false, stop: false },
					multipart: false,
					url : flo.template_dir + '/flotheme/upload/destination.php',
					headers : {
					//     'hash' : FEU_VARS.hash,
					//     'feu' : FEU_VARS.uploadflag
					},
					max_file_size :'4mb',
					chunk_size : '1mb',
					unique_names : false,
					filters : [
						{title : "Image files", extensions : "pdf,rtf,txt,doc,xml"}
					],
					flash_swf_url : flo.template_dir + '/js/libs/plupload/js/plupload.flash.swf',
					silverlight_xap_url : flo.template_dir + '/js/libs/plupload/js/plupload.silverlight.xap',
					// Post init events, bound after the internal events
					init : {
						FileUploaded: function(up, file, info) {
							// Called when a file has finished uploading

							var data = $.parseJSON(info.response);
							var html = '<li><img src="' + data.preview + '" alt="" /><a href="#" class="delete" data-id="' + data.id + '">delete</a></li>';
							gallery.append(html);

						},
						QueueChanged: function(up) {},
						Error:function() {}
					}
				};

				uploader_gallery.pluploadQueue(uploader_settings_gallery);
				uploader_files.pluploadQueue(uploader_settings_files);

				gallery.find('a.delete').live('click', function(e){
					e.preventDefault();
					var link = $(this);

					if (!confirm('Are you sure you want to delete this image?')) {
						return;
					}
					$.get(flo.ajax_load_url, {
						'action':'flo_adv_delete_image',
						'id':link.data('id')
					}, function(data){
						if (data.error) {
							alert(data.msg);
							return;
						}
						link.parent().fadeOut('fast', function(){
							$(this).remove();
						});
					}, 'json');
				});

				gallery.find('a.set-main').live('click', function(e){
					e.preventDefault();
					var link = $(this);
					var li = link.parent();

					if (li.hasClass('main')) {
						return;
					}
					$.get(flo.ajax_load_url, {
						'action':'flo_adv_set_main_image',
						'id':link.data('id')
					}, function(data){
						if (data.error) {
							alert(data.msg);
							return;
						}
						link.parent().addClass('main').siblings('.main').removeClass('main');
					}, 'json');
				});
			}
			if (bprofile.length) {
				init_bprofile();
			}

			function init_bevents() {

			}
			if (bevents.length) {
				init_bevents();
			}

			function init_bevent() {
				
			}
			if (bevent.length) {
				init_bevents();
			}
		});
	};
	$('#advertisers').init_advertisers();

	$.fn.init_subscribe = function() {
		$(this).each(function(){
			var subscribe = $(this);
			var annual = {
				ga:$('.annual .ga', subscribe),
				flo:$('.annual .flo', subscribe)
			};
			$('select', subscribe).dxSelect({
				clicked:function() {
					var b = this.title;

					$.each(annual, function(){
						$(this).hide();
					});
					annual[b].show();
				}
			});
		});
	};
	$('#subscribe').init_subscribe();


	$.fn.init_featured_placement = function() {
		$(this).each(function(){
			var placement = $(this);

			var local_select = $('select.gfield_select:contains("--")', placement);

			local_select.change(_filter_local_select).trigger('change');

			function _filter_local_select() {
				var s = $(this);
				var selected = s.find('option:selected');
				if (!s.find('option:selected').text().match(/\-\-/)) {
					selected.next().attr('selected', 'selected');
				}
			}
		});
	};
	$('#buy-featured-placement').init_featured_placement();

	$.fn.init_expo = function() {
		$(this).each(function(){
			var expo = $(this);

			$('p', expo).fitVids();

		});
	};
	$('#expo').init_expo();

});
