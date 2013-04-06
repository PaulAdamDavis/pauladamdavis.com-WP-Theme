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
    <?php if ($_SERVER['HTTP_HOST'] == 'pauladamdavis.com') : ?>
    <script type="text/javascript" src="http://use.typekit.com/pxo6zke.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <?php endif; ?>

    <!-- CSS -->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/css/less.css?1234567" type="text/css" />

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

         <?php

            if (has_post_thumbnail($post->ID)) :
                $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(1200, 600), false, '' );
                $header_image = $src[0];
            else :
                $images = array(
                    'blonc.jpg',
                    'france.jpg',
                    'france_2.jpg',
                    'ilse.jpg'
                );
                $rand_keys = array_rand($images, 1);
                $header_image = get_bloginfo("template_url") . '/images/headers/' . $images[$rand_keys];
            endif;

        ?>

	   <div class="instagram_mosaic" style="background-image: url(<?php echo $header_image; ?>);"></div>

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