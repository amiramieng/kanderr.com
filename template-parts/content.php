<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class(array('content', 'col-md-4', 'col-lg-3')); ?>>

    <div class="content-thumb">
        <?php if(has_post_thumbnail()): ?>
            <?php the_post_thumbnail(); ?>
        <?php endif; ?>
    </div>

    <div class="content-overlay">
        <!-- post title -->
        <h1 class="content-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h1>
        <!-- /post title -->

        <div class="content-excerpt">
            <?php echo kanderr_excerpt('kanderr_recent_films_excerpt'); ?>
        </div>

        <div class="content-meta">
            <!-- post details -->
            <span class="date"><?php the_time('F j, Y'); ?> / <?php the_time('g:i a'); ?></span>
            <!-- /post details -->
        </div>

    </div>

</article>
<!-- /article -->
