
// HTML5 Fallbacks for older browsers
jQuery(function($) {
	// check placeholder browser support
	if (!Modernizr.input.placeholder) {
		// set placeholder values
		$(this).find('[placeholder]').each(function() {
			$(this).val( $(this).attr('placeholder') );
		});
 
		// focus and blur of placeholders
		$('[placeholder]').focus(function() {
			if ($(this).val() == $(this).attr('placeholder')) {
				$(this).val('');
				$(this).removeClass('placeholder');
			}
		}).blur(function() {
			if ($(this).val() == '' || $(this).val() == $(this).attr('placeholder')) {
				$(this).val($(this).attr('placeholder'));
				$(this).addClass('placeholder');
			}
		});
 
		// remove placeholders on submit
		$('[placeholder]').closest('form').submit(function() {
			$(this).find('[placeholder]').each(function() {
				if ($(this).val() == $(this).attr('placeholder')) {
					$(this).val('');
				}
			});
		});
	}
});

Modernizr.addTest('ipad', function () {
  return !!navigator.userAgent.match(/iPad/i);
});

Modernizr.addTest('iphone', function () {
  return !!navigator.userAgent.match(/iPhone/i);
});

Modernizr.addTest('ipod', function () {
  return !!navigator.userAgent.match(/iPod/i);
});

Modernizr.addTest('appleios', function () {
  return (Modernizr.ipad || Modernizr.ipod || Modernizr.iphone);
});

Modernizr.addTest('positionfixed', function () {
	var test    = document.createElement('div'),
		control = test.cloneNode(false),
		fake = false,
		root = document.body || (function () {
			fake = true;
			return document.documentElement.appendChild(document.createElement('body'));
		}());

	var oldCssText = root.style.cssText;
	root.style.cssText = 'padding:0;margin:0';
	test.style.cssText = 'position:fixed;top:42px';
	root.appendChild(test);
	root.appendChild(control);
	
	var ret = test.offsetTop !== control.offsetTop;

	root.removeChild(test);
	root.removeChild(control);
	root.style.cssText = oldCssText;
	
	if (fake) {
		document.documentElement.removeChild(root);
	}
	
	/* Uh-oh. iOS would return a false positive here.
	 * If it's about to return true, we'll explicitly test for known iOS User Agent strings.
	 * "UA Sniffing is bad practice" you say. Agreeable, but sadly this feature has made it to
	 * Modernizr's list of undectables, so we're reduced to having to use this. */
	return ret && !Modernizr.appleios;
});



jQuery(function($){

	$.fn.eqHeights = function() {
		var el = $(this);
		if (el.length > 0 && !el.data('eqHeights')) {
			$(window).bind('resize.eqHeights', function() {
				el.eqHeights();
			});
			el.data('eqHeights', true);
		}
		return el.each(function() {
			var curHighest = 0;
			$(this).children().each(function() {
				var el = $(this),
				elHeight = el.height('auto').outerHeight();
				if (elHeight > curHighest) {
					curHighest = elHeight;
				}
			}).height(curHighest);
		});
	};

	$.fn.featuredEqHeights = function() {
		var el = $(this);
		if (el.length > 0 && !el.data('eqHeights')) {
			$(window).bind('resize.eqHeights', function() {
				el.eqHeights();
			});
			el.data('eqHeights', true);
		}
		return el.each(function() {
			var curHighest = 0;
			$(this).children().each(function() {
				var el = $(this),
				elHeight = el.height('auto').outerHeight();
				if (elHeight > curHighest) {
					curHighest = elHeight;
				}
			}).height(curHighest).find('a').height(curHighest).find('.empty').height(curHighest);
		});
	};



	$.fn.dxSelect = function(_options){
		
		var options = $.extend({
			'clicked':function(){},
			'hide_first':false
		}, _options);
		
		return this.each(function(){
				var hideOnClick;
				var fn = $(this);
				fn.hide();
				
				var name = fn.attr('name');

				var wrapper = $('<div></div>');
					wrapper.addClass('select-wrapper-' + name).addClass('select-wrapper');

				var div = $('<span></span>');
						div.addClass('select-' + name).addClass('select');
				var ul = $('<ul></ul>');
						ul.addClass('select-options-' + name).addClass('select-options');

				fn.children().each(function(k){
					var opt = $(this);

					if (!(options.hide_first && k === 0)) {
						ul.append('<li title="' + opt.val() + '" class="' + (opt.attr('selected') ? 'selected' : '') + '">' + opt.text() +  '</li>');
					}
					if (opt.attr('selected')) {
						div.html('<span>' + opt.text() + '</span>');
					}
				});

				ul.find('li').bind('clicked', options.clicked).click(function(){
					var li = $(this);
					fn.val(li.attr('title'));
					fn.trigger('change');
					$('span', div).text(li.text());
					li.addClass('selected').siblings('.selected').removeClass('selected');
					li.trigger('clicked');
				}).filter('.selected').trigger('clicked');

				wrapper.append(div).append(ul);
				wrapper.click(function(){
					if (ul.is(':visible')) {
						ul.hide();
					} else {
						ul.slideDown('fast');
					}
				}).hover(function(){
					hideOnClick = false;
				}, function(){
					hideOnClick = true;
				});

				fn.after(wrapper);
				$(document).click(function(e){
					if (hideOnClick) {
							ul.hide();
					}
				});
		});
	};
});





/*
 * jQuery EasyTabs plugin 3.1.1
 *
 * Copyright (c) 2010-2011 Steve Schwartz (JangoSteve)
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Date: Tue Jan 26 16:30:00 2012 -0500
 */
