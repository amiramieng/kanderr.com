<?php get_header(); ?>

<main role="main">
	<!-- section -->
	<section class="container">

		<?php if (have_posts()): ?>

			<?php while (have_posts()) : the_post(); ?>

				<?php get_template_part('template-parts/single', get_post_type()); ?>

			<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h1><?php _e( 'Sorry, nothing to display.', 'kanderr-theme' ); ?></h1>

			</article>
			<!-- /article -->

		<?php endif; ?>

	</section>
	<!-- /section -->
</main>

<?php get_footer(); ?>
