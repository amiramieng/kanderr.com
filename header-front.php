<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title(''); ?><?php if (wp_title('', false)) {
        echo ' :';
    } ?> <?php bloginfo('name'); ?></title>

    <link href="//www.google-analytics.com" rel="dns-prefetch">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">

    <?php wp_head(); ?>
    <script>
    // conditionizr.com
    // configure environment tests
    conditionizr.config({
        assets: '<?php echo get_template_directory_uri(); ?>',
        tests: {}
    });
    </script>

</head>

<body <?php body_class(); ?> <?php kanderrFrontPage(); ?>>

    <div id="preloader" class="d-none">
        <div class="preloader-container">
            <img id="preloader-img-1" class="d-none" src="<?php echo get_template_directory_uri(); ?>/img/preloader-img-1.png">
            <img id="preloader-img-2" class="d-none" src="<?php echo get_template_directory_uri(); ?>/img/preloader-img-2.png">
            <img id="preloader-logo" src="<?php echo get_template_directory_uri(); ?>/img/preloader-logo.png">
        </div>
    </div>

    <div id="video-carousel" class="carousel slide carousel-fade" data-ride="carousel">

        <?php kanderr_carousel(); ?>

    </div>

    <!-- header -->
    <header class="header header-front clear" role="banner">

        <div class="navbar-container">
            <!-- nav -->
            <nav class="navbar container" role="navigation">
                <input type="checkbox" id="nav" class="d-none">
                <label for="nav" class="nav-toggler">
                    <i></i>
                    <i></i>
                    <i></i>
                </label>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location'  => 'header-menu',
                        'menu'            => '',
                        'container'       => 'div',
                        'container_class' => 'header-menu',
                        'container_id'    => '',
                        'menu_class'      => 'menu',
                        'menu_id'         => '',
                        'echo'            => true,
                        'link_before'     => '<span class="text">',
                        'link_after'      => '</span>
                                            <span class="line -top"></span>
                                            <span class="line -bottom"></span>',
                    )
                );
                ?>
                <div class="logo">
                    <a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" class="shadowed" alt="<?php echo bloginfo('name'); ?>"></a>
                </div>
            </nav>
            <!-- /nav -->
        </div>

        <div class="kanderr-captions-container">
            <div class="container kanderr-captions">
                <div id="carousel-captions">
                    <?php kanderr_carousel_captions(); ?>
                </div>
            </div>
        </div>

        <?php kanderr_carousel_indicators(); ?>

        <a class="carousel-control-prev" href="#video-carousel" role="button" data-slide="prev">
            <span class="fas fa-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#video-carousel" role="button" data-slide="next">
            <span class="fas fa-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

    </header>
    <!-- /header -->
