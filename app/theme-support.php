<?php



function kanderr_logo() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    $logo = '<img src="'.$image[0].'" alt="Logo" class="logo-img">';

    return $logo;
}

function kanderr_header() {
    if(is_single() && has_post_thumbnail()) {
        $header = '<img src="'.get_the_post_thumbnail_url().'">';
    } else {
        $header = '<img src="'.get_header_image().'">';
    }

    return $header;
}

function kanderr_carousel() {

    $i = 0;
    $carouselInner = '<div class="carousel-inner">';

    $args = array(
        'numberposts'	=> -1,
        'post_type'		=> 'film',
    );

    $loop = new WP_Query($args);

    if($loop->have_posts()):
        while($loop->have_posts()):
            $loop->the_post();

            if(have_rows('carousel')):
                while(have_rows('carousel')): the_row();

                $detect = new Mobile_Detect;

                if(get_sub_field('carousel_condition') == true && get_sub_field('carousel_segment') !== '' && get_sub_field('carousel_segment_fallback') !== '') {

                    if($i == 0) {
                        $carouselInner .= '<div class="carousel-item active">';
                    } else {
                        $carouselInner .= '<div class="carousel-item">';
                    }

                    $carouselInner .= '<div class="view view-kanderr-fallback">';
                    $carouselInner .= '<img src="'.get_sub_field('carousel_segment_fallback').'">';
                    $carouselInner .= '</div>';

                    $carouselInner .= '<div class="view view-kanderr">';

                    if (!$detect->isiOS()) {
                        $carouselInner .= '<video id="video-'.$i.'" class="video-fluid" autoplay loop muted>';
                        $carouselInner .= '<source src="'.get_sub_field('carousel_segment').'" type="video/mp4">';
                        $carouselInner .= '</video>';
                    }

                    $carouselInner .= '</div></div>';

                    $i++;

                }


            endwhile;
        endif;

    endwhile;
endif;

$carouselInner .= '</div>';

echo '<span class="hide index" data-index="'.$i.'"></span>';
echo $carouselInner;

}

function kanderr_carousel_captions() {
    $i = 0;
    $carouselCaption = '';

    $args = array(
        'numberposts'	=> -1,
        'post_type'		=> 'film',
    );

    $loop = new WP_Query($args);

    if($loop->have_posts()):
        while($loop->have_posts()):
            $loop->the_post();

            if(have_rows('carousel')):
                while(have_rows('carousel')): the_row();

                if(get_sub_field('carousel_condition') == true && get_sub_field('carousel_segment') !== '') {

                    $carouselCaption .= '<div class="carousel-caption no-padding" id="caption-'.$i.'">';
                    $carouselCaption .= '<div class="animated fadeInDown">';
                    $carouselCaption .= '<h3 class="h3-responsive">'.get_the_title().'</h3>';
                    $carouselCaption .= '<p class="carousel-caption-director">a film by '.get_field('director').'</p>';
                    $carouselCaption .= '<p class="carousel-caption-excerpt">'.kanderr_excerpt('kanderr_carousel_excerpt').'</p>';
                    $carouselCaption .= '<button class="kanderr-btn mt-5" onclick="window.location.href=&#39;'.get_the_permalink().'&#39;">WATCH TRAILER</button>';
                    $carouselCaption .= '</div></div>';

                    $i++;

                }


            endwhile;
        endif;


    endwhile;
endif;

echo $carouselCaption;
}

function kanderr_carousel_indicators() {

    $i = 0;
    $carouselIndicators = '<ol class="carousel-indicators">';

    $args = array(
        'numberposts'	=> -1,
        'post_type'		=> 'film',
    );

    $loop = new WP_Query($args);

    if($loop->have_posts()):
        while($loop->have_posts()):
            $loop->the_post();

            if(have_rows('carousel')):
                while(have_rows('carousel')): the_row();

                if(get_sub_field('carousel_condition') == true && get_sub_field('carousel_segment') !== '') {

                    if($i == 0) {
                        $carouselIndicators .= '<li id="indicator-'.$i.'" data-target="#video-carousel" data-slide-to="'.$i.'" class="active"></li>';
                    } else {
                        $carouselIndicators .= '<li id="indicator-'.$i.'" data-target="#video-carousel" data-slide-to="'.$i.'"></li>';
                    }

                    $i++;

                }

            endwhile;
        endif;



    endwhile;
endif;

$carouselIndicators .= '</ol>';

echo $carouselIndicators;

}

function kanderr_get_embedded_media($type = array())
{
    $content = do_shortcode(apply_filters('the_content', get_the_content()));
    $embed = get_media_embedded_in_content($content, $type);
    if (in_array('audio', $type)) :
        $output = str_replace('?visual=true', '?visual=false', $embed[0]); else:
        $output = $embed[0];
    endif;
    return $output;
}

function kanderr_carousel_excerpt($length)
{
    return 15;
}

function kanderr_recent_films_excerpt($length)
{
    return 20;
}

// Create the Custom Excerpts callback
function kanderr_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    } else {
        add_filter('excerpt_more', function() {
            return '...';
        });
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    return $output;
}

function kanderr_recent_films() {
    $args = array(
        'post_type' => 'film',
        'numberposts' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    $loop = new WP_Query($args);
    if ($loop->have_posts()):
        while ($loop->have_posts()):
            $loop->the_post();
            ?>
            <div class="recent-film" id="recent-film-<?php the_ID(); ?>" data-aos="fade-up">
                <?php if (has_post_thumbnail()): ?>
                    <div class="recent-film-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <div class="recent-film-overlay">
                        <h4><?php the_title(); ?></h4>
                        <span class="recent-film-excerpt"><?php echo kanderr_excerpt('kanderr_recent_films_excerpt'); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        endwhile;
    endif;

    wp_reset_postdata();
}

function kanderr_team() {
    $args = array(
        'post_type' => 'team',
    );

    $loop = new WP_Query($args);
    if ($loop->have_posts()):
        while ($loop->have_posts()):
            $loop->the_post();
            ?>
            <div class="team-member" data-aos="fade-up" id="">
                <div class="team-member-container"><img src="<?php the_post_thumbnail(); ?>"></div>
                <div class="team-member-overlay">
                    <div class="team-member-meta">
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <div class="team-member-role">
                             <?php the_tags( '', ' / ', '' ); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
    endif;

    wp_reset_postdata();
}

?>
