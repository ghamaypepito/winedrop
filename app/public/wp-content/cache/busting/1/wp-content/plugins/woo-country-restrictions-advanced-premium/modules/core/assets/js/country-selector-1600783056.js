
function wcacrSetCookie(name, value, days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
function wcacrGetCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1, c.length);
		}
		if (c.indexOf(nameEQ) == 0) {
			return c.substring(nameEQ.length, c.length);
		}
	}
	return null;
}

// Popup
jQuery(window).on('load', function () {
	var $popup = jQuery('.wcacr-country-selector-popup');
	if (!$popup.length) {
		return true;
	}
	var cookieName = 'wcacr_first_time';
	if (wcacrGetCookie(cookieName)) {
		return true;
	}
	if (!jQuery('.wcacr-country-selector-popup ul li').length) {
		return true;
	}
	wcacrSetCookie(cookieName, 1, 30);

	jQuery('.wcacr-country-selector-popup-shadow, .wcacr-country-selector-popup').appendTo(jQuery('body'));
	jQuery('.wcacr-country-selector-popup-shadow, .wcacr-country-selector-popup').addClass('wcacr-visible');
	$popup.find('.wcacr-close').click(function (e) {
		e.preventDefault();

		jQuery('.wcacr-country-selector-popup-shadow, .wcacr-country-selector-popup').removeClass('wcacr-visible');
	});
	var $currentCountry = $popup.find('.wcacr-current-country-link');
	$currentCountry.removeClass('menu-item');
	$currentCountry.removeClass('menu-item-has-children');
	$currentCountry.removeClass('dropdown');
	$currentCountry.removeClass('ubermenu-item');
	$currentCountry.removeClass('ubermenu-item-has-children');
	$currentCountry.removeClass('ubermenu-item-level-0');
	$currentCountry.removeClass('ubermenu-column');
	$currentCountry.removeClass('ubermenu-has-submenu-drop');

	var currentCountryName = $currentCountry.data('country-name');

	if ($currentCountry.text().indexOf(currentCountryName) < 0) {
		$currentCountry.append(currentCountryName);
	}
	$currentCountry.click(function (e) {
		e.preventDefault();

		// If this link is inside the popup, automatically close the popup when the link is clicked
		if (jQuery(this).parents('.wcacr-country-selector-popup').length) {
			jQuery('.wcacr-country-selector-popup .wcacr-close').click();
		}
	});

	$popup.find('.dropdown-menu').removeClass('dropdown-menu');
	$popup.find('.dropdown-menu').removeClass('sub-menu');
	$popup.css({
		top: (jQuery(window).height() - $popup.height()) / 2,
		left: (jQuery(window).width() - $popup.width()) / 2
	});

});

function wcacrRemoveCountrySelectorFromCache(cacheKey) {
	try {
		var wc_fragments = jQuery.parseJSON(sessionStorage.getItem(cacheKey));
		if (typeof wc_fragments['li.wccr-country-selector.menu-item'] !== 'undefined') {
			delete wc_fragments['li.wccr-country-selector.menu-item'];
			sessionStorage.setItem(cacheKey, JSON.stringify(wc_fragments));
		}
	} catch (err) {
	}
}
// The country dropdown fragment must not be cached, otherwise it shows the old country after we select another country
setTimeout(function () {

	jQuery(document.body).on('wc_fragments_refreshed', function () {
		console.log('run');
		wcacrRemoveCountrySelectorFromCache(wc_cart_fragments_params.fragment_name);
	});
}, 500);