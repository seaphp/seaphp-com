<!doctype html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<?php // Google Chrome Frame for IE ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php wp_title( ' | ', true, 'right' ); ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
	<meta name="msapplication-TileColor" content="#f16c00">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="skip-nav" class="skip-nav">
		<a href="#main">Skip to content</a>
		<a href="#sidebar1">Skip to sidebar</a>
		<a href="#footer">Skip to footer</a>
	</div>

	<header class="page-header" role="banner">
		<div id="inner-header" class="wrap clearfix">
			<div id="logo"><a href="<?php echo home_url(); ?>" ><img src="<?php echo get_template_directory_uri() . '/library/images/logo.jpg'; ?>" width="100" alt="<?php bloginfo('name'); ?>"></a></div>
		</div>
	</header>
	<div id="container">

		<nav id="top-nav" role="navigation">
			<?php seaphp_main_nav(); ?>

		<div class="social">
		<?php
			$icons =  [
				'fb' => [
					'filename' => 'Facebook.png',
					'name' => 'Facebook',
					'url' => 'https://www.facebook.com/Seattle-PHP-User-Group-769454953066132/'
				],
				'gh' => [
					'filename' => 'Github.png',
					'name' => 'GitHub',
					'url' => 'https://github.com/seaphp'
				],
				'twitter' => [
					'filename' => 'Twitter-Bird-2.png',
					'name' => 'Twitter',
					'url' => 'http://www.twitter.com/seaphp'
				]
			];

			$dir_uri = get_stylesheet_directory_uri();
			foreach ( $icons AS $id => $d ){
				$icon_url = $dir_uri . '/library/images/72/' . $d['filename'];
				?>
				<a href="<?php echo $d['url']; ?>">
				<img src="<?php echo $icon_url; ?>" alt="<?php echo $d['name']; ?>">
				</a>
				<?php
			}

		?>
		</div>
		</nav>

		<div class="page-content">

