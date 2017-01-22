'use strict';

(function() {

	function topSlider() {
		$('.top-slider .fullscreen').slick({
			dots: false,
			infinite: true,
			speed: 500,
			slidesToShow: 1,
			adaptiveHeight: false,
			arrows: false,
			autoplay: true,
			autoplaySpeed: 5000,
			fade: true,
            pauseOnHover: false
		});
		$('.top-slider .middletext').slick({
			dots: false,
			infinite: true,
			speed: 500,
			slidesToShow: 1,
			adaptiveHeight: true,
			arrows: false,
			autoplay: true,
			autoplaySpeed: 5000,
			fade: true,
            pauseOnHover: false
		});
	}

	function sectionfadeIn() {
		var scrollTop = $(window).scrollTop(),
			windowHeight = $(window).outerHeight();
		$('.sectionfadeIn').each(function () {
			var $section = $(this),
				sectionOffsetTop = $section.offset().top,
				sectionHeight = $section.height();
			if((scrollTop+windowHeight) >= (sectionOffsetTop + sectionHeight/3)){
				$section.addClass('fadein');
			}
		})
	}

	function gallery() {
		$('.gallery-items').lightGallery({
			actualSize: false,
			download: false
		});
	}
	function countTo() {
		var scrollTop = $(window).scrollTop(),
			windowHeight = $(window).outerHeight();
		$('.facts-countto').each(function () {
			var $section = $(this),
				sectionOffsetTop = $section.offset().top,
				sectionHeight = $section.height();
			if(((scrollTop+windowHeight) >= (sectionOffsetTop + sectionHeight)) && !$section.is('.complete')){
				$section.countTo();
				$section.addClass('complete');
			}
		})
	}

	function topMenuPositin() {
		var $header = $('header#header'),
			headerHeight = $header.find('.header-inner').outerHeight(),
			windowHeight = $(window).outerHeight(),
			windowScrollTop = $(window).scrollTop();
		if(windowScrollTop >= windowHeight-headerHeight){
			$header.addClass('showMenu');
		}
		else{
			$header.removeClass('showMenu');
		}
	}
	
	function scrollTo(scrollToSection) {
		var headerHeight = $('header#header .header-inner').outerHeight();
		$('body, html').animate({
			scrollTop: scrollToSection-headerHeight
		}, 700);
		$('header#header').removeClass('openMenu');
	}

	function activeMenuPositin() {
		$('[data-section-id]').each(function () {
			if($(this).offset().top<=$(document).scrollTop()+$('header#header .header-inner').outerHeight()){
				$('.top_menu li').removeClass('active');
				$('.top_menu a[href="'+$(this).attr('data-section-id')+'"]').closest('li').addClass('active');
			}
			// else if($(document).scrollTop() < $(window).height()){
			// 	$('.top_menu li').removeClass('active');
			// }
		})
	}

	$('[data-scroll-to]').on('click', function (e) {
		e.preventDefault();
		var $this = $(this),
			section = $('[data-section-id="'+$this.attr('data-scroll-to')+'"]').offset().top;
		scrollTo(section);
	});

	$('.top_menu a').on('click', function (e) {
		e.preventDefault();
		var $this = $(this),
			section = $('[data-section-id="'+$this.attr('href')+'"]').offset().top;
		scrollTo(section);
	});
	$('#header .logo a').on('click', function (e) {
		e.preventDefault();
		scrollTo(0);
	});

	$('button.mobile-menu-toggle').on('click', function (e) {
		e.preventDefault();
		$('header#header').toggleClass('openMenu');
	});

	gallery();
	topSlider();
	sectionfadeIn();
	//countTo();
	//topMenuPositin();
	activeMenuPositin();

	$(window).on('load resize scroll', function () {
		sectionfadeIn();
		countTo();
		//topMenuPositin();
		activeMenuPositin();
	});
})();