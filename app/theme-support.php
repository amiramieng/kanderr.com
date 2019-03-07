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

          if(get_sub_field('carousel_condition') == true && get_sub_field('carousel_segment') !== '') {

            if($i == 0) {
              $carouselInner .= '<div class="carousel-item active">';
            } else {
              $carouselInner .= '<div class="carousel-item">';
            }

            $carouselInner .= '<div class="view view-kanderr">';
            $carouselInner .= '<video id="video-'.$i.'" class="video-fluid" autoplay loop muted>';
            $carouselInner .= '<source src="'.get_sub_field('carousel_segment').'" type="video/mp4">';
            $carouselInner .= '</video></div></div>';

          }

        endwhile;
      endif;

        $i++;

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
            $carouselCaption .= '<p>a film by '.get_field('director').'</p>';
						$carouselCaption .= '<p>'.get_the_excerpt().'</p>';
            $carouselCaption .= '<button class="kanderr-btn mt-5" onclick="window.location.href=&#39;'.get_the_permalink().'&#39;">WATCH TRAILER</button>';
						$carouselCaption .= '</div></div>';

          }

        endwhile;
      endif;

        $i++;

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

          }

        endwhile;
      endif;

        $i++;

    endwhile;
  endif;

  $carouselIndicators .= '</ol>';

  echo $carouselIndicators;

}

?>