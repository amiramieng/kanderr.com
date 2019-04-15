<!-- footer -->
<footer class="footer" role="contentinfo">
	<div class="container row footer-inner">
		<div class="col-md-4">
			<h3>Index</h3>
			<?php footer_nav(); ?>
			<h3>Keep In Touch</h3>
			<ul class="social-bar">
				<li><a href="https://www.facebook.com/kanderrfilms" target="_blank" title="Facebook"><span class="fab fa-facebook"></span></a></li>
				<li><a href="https://www.instagram.com/kanderrfilms/" target="_blank" title="Instagram"><span class="fab fa-instagram"></span></a></li>
				<li><a href="" target="_blank" title="YouTube"><span class="fab fa-youtube"></span></a></li>
				<li><a href="https://vimeo.com/user90723484" target="_blank" title="Vimeo"><span class="fab fa-vimeo"></span></a></li>
			</ul>
		</div>

		<div class="col-md-4 contact">
			<h3>Contact Us</h3>
			<form novalidate id="contact-form" action="#" method="post"
			data-url="<?php echo admin_url('admin-ajax.php'); ?>">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Your name" id="name" name="name">
				<small class="text-danger no-error">Your Name is Required</small>
			</div>
			<div class="form-group">
				<input type="email" class="form-control" placeholder="Your email" id="email" name="email">
				<small class="text-danger no-error">A Valid Email is Required</small>
			</div>
			<div class="form-group">
				<textarea class="form-control" placeholder="Your message..." id="message" name="message"
				maxlength="500"></textarea>
				<small class="text-danger no-error">A Message is Required</small>
			</div>
			<div class="row mt-3">
				<div class="col-xs-3">
					<button type="submit" class="btn btn-default btn-submit kanderr-btn">Submit</button>
				</div>
				<div class="col-xs-9">
					<small class="text-info form-control-msg js-form-submission">Submission in process, please
						wait...</small>
						<small class="text-success form-control-msg js-form-success">Message successfully submitted,
							thank you.</small>
							<small class="text-danger form-control-msg js-form-error">There was an issue contacting
								Kanderr, please try again.</small>
							</div>
						</div>
						<input type="hidden" name="action" value="kanderr_contact_me">
					</form>
				</div>

				<div class="col-md-4 kanderr-copy">
					<div class="kanderr-footer background-image">

					</div>
					<!-- copyright -->
					<p class="copyright">
						&copy; <?php echo date('Y'); ?> Copyright <a href="https://amirrami.com"
						title="Amir Rami" target="_blank">Amir</a>
					</p>
					<!-- /copyright -->
				</div>



			</div>
		</footer>
		<!-- /footer -->



		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(f, i, r, e, s, h, l) {
			i['GoogleAnalyticsObject'] = s;
			f[s] = f[s] || function() {
				(f[s].q = f[s].q || []).push(arguments)
			}, f[s].l = 1 * new Date();
			h = i.createElement(r),
			l = i.getElementsByTagName(r)[0];
			h.async = 1;
			h.src = e;
			l.parentNode.insertBefore(h, l)
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>

	</body>

	</html>