( function($) {

  $.easytabs = function(container, options) {

		// Attach to plugin anything that should be available via
		// the $container.data('easytabs') object
	var plugin = this,
		$container = $(container),

		defaults = {
		  animate: true,
		  panelActiveClass: "active",
		  tabActiveClass: "active",
		  defaultTab: "li:first-child",
		  animationSpeed: "normal",
		  tabs: "> ul > li",
		  updateHash: true,
		  cycle: false,
		  collapsible: false,
		  collapsedClass: "collapsed",
		  collapsedByDefault: true,
		  uiTabs: false,
		  transitionIn: 'fadeIn',
		  transitionOut: 'fadeOut',
		  transitionInEasing: 'swing',
		  transitionOutEasing: 'swing',
		  transitionCollapse: 'slideUp',
		  transitionUncollapse: 'slideDown',
		  transitionCollapseEasing: 'swing',
		  transitionUncollapseEasing: 'swing',
		  containerClass: "",
		  tabsClass: "",
		  tabClass: "",
		  panelClass: "",
		  cache: true,
		  panelContext: $container
		},

		// Internal instance variables
		// (not available via easytabs object)
		$defaultTab,
		$defaultTabLink,
		transitions,
		lastHash,
		skipUpdateToHash,
		animationSpeeds = {
		  fast: 200,
		  normal: 400,
		  slow: 600
		},

		// Shorthand variable so that we don't need to call
		// plugin.settings throughout the plugin code
		settings;

	// =============================================================
	// Functions available via easytabs object
	// =============================================================

	plugin.init = function() {

	  plugin.settings = settings = $.extend({}, defaults, options);

	  // Add jQuery UI's crazy class names to markup,
	  // so that markup will match theme CSS
	  if ( settings.uiTabs ) {
		settings.tabActiveClass = 'ui-tabs-selected';
		settings.containerClass = 'ui-tabs ui-widget ui-widget-content ui-corner-all';
		settings.tabsClass = 'ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all';
		settings.tabClass = 'ui-state-default ui-corner-top';
		settings.panelClass = 'ui-tabs-panel ui-widget-content ui-corner-bottom';
	  }

	  // If collapsible is true and defaultTab specified, assume user wants defaultTab showing (not collapsed)
	  if ( settings.collapsible && options.defaultTab !== undefined && options.collpasedByDefault === undefined ) {
		settings.collapsedByDefault = false;
	  }

	  // Convert 'normal', 'fast', and 'slow' animation speed settings to their respective speed in milliseconds
	  if ( typeof(settings.animationSpeed) === 'string' ) {
		settings.animationSpeed = animationSpeeds[settings.animationSpeed];
	  }

	  $('a.anchor').remove().prependTo('body');

	  // Store easytabs object on container so we can easily set
	  // properties throughout
	  $container.data('easytabs', {});

	  plugin.setTransitions();

	  plugin.getTabs();

	  addClasses();

	  setDefaultTab();

	  bindToTabClicks();

	  initHashChange();

	  initCycle();

	  // Append data-easytabs HTML attribute to make easy to query for
	  // easytabs instances via CSS pseudo-selector
	  $container.attr('data-easytabs', true);
	};

	// Set transitions for switching between tabs based on options.
	// Could be used to update transitions if settings are changes.
	plugin.setTransitions = function() {
	  transitions = ( settings.animate ) ? {
		  show: settings.transitionIn,
		  hide: settings.transitionOut,
		  speed: settings.animationSpeed,
		  collapse: settings.transitionCollapse,
		  uncollapse: settings.transitionUncollapse,
		  halfSpeed: settings.animationSpeed / 2
		} :
		{
		  show: "show",
		  hide: "hide",
		  speed: 0,
		  collapse: "hide",
		  uncollapse: "show",
		  halfSpeed: 0
		};
	};

	// Find and instantiate tabs and panels.
	// Could be used to reset tab and panel collection if markup is
	// modified.
	plugin.getTabs = function() {
	  var $matchingPanel;

	  // Find the initial set of elements matching the setting.tabs
	  // CSS selector within the container
	  plugin.tabs = $container.find(settings.tabs),

	  // Instantiate panels as empty jquery object
	  plugin.panels = $(),

	  plugin.tabs.each(function(){
		var $tab = $(this),
			$a = $tab.children('a'),

			// targetId is the ID of the panel, which is either the
			// `href` attribute for non-ajax tabs, or in the
			// `data-target` attribute for ajax tabs since the `href` is
			// the ajax URL
			targetId = $tab.children('a').data('target');

		$tab.data('easytabs', {});

		// If the tab has a `data-target` attribute, and is thus an ajax tab
		if ( targetId !== undefined && targetId !== null ) {
		  $tab.data('easytabs').ajax = $a.attr('href');
		} else {
		  targetId = $a.attr('href');
		}
		targetId = targetId.match(/#([^\?]+)/)[0].substr(1);

		$matchingPanel = settings.panelContext.find("#" + targetId);

		// If tab has a matching panel, add it to panels
		if ( $matchingPanel.length ) {

		  // Store panel height before hiding
		  $matchingPanel.data('easytabs', {
			position: $matchingPanel.css('position'),
			visibility: $matchingPanel.css('visibility')
		  });

		  // Don't hide panel if it's active (allows `getTabs` to be called manually to re-instantiate tab collection)
		  $matchingPanel.not(settings.panelActiveClass).hide();

		  plugin.panels = plugin.panels.add($matchingPanel);

		  $tab.data('easytabs').panel = $matchingPanel;

		// Otherwise, remove tab from tabs collection
		} else {
		  plugin.tabs = plugin.tabs.not($tab);
		}
	  });
	};

	// Select tab and fire callback
	plugin.selectTab = function($clicked, callback) {
	  var url = window.location,
		  hash = url.hash.match(/^[^\?]*/)[0],
		  $targetPanel = $clicked.parent().data('easytabs').panel,
		  ajaxUrl = $clicked.parent().data('easytabs').ajax;

	  // Tab is collapsible and active => toggle collapsed state
	  if( settings.collapsible && ! skipUpdateToHash && ($clicked.hasClass(settings.tabActiveClass) || $clicked.hasClass(settings.collapsedClass)) ) {
		plugin.toggleTabCollapse($clicked, $targetPanel, ajaxUrl, callback);

	  // Tab is not active and panel is not active => select tab
	  } else if( ! $clicked.hasClass(settings.tabActiveClass) || ! $targetPanel.hasClass(settings.panelActiveClass) ){
		activateTab($clicked, $targetPanel, ajaxUrl, callback);

	  // Cache is disabled => reload (e.g reload an ajax tab).
	  } else if ( ! settings.cache ){
		activateTab($clicked, $targetPanel, ajaxUrl, callback);
	  }

	};

	// Toggle tab collapsed state and fire callback
	plugin.toggleTabCollapse = function($clicked, $targetPanel, ajaxUrl, callback) {
	  plugin.panels.stop(true,true);

	  if( fire($container,"easytabs:before", [$clicked, $targetPanel, settings]) ){
		plugin.tabs.filter("." + settings.tabActiveClass).removeClass(settings.tabActiveClass).children().removeClass(settings.tabActiveClass);

		// If panel is collapsed, uncollapse it
		if( $clicked.hasClass(settings.collapsedClass) ){

		  // If ajax panel and not already cached
		  if( ajaxUrl && (!settings.cache || !$clicked.parent().data('easytabs').cached) ) {
			$container.trigger('easytabs:ajax:beforeSend', [$clicked, $targetPanel]);

			$targetPanel.load(ajaxUrl, function(response, status, xhr){
			  $clicked.parent().data('easytabs').cached = true;
			  $container.trigger('easytabs:ajax:complete', [$clicked, $targetPanel, response, status, xhr]);
			});
		  }

		  // Update CSS classes of tab and panel
		  $clicked.parent()
			.removeClass(settings.collapsedClass)
			.addClass(settings.tabActiveClass)
			.children()
			  .removeClass(settings.collapsedClass)
			  .addClass(settings.tabActiveClass);

		  $targetPanel
			.addClass(settings.panelActiveClass)
			[transitions.uncollapse](transitions.speed, settings.transitionUncollapseEasing, function(){
			  $container.trigger('easytabs:midTransition', [$clicked, $targetPanel, settings]);
			  if(typeof callback == 'function') callback();
			});

		// Otherwise, collapse it
		} else {

		  // Update CSS classes of tab and panel
		  $clicked.addClass(settings.collapsedClass)
			.parent()
			  .addClass(settings.collapsedClass);

		  $targetPanel
			.removeClass(settings.panelActiveClass)
			[transitions.collapse](transitions.speed, settings.transitionCollapseEasing, function(){
			  $container.trigger("easytabs:midTransition", [$clicked, $targetPanel, settings]);
			  if(typeof callback == 'function') callback();
			});
		}
	  }
	};


	// Find tab with target panel matching value
	plugin.matchTab = function(hash) {
	  return plugin.tabs.find("[href='" + hash + "'],[data-target='" + hash + "']").first();
	};

	// Find panel with `id` matching value
	plugin.matchInPanel = function(hash) {
	  return ( hash ? plugin.panels.filter(':has(' + hash + ')').first() : [] );
	};

	// Select matching tab when URL hash changes
	plugin.selectTabFromHashChange = function() {
	  var hash = window.location.hash.match(/^[^\?]*/)[0],
		  $tab = plugin.matchTab(hash),
		  $panel;

	  if ( settings.updateHash ) {

		// If hash directly matches tab
		if( $tab.length ){
		  skipUpdateToHash = true;
		  plugin.selectTab( $tab );

		} else {
		  $panel = plugin.matchInPanel(hash);

		  // If panel contains element matching hash
		  if ( $panel.length ) {
			hash = '#' + $panel.attr('id');
			$tab = plugin.matchTab(hash);
			skipUpdateToHash = true;
			plugin.selectTab( $tab );

		  // If default tab is not active...
		  } else if ( ! $defaultTab.hasClass(settings.tabActiveClass) && ! settings.cycle ) {

			// ...and hash is blank or matches a parent of the tab container or
			// if the last tab (before the hash updated) was one of the other tabs in this container.
			if ( hash === '' || plugin.matchTab(lastHash).length || $container.closest(hash).length ) {
			  skipUpdateToHash = true;
			  plugin.selectTab( $defaultTabLink );
			}
		  }
		}
	  }
	};

	// Cycle through tabs
	plugin.cycleTabs = function(tabNumber){
	  if(settings.cycle){
		tabNumber = tabNumber % plugin.tabs.length;
		$tab = $( plugin.tabs[tabNumber] ).children("a").first();
		skipUpdateToHash = true;
		plugin.selectTab( $tab, function() {
		  setTimeout(function(){ plugin.cycleTabs(tabNumber + 1); }, settings.cycle);
		});
	  }
	};

	// Convenient public methods
	plugin.publicMethods = {
	  select: function(tabSelector){
		var $tab;

		// Find tab container that matches selector (like 'li#tab-one' which contains tab link)
		if ( ($tab = plugin.tabs.filter(tabSelector)).length === 0 ) {

		  // Find direct tab link that matches href (like 'a[href="#panel-1"]')
		  if ( ($tab = plugin.tabs.find("a[href='" + tabSelector + "']")).length === 0 ) {

			// Find direct tab link that matches selector (like 'a#tab-1')
			if ( ($tab = plugin.tabs.find("a" + tabSelector)).length === 0 ) {

			  // Find direct tab link that matches data-target (lik 'a[data-target="#panel-1"]')
			  if ( ($tab = plugin.tabs.find("[data-target='" + tabSelector + "']")).length === 0 ) {

				// Find direct tab link that ends in the matching href (like 'a[href$="#panel-1"]', which would also match http://example.com/currentpage/#panel-1)
				if ( ($tab = plugin.tabs.find("a[href$='" + tabSelector + "']")).length === 0 ) {

				  $.error('Tab \'' + tabSelector + '\' does not exist in tab set');
				}
			  }
			}
		  }
		} else {
		  // Select the child tab link, since the first option finds the tab container (like <li>)
		  $tab = $tab.children("a").first();
		}
		plugin.selectTab($tab);
	  }
	};

	// =============================================================
	// Private functions
	// =============================================================

	// Triggers an event on an element and returns the event result
	var fire = function(obj, name, data) {
	  var event = $.Event(name);
	  obj.trigger(event, data);
	  return event.result !== false;
	}

	// Add CSS classes to markup (if specified), called by init
	var addClasses = function() {
	  $container.addClass(settings.containerClass);
	  plugin.tabs.parent().addClass(settings.tabsClass);
	  plugin.tabs.addClass(settings.tabClass);
	  plugin.panels.addClass(settings.panelClass);
	};

	// Set the default tab, whether from hash (bookmarked) or option,
	// called by init
	var setDefaultTab = function(){
	  var hash = window.location.hash.match(/^[^\?]*/)[0],
		  $selectedTab = plugin.matchTab(hash).parent(),
		  $panel;

	  // If hash directly matches one of the tabs, active on page-load
	  if( $selectedTab.length === 1 ){
		$defaultTab = $selectedTab;
		settings.cycle = false;

	  } else {
		$panel = plugin.matchInPanel(hash);

		// If one of the panels contains the element matching the hash,
		// make it active on page-load
		if ( $panel.length ) {
		  hash = '#' + $panel.attr('id');
		  $defaultTab = plugin.matchTab(hash).parent();

		// Otherwise, make the default tab the one that's active on page-load
		} else {
		  $defaultTab = plugin.tabs.parent().find(settings.defaultTab);
		  if ( $defaultTab.length === 0 ) {
			$.error("The specified default tab ('" + settings.defaultTab + "') could not be found in the tab set.");
		  }
		}
	  }

	  $defaultTabLink = $defaultTab.children("a").first();

	  activateDefaultTab($selectedTab);
	};

	// Activate defaultTab (or collapse by default), called by setDefaultTab
	var activateDefaultTab = function($selectedTab) {
	  var defaultPanel,
		  defaultAjaxUrl;

	  if ( settings.collapsible && $selectedTab.length === 0 && settings.collapsedByDefault ) {
		$defaultTab
		  .addClass(settings.collapsedClass)
		  .children()
			.addClass(settings.collapsedClass);

	  } else {

		defaultPanel = $( $defaultTab.data('easytabs').panel );
		defaultAjaxUrl = $defaultTab.data('easytabs').ajax;

		if ( defaultAjaxUrl && (!settings.cache || !$defaultTab.data('easytabs').cached) ) {
		  $container.trigger('easytabs:ajax:beforeSend', [$defaultTabLink, defaultPanel]);
		  defaultPanel.load(defaultAjaxUrl, function(response, status, xhr){
			$defaultTab.data('easytabs').cached = true;
			$container.trigger('easytabs:ajax:complete', [$defaultTabLink, defaultPanel, response, status, xhr]);
		  });
		}

		$defaultTab.data('easytabs').panel
		  .show()
		  .addClass(settings.panelActiveClass);

		$defaultTab
		  .addClass(settings.tabActiveClass)
		  .children()
			.addClass(settings.tabActiveClass);
	  }
	};

	// Bind tab-select funtionality to namespaced click event, called by
	// init
	var bindToTabClicks = function() {
	  plugin.tabs.children("a").bind("click.easytabs", function(e) {

		// Stop cycling when a tab is clicked
		settings.cycle = false;

		// Hash will be updated when tab is clicked,
		// don't cause tab to re-select when hash-change event is fired
		skipUpdateToHash = false;

		// Select the panel for the clicked tab
		plugin.selectTab( $(this) );

		// Don't follow the link to the anchor
		e.preventDefault();
	  });
	};

	// Activate a given tab/panel, called from plugin.selectTab:
	//
	//   * fire `easytabs:before` hook
	//   * get ajax if new tab is an uncached ajax tab
	//   * animate out previously-active panel
	//   * fire `easytabs:midTransition` hook
	//   * update URL hash
	//   * animate in newly-active panel
	//   * update CSS classes for inactive and active tabs/panels
	//
	// TODO: This could probably be broken out into many more modular
	// functions
	var activateTab = function($clicked, $targetPanel, ajaxUrl, callback) {
	  plugin.panels.stop(true,true);

	  if( fire($container,"easytabs:before", [$clicked, $targetPanel, settings]) ){
		var $visiblePanel = plugin.panels.filter(":visible"),
			$panelContainer = $targetPanel.parent(),
			targetHeight,
			visibleHeight,
			heightDifference,
			showPanel,
			hash = window.location.hash.match(/^[^\?]*/)[0];

		if (settings.animate) {
		  targetHeight = getHeightForHidden($targetPanel);
		  visibleHeight = $visiblePanel.length ? setAndReturnHeight($visiblePanel) : 0;
		  heightDifference = targetHeight - visibleHeight;
		}

		// Set lastHash to help indicate if defaultTab should be
		// activated across multiple tab instances.
		lastHash = hash;

		// TODO: Move this function elsewhere
		showPanel = function() {
		  // At this point, the previous panel is hidden, and the new one will be selected
		  $container.trigger("easytabs:midTransition", [$clicked, $targetPanel, settings]);

		  // Gracefully animate between panels of differing heights, start height change animation *after* panel change if panel needs to contract,
		  // so that there is no chance of making the visible panel overflowing the height of the target panel
		  if (settings.animate && settings.transitionIn == 'fadeIn') {
			if (heightDifference < 0)
			  $panelContainer.animate({
				height: $panelContainer.height() + heightDifference
			  }, transitions.halfSpeed ).css({ 'min-height': '' });
		  }

		  if ( settings.updateHash && ! skipUpdateToHash ) {
			//window.location = url.toString().replace((url.pathname + hash), (url.pathname + $clicked.attr("href")));
			// Not sure why this behaves so differently, but it's more straight forward and seems to have less side-effects
			window.location.hash = '#' + $targetPanel.attr('id');
		  } else {
			skipUpdateToHash = false;
		  }

		  $targetPanel
			[transitions.show](transitions.speed, settings.transitionInEasing, function(){
			  $panelContainer.css({height: '', 'min-height': ''}); // After the transition, unset the height
			  $container.trigger("easytabs:after", [$clicked, $targetPanel, settings]);
			  // callback only gets called if selectTab actually does something, since it's inside the if block
			  if(typeof callback == 'function'){
				callback();
			  }
		  });
		};

		if ( ajaxUrl && (!settings.cache || !$clicked.parent().data('easytabs').cached) ) {
		  $container.trigger('easytabs:ajax:beforeSend', [$clicked, $targetPanel]);
		  $targetPanel.load(ajaxUrl, function(response, status, xhr){
			$clicked.parent().data('easytabs').cached = true;
			$container.trigger('easytabs:ajax:complete', [$clicked, $targetPanel, response, status, xhr]);
		  });
		}

		// Gracefully animate between panels of differing heights, start height change animation *before* panel change if panel needs to expand,
		// so that there is no chance of making the target panel overflowing the height of the visible panel
		if( settings.animate && settings.transitionOut == 'fadeOut' ) {
		  if( heightDifference > 0 ) {
			$panelContainer.animate({
			  height: ( $panelContainer.height() + heightDifference )
			}, transitions.halfSpeed );
		  } else {
			// Prevent height jumping before height transition is triggered at midTransition
			$panelContainer.css({ 'min-height': $panelContainer.height() });
		  }
		}

		// Change the active tab *first* to provide immediate feedback when the user clicks
		plugin.tabs.filter("." + settings.tabActiveClass).removeClass(settings.tabActiveClass).children().removeClass(settings.tabActiveClass);
		plugin.tabs.filter("." + settings.collapsedClass).removeClass(settings.collapsedClass).children().removeClass(settings.collapsedClass);
		$clicked.parent().addClass(settings.tabActiveClass).children().addClass(settings.tabActiveClass);

		plugin.panels.filter("." + settings.panelActiveClass).removeClass(settings.panelActiveClass);
		$targetPanel.addClass(settings.panelActiveClass);

		if( $visiblePanel.length ) {
		  $visiblePanel
			[transitions.hide](transitions.speed, settings.transitionOutEasing, showPanel);
		} else {
		  $targetPanel
			[transitions.uncollapse](transitions.speed, settings.transitionUncollapseEasing, showPanel);
		}
	  }
	};

	// Get heights of panels to enable animation between panels of
	// differing heights, called by activateTab
	var getHeightForHidden = function($targetPanel){

	  if ( $targetPanel.data('easytabs') && $targetPanel.data('easytabs').lastHeight ) {
		return $targetPanel.data('easytabs').lastHeight;
	  }

	  // this is the only property easytabs changes, so we need to grab its value on each tab change
	  var display = $targetPanel.css('display'),

		  // Workaround, because firefox returns wrong height if element itself has absolute positioning
		  height = $targetPanel
			.wrap($('<div>', {position: 'absolute', 'visibility': 'hidden', 'overflow': 'hidden'}))
			.css({'position':'relative','visibility':'hidden','display':'block'})
			.outerHeight();

	  $targetPanel.unwrap();

	  // Return element to previous state
	  $targetPanel.css({
		position: $targetPanel.data('easytabs').position,
		visibility: $targetPanel.data('easytabs').visibility,
		display: display
	  });

	  // Cache height
	  $targetPanel.data('easytabs').lastHeight = height;

	  return height;
	};

	// Since the height of the visible panel may have been manipulated due to interaction,
	// we want to re-cache the visible height on each tab change, called
	// by activateTab
	var setAndReturnHeight = function($visiblePanel) {
	  var height = $visiblePanel.outerHeight();

	  if( $visiblePanel.data('easytabs') ) {
		$visiblePanel.data('easytabs').lastHeight = height;
	  } else {
		$visiblePanel.data('easytabs', {lastHeight: height});
	  }
	  return height;
	};

	// Setup hash-change callback for forward- and back-button
	// functionality, called by init
	var initHashChange = function(){

	  // enabling back-button with jquery.hashchange plugin
	  // http://benalman.com/projects/jquery-hashchange-plugin/
	  if(typeof $(window).hashchange === 'function'){
		$(window).hashchange( function(){
		  plugin.selectTabFromHashChange();
		});
	  } else if ($.address && typeof $.address.change === 'function') { // back-button with jquery.address plugin http://www.asual.com/jquery/address/docs/
		$.address.change( function(){
		  plugin.selectTabFromHashChange();
		});
	  }
	};

	// Begin cycling if set in options, called by init
	var initCycle = function(){
	  var tabNumber;
	  if (settings.cycle) {
		tabNumber = plugin.tabs.index($defaultTab);
		setTimeout( function(){ plugin.cycleTabs(tabNumber + 1); }, settings.cycle);
	  }
	};


	plugin.init();

  };

  $.fn.easytabs = function(options) {
	var args = arguments;

	return this.each(function() {
	  var $this = $(this),
		  plugin = $this.data('easytabs');

	  // Initialization was called with $(el).easytabs( { options } );
	  if (undefined === plugin) {
		plugin = new $.easytabs(this, options);
		$this.data('easytabs', plugin);
	  }

	  // User called public method
	  if ( plugin.publicMethods[options] ){
		return plugin.publicMethods[options](Array.prototype.slice.call( args, 1 ));
	  }
	});
  };

})(jQuery);


/*
 * jQuery FlexSlider v2.1
 * http://www.woothemes.com/flexslider/
 *
 * Copyright 2012 WooThemes
 * Free to use under the GPLv2 license.
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Contributing author: Tyler Smith (@mbmufffin)
 */

;(function ($) {

  //FlexSlider: Object Instance
  $.flexslider = function(el, options) {
	var slider = $(el),
		vars = $.extend({}, $.flexslider.defaults, options),
		namespace = vars.namespace,
		touch = ("ontouchstart" in window) || window.DocumentTouch && document instanceof DocumentTouch,
		eventType = (touch) ? "touchend" : "click",
		vertical = vars.direction === "vertical",
		reverse = vars.reverse,
		carousel = (vars.itemWidth > 0),
		fade = vars.animation === "fade",
		asNav = vars.asNavFor !== "",
		methods = {};
	
	// Store a reference to the slider object
	$.data(el, "flexslider", slider);
	
	// Privat slider methods
	methods = {
	  init: function() {
		slider.animating = false;
		slider.currentSlide = vars.startAt;
		slider.animatingTo = slider.currentSlide;
		slider.atEnd = (slider.currentSlide === 0 || slider.currentSlide === slider.last);
		slider.containerSelector = vars.selector.substr(0,vars.selector.search(' '));
		slider.slides = $(vars.selector, slider);
		slider.container = $(slider.containerSelector, slider);
		slider.count = slider.slides.length;
		// SYNC:
		slider.syncExists = $(vars.sync).length > 0;
		// SLIDE:
		if (vars.animation === "slide") vars.animation = "swing";
		slider.prop = (vertical) ? "top" : "marginLeft";
		slider.args = {};
		// SLIDESHOW:
		slider.manualPause = false;
		// TOUCH/USECSS:
		slider.transitions = !vars.video && !fade && vars.useCSS && (function() {
		  var obj = document.createElement('div'),
			  props = ['perspectiveProperty', 'WebkitPerspective', 'MozPerspective', 'OPerspective', 'msPerspective'];
		  for (var i in props) {
			if ( obj.style[ props[i] ] !== undefined ) {
			  slider.pfx = props[i].replace('Perspective','').toLowerCase();
			  slider.prop = "-" + slider.pfx + "-transform";
			  return true;
			}
		  }
		  return false;
		}());
		// CONTROLSCONTAINER:
		if (vars.controlsContainer !== "") slider.controlsContainer = $(vars.controlsContainer).length > 0 && $(vars.controlsContainer);
		// MANUAL:
		if (vars.manualControls !== "") slider.manualControls = $(vars.manualControls).length > 0 && $(vars.manualControls);
		
		// RANDOMIZE:
		if (vars.randomize) {
		  slider.slides.sort(function() { return (Math.round(Math.random())-0.5); });
		  slider.container.empty().append(slider.slides);
		}
		
		slider.doMath();
		
		// ASNAV:
		if (asNav) methods.asNav.setup();
		
		// INIT
		slider.setup("init");
		
		// CONTROLNAV:
		if (vars.controlNav) methods.controlNav.setup();
		
		// DIRECTIONNAV:
		if (vars.directionNav) methods.directionNav.setup();
		
		// KEYBOARD:
		if (vars.keyboard && ($(slider.containerSelector).length === 1 || vars.multipleKeyboard)) {
		  $(document).bind('keyup', function(event) {
			var keycode = event.keyCode;
			if (!slider.animating && (keycode === 39 || keycode === 37)) {
			  var target = (keycode === 39) ? slider.getTarget('next') :
						   (keycode === 37) ? slider.getTarget('prev') : false;
			  slider.flexAnimate(target, vars.pauseOnAction);
			}
		  });
		}
		// MOUSEWHEEL:
		if (vars.mousewheel) {
		  slider.bind('mousewheel', function(event, delta, deltaX, deltaY) {
			event.preventDefault();
			var target = (delta < 0) ? slider.getTarget('next') : slider.getTarget('prev');
			slider.flexAnimate(target, vars.pauseOnAction);
		  });
		}
		
		// PAUSEPLAY
		if (vars.pausePlay) methods.pausePlay.setup();
		
		// SLIDSESHOW
		if (vars.slideshow) {
		  if (vars.pauseOnHover) {
			slider.hover(function() {
			  if (!slider.manualPlay && !slider.manualPause) slider.pause();
			}, function() {
			  if (!slider.manualPause && !slider.manualPlay) slider.play();
			});
		  }
		  // initialize animation
		  (vars.initDelay > 0) ? setTimeout(slider.play, vars.initDelay) : slider.play();
		}
		
		// TOUCH
		if (touch && vars.touch) methods.touch();
		
		// FADE&&SMOOTHHEIGHT || SLIDE:
		if (!fade || (fade && vars.smoothHeight)) $(window).bind("resize focus", methods.resize);
		
		
		// API: start() Callback
		setTimeout(function(){
		  vars.start(slider);
		}, 200);
	  },
	  asNav: {
		setup: function() {
		  slider.asNav = true;
		  slider.animatingTo = Math.floor(slider.currentSlide/slider.move);
		  slider.currentItem = slider.currentSlide;
		  slider.slides.removeClass(namespace + "active-slide").eq(slider.currentItem).addClass(namespace + "active-slide");
		  slider.slides.click(function(e){
			e.preventDefault();
			var $slide = $(this),
				target = $slide.index();
			if (!$(vars.asNavFor).data('flexslider').animating && !$slide.hasClass('active')) {
			  slider.direction = (slider.currentItem < target) ? "next" : "prev";
			  slider.flexAnimate(target, vars.pauseOnAction, false, true, true);
			}
		  });
		}
	  },
	  controlNav: {
		setup: function() {
		  if (!slider.manualControls) {
			methods.controlNav.setupPaging();
		  } else { // MANUALCONTROLS:
			methods.controlNav.setupManual();
		  }
		},
		setupPaging: function() {
		  var type = (vars.controlNav === "thumbnails") ? 'control-thumbs' : 'control-paging',
			  j = 1,
			  item;
		  
		  slider.controlNavScaffold = $('<ol class="'+ namespace + 'control-nav ' + namespace + type + '"></ol>');
		  
		  if (slider.pagingCount > 1) {
			for (var i = 0; i < slider.pagingCount; i++) {
			  item = (vars.controlNav === "thumbnails") ? '<img src="' + slider.slides.eq(i).attr("data-thumb") + '"/>' : '<a>' + j + '</a>';
			  slider.controlNavScaffold.append('<li>' + item + '</li>');
			  j++;
			}
		  }
		  
		  // CONTROLSCONTAINER:
		  (slider.controlsContainer) ? $(slider.controlsContainer).append(slider.controlNavScaffold) : slider.append(slider.controlNavScaffold);
		  methods.controlNav.set();
		  
		  methods.controlNav.active();
		
		  slider.controlNavScaffold.delegate('a, img', eventType, function(event) {
			event.preventDefault();
			var $this = $(this),
				target = slider.controlNav.index($this);

			if (!$this.hasClass(namespace + 'active')) {
			  slider.direction = (target > slider.currentSlide) ? "next" : "prev";
			  slider.flexAnimate(target, vars.pauseOnAction);
			}
		  });
		  // Prevent iOS click event bug
		  if (touch) {
			slider.controlNavScaffold.delegate('a', "click touchstart", function(event) {
			  event.preventDefault();
			});
		  }
		},
		setupManual: function() {
		  slider.controlNav = slider.manualControls;
		  methods.controlNav.active();
		  
		  slider.controlNav.live(eventType, function(event) {
			event.preventDefault();
			var $this = $(this),
				target = slider.controlNav.index($this);
				
			if (!$this.hasClass(namespace + 'active')) {
			  (target > slider.currentSlide) ? slider.direction = "next" : slider.direction = "prev";
			  slider.flexAnimate(target, vars.pauseOnAction);
			}
		  });
		  // Prevent iOS click event bug
		  if (touch) {
			slider.controlNav.live("click touchstart", function(event) {
			  event.preventDefault();
			});
		  }
		},
		set: function() {
		  var selector = (vars.controlNav === "thumbnails") ? 'img' : 'a';
		  slider.controlNav = $('.' + namespace + 'control-nav li ' + selector, (slider.controlsContainer) ? slider.controlsContainer : slider);
		},
		active: function() {
		  slider.controlNav.removeClass(namespace + "active").eq(slider.animatingTo).addClass(namespace + "active");
		},
		update: function(action, pos) {
		  if (slider.pagingCount > 1 && action === "add") {
			slider.controlNavScaffold.append($('<li><a>' + slider.count + '</a></li>'));
		  } else if (slider.pagingCount === 1) {
			slider.controlNavScaffold.find('li').remove();
		  } else {
			slider.controlNav.eq(pos).closest('li').remove();
		  }
		  methods.controlNav.set();
		  (slider.pagingCount > 1 && slider.pagingCount !== slider.controlNav.length) ? slider.update(pos, action) : methods.controlNav.active();
		}
	  },
	  directionNav: {
		setup: function() {
		  var directionNavScaffold = $('<ul class="' + namespace + 'direction-nav"><li><a class="' + namespace + 'prev" href="#">' + vars.prevText + '</a></li><li><a class="' + namespace + 'next" href="#">' + vars.nextText + '</a></li></ul>');
		
		  // CONTROLSCONTAINER:
		  if (slider.controlsContainer) {
			$(slider.controlsContainer).append(directionNavScaffold);
			slider.directionNav = $('.' + namespace + 'direction-nav li a', slider.controlsContainer);
		  } else {
			slider.append(directionNavScaffold);
			slider.directionNav = $('.' + namespace + 'direction-nav li a', slider);
		  }
		
		  methods.directionNav.update();
		
		  slider.directionNav.bind(eventType, function(event) {
			event.preventDefault();
			var target = ($(this).hasClass(namespace + 'next')) ? slider.getTarget('next') : slider.getTarget('prev');
			slider.flexAnimate(target, vars.pauseOnAction);
		  });
		  // Prevent iOS click event bug
		  if (touch) {
			slider.directionNav.bind("click touchstart", function(event) {
			  event.preventDefault();
			});
		  }
		},
		update: function() {
		  var disabledClass = namespace + 'disabled';
		  if (slider.pagingCount === 1) {
			slider.directionNav.addClass(disabledClass);
		  } else if (!vars.animationLoop) {
			if (slider.animatingTo === 0) {
			  slider.directionNav.removeClass(disabledClass).filter('.' + namespace + "prev").addClass(disabledClass);
			} else if (slider.animatingTo === slider.last) {
			  slider.directionNav.removeClass(disabledClass).filter('.' + namespace + "next").addClass(disabledClass);
			} else {
			  slider.directionNav.removeClass(disabledClass);
			}
		  } else {
			slider.directionNav.removeClass(disabledClass);
		  }
		}
	  },
	  pausePlay: {
		setup: function() {
		  var pausePlayScaffold = $('<div class="' + namespace + 'pauseplay"><a></a></div>');
		
		  // CONTROLSCONTAINER:
		  if (slider.controlsContainer) {
			slider.controlsContainer.append(pausePlayScaffold);
			slider.pausePlay = $('.' + namespace + 'pauseplay a', slider.controlsContainer);
		  } else {
			slider.append(pausePlayScaffold);
			slider.pausePlay = $('.' + namespace + 'pauseplay a', slider);
		  }

		  methods.pausePlay.update((vars.slideshow) ? namespace + 'pause' : namespace + 'play');

		  slider.pausePlay.bind(eventType, function(event) {
			event.preventDefault();
			if ($(this).hasClass(namespace + 'pause')) {
			  slider.manualPause = true;
			  slider.manualPlay = false;
			  slider.pause();
			} else {
			  slider.manualPause = false;
			  slider.manualPlay = true;
			  slider.play();
			}
		  });
		  // Prevent iOS click event bug
		  if (touch) {
			slider.pausePlay.bind("click touchstart", function(event) {
			  event.preventDefault();
			});
		  }
		},
		update: function(state) {
		  (state === "play") ? slider.pausePlay.removeClass(namespace + 'pause').addClass(namespace + 'play').text(vars.playText) : slider.pausePlay.removeClass(namespace + 'play').addClass(namespace + 'pause').text(vars.pauseText);
		}
	  },
	  touch: function() {
		var startX,
		  startY,
		  offset,
		  cwidth,
		  dx,
		  startT,
		  scrolling = false;
			  
		el.addEventListener('touchstart', onTouchStart, false);
		function onTouchStart(e) {
		  if (slider.animating) {
			e.preventDefault();
		  } else if (e.touches.length === 1) {
			slider.pause();
			// CAROUSEL: 
			cwidth = (vertical) ? slider.h : slider. w;
			startT = Number(new Date());
			// CAROUSEL:
			offset = (carousel && reverse && slider.animatingTo === slider.last) ? 0 :
					 (carousel && reverse) ? slider.limit - (((slider.itemW + vars.itemMargin) * slider.move) * slider.animatingTo) :
					 (carousel && slider.currentSlide === slider.last) ? slider.limit :
					 (carousel) ? ((slider.itemW + vars.itemMargin) * slider.move) * slider.currentSlide : 
					 (reverse) ? (slider.last - slider.currentSlide + slider.cloneOffset) * cwidth : (slider.currentSlide + slider.cloneOffset) * cwidth;
			startX = (vertical) ? e.touches[0].pageY : e.touches[0].pageX;
			startY = (vertical) ? e.touches[0].pageX : e.touches[0].pageY;

			el.addEventListener('touchmove', onTouchMove, false);
			el.addEventListener('touchend', onTouchEnd, false);
		  }
		}

		function onTouchMove(e) {
		  dx = (vertical) ? startX - e.touches[0].pageY : startX - e.touches[0].pageX;
		  scrolling = (vertical) ? (Math.abs(dx) < Math.abs(e.touches[0].pageX - startY)) : (Math.abs(dx) < Math.abs(e.touches[0].pageY - startY));
		  
		  if (!scrolling || Number(new Date()) - startT > 500) {
			e.preventDefault();
			if (!fade && slider.transitions) {
			  if (!vars.animationLoop) {
				dx = dx/((slider.currentSlide === 0 && dx < 0 || slider.currentSlide === slider.last && dx > 0) ? (Math.abs(dx)/cwidth+2) : 1);
			  }
			  slider.setProps(offset + dx, "setTouch");
			}
		  }
		}
		
		function onTouchEnd(e) {
		  if (slider.animatingTo === slider.currentSlide && !scrolling && !(dx === null)) {
			var updateDx = (reverse) ? -dx : dx,
				target = (updateDx > 0) ? slider.getTarget('next') : slider.getTarget('prev');
			
			if (slider.canAdvance(target) && (Number(new Date()) - startT < 550 && Math.abs(updateDx) > 50 || Math.abs(updateDx) > cwidth/2)) {
			  slider.flexAnimate(target, vars.pauseOnAction);
			} else {
			  slider.flexAnimate(slider.currentSlide, vars.pauseOnAction, true);
			}
		  }
		  // finish the touch by undoing the touch session
		  el.removeEventListener('touchmove', onTouchMove, false);
		  el.removeEventListener('touchend', onTouchEnd, false);
		  startX = null;
		  startY = null;
		  dx = null;
		  offset = null;
		}
	  },
	  resize: function() {
		if (!slider.animating && slider.is(':visible')) {
		  if (!carousel) slider.doMath();
		  
		  if (fade) {
			// SMOOTH HEIGHT:
			methods.smoothHeight();
		  } else if (carousel) { //CAROUSEL:
			slider.slides.width(slider.computedW);
			slider.update(slider.pagingCount);
			slider.setProps();
		  }
		  else if (vertical) { //VERTICAL:
			slider.viewport.height(slider.h);
			slider.setProps(slider.h, "setTotal");
		  } else {
			// SMOOTH HEIGHT:
			if (vars.smoothHeight) methods.smoothHeight();
			slider.newSlides.width(slider.computedW);
			slider.setProps(slider.computedW, "setTotal");
		  }
		}
	  },
	  smoothHeight: function(dur) {
		if (!vertical || fade) {
		  var $obj = (fade) ? slider : slider.viewport;
		  (dur) ? $obj.animate({"height": slider.slides.eq(slider.animatingTo).height()}, dur) : $obj.height(slider.slides.eq(slider.animatingTo).height());
		}
	  },
	  sync: function(action) {
		var $obj = $(vars.sync).data("flexslider"),
			target = slider.animatingTo;
		
		switch (action) {
		  case "animate": $obj.flexAnimate(target, vars.pauseOnAction, false, true); break;
		  case "play": if (!$obj.playing && !$obj.asNav) { $obj.play(); } break;
		  case "pause": $obj.pause(); break;
		}
	  }
	}
	
	// public methods
	slider.flexAnimate = function(target, pause, override, withSync, fromNav) {
	  if (asNav && slider.pagingCount === 1) slider.direction = (slider.currentItem < target) ? "next" : "prev";

	  if (!slider.animating && (slider.canAdvance(target, fromNav) || override) && slider.is(":visible")) {
		if (asNav && withSync) {
		  var master = $(vars.asNavFor).data('flexslider');
		  slider.atEnd = target === 0 || target === slider.count - 1;
		  master.flexAnimate(target, true, false, true, fromNav);
		  slider.direction = (slider.currentItem < target) ? "next" : "prev";
		  master.direction = slider.direction;
		  
		  if (Math.ceil((target + 1)/slider.visible) - 1 !== slider.currentSlide && target !== 0) {
			slider.currentItem = target;
			slider.slides.removeClass(namespace + "active-slide").eq(target).addClass(namespace + "active-slide");
			target = Math.floor(target/slider.visible);
		  } else {
			slider.currentItem = target;
			slider.slides.removeClass(namespace + "active-slide").eq(target).addClass(namespace + "active-slide");
			return false;
		  }
		}
		
		slider.animating = true;
		slider.animatingTo = target;
		// API: before() animation Callback
		vars.before(slider);
		
		// SLIDESHOW:
		if (pause) slider.pause();
		
		// SYNC:
		if (slider.syncExists && !fromNav) methods.sync("animate");
		
		// CONTROLNAV
		if (vars.controlNav) methods.controlNav.active();
		
		// !CAROUSEL:
		// CANDIDATE: slide active class (for add/remove slide)
		if (!carousel) slider.slides.removeClass(namespace + 'active-slide').eq(target).addClass(namespace + 'active-slide');
		
		// INFINITE LOOP:
		// CANDIDATE: atEnd
		slider.atEnd = target === 0 || target === slider.last;
		
		// DIRECTIONNAV:
		if (vars.directionNav) methods.directionNav.update();
		
		if (target === slider.last) {
		  // API: end() of cycle Callback
		  vars.end(slider);
		  // SLIDESHOW && !INFINITE LOOP:
		  if (!vars.animationLoop) slider.pause();
		}
		
		// SLIDE:
		if (!fade) {
		  var dimension = (vertical) ? slider.slides.filter(':first').height() : slider.computedW,
			  margin, slideString, calcNext;
		  
		  // INFINITE LOOP / REVERSE:
		  if (carousel) {
			margin = (vars.itemWidth > slider.w) ? vars.itemMargin * 2 : vars.itemMargin;
			calcNext = ((slider.itemW + margin) * slider.move) * slider.animatingTo;
			slideString = (calcNext > slider.limit && slider.visible !== 1) ? slider.limit : calcNext;
		  } else if (slider.currentSlide === 0 && target === slider.count - 1 && vars.animationLoop && slider.direction !== "next") {
			slideString = (reverse) ? (slider.count + slider.cloneOffset) * dimension : 0;
		  } else if (slider.currentSlide === slider.last && target === 0 && vars.animationLoop && slider.direction !== "prev") {
			slideString = (reverse) ? 0 : (slider.count + 1) * dimension;
		  } else {
			slideString = (reverse) ? ((slider.count - 1) - target + slider.cloneOffset) * dimension : (target + slider.cloneOffset) * dimension;
		  }
		  slider.setProps(slideString, "", vars.animationSpeed);
		  if (slider.transitions) {
			if (!vars.animationLoop || !slider.atEnd) {
			  slider.animating = false;
			  slider.currentSlide = slider.animatingTo;
			}
			slider.container.unbind("webkitTransitionEnd transitionend");
			slider.container.bind("webkitTransitionEnd transitionend", function() {
			  slider.wrapup(dimension);
			});
		  } else {
			slider.container.animate(slider.args, vars.animationSpeed, vars.easing, function(){
			  slider.wrapup(dimension);
			});
		  }
		} else { // FADE:
		  slider.slides.eq(slider.currentSlide).fadeOut(vars.animationSpeed, vars.easing);
		  slider.slides.eq(target).fadeIn(vars.animationSpeed, vars.easing, slider.wrapup);
		}
		// SMOOTH HEIGHT:
		if (vars.smoothHeight) methods.smoothHeight(vars.animationSpeed);
	  }
	} 
	slider.wrapup = function(dimension) {
	  // SLIDE:
	  if (!fade && !carousel) {
		if (slider.currentSlide === 0 && slider.animatingTo === slider.last && vars.animationLoop) {
		  slider.setProps(dimension, "jumpEnd");
		} else if (slider.currentSlide === slider.last && slider.animatingTo === 0 && vars.animationLoop) {
		  slider.setProps(dimension, "jumpStart");
		}
	  }
	  slider.animating = false;
	  slider.currentSlide = slider.animatingTo;
	  // API: after() animation Callback
	  vars.after(slider);
	}
	
	// SLIDESHOW:
	slider.animateSlides = function() {
	  if (!slider.animating) slider.flexAnimate(slider.getTarget("next"));
	}
	// SLIDESHOW:
	slider.pause = function() {
	  clearInterval(slider.animatedSlides);
	  slider.playing = false;
	  // PAUSEPLAY:
	  if (vars.pausePlay) methods.pausePlay.update("play");
	  // SYNC:
	  if (slider.syncExists) methods.sync("pause");
	}
	// SLIDESHOW:
	slider.play = function() {
	  slider.animatedSlides = setInterval(slider.animateSlides, vars.slideshowSpeed);
	  slider.playing = true;
	  // PAUSEPLAY:
	  if (vars.pausePlay) methods.pausePlay.update("pause");
	  // SYNC:
	  if (slider.syncExists) methods.sync("play");
	}
	slider.canAdvance = function(target, fromNav) {
	  // ASNAV:
	  var last = (asNav) ? slider.pagingCount - 1 : slider.last;
	  return (fromNav) ? true :
			 (asNav && slider.currentItem === slider.count - 1 && target === 0 && slider.direction === "prev") ? true :
			 (asNav && slider.currentItem === 0 && target === slider.pagingCount - 1 && slider.direction !== "next") ? false :
			 (target === slider.currentSlide && !asNav) ? false :
			 (vars.animationLoop) ? true :
			 (slider.atEnd && slider.currentSlide === 0 && target === last && slider.direction !== "next") ? false :
			 (slider.atEnd && slider.currentSlide === last && target === 0 && slider.direction === "next") ? false :
			 true;
	}
	slider.getTarget = function(dir) {
	  slider.direction = dir; 
	  if (dir === "next") {
		return (slider.currentSlide === slider.last) ? 0 : slider.currentSlide + 1;
	  } else {
		return (slider.currentSlide === 0) ? slider.last : slider.currentSlide - 1;
	  }
	}
	
	// SLIDE:
	slider.setProps = function(pos, special, dur) {
	  var target = (function() {
		var posCheck = (pos) ? pos : ((slider.itemW + vars.itemMargin) * slider.move) * slider.animatingTo,
			posCalc = (function() {
			  if (carousel) {
				return (special === "setTouch") ? pos :
					   (reverse && slider.animatingTo === slider.last) ? 0 :
					   (reverse) ? slider.limit - (((slider.itemW + vars.itemMargin) * slider.move) * slider.animatingTo) :
					   (slider.animatingTo === slider.last) ? slider.limit : posCheck;
			  } else {
				switch (special) {
				  case "setTotal": return (reverse) ? ((slider.count - 1) - slider.currentSlide + slider.cloneOffset) * pos : (slider.currentSlide + slider.cloneOffset) * pos;
				  case "setTouch": return (reverse) ? pos : pos;
				  case "jumpEnd": return (reverse) ? pos : slider.count * pos;
				  case "jumpStart": return (reverse) ? slider.count * pos : pos;
				  default: return pos;
				}
			  }
			}());
			return (posCalc * -1) + "px";
		  }());

	  if (slider.transitions) {
		target = (vertical) ? "translate3d(0," + target + ",0)" : "translate3d(" + target + ",0,0)";
		dur = (dur !== undefined) ? (dur/1000) + "s" : "0s";
		slider.container.css("-" + slider.pfx + "-transition-duration", dur);
	  }
	  
	  slider.args[slider.prop] = target;
	  if (slider.transitions || dur === undefined) slider.container.css(slider.args);
	}
	
	slider.setup = function(type) {
	  // SLIDE:
	  if (!fade) {
		var sliderOffset, arr;
			
		if (type === "init") {
		  slider.viewport = $('<div class="' + namespace + 'viewport"></div>').css({"overflow": "hidden", "position": "relative"}).appendTo(slider).append(slider.container);
		  // INFINITE LOOP:
		  slider.cloneCount = 0;
		  slider.cloneOffset = 0;
		  // REVERSE:
		  if (reverse) {
			arr = $.makeArray(slider.slides).reverse();
			slider.slides = $(arr);
			slider.container.empty().append(slider.slides);
		  }
		}
		// INFINITE LOOP && !CAROUSEL:
		if (vars.animationLoop && !carousel) {
		  slider.cloneCount = 2;
		  slider.cloneOffset = 1;
		  // clear out old clones
		  if (type !== "init") slider.container.find('.clone').remove();
		  slider.container.append(slider.slides.first().clone().addClass('clone')).prepend(slider.slides.last().clone().addClass('clone'));
		}
		slider.newSlides = $(vars.selector, slider);
		
		sliderOffset = (reverse) ? slider.count - 1 - slider.currentSlide + slider.cloneOffset : slider.currentSlide + slider.cloneOffset;
		// VERTICAL:
		if (vertical && !carousel) {
		  slider.container.height((slider.count + slider.cloneCount) * 200 + "%").css("position", "absolute").width("100%");
		  setTimeout(function(){
			slider.newSlides.css({"display": "block"});
			slider.doMath();
			slider.viewport.height(slider.h);
			slider.setProps(sliderOffset * slider.h, "init");
		  }, (type === "init") ? 100 : 0);
		} else {
		  slider.container.width((slider.count + slider.cloneCount) * 200 + "%");
		  slider.setProps(sliderOffset * slider.computedW, "init");
		  setTimeout(function(){
			slider.doMath();
			slider.newSlides.css({"width": slider.computedW, "float": "left", "display": "block"});
			// SMOOTH HEIGHT:
			if (vars.smoothHeight) methods.smoothHeight();
		  }, (type === "init") ? 100 : 0);
		}
	  } else { // FADE: 
		slider.slides.css({"width": "100%", "float": "left", "marginRight": "-100%", "position": "relative"});
		if (type === "init") slider.slides.eq(slider.currentSlide).fadeIn(vars.animationSpeed, vars.easing);
		// SMOOTH HEIGHT:
		if (vars.smoothHeight) methods.smoothHeight();
	  }
	  // !CAROUSEL:
	  // CANDIDATE: active slide
	  if (!carousel) slider.slides.removeClass(namespace + "active-slide").eq(slider.currentSlide).addClass(namespace + "active-slide");
	}
	
	slider.doMath = function() {
	  var slide = slider.slides.first(),
		  slideMargin = vars.itemMargin,
		  minItems = vars.minItems,
		  maxItems = vars.maxItems;
	  
	  slider.w = slider.width();
	  slider.h = slide.height();
	  slider.boxPadding = slide.outerWidth() - slide.width();

	  // CAROUSEL:
	  if (carousel) {
		slider.itemT = vars.itemWidth + slideMargin;
		slider.minW = (minItems) ? minItems * slider.itemT : slider.w;
		slider.maxW = (maxItems) ? maxItems * slider.itemT : slider.w;
		slider.itemW = (slider.minW > slider.w) ? (slider.w - (slideMargin * minItems))/minItems :
					   (slider.maxW < slider.w) ? (slider.w - (slideMargin * maxItems))/maxItems :
					   (vars.itemWidth > slider.w) ? slider.w : vars.itemWidth;
		slider.visible = Math.floor(slider.w/(slider.itemW + slideMargin));
		slider.move = (vars.move > 0 && vars.move < slider.visible ) ? vars.move : slider.visible;
		slider.pagingCount = Math.ceil(((slider.count - slider.visible)/slider.move) + 1);
		slider.last =  slider.pagingCount - 1;
		slider.limit = (slider.pagingCount === 1) ? 0 :
					   (vars.itemWidth > slider.w) ? ((slider.itemW + (slideMargin * 2)) * slider.count) - slider.w - slideMargin : ((slider.itemW + slideMargin) * slider.count) - slider.w - slideMargin;
	  } else {
		slider.itemW = slider.w;
		slider.pagingCount = slider.count;
		slider.last = slider.count - 1;
	  }
	  slider.computedW = slider.itemW - slider.boxPadding;
	}
	
	slider.update = function(pos, action) {
	  slider.doMath();
	  
	  // update currentSlide and slider.animatingTo if necessary
	  if (!carousel) {
		if (pos < slider.currentSlide) {
		  slider.currentSlide += 1;
		} else if (pos <= slider.currentSlide && pos !== 0) {
		  slider.currentSlide -= 1;
		}
		slider.animatingTo = slider.currentSlide;
	  }
	  
	  // update controlNav
	  if (vars.controlNav && !slider.manualControls) {
		if ((action === "add" && !carousel) || slider.pagingCount > slider.controlNav.length) {
		  methods.controlNav.update("add");
		} else if ((action === "remove" && !carousel) || slider.pagingCount < slider.controlNav.length) {
		  if (carousel && slider.currentSlide > slider.last) {
			slider.currentSlide -= 1;
			slider.animatingTo -= 1;
		  }
		  methods.controlNav.update("remove", slider.last);
		}
	  }
	  // update directionNav
	  if (vars.directionNav) methods.directionNav.update();
	  
	}
	
	slider.addSlide = function(obj, pos) {
	  var $obj = $(obj);
	  
	  slider.count += 1;
	  slider.last = slider.count - 1;
	  
	  // append new slide
	  if (vertical && reverse) {
		(pos !== undefined) ? slider.slides.eq(slider.count - pos).after($obj) : slider.container.prepend($obj);
	  } else {
		(pos !== undefined) ? slider.slides.eq(pos).before($obj) : slider.container.append($obj);
	  }
	  
	  // update currentSlide, animatingTo, controlNav, and directionNav
	  slider.update(pos, "add");
	  
	  // update slider.slides
	  slider.slides = $(vars.selector + ':not(.clone)', slider);
	  // re-setup the slider to accomdate new slide
	  slider.setup();
	  
	  //FlexSlider: added() Callback
	  vars.added(slider);
	}
	slider.removeSlide = function(obj) {
	  var pos = (isNaN(obj)) ? slider.slides.index($(obj)) : obj;
	  
	  // update count
	  slider.count -= 1;
	  slider.last = slider.count - 1;
	  
	  // remove slide
	  if (isNaN(obj)) {
		$(obj, slider.slides).remove();
	  } else {
		(vertical && reverse) ? slider.slides.eq(slider.last).remove() : slider.slides.eq(obj).remove();
	  }
	  
	  // update currentSlide, animatingTo, controlNav, and directionNav
	  slider.doMath();
	  slider.update(pos, "remove");
	  
	  // update slider.slides
	  slider.slides = $(vars.selector + ':not(.clone)', slider);
	  // re-setup the slider to accomdate new slide
	  slider.setup();
	  
	  // FlexSlider: removed() Callback
	  vars.removed(slider);
	}
	
	//FlexSlider: Initialize
	methods.init();
  }
  
  //FlexSlider: Default Settings
  $.flexslider.defaults = {
	namespace: "flex-",             //{NEW} String: Prefix string attached to the class of every element generated by the plugin
	selector: ".slides > li",       //{NEW} Selector: Must match a simple pattern. '{container} > {slide}' -- Ignore pattern at your own peril
	animation: "fade",              //String: Select your animation type, "fade" or "slide"
	easing: "swing",               //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
	direction: "horizontal",        //String: Select the sliding direction, "horizontal" or "vertical"
	reverse: false,                 //{NEW} Boolean: Reverse the animation direction
	animationLoop: true,             //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
	smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode  
	startAt: 0,                     //Integer: The slide that the slider should start on. Array notation (0 = first slide)
	slideshow: true,                //Boolean: Animate slider automatically
	slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
	animationSpeed: 600,            //Integer: Set the speed of animations, in milliseconds
	initDelay: 0,                   //{NEW} Integer: Set an initialization delay, in milliseconds
	randomize: false,               //Boolean: Randomize slide order
	
	// Usability features
	pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
	pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
	useCSS: true,                   //{NEW} Boolean: Slider will use CSS3 transitions if available
	touch: true,                    //{NEW} Boolean: Allow touch swipe navigation of the slider on touch-enabled devices
	video: false,                   //{NEW} Boolean: If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches
	
	// Primary Controls
	controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
	directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
	prevText: "Previous",           //String: Set the text for the "previous" directionNav item
	nextText: "Next",               //String: Set the text for the "next" directionNav item
	
	// Secondary Navigation
	keyboard: true,                 //Boolean: Allow slider navigating via keyboard left/right keys
	multipleKeyboard: false,        //{NEW} Boolean: Allow keyboard navigation to affect multiple sliders. Default behavior cuts out keyboard navigation with more than one slider present.
	mousewheel: false,              //{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
	pausePlay: false,               //Boolean: Create pause/play dynamic element
	pauseText: "Pause",             //String: Set the text for the "pause" pausePlay item
	playText: "Play",               //String: Set the text for the "play" pausePlay item
	
	// Special properties
	controlsContainer: "",          //{UPDATED} jQuery Object/Selector: Declare which container the navigation elements should be appended too. Default container is the FlexSlider element. Example use would be $(".flexslider-container"). Property is ignored if given element is not found.
	manualControls: "",             //{UPDATED} jQuery Object/Selector: Declare custom control navigation. Examples would be $(".flex-control-nav li") or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
	sync: "",                       //{NEW} Selector: Mirror the actions performed on this slider with another slider. Use with care.
	asNavFor: "",                   //{NEW} Selector: Internal property exposed for turning the slider into a thumbnail navigation for another slider
	
	// Carousel Options
	itemWidth: 0,                   //{NEW} Integer: Box-model width of individual carousel items, including horizontal borders and padding.
	itemMargin: 0,                  //{NEW} Integer: Margin between carousel items.
	minItems: 0,                    //{NEW} Integer: Minimum number of carousel items that should be visible. Items will resize fluidly when below this.
	maxItems: 0,                    //{NEW} Integer: Maxmimum number of carousel items that should be visible. Items will resize fluidly when above this limit.
	move: 0,                        //{NEW} Integer: Number of carousel items that should move on animation. If 0, slider will move all visible items.
									
	// Callback API
	start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
	before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
	after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
	end: function(){},              //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
	added: function(){},            //{NEW} Callback: function(slider) - Fires after a slide is added
	removed: function(){}           //{NEW} Callback: function(slider) - Fires after a slide is removed
  }


  //FlexSlider: Plugin Function
  $.fn.flexslider = function(options) {
	if (options === undefined) options = {};
	
	if (typeof options === "object") {
	  return this.each(function() {
		var $this = $(this),
			selector = (options.selector) ? options.selector : ".slides > li",
			$slides = $this.find(selector);

		if ($slides.length === 1) {
		  $slides.fadeIn(400);
		  if (options.start) options.start($this);
		} else if ($this.data('flexslider') === undefined) {
		  new $.flexslider(this, options);
		}
	  });
	} else {
	  // Helper strings to quickly perform functions on the slider
	  var $slider = $(this).data('flexslider');
	  switch (options) {
		case "play": $slider.play(); break;
		case "pause": $slider.pause(); break;
		case "next": $slider.flexAnimate($slider.getTarget("next"), true); break;
		case "prev":
		case "previous": $slider.flexAnimate($slider.getTarget("prev"), true); break;
		default: if (typeof options === "number") $slider.flexAnimate(options, true);
	  }
	}
  }  

})(jQuery);

/*global jQuery */
/*! 
* FitVids 1.0
*
* Copyright 2011, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
* Date: Thu Sept 01 18:00:00 2011 -0500
*/

(function( $ ){

  $.fn.fitVids = function( options ) {
	var settings = {
	  customSelector: null
	}
	
	var div = document.createElement('div'),
		ref = document.getElementsByTagName('base')[0] || document.getElementsByTagName('script')[0];
		
	div.className = 'fit-vids-style';
	div.innerHTML = '&shy;<style>         \
	  .fluid-width-video-wrapper {        \
		 width: 100%;                     \
		 position: relative;              \
		 padding: 0;                      \
	  }                                   \
										  \
	  .fluid-width-video-wrapper iframe,  \
	  .fluid-width-video-wrapper object,  \
	  .fluid-width-video-wrapper embed {  \
		 position: absolute;              \
		 top: 0;                          \
		 left: 0;                         \
		 width: 100%;                     \
		 height: 100%;                    \
	  }                                   \
	</style>';
					  
	ref.parentNode.insertBefore(div,ref);
	
	if ( options ) { 
	  $.extend( settings, options );
	}
	
	return this.each(function(){
	  var selectors = [
		"iframe[src^='http://player.vimeo.com']", 
		"iframe[src^='http://www.youtube.com']", 
		"iframe[src^='https://www.youtube.com']", 
		"iframe[src^='http://www.kickstarter.com']", 
		"object", 
		"embed"
	  ];
	  
	  if (settings.customSelector) {
		selectors.push(settings.customSelector);
	  }
	  
	  var $allVideos = $(this).find(selectors.join(','));

	  $allVideos.each(function(){
		var $this = $(this);
		if (this.tagName.toLowerCase() == 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; } 
		var height = this.tagName.toLowerCase() == 'object' ? $this.attr('height') : $this.height(),
			aspectRatio = height / $this.width();
		if(!$this.attr('id')){
			var videoID = 'fitvid' + Math.floor(Math.random()*999999);
			$this.attr('id', videoID);
		}
		$this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
		$this.removeAttr('height').removeAttr('width');
	  });
	});
  
  }
})( jQuery );

/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
*/
(function(w){
	
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ){
		return;
	}
	
	var doc = w.document;

	if( !doc.querySelector ){return;}

	var meta = doc.querySelector( "meta[name=viewport]" ),
		initialContent = meta && meta.getAttribute( "content" ),
		disabledZoom = initialContent + ",maximum-scale=1",
		enabledZoom = initialContent + ",maximum-scale=10",
		enabled = true,
		x, y, z, aig;

	if( !meta ){return;}

	function restoreZoom(){
		meta.setAttribute( "content", enabledZoom );
		enabled = true;
	}

	function disableZoom(){
		meta.setAttribute( "content", disabledZoom );
		enabled = false;
	}
	
	function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
				
		// If portrait orientation and in one of the danger zones
		if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){
				disableZoom();
			}        	
		}
		else if( !enabled ){
			restoreZoom();
		}
	}
	
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );

})(this);


// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());

(function($) {

	$.scrollToElement = function( $element, speed ) {

		speed = speed || 750;

		$("html, body").animate({
			scrollTop: $element.offset().top,
			scrollLeft: $element.offset().left
		}, speed);
		return $element;
	};

	$.fn.scrollTo = function( speed ) {
		speed = speed || "normal";
		return $.scrollToElement( this, speed );
	};
	
	jQuery.fn.labelify = function(settings) {
	  settings = jQuery.extend({
		text: "title",
		labelledClass: ""
	  }, settings);
	  var lookups = {
		title: function(input) {
		  return $(input).attr("title");
		},
		label: function(input) {
		  return $("label[for=" + input.id +"]").text();
		}
	  };
	  var lookup;
	  var jQuery_labellified_elements = $(this);
	  return $(this).each(function() {
		if (typeof settings.text === "string") {
		  lookup = lookups[settings.text]; // what if not there?
		} else {
		  lookup = settings.text; // what if not a fn?
		};
		// bail if lookup isn't a function or if it returns undefined
		if (typeof lookup !== "function") {return;}
		var lookupval = lookup(this);
		if (!lookupval) {return;}

		// need to strip newlines because the browser strips them
		// if you set textbox.value to a string containing them
		$(this).data("label",lookup(this).replace(/\n/g,''));
		$(this).focus(function() {
		  if (this.value === $(this).data("label")) {
			this.value = this.defaultValue;
			$(this).removeClass(settings.labelledClass);
		  }
		}).blur(function(){
		  if (this.value === this.defaultValue) {
			this.value = $(this).data("label");
			$(this).addClass(settings.labelledClass);
		  }
		});

		var removeValuesOnExit = function() {
		  jQuery_labellified_elements.each(function(){
			if (this.value === $(this).data("label")) {
			  this.value = this.defaultValue;
			  $(this).removeClass(settings.labelledClass);
			}
		  })
		};

		$(this).parents("form").submit(removeValuesOnExit);
		$(window).unload(removeValuesOnExit);

		if (this.value !== this.defaultValue) {
		  // user already started typing; don't overwrite their work!
		  return;
		}
		// actually set the value
		this.value = $(this).data("label");
		$(this).addClass(settings.labelledClass);

	  });
	};
})(jQuery);

