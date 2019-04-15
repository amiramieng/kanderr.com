<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class(array('single', 'single-film')); ?>>

    <!-- post title -->
    <h1 class="single-title">
        <?php the_title(); ?>
    </h1>
    <!-- /post title -->

    <div class="single-content">
        <?php the_content(); // Dynamic Content ?>
    </div>

    <?php edit_post_link(); // Always handy to have Edit Post Links available ?>

    <?php comments_template(); ?>

</article>
<!-- /article -->
