App = {
	// Content Languages
	languages: ['/en/'],
	// Function to initialize on Document Load
	init: () => {
		console.log('Kanderr initialized!');

		App.contactAJAX();
		App.frontPageInit();
	},
	frontPageInit: () => {
		if (document.body.dataset.front !== undefined) {
			App.videoCarousel();
		}
	},
	videoCarousel: () => {
		jQuery("#video-carousel").on('slide.bs.carousel', function (evt) {

			const step = jQuery(evt.relatedTarget).index();
			let index;

			if (step == 0) {
				index = jQuery(this).find('.hide.index').data('index') - 1;
			} else {
				index = step - 1;
			}

			jQuery('#video-' + index).get(0).pause();
			jQuery('#video-' + index).get(0).currentTime = 0;
			jQuery('#video-' + step).get(0).play();


			jQuery('#carousel-captions .carousel-caption:not(#caption-' + step + ')').css('display', 'none');
			jQuery('#caption-' + step).css('display', 'block');

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