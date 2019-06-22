<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>

    <!-- post title -->
    <h1 class="single-title">
        <?php the_title(); ?>
    </h1>
    <!-- /post title -->

    <div class="single-meta">
        <!-- post details -->
        <span class="date"><?php the_time('F j, Y'); ?> / <?php the_time('g:i a'); ?></span>
        <span class="comments">
            <?php if (comments_open( get_the_ID() ) ):
                echo ' / ';
                comments_popup_link( __( 'Leave your thoughts', 'kanderr-theme' ), __( '1 Comment', 'kanderr-theme' ), __( '% Comments', 'kanderr-theme' ));
            endif;
            ?>
        </span>
        <!-- /post details -->
    </div>

    <div class="single-content clearfix">
        <?php the_content(); // Dynamic Content ?>
    </div>

    <p><?php _e( 'This post was written by ', 'kanderr-theme' ); the_author(); ?></p>

    <?php edit_post_link(); // Always handy to have Edit Post Links available ?>

    <?php comments_template(); ?>

</article>
<!-- /article -->
