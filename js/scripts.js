(function ($, root, undefined) {

	$(function () {

		'use strict';

		//
		function validateEmail(email) {
		  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		  return re.test(email);
		}

		// DOM ready, take it away
		$("#video-carousel").on('slide.bs.carousel', function(evt) {

		   var step = $(evt.relatedTarget).index();
			 var index;

			 if(step == 0) {
				 index = $(this).find('.hide.index').data('index') - 1;
			 } else {
				 index = step - 1;
			 }

			 $('#video-'+index).get(0).pause();
			 $('#video-'+index).get(0).currentTime = 0;
			 $('#video-'+step).get(0).play();


		   $('#carousel-captions .carousel-caption:not(#caption-'+step+')').css('display', 'none');
		   $('#caption-'+step).css('display', 'block');

			 $('.carousel-indicators').find('#indicator-'+index).removeClass('active');
			 $('.carousel-indicators').find('#indicator-'+step).addClass('active');

		});

		// Mobile Menu Toggler
		$('.mobile-menu-toggler').toggle(function() {

			$(this).find('.mobile-menu-bar:nth-child(1)').addClass('bar-1');
			$(this).find('.mobile-menu-bar:nth-child(2)').addClass('bar-2');
			$(this).find('.mobile-menu-bar:nth-child(3)').addClass('bar-3');

			$('.mobile-menu').addClass('collapse');
			$('.mobile-menu.collapse').find('.kanderr-mobile-nav').addClass('show');

		}, function() {

			$(this).find('.mobile-menu-bar:nth-child(1)').removeClass('bar-1');
			$(this).find('.mobile-menu-bar:nth-child(2)').removeClass('bar-2');
			$(this).find('.mobile-menu-bar:nth-child(3)').removeClass('bar-3');

			$('.mobile-menu').removeClass('collapse');
			$('.mobile-menu').find('.kanderr-mobile-nav').removeClass('show');

		});

		// Contact Form Submission
		$('#contact-form').on('submit', function(e) {
			e.preventDefault();

			$('.has-error').removeClass('has-error');
			$('.js-show-feedback').removeClass('js-show-feedback');

			var form = $(this);
			var name = form.find('#name').val();
			var email = form.find('#email').val();
			var message = form.find('#message').val();
			var ajaxurl = form.data('url');

			if(name === '') {
				$('#name').parent('.form-group').addClass('has-error');
				return;
			}
			if(email === '') {
				$('#email').parent('.form-group').addClass('has-error');
				return;
			}
			if(!validateEmail(email)) {
				$('#email').parent('.form-group').addClass('has-error');
				return;
			}
			if(message === '') {
				$('#message').parent('.form-group').addClass('has-error');
				return;
			}

			form.find('input, button, textarea').attr('disabled', 'disabled');
			$('.js-form-submission').addClass('js-show-feedback');

			$.ajax({
				url: ajaxurl,
				type: 'post',
				data: {
					name: name,
					email: email,
					message: message,
					action: 'kanderr_contact_me'
				},
				error: function(response) {
					$('.js-form-submission').removeClass('js-show-feedback');
					$('.js-form-error').addClass('js-show-feedback');
					form.find('input, button, textarea').removeAttr('disabled');
				},
				success: function(response) {
					if(response == 0) {
						setTimeout(function() {
							$('.js-form-submission').removeClass('js-show-feedback');
							$('.js-form-error').addClass('js-show-feedback');
							form.find('input, button, textarea').removeAttr('disabled');
						}, 1500);
					} else {
						setTimeout(function() {
							$('.js-form-submission').removeClass('js-show-feedback');
							$('.js-form-success').addClass('js-show-feedback');
							form.find('input, button, textarea').removeAttr('disabled').val('');
						}, 1500);
					}
				}
			});

		});

	});

})(jQuery, this);
