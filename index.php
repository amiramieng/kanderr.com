<?php /* Template Name: Blog */ get_header(); ?>

	<main role="main" class="container">
		<!-- section -->
		<section class="theme-section">

			<h1 class="theme-section-h1"><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>

			<?php get_template_part('template-parts/loop'); ?>

			<?php //get_template_part('template-parts/pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
