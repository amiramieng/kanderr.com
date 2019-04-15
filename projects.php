<?php /* Template Name: Projects */ get_header(); ?>

<?php query_posts('post_type=film&cat=project'); ?>

	<main role="main" class="container">
		<!-- section -->
		<section class="theme-section">

			<h1 class="theme-section-h1"><?php _e( 'Projects', 'kanderr-theme' ); ?></h1>

			<?php get_template_part('template-parts/loop'); ?>

			<?php //get_template_part('template-parts/pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
