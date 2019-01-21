<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

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
	<body <?php body_class(); ?>>

		<!-- container-fluid -->
		<div class="container-fluid no-padding">

			<!-- nav -->
			<nav class="navbar header-menu container" role="navigation">
				<?php header_nav(); ?>
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo home_url(); ?>">
						<?php echo kanderr_logo(); ?>
					</a>
				</div>
			</nav>
			<!-- /nav -->

			<!-- nav -->
			<nav class="navbar mobile-menu container-fluid" role="navigation">
				<div class="mobile-menu-toggler">
					<span class="mobile-menu-bar"></span>
					<span class="mobile-menu-bar"></span>
					<span class="mobile-menu-bar"></span>
				</div>
				<?php mobile_nav(); ?>
			</nav>
			<!-- /nav -->

			<?php if(is_front_page()): ?>

				<div id="video-carousel" class="carousel slide" data-ride="carousel">

					<?php kanderr_carousel(); ?>

				</div>

				<!-- header -->
				<header class="header clear" role="banner">

					<div class="container kanderr-captions no-padding">
						<div class="col-xs-12 col-lg-6 float-right kanderr-captions-inner">
							<div id="carousel-captions">
								<?php kanderr_carousel_captions(); ?>
							</div>
						</div>
					</div>

					<?php kanderr_carousel_indicators(); ?>

					<a class="carousel-control-prev" href="#video-carousel" role="button" data-slide="prev">
						<span class="fas fa-caret-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#video-carousel" role="button" data-slide="next">
						<span class="fas fa-caret-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>

				</header>
				<!-- /header -->

			<?php else: ?>

				<div class="header-image">
					<?php echo kanderr_header(); ?>
				</div>

				<header class="header-2 clear" role="banner">

				</header>

			<?php endif; ?>

		</div>
		<!-- /container-fluid -->

		<div class="container-fluid no-padding" id="main">
			<div class="container py-5">
