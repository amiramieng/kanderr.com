<?php /* Template Name: Home */ get_header('front'); ?>

	<main role="main">
		<!-- section -->

		<section class="container theme-section" id="about">

			<div class="about-left" data-aos="fade-right">
				<h1 class="theme-section-h1">About Us</h1>

				<p><?php _e('Kandërr is a Prishtina based omniplatform entertainment company that transforms ideas into visions and has a special treat for those unconventional ones.', 'kanderr-theme'); ?></p>

				<div class="about-social" data-aos="fade-up">
					<ul class="social-bar">
						<li><a href="https://www.facebook.com/kanderrfilms" target="_blank" title="Facebook"><span class="fab fa-facebook"></span></a></li>
						<li><a href="https://www.instagram.com/kanderrfilms/" target="_blank" title="Instagram"><span class="fab fa-instagram"></span></a></li>
						<li><a href="" target="_blank" title="YouTube"><span class="fab fa-youtube"></span></a></li>
						<li><a href="https://vimeo.com/user90723484" target="_blank" title="Vimeo"><span class="fab fa-vimeo"></span></a></li>
					</ul>
				</div>
			</div>
			<div class="about-right">
				<div class="about-logo" data-aos="fade-left">

				</div>
			</div>
		</section>

		<section class="container theme-section" id="team">
			<div class="team-container">

				<?php kanderr_team(); ?>

			</div>
		</section>

		<!-- /section -->

	</main>


<?php get_footer(); ?>
