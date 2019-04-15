<?php /* Template Name: News */ get_header(); ?>

<?php query_posts('post_type=post&cat=news'); ?>

	<main role="main" class="container">
		<!-- section -->
		<section>

			<h1><?php _e( 'News', 'kanderr-theme' ); ?></h1>

			<?php get_template_part('template-parts/loop'); ?>

			<?php //get_template_part('template-parts/pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
