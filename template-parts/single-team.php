<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class(array('single', 'single-team')); ?>>

    <div class="row">

        <div class="col-md-6">

            <!-- post title -->
            <h1 class="single-title">
                <?php the_title(); ?>
            </h1>
            <!-- /post title -->

            <span class="single-team-tags"><?php the_tags( '', ' / ', ''); // Separated by commas with a line break at the end ?></span>

            <div class="single-content">
                <?php the_content(); // Dynamic Content ?>
            </div>

            <?php edit_post_link(); // Always handy to have Edit Post Links available ?>

        </div>

        <div class="col-md-6">
            <?php the_post_thumbnail(); ?>
        </div>

    </div>

</article>
<!-- /article -->
