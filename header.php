<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <!-- Meta Tags & Browser Stuff -->
    <meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" />
    <title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>

    <!-- RSS Feed -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo("name") ?>" href="<?php bloginfo("url") ?>/feed/" />

    <!-- Make the HTML5 elements work in IE. -->
    <!--[if IE]>
    <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/respond.js"></script>
    <![endif]-->

    <!-- Typekit // Only works on pauladamdavis.com -->
    <script type="text/javascript" src="http://use.typekit.com/pxo6zke.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

    <!-- CSS -->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/css/less.css" type="text/css" />

	<!-- The small mountain of stuff WP puts in -->
    <?php wp_head(); ?>

	<?php if (!is_user_logged_in()) : ?>
	<script>
        // Analytics
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-20924453-1']);
        _gaq.push(['_trackPageview']);
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <?php endif; ?>

    <?php
        if (is_singular() && get_option('thread_comments')) :
            wp_enqueue_script('comment-reply');
        endif;
    ?>

</head>
<body <?php body_class(); ?>>

	<header id="header">

	   <div class="instagram_mosaic"></div>

	    <a id="logo" href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
	    <small>Designer – developer – music lover – speaker – freelancer</small>
		<nav>
			<ul>
				<?php wp_nav_menu(array(
				    'sort_column' => 'menu_order',
				    'container_class' => 'menu-header',
				    'menu' => 'Header',
				    'container' => '',
				    'items_wrap' => '%3$s'
				)); ?>
			</ul>
		</nav>
	</header>

	<div class="wrapper">

	<div id="main">