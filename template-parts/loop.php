<?php if (have_posts()): ?>

	<div class="loop-container">

	<?php while (have_posts()) : the_post(); ?>

		<?php get_template_part('template-parts/content', get_post_type()); ?>

	<?php endwhile; ?>

	</div>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
