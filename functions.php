<?php

    // TODO: Clean up and reorganise files

    // Show errors, without needing to change wp-config.php
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');


    // Dirty pre function with limited height and randomnlt changing border colours
    function pre($var, $fixed_height = true) {
        $height = ($fixed_height) ? 'max-height: 300px;' : '';
        echo '<pre style="background: #fcffb1; text-align: left; outline: 4px solid rgb('. rand(0, 250) .','. rand(0, 250) .','. rand(0, 250) .'); width: 100%; overflow: auto; '. $height .'">';
            if ($var) :
                print_r($var);
            else :
                echo "\n\n\t--- <b>No data recieved by pre() function</b> ---\n\n";
            endif;
        echo '</pre>';
    }


    // Add post formats & meta boxes
    add_action('after_setup_theme', 'childtheme_formats', 11);
    function childtheme_formats(){
         add_theme_support('post-formats', array(
            'aside',
            'link'
        ));
    }
    require_once "admin/formats-meta.php";


    // Make [gallery] shortcode use large images
    function pad2013_gallery_atts( $atts ) {
        if (has_post_format( 'gallery')) :
            $atts['size'] = 'large';
        endif;
        return $atts;
    }
    add_filter('shortcode_atts_gallery', 'pad2013_gallery_atts' );


    // Remove width & height from [gallery] images
    add_filter('wp_get_attachment_link', 'remove_img_width_height', 10, 1);
    function remove_img_width_height($html) {
        $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
        return $html;
    }


    // Remove default styling from [gallery]
    add_filter('use_default_gallery_style', '__return_false');


    // Add fancybox class to [gallery] images
    add_filter('wp_get_attachment_link', 'add_gallery_id_rel');
    function add_gallery_id_rel($link) {
        global $post;
        return str_replace('<a href', '<a class="fancybox" rel="group-'. $post->ID .'" href', $link);
    }


    // Remove generator meta tag from head & admin bar
    remove_action('wp_head', 'wp_generator');
    add_filter('show_admin_bar', '__return_false');


    // Support featured image & menues
    add_theme_support('post-thumbnails');
    add_theme_support('menus');


    // Disable default theme updates from V3.0
    remove_action( 'load-update-core.php', 'wp_update_themes' );
    add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );


    // Remove default CSS block from [gallery]
    // add_filter( 'use_default_gallery_style', '__return_false' );


    // Remove width & height from gallery shortcode
    // add_filter('wp_get_attachment_link', 'remove_img_width_height', 10, 1);
    // function remove_img_width_height($html) {
    //     $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    //     return $html;
    // }


    // If page needs pagination nav, return true
    function show_posts_nav() {
    	global $wp_query;
    	return ($wp_query->max_num_pages > 1);
    }

    // Modifies the default [...] to say something a little more useful.
    function new_excerpt_more($more) {
        global $post;
        return '&nbsp;<a href="'. get_permalink($post->ID) . '">' . 'Read more' . '</a>';
    }
    add_filter('excerpt_more', 'new_excerpt_more');


    // Alter time between RSS refreshes
    add_filter('wp_feed_cache_transient_lifetime', create_function('$a', 'return 1800;'));


	// Get the contet by ID
	function get_the_content_by_id($gcbid) {
	    $my_postid = $gcbid;//This is page id or post id
	    $content_post = get_post($my_postid);
	    $content = $content_post->post_content;
	    $content = apply_filters('the_content', $content);
	    $content = str_replace(']]>', ']]>', $content);
	    return $content;
	}

	// Trim string my whole words
	function trimWords($string, $count, $ellipsis = false){
	    $words = explode(' ', $string);
	    if (count($words) > $count){
	        array_splice($words, $count);
	        $string = implode(' ', $words);
	        if (is_string($ellipsis)){
	            $string .= $ellipsis;
	        } elseif ($ellipsis){
	            $string .= 'âFFFD¦';
	        }
	    }
	    return $string;
	}


	// Time ago
	function _ago($tm,$rcs = 0) {
		$cur_tm = time(); $dif = $cur_tm-$tm;
		$pds = array('second','minute','hour','day','week','month','year','decade');
		$lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
		for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
		$no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
		if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
		return $x;
	}


    // Change number of posts in archive & search results
    function change_wp_archive_size($query) {
        if ($query->is_archive || $query->is_search) : // Make sure it is a search page
            $query->query_vars['posts_per_page'] = 1000; // Change 10 to the number of posts you would like to show
        endif;
        return $query; // Return our modified query variables
    }
    add_filter('pre_get_posts', 'change_wp_archive_size'); // Hook our custom function onto the request filter


    // Make search use /search/whatever instead of ?s=whatever
    function search_url_rewrite(){
        if(is_search() && !empty($_GET['s'])){
                wp_redirect(home_url("/search/"). urlencode(get_query_var('s')));
                exit();
        }
    }
    add_action('template_redirect', 'search_url_rewrite');


    // Comment template
    function pad_2013_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
        ?>
        <li class="post pingback">
            <p>Pingback: <?php comment_author_link(); ?><?php edit_comment_link('Edit', '<span class="edit-link">', '</span>'); ?></p>
        <?php
                break;
            default :
        ?>

        <li class="comment-item depth_<?php echo $depth; ?>" id="li-comment-<?php comment_ID(); ?>">
            <article id="comment-<?php comment_ID(); ?>" class="comment">

                <div class="left">
    				<?php comment_author_link() ?> <a href="#comment-<?php comment_id(); ?>" class="comment_hash">#</a>
    				<span><?php comment_date('F jS, Y') ?> at <?php comment_time() ?></span>
    				<?php echo get_avatar($comment, 30); ?>
    			</div>
    			<div class="right">
    				<?php if ($comment->comment_approved == '0') : ?>
    					<span class="red">Your comment is awaiting moderation, <?php comment_author(); ?>.</span><br>
    				<?php endif; ?>
    				<?php comment_text() ?>
    				<div class="reply reply_link">
                        <?php comment_reply_link(
                            array_merge(
                                $args,
                                array(
                                    'reply_text' => 'Reply',
                                    'depth' => $depth,
                                    'max_depth' => $args['max_depth']
                                )
                            )
                        ); ?>
                    </div><!-- .reply -->
    			</div>

                <div class="clear"></div>

            </article><!-- #comment-## -->

        <?php
                break;
        endswitch;
    } // end pad_2013_comment()


    function convert_number_to_words($number, $alt) {

        $alt = ($alt) ? $alt : false;

        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        if ($alt == 'capitalize') {
            $string = ucwords($string);
        }

        return $string;
    } // end convert_number_to_words()