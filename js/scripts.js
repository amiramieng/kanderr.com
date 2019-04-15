App = {
	// Content Languages
	languages: ['/en/'],
	// Function to initialize on Document Load
	init: () => {
		console.log('Kanderr initialized!');

		AOS.init();
		App.contactAJAX();
		App.frontPageInit();
		App.testConnection();
	},
	frontPageInit: () => {
		if (document.body.dataset.front !== undefined) {
			//jQuery('body').css('overflow-y', 'hidden');
			//jQuery('.nav-toggler').css('display', 'none');

			App.videoCarousel();
			App.kanderrNavbar();
			// App.kanderrPreloader();
		}
	},
	testConnection: () => {
		// Network Information object
		var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
		// initialize
		if (connection) {
			connection.addEventListener("change", App.bandwidthChange());
			// App.bandwidthChange();
		}
	},
	highBandwidth: () => {
		var conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
		console.log(conn);
		return !conn.metered && conn.downlink > 2
	},
	bandwidthChange: () => {

		var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

		// var body = document.body;
		//
		// if (highBandwidth) {
		// 	body.classList.add("hibw");
		// }
		// else {
		// 	body.classList.remove("hibw");
		// }

		// console.group('Connection Test');
		console.info(
			"switching to " +
			(App.highBandwidth ? "high" : "low") +
			" bandwidth mode"
		);
		// Network type that browser uses
		console.log('         type: ' + connection.type);
		// Effective bandwidth estimate
		console.log('     downlink: ' + connection.downlink + 'Mb/s');
		// Effective round-trip time estimate
		console.log('          rtt: ' + connection.rtt + 'ms');
		// Upper bound on the downlink speed of the first network hop
		console.log('  downlinkMax: ' + connection.downlinkMax + 'Mb/s');
		// Effective connection type determined using a combination of recently
		// observed rtt and downlink values: ' +
		console.log('effectiveType: ' + connection.effectiveType);
		// True if the user has requested a reduced data usage mode from the user
		// agent.
		console.log('     saveData: ' + connection.saveData);
		// console.groupEnd('Connection Test');

	},
	kanderrPreloader: () => {
		jQuery(window).load(function() {
			setTimeout(() => {
				jQuery("#preloader").fadeOut("slow");
				// jQuery('body').css('overflow-y', 'auto');
				// jQuery('.nav-toggler').css('display', 'block');
			}, 2000);
		})
	},
	kanderrNavbar: () => {
		let scrollTop = 0;
		jQuery(window).on('scroll', function() {
			jQuery('.navbar-container').toggleClass('scroll', jQuery(window).scrollTop() <= scrollTop && jQuery(window).scrollTop() > 0 && jQuery(window).width() > 768);
			scrollTop = jQuery(window).scrollTop();
		})
	},
	videoCarousel: () => {
		console.log('Video Carousel Initialized.');

		if (!App.highBandwidth) {
			jQuery('.view.view-kanderr').css('display', 'none');
		} else {
			jQuery('.view.view-kanderr').css('display', 'block');
		}

		jQuery('#caption-0').addClass('active');

		jQuery("#video-carousel").on('slide.bs.carousel', function (evt) {

			const step = jQuery(evt.relatedTarget).index();
			let index;
			let next;

			if (step == 0) {
				index = jQuery(this).find('.hide.index').data('index') - 1;
			} else {
				index = step - 1;
			}

			if (step == jQuery(this).find('.hide.index').data('index') - 1) {
				next = 0;
			} else {
				next = step + 1;
			}

			console.log(index, step);

			jQuery('#video-' + index).get(0).pause();
			jQuery('#video-' + index).get(0).currentTime = 0;
			jQuery('#video-' + step).get(0).play();

			// jQuery('#caption-' + index).removeClass('active');
			// jQuery('#caption-' + index).addClass('past');
			jQuery('#caption-' + step).addClass('active');
			jQuery('#carousel-captions .carousel-caption:not(#caption-' + step + ')').removeClass('active');
			// jQuery('#caption-' + next).removeClass('past');

			jQuery('.carousel-indicators').find('#indicator-' + index).removeClass('active');
			jQuery('.carousel-indicators').find('#indicator-' + step).addClass('active');

		});
	},
	// Validate Email
	validateEmail: (email) => {
		let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(String(email).toLowerCase());
	},
	contactAJAX: () => {
		const contactForm = document.querySelector('#contact-form');

		contactForm.addEventListener('submit', (e) => {
			e.preventDefault();

			const name = contactForm.querySelector('#name');
			const email = contactForm.querySelector('#email');
			const message = contactForm.querySelector('#message');

			const data = {
				name: name.value,
				email: email.value,
				message: message.value,
			}

			if (!data.name) {
				name.parentElement.classList.add('has-error');
				return;
			}
			if (!App.validateEmail(data.email)) {
				email.parentElement.classList.add('has-error');
				return;
			}
			if (!data.email) {
				email.parentElement.classList.add('has-error');
				return;
			}
			if (!data.message) {
				message.parentElement.classList.add('has-error');
				return;
			}

			const ajaxURL = contactForm.dataset.url;
			const params = new URLSearchParams(new FormData(contactForm));

			document.querySelectorAll('.form-control').forEach(form => form.disabled = true);

			fetch(ajaxURL, {
					method: 'POST',
					body: params,
				}).then(res => res.json())
				.catch(error => {
					document.querySelectorAll('.form-control').forEach(form => form.value = '');
					document.querySelector('.js-form-submission').classList.remove('js-show-feedback');
					document.querySelector('.js-form-error').classList.add('js-show-feedback');
					document.querySelectorAll('.form-control').forEach(form => form.disabled = false);
				})
				.then(response => {
					console.log(response);

					if (response === 0 || response.status === 'error') {
						document.querySelectorAll('.form-control').forEach(form => form.value = '');
						document.querySelector('.js-form-submission').classList.remove('js-show-feedback');
						document.querySelector('.js-form-error').classList.add('js-show-feedback');
						document.querySelectorAll('.form-control').forEach(form => form.disabled = false);
						return;
					}

					document.querySelectorAll('.form-control').forEach(form => form.value = '');
					document.querySelector('.js-form-submission').classList.remove('js-show-feedback');
					document.querySelector('.js-form-success').classList.add('js-show-feedback');
					document.querySelectorAll('.form-control').forEach(form => form.disabled = false);
				});



		});
	}

}

document.addEventListener('DOMContentLoaded', function (e) {
	//console.log(e);

	App.init();
});

(function ($, root, undefined) {

	$(function () {

		'use strict';


		// Mobile Menu Toggler
		$('.mobile-menu-toggler').toggle(function () {

			$(this).find('.mobile-menu-bar:nth-child(1)').addClass('bar-1');
			$(this).find('.mobile-menu-bar:nth-child(2)').addClass('bar-2');
			$(this).find('.mobile-menu-bar:nth-child(3)').addClass('bar-3');

			$('.mobile-menu').addClass('collapse');
			$('.mobile-menu.collapse').find('.kanderr-mobile-nav').addClass('show');

		}, function () {

			$(this).find('.mobile-menu-bar:nth-child(1)').removeClass('bar-1');
			$(this).find('.mobile-menu-bar:nth-child(2)').removeClass('bar-2');
			$(this).find('.mobile-menu-bar:nth-child(3)').removeClass('bar-3');

			$('.mobile-menu').removeClass('collapse');
			$('.mobile-menu').find('.kanderr-mobile-nav').removeClass('show');

		});

	});

})(jQuery, this);
