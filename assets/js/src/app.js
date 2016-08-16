'use strict';

"'article aside footer header nav section time'".replace(/\w+/g,function(n){document.createElement(n);});

var viewportWidth = 0;

var mobileCheck = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
    },
    any: function() {
        return (mobileCheck.Android() || mobileCheck.BlackBerry() || mobileCheck.iOS() || mobileCheck.Opera() || mobileCheck.Windows());
    }
};

var isMobile = (mobileCheck.any()) ? true : false;

$(window).resize(function() {
	//recalculate for dropdown selection
	viewportWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
	//close dropdowns
	if(!isMobile) {
		$('.dropdown').slideUp('fast');
	}

	if(!isMobile && viewportWidth <= 1024) {
		$('nav.main').fadeOut('fast');
	} else if(viewportWidth > 1024) {
		$('nav.main').fadeIn('fast');
		$('nav.main ul li > ul.subnav').css('display','none');
	}
});

$(document).ready(function() {

	viewportWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

	/************************************************************************************/
	/* popups
	/************************************************************************************/
	var $overlay = $('.overlay');
	var $overlayClose = $('.overlay-close');
	var $overlayOpen = $('.demo-link');
	var $popupDemo = $('#popup-demo');

	$overlayOpen.click(function() {
		$popupDemo.css('display', 'block');
		$overlay.fadeIn('fast');
	});

	var $newsletterOpen = $('.newsletter-popup');
	var $popupNewsletter = $('#popup-newsletter');

	$newsletterOpen.click(function() {
		$popupNewsletter.css('display', 'block');
		$overlay.fadeIn('fast');
	});

	$overlayClose.click(function() {
		$popupDemo.css('display', 'none');
		$popupNewsletter.css('display', 'none');
		$overlay.fadeOut('fast');
	});

	/************************************************************************************/
	/* mobile nav
	/************************************************************************************/
	var $nav = $('nav.main');
	var $navMobile = $('.nav-mobile');

	$navMobile.click(function() {
		if($nav.css('display') === 'none') {
			$nav.fadeIn('fast');
			$('body').addClass('fixed');
		} else {
			$nav.fadeOut('fast');
			$('.dropdown').fadeOut('fast');
			$('body').removeClass('fixed');
		}
	});

	/************************************************************************************/
	/* main nav
	/************************************************************************************/
	var $navItem, $dropdown, $navID, $navCall, $dropdownOffset;

	$navItem = $('nav.main ul li > a');
	$dropdown = $('.dropdown');

	$navItem.click(function() {
		
		$dropdownOffset = $(this).offset().left;
		$navID = $(this).attr('rel');
		
		if($('ul#nav'+$navID).css('display') === 'block') {
			if(!isMobile && viewportWidth > 1024) {
				$dropdown.slideUp('fast');
				$dropdown.find('> ul').css('display', 'none');
			} else {
				$(this).parent().find('> ul').css('display', 'none');
			}
		} else {
			if(!isMobile && viewportWidth > 1024) {
				$dropdown.find('> ul').css('display', 'none');
				$('ul#nav'+$navID).not('.subnav').css('display', 'block');
				$('ul#nav'+$navID).not('.subnav').css('left', $dropdownOffset);
				$dropdown.slideDown('fast');
			} else if(isMobile || viewportWidth <= 1024) {
				$('ul.subnav#nav'+$navID).css('display', 'block');
				$('ul.subnav#nav'+$navID).css('left', $dropdownOffset);
			}
		}
	});

	$dropdown.mouseleave(function() {
		$dropdown.delay().slideUp('fast');
	});

	/************************************************************************************/
	/* home go
	/************************************************************************************/
	var $go = $('.go.down');
	if($go.length) {
		var $goScrollLoc;

		if(viewportWidth <= 1500 && !isMobile) {
			$goScrollLoc = $('h2:eq(0)').offset().top - 20;
		} else {
			$goScrollLoc = $('article:eq(0)').offset().top;
		}

		$go.click(function() {
			$('html, body').animate({
		        scrollTop: $goScrollLoc
		    }, 1000);
		});
	}

	/************************************************************************************/
	/* roames icons go
	/************************************************************************************/
	var $roamesIcon = $('body#panels .icons .icon');

	$roamesIcon.click(function() {
		var $targetID = $(this).attr('rel');
		var $target = $('#'+$targetID);
		$target = $target.offset().top;
		
		$('html, body').animate({
	        scrollTop: $target
	    }, 1000);
	});

	/*************************************/
    /** VIDEO RESPONSIVENESS **/
    /*************************************/
    // Find all YouTube videos
    var $allVideos = $("iframe[src^='https://www.youtube.com']");
    // The element that is fluid width
    var $fluidEl = $(".video-holder");
    // Figure out and save aspect ratio for each video
    $allVideos.each(function() {
        $(this).data("aspectRatio", this.height / this.width).removeAttr("height").removeAttr("width");
    });
    // When the window is resized
    $(window).resize(function() {
        var $newWidth = $fluidEl.width();
        // Resize all videos according to their own aspect ratio
        $allVideos.each(function() {
            var $el = $(this);
            $el.width($newWidth).height($newWidth * $el.data("aspectRatio"));
        });
    }).resize();
});