function isIE() {
    return /msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent)
}
function isSafari() {
    return /Safari/.test(navigator.userAgent) && !/Chrome/.test(navigator.userAgent)
}
function isIOS() {
    return navigator.userAgent.match(/iPad/i) != null || navigator.userAgent.match(/iPhone/i) != null || navigator.userAgent.match(/iPod/i) != null || navigator.userAgent.match(/iPod/i) != null
}
var showPinterest = function (obj_id) {
    function s() {
        var a = window,
            b = document;
        return ("" + (a.getSelection ? a.getSelection() : b.getSelection ? b.getSelection() : b.selection.createRange().text)).replace(/(^\s+|\s+$)/g, "")
    }
    function v(a) {
        var b = a.src == location.href ? document.referrer || location.href : location.href;
        if (isSafari()) b = encodeURI(b);
        b = {
            media: a.src,
            url: b,
            alt: a.alt,
            title: document.title,
            is_video: a.type == "video"
        };
        if (q) b.description = q;
        a = [];
        a.push(w);
        a.push("?");
        for (var d in b) {
            a.push(encodeURIComponent(d));
            a.push("=");
            a.push(encodeURIComponent(b[d]));
            a.push("&")
        }
        var e = [];
        e.push(x);
        e.push("?");
        for (d in b) {
            e.push(encodeURIComponent(d));
            e.push("=");
            e.push(encodeURIComponent(b[d]));
            e.push("&")
        }
        d = e.join("");
        var c = a.join("");
        if (isIOS()) {
            setTimeout(function () {
                window.location = c
            }, 25);
            window.location = d
        } else window.open(c, "pin" + (new Date).getTime(), "status=no,resizable=no,scrollbars=yes,personalbar=no,directories=no,location=no,toolbar=no,menubar=no,width=632,height=270,left=0,top=0")
    }
    function y(a) {
        if (Math.max(a.h, a.w) > 199) {
            if (a.h < a.w) return "margin-top: " + parseInt(100 - 100 * (a.h / a.w)) + "px;";
            return ""
        } else return "margin-top: " + parseInt(100 - a.h / 2) + "px;"
    }
    var p = [];
    if (!document.tpmLjs) {
        document.tpmLjs = 1;
        var i = /^https?:\/\/.*?\.?facebook\.com\//,
            f = /^https?:\/\/.*?\.?google\.com\/reader\//;
        if (location.href.match(/^https?:\/\/.*?\.?pinterest\.com\//)) window.alert("The bookmarklet is installed! Now you can click your Pin It button to pin images as you browse sites around the web.");
        else if (location.href.match(i)) window.alert("The bookmarklet can't pin images directly from Facebook. Sorry about that.");
        else if (location.href.match(f)) window.alert("The bookmarklet can't pin images directly from Google Reader. Sorry about that.");
        else {
            var w = "http://pinterest.com/pin/create/bookmarklet/",
                x = "pinit12://pinterest.com/pin/create/bookmarklet/",
                q = null;
            if (s().length > 0) q = s();
            var m = function () {
                    function a(g) {
                        var j = new Image;
                        j.height = 360;
                        j.width = 480;
                        j.src = "http://img.youtube.com/vi/" + g + "/0.jpg";
                        return e(j, "video")
                    }
                    function b(g) {
                        if (g.src && g.src != "") {
                            var j = g.src.indexOf("?") > -1 ? "&" : "?";
                            g.src += j + "autoplay=0";
                            g.src += "&wmode=transparent"
                        }
                        g.setAttribute("wmode", "transparent");
                        j = g.parentNode;
                        var r = g.nextSibling;
                        j.removeChild(g);
                        j.insertBefore(g, r)
                    }
                    for (var d = [], e = function (g, j) {
                            j = j || "image";
                            var r = g.height,
                                z = g.width,
                                t = g.src,
                                u = new Image;
                            u.src = t;
                            return {
                                w: z,
                                h: r,
                                src: t,
                                img: g,
                                alt: "alt",
                                im2: u,
                                type: j
                            }
                        }, c = document.getElementsByTagName("iframe"), k = 0; k < c.length; k++) {
                        var l = /^http:\/\/www\.youtube\.com\/embed\/([a-zA-Z0-9\-_]+)/;
                        if (l = l.exec(c[k].src)) {
                            d.push(a(l[1]));
                            b(c[k])
                        }
                    }
                    c = document.getElementsByTagName("embed");
                    for (k = 0; k < c.length; k++) {
                        l = /^http:\/\/www\.youtube\.com\/v\/([a-zA-Z0-9\-_]+)/;
                        if (l = l.exec(c[k].src)) {
                            d.push(a(l[1]));
                            b(c[k])
                        }
                    }
                    l = /^http:\/\/www\.youtube\.com\/watch\?.*v=([a-zA-Z0-9\-_]+)/;
                    if (l = l.exec(window.location.href)) {
                        d.push(a(l[1]));
                        b(document.getElementById("movie_player"))
                    }
                    //console.log(document.getElementsByTagName('article')[0].getElementsByTagName("img"))
                    var images = document.getElementById(obj_id).getElementsByTagName("img");
                    for (k = 0; k < images.length; k++) {
                        c = images[k];
                        if (c.style.display != "none") {
                            c = e(c);
                            if (c.w > 80 && c.h > 80 && (c.h > 109 || c.w > 109)) d.push(c)
                        }
                    }
                    return d
                }();
            if (m.length == 0) {
                window.alert("Sorry, we can't see any big images or videos on this page.");
                document.tpmLjs = 0
            } else {
                i = function () {
                    o.parentNode.removeChild(o);
                    n.parentNode.removeChild(n);
                    document.tpmLjs = 0;
                    if (isIE()) for (var a = 0; a < p.length; a++) p[a].parent.insertBefore(p[a].player, p[a].sibling);
                    return false
                };
                html = "<style>\n#tpm_Container {font-family: 'helvetica neue', arial, sans-serif; position: absolute; padding-top: 37px; z-index: 100000002; top: 0; left: 0; background-color: transparent; opacity: 1;}\n#tpm_Overlay {position: fixed; z-index: 9999; top: 0; right: 0; bottom: 0; left: 0; background-color: #f2f2f2; opacity: .95;}\n#tpm_Control {position:relative; z-index: 100000; float: left; background-color: #fcf9f9; border: solid #ccc; border-width: 0 1px 1px 0; height: 200px; width: 200px; opacity: 1;}\n#tpm_Control img {position: relative; padding: 0; display: block; margin: 82px auto 0; -ms-interpolation-mode: bicubic;}\n#tpm_Control a {position: fixed; z-index: 10001; right: 0; top: 0; left: 0; height: 24px; padding: 12px 0 0; text-align: center; font-size: 14px; line-height: 1em; text-shadow: 0 1px #fff; color: #211922; font-weight: bold; text-decoration: none; background: #fff url(http://d3io1k5o0zdpqr.cloudfront.net/images/fullGradient07Normal.png) 0 0 repeat-x; border-bottom: 1px solid #ccc; -mox-box-shadow: 0 0 2px #d7d7d7; -webkit-box-shadow: 0 0 2px #d7d7d7;}\n#tpm_Control a:hover {color: #fff; text-decoration: none; background-color: #1389e5; border-color: #1389e5; text-shadow: 0 -1px #46A0E6;}\n#tpm_Control a:active {height: 23px; padding-top: 13px; background-color: #211922; border-color: #211922; background-image: url(http://d3io1k5o0zdpqr.cloudfront.net/images/fullGradient07Inverted.png); text-shadow: 0 -1px #211922;}\n.tpmImagePreview {position: relative; padding: 0; margin: 0; float: left; background-color: #fff; border: solid #e7e7e7; border-width: 0 1px 1px 0; height: 200px; width: 200px; opacity: 1; z-index: 10002; text-align: center;}\n.tpmImagePreview .tpmImg {border: none; height: 200px; width: 200px; opacity: 1; padding: 0;}\n.tpmImagePreview .tpmImg a {margin: 0; padding: 0; position: absolute; top: 0; bottom: 0; right: 0; left: 0; display: block; text-align: center; z-index: 1;}\n.tpmImagePreview .tpmImg a:hover {background-color: #fcf9f9; border: none;}\n.tpmImagePreview .tpmImg .ImageToPin {max-height: 200px; max-width: 200px; width: auto !important; height: auto !important;}\n.tpmImagePreview img.tpm_PinIt {border: none; position: absolute; top: 82px; left: 42px; display: none; padding: 0; background-color: transparent; z-index: 100;}\n.tpmImagePreview img.tpm_vidind {border: none; position: absolute; top: 75px; left: 75px; padding: 0; background-color: transparent; z-index: 99;}\n.tpmDimensions { position: relative; margin-top: 180px; text-align: center; font-size: 10px; z-index:10003; display: inline-block; background: white; border-radius: 4px; padding: 0 2px;}\n\n</style>";
                if (isIE()) {
                    f = document.createElement("style");
                    f.type = "text/css";
                    f.media = "screen";
                    f.styleSheet.cssText = "#tpm_Container {font-family: 'helvetica neue', arial, sans-serif; position: absolute; padding-top: 37px; z-index: 100000002; top: 0; left: 0; background-color: transparent; opacity: 1;}\n#tpm_Overlay {position: fixed; z-index: 9999; top: 0; right: 0; bottom: 0; left: 0; background-color: #f2f2f2; opacity: .95;}\n#tpm_Control {position:relative; z-index: 100000; float: left; background-color: #fcf9f9; border: solid #ccc; border-width: 0 1px 1px 0; height: 200px; width: 200px; opacity: 1;}\n#tpm_Control img {position: relative; padding: 0; display: block; margin: 82px auto 0; -ms-interpolation-mode: bicubic;}\n#tpm_Control a {position: fixed; z-index: 10001; right: 0; top: 0; left: 0; height: 24px; padding: 12px 0 0; text-align: center; font-size: 14px; line-height: 1em; text-shadow: 0 1px #fff; color: #211922; font-weight: bold; text-decoration: none; background: #fff url(http://d3io1k5o0zdpqr.cloudfront.net/images/fullGradient07Normal.png) 0 0 repeat-x; border-bottom: 1px solid #ccc; -mox-box-shadow: 0 0 2px #d7d7d7; -webkit-box-shadow: 0 0 2px #d7d7d7;}\n#tpm_Control a:hover {color: #fff; text-decoration: none; background-color: #1389e5; border-color: #1389e5; text-shadow: 0 -1px #46A0E6;}\n#tpm_Control a:active {height: 23px; padding-top: 13px; background-color: #211922; border-color: #211922; background-image: url(http://d3io1k5o0zdpqr.cloudfront.net/images/fullGradient07Inverted.png); text-shadow: 0 -1px #211922;}\n.tpmImagePreview {position: relative; padding: 0; margin: 0; float: left; background-color: #fff; border: solid #e7e7e7; border-width: 0 1px 1px 0; height: 200px; width: 200px; opacity: 1; z-index: 10002; text-align: center;}\n.tpmImagePreview .tpmImg {border: none; height: 200px; width: 200px; opacity: 1; padding: 0;}\n.tpmImagePreview .tpmImg a {margin: 0; padding: 0; position: absolute; top: 0; bottom: 0; right: 0; left: 0; display: block; text-align: center; z-index: 1;}\n.tpmImagePreview .tpmImg a:hover {background-color: #fcf9f9; border: none;}\n.tpmImagePreview .tpmImg .ImageToPin {max-height: 200px; max-width: 200px; width: auto !important; height: auto !important;}\n.tpmImagePreview img.tpm_PinIt {border: none; position: absolute; top: 82px; left: 42px; display: none; padding: 0; background-color: transparent; z-index: 100;}\n.tpmImagePreview img.tpm_vidind {border: none; position: absolute; top: 75px; left: 75px; padding: 0; background-color: transparent; z-index: 99;}\n.tpmDimensions { position: relative; margin-top: 180px; text-align: center; font-size: 10px; z-index:10003; display: inline-block; background: white; border-radius: 4px; padding: 0 2px;}\n";
                    document.getElementsByTagName("head")[0].appendChild(f)
                } else {
                    if (navigator.userAgent.lastIndexOf("Safari/") > 0 && parseInt(navigator.userAgent.substr(navigator.userAgent.lastIndexOf("Safari/") + 7, 7)) < 533) {
                        f = document.createElement("style");
                        f.innerText = "\n#tpm_Container {font-family: 'helvetica neue', arial, sans-serif; position: absolute; padding-top: 37px; z-index: 100000002; top: 0; left: 0; background-color: transparent; opacity: 1;}\n#tpm_Overlay {position: fixed; z-index: 9999; top: 0; right: 0; bottom: 0; left: 0; background-color: #f2f2f2; opacity: .95;}\n#tpm_Control {position:relative; z-index: 100000; float: left; background-color: #fcf9f9; border: solid #ccc; border-width: 0 1px 1px 0; height: 200px; width: 200px; opacity: 1;}\n#tpm_Control img {position: relative; padding: 0; display: block; margin: 82px auto 0; -ms-interpolation-mode: bicubic;}\n#tpm_Control a {position: fixed; z-index: 10001; right: 0; top: 0; left: 0; height: 24px; padding: 12px 0 0; text-align: center; font-size: 14px; line-height: 1em; text-shadow: 0 1px #fff; color: #211922; font-weight: bold; text-decoration: none; background: #fff url(http://d3io1k5o0zdpqr.cloudfront.net/images/fullGradient07Normal.png) 0 0 repeat-x; border-bottom: 1px solid #ccc; -mox-box-shadow: 0 0 2px #d7d7d7; -webkit-box-shadow: 0 0 2px #d7d7d7;}\n#tpm_Control a:hover {color: #fff; text-decoration: none; background-color: #1389e5; border-color: #1389e5; text-shadow: 0 -1px #46A0E6;}\n#tpm_Control a:active {height: 23px; padding-top: 13px; background-color: #211922; border-color: #211922; background-image: url(http://d3io1k5o0zdpqr.cloudfront.net/images/fullGradient07Inverted.png); text-shadow: 0 -1px #211922;}\n.tpmImagePreview {position: relative; padding: 0; margin: 0; float: left; background-color: #fff; border: solid #e7e7e7; border-width: 0 1px 1px 0; height: 200px; width: 200px; opacity: 1; z-index: 10002; text-align: center;}\n.tpmImagePreview .tpmImg {border: none; height: 200px; width: 200px; opacity: 1; padding: 0;}\n.tpmImagePreview .tpmImg a {margin: 0; padding: 0; position: absolute; top: 0; bottom: 0; right: 0; left: 0; display: block; text-align: center; z-index: 1;}\n.tpmImagePreview .tpmImg a:hover {background-color: #fcf9f9; border: none;}\n.tpmImagePreview .tpmImg .ImageToPin {max-height: 200px; max-width: 200px; width: auto !important; height: auto !important;}\n.tpmImagePreview img.tpm_PinIt {border: none; position: absolute; top: 82px; left: 42px; display: none; padding: 0; background-color: transparent; z-index: 100;}\n.tpmImagePreview img.tpm_vidind {border: none; position: absolute; top: 75px; left: 75px; padding: 0; background-color: transparent; z-index: 99;}\n.tpmDimensions { position: relative; margin-top: 180px; text-align: center; font-size: 10px; z-index:10003; display: inline-block; background: white; border-radius: 4px; padding: 0 2px;}\n\n"
                    } else {
                        f = document.createElement("style");
                        f.innerHTML = "\n#tpm_Container {font-family: 'helvetica neue', arial, sans-serif; position: absolute; padding-top: 37px; z-index: 100000002; top: 0; left: 0; background-color: transparent; opacity: 1;}\n#tpm_Overlay {position: fixed; z-index: 9999; top: 0; right: 0; bottom: 0; left: 0; background-color: #f2f2f2; opacity: .95;}\n#tpm_Control {position:relative; z-index: 100000; float: left; background-color: #fcf9f9; border: solid #ccc; border-width: 0 1px 1px 0; height: 200px; width: 200px; opacity: 1;}\n#tpm_Control img {position: relative; padding: 0; display: block; margin: 82px auto 0; -ms-interpolation-mode: bicubic;}\n#tpm_Control a {position: fixed; z-index: 10001; right: 0; top: 0; left: 0; height: 24px; padding: 12px 0 0; text-align: center; font-size: 14px; line-height: 1em; text-shadow: 0 1px #fff; color: #211922; font-weight: bold; text-decoration: none; background: #fff url(http://d3io1k5o0zdpqr.cloudfront.net/images/fullGradient07Normal.png) 0 0 repeat-x; border-bottom: 1px solid #ccc; -mox-box-shadow: 0 0 2px #d7d7d7; -webkit-box-shadow: 0 0 2px #d7d7d7;}\n#tpm_Control a:hover {color: #fff; text-decoration: none; background-color: #1389e5; border-color: #1389e5; text-shadow: 0 -1px #46A0E6;}\n#tpm_Control a:active {height: 23px; padding-top: 13px; background-color: #211922; border-color: #211922; background-image: url(http://d3io1k5o0zdpqr.cloudfront.net/images/fullGradient07Inverted.png); text-shadow: 0 -1px #211922;}\n.tpmImagePreview {position: relative; padding: 0; margin: 0; float: left; background-color: #fff; border: solid #e7e7e7; border-width: 0 1px 1px 0; height: 200px; width: 200px; opacity: 1; z-index: 10002; text-align: center;}\n.tpmImagePreview .tpmImg {border: none; height: 200px; width: 200px; opacity: 1; padding: 0;}\n.tpmImagePreview .tpmImg a {margin: 0; padding: 0; position: absolute; top: 0; bottom: 0; right: 0; left: 0; display: block; text-align: center; z-index: 1;}\n.tpmImagePreview .tpmImg a:hover {background-color: #fcf9f9; border: none;}\n.tpmImagePreview .tpmImg .ImageToPin {max-height: 200px; max-width: 200px; width: auto !important; height: auto !important;}\n.tpmImagePreview img.tpm_PinIt {border: none; position: absolute; top: 82px; left: 42px; display: none; padding: 0; background-color: transparent; z-index: 100;}\n.tpmImagePreview img.tpm_vidind {border: none; position: absolute; top: 75px; left: 75px; padding: 0; background-color: transparent; z-index: 99;}\n.tpmDimensions { position: relative; margin-top: 180px; text-align: center; font-size: 10px; z-index:10003; display: inline-block; background: white; border-radius: 4px; padding: 0 2px;}\n\n"
                    }
                    document.body.appendChild(f)
                }
                var o = document.createElement("div");
                o.setAttribute("id", "tpm_Overlay");
                document.keydown = i;
                document.body.appendChild(o);
                var n = document.createElement("div");
                n.setAttribute("id", "tpm_Container");
                document.body.appendChild(n);
                f = document.createElement("div");
                f.setAttribute("id", "tpm_Control");
                t_img = new Image;
                t_img.src = "http://d3io1k5o0zdpqr.cloudfront.net/images/about/LogoAbout.png";
                f.appendChild(t_img);
                t_a = document.createElement("a");
                t_a.href = "#";
                t_a.id = "tpm_RemoveLink";
                t_a.appendChild(document.createTextNode("Cancel Pin"));
                f.appendChild(t_a);
                n.appendChild(f);
                document.getElementById("tpm_RemoveLink").onclick = i;
                i = {};
                for (var h = 0; h < m.length; h++) if (!(i[m[h].src] || m[h].im2.height && m[h].im2.height < 80)) {
                    i[m[h].src] = 1;
                    (function (a) {
                        var b = document.createElement("div");
                        if (isIE()) b.className = "tpmImagePreview";
                        else b.setAttribute("class", "tpmImagePreview");
                        var d = document.createElement("div");
                        if (isIE()) d.className = "tpmImg";
                        else d.setAttribute("class", "tpmImg");
                        var e = document.createElement("span");
                        e.innerHTML = a.w + " x " + a.h;
                        if (isIE()) e.className = "tpmDimensions";
                        else e.setAttribute("class", "tpmDimensions");
                        b.appendChild(e);
                        document.getElementById("tpm_Container").appendChild(b).appendChild(d);
                        b = document.createElement("a");
                        b.setAttribute("href", "#");
                        b.onclick = function () {
                            v(a);
                            o.parentNode.removeChild(o);
                            n.parentNode.removeChild(n);
                            document.tpmLjs = 0;
                            return false
                        };
                        d.appendChild(b);
                        e = document.createElement("img");
                        if (isIE()) d.className = "tpmImg";
                        else d.setAttribute("class", "tpmImg");
                        e.setAttribute("style", "" + y(a));
                        e.src = a.src;
                        e.setAttribute("alt", "Pin This");
                        e.className = "ImageToPin";
                        b.appendChild(e);
                        var c = document.createElement("img");
                        if (isIE()) c.className = "tpm_PinIt";
                        else c.setAttribute("class", "tpm_PinIt");
                        c.src = "http://d3io1k5o0zdpqr.cloudfront.net/images/PinThis.png";
                        c.setAttribute("alt", "Pin This");
                        if (isIE()) {
                            b.attachEvent("onmouseover", function () {
                                c.style.display = "block"
                            });
                            b.attachEvent("onmouseout", function () {
                                c.style.display = "none"
                            })
                        } else {
                            b.addEventListener("mouseover", function () {
                                c.style.display = "block"
                            }, false);
                            b.addEventListener("mouseout", function () {
                                c.style.display = "none"
                            }, false)
                        }
                        b.appendChild(c);
                        if (m[h].type == "video") {
                            d = document.createElement("img");
                            if (isIE()) d.className = "tpm_vidind";
                            else d.setAttribute("class", "tpm_vidind");
                            d.src = "http://d3io1k5o0zdpqr.cloudfront.net/images/VideoIndicator.png";
                            b.appendChild(d)
                        }
                    })(m[h])
                }
                if (isIE()) {
                    i = document.getElementsByTagName("object");
                    for (h = 0; h < i.length; h++) {
                        f = {
                            player: i[h],
                            parent: i[h].parentNode,
                            sibling: i[h].nextSibling
                        };
                        f.parent.removeChild(i[h]);
                        p.push(f)
                    }
                }
                scroll(0, 0);
                return m
            }
        }
    }
};




/*
	Breakpoints.js
	version 1.0
	
	Creates handy events for your responsive design breakpoints
	
	Copyright 2011 XOXCO, Inc
	http://xoxco.com/

	Documentation for this plugin lives here:
	http://xoxco.com/projects/code/breakpoints
	
	Licensed under the MIT license:
	http://www.opensource.org/licenses/mit-license.php

*/
(function($) {

	var lastSize = 0;
	var interval = null;

	$.fn.resetBreakpoints = function() {
		$(window).unbind('resize');
		if (interval) {
			clearInterval(interval);
		}
		lastSize = 0;
	};
	
	$.fn.setBreakpoints = function(settings) {
		var options = jQuery.extend({
							distinct: true,
							breakpoints: new Array(320,480,768,1024)
				    	},settings);


		interval = setInterval(function() {
	
			var w = $(window).width();
			var done = false;
			
			for (var bp in options.breakpoints.sort(function(a,b) { return (b-a) })) {
			
				// fire onEnter when a browser expands into a new breakpoint
				// if in distinct mode, remove all other breakpoints first.
				if (!done && w >= options.breakpoints[bp] && lastSize < options.breakpoints[bp]) {
					if (options.distinct) {
						for (var x in options.breakpoints.sort(function(a,b) { return (b-a) })) {
							if ($('body').hasClass('breakpoint-' + options.breakpoints[x])) {
								$('body').removeClass('breakpoint-' + options.breakpoints[x]);
								$(window).trigger('exitBreakpoint' + options.breakpoints[x]);
							}
						}
						done = true;
					}
					$('body').addClass('breakpoint-' + options.breakpoints[bp]);
					$(window).trigger('enterBreakpoint' + options.breakpoints[bp]);

				}				

				// fire onExit when browser contracts out of a larger breakpoint
				if (w < options.breakpoints[bp] && lastSize >= options.breakpoints[bp]) {
					$('body').removeClass('breakpoint-' + options.breakpoints[bp]);
					$(window).trigger('exitBreakpoint' + options.breakpoints[bp]);

				}
				
				// if in distinct mode, fire onEnter when browser contracts into a smaller breakpoint
				if (
					options.distinct && // only one breakpoint at a time
					w >= options.breakpoints[bp] && // and we are in this one
					w < options.breakpoints[bp-1] && // and smaller than the bigger one
					lastSize > w && // and we contracted
					lastSize >0 &&  // and this is not the first time
					!$('body').hasClass('breakpoint-' + options.breakpoints[bp]) // and we aren't already in this breakpoint
					) {					
					$('body').addClass('breakpoint-' + options.breakpoints[bp]);
					$(window).trigger('enterBreakpoint' + options.breakpoints[bp]);

				}						
			}
			
			// set up for next call
			if (lastSize != w) {
				lastSize = w;
			}
		},250);
	};
	
})(jQuery);



/*! http://tinynav.viljamis.com v1.1 by @viljamis */
(function ($, window, i) {
  $.fn.floTinyNav = function (options) {

    // Default settings
    var settings = $.extend({
      'active' : 'selected', // String: Set the "active" class
      'header' : '', // String: Specify text for "header" and show header instead of the active item
      'label'  : '' // String: sets the <label> text for the <select> (if not set, no label will be added)
    }, options);

    return this.each(function () {

      // Used for namespacing
      i++;

      var $nav = $(this),
        // Namespacing
        namespace = 'tinynav',
        namespace_i = namespace + i,
        l_namespace_i = '.l_' + namespace_i,
        $select = $('<select/>').attr("id", namespace_i).attr('name', namespace_i).addClass(namespace + ' ' + namespace_i);

      if ($nav.is('ul,ol')) {

        if (settings.header !== '') {
          $select.append(
            $('<option/>').text(settings.header)
          );
        }

        // Build options
        var options = '';

        $nav
          .addClass('l_' + namespace_i)
          .find('> li > a, .submenu .sections a')
          .each(function () {
            options += '<option value="' + $(this).attr('href') + '">';
            var j;
            for (j = 0; j < $(this).parents('ul, ol').length - 1; j++) {
              options += '- ';
            }
            options += $(this).text() + '</option>';
          });

        // Append options into a select
        $select.append(options);

        // Select the active item
        if (!settings.header) {
          $select
            .find(':eq(' + $(l_namespace_i + ' li')
            .index($(l_namespace_i + ' li.' + settings.active)) + ')')
            .attr('selected', true);
        }

        // Change window location
        $select.change(function () {
          window.location.href = $(this).val();
        });

        // Inject select
        $(l_namespace_i).after($select);

        // Inject label
        if (settings.label) {
          $select.before(
            $("<label/>")
              .attr("for", namespace_i)
              .addClass(namespace + '_label ' + namespace_i + '_label')
              .append(settings.label)
          );
        }

      }

    });

  };
})(jQuery, this, 0);