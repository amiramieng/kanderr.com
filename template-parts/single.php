<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>

    <!-- post title -->
    <h1 class="single-title">
        <?php the_title(); ?>
    </h1>
    <!-- /post title -->

    <!-- post details -->
    <span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
    <span class="author"><?php _e( 'Published by', 'html5blank' ); ?> <?php the_author_posts_link(); ?></span>
    <span class="comments"><?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'html5blank' ), __( '1 Comment', 'html5blank' ), __( '% Comments', 'html5blank' )); ?></span>
    <!-- /post details -->

    <div class="single-content">
        <?php the_content(); // Dynamic Content ?>
    </div>

    <?php the_tags( __( 'Tags: ', 'html5blank' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>

    <p><?php _e( 'Categorised in: ', 'html5blank' ); the_category(', '); // Separated by commas ?></p>

    <p><?php _e( 'This post was written by ', 'html5blank' ); the_author(); ?></p>

    <?php edit_post_link(); // Always handy to have Edit Post Links available ?>

    <?php comments_template(); ?>

</article>
<!-- /article -->
