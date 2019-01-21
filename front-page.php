<?php /* Template Name: Home */ get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>


		</section>
		<!-- /section -->
		<section class="bottom-widget-area">
			<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-page-bottom-widget-area')) ?>
		</section>
	</main>


<?php get_footer(); ?>
