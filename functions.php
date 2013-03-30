<?php

	// error_reporting(E_ALL);
	// ini_set('display_errors', '1');

    // Remove generator meta tag from head
    remove_action('wp_head', 'wp_generator');

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

    // Hide Admin Bar in WP 3.1
    add_filter('show_admin_bar', '__return_false');


    // If page is publiched
    // http://app.kodery.com/s/35
    function is_published($id) {
        $page_data = get_page($id);
        if($page_data->post_status == 'publish') :
            return true;
        else :
            return false;
        endif;
    }

    // Alter time between RSS refreshes
    add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );

    // Support featured image
    add_theme_support('post-thumbnails');

    // Support menus
    add_theme_support('menus');

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

	// Linky tweet sting - http://davidwalsh.name/linkify-twitter-feed
	function linkify_twitter_status($status_text) {  // linkify URLs
	  $status_text = preg_replace(
	    '/(https?:\/\/\S+)/',
	    '<a href="\1">\1</a>',
	    $status_text
	  );

	  // linkify twitter users
	  $status_text = preg_replace(
	    '/(^|\s)@(\w+)/',
	    '\1@<a href="http://twitter.com/\2">\2</a>',
	    $status_text
	  );

	  // linkify tags
	  $status_text = preg_replace(
	    '/(^|\s)#(\w+)/',
	    '\1#<a href="http://search.twitter.com/search?q=%23\2">\2</a>',
	    $status_text
	  );

	  return $status_text;
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

	// Disable default theme updates from V3.0
    remove_action( 'load-update-core.php', 'wp_update_themes' );
    add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );




    // Change number of posts in search results
    function change_wp_archive_size($query) {
        if ($query->is_archive) : // Make sure it is a search page
            $query->query_vars['posts_per_page'] = 1000; // Change 10 to the number of posts you would like to show
        endif;
        return $query; // Return our modified query variables
    }
    add_filter('pre_get_posts', 'change_wp_archive_size'); // Hook our custom function onto the request filter





	if (!function_exists('twentyeleven_comment')) :
    function twentyeleven_comment($comment, $args, $depth) {
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
                    <!-- img alt="" src="<?php bloginfo("template_url"); ?>/images/gravatar.jpg" class="avatar avatar-30 photo" height="30" width="30" -->
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
    }
    endif; // ends check for twentyeleven_comment()


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
    }



    function change_wp_search_size($query) {
        if ($query->is_search) :
            $query->query_vars['posts_per_page'] = 1000;
        endif;
        return $query;
    }
    add_filter('pre_get_posts', 'change_wp_search_size');

    function search_url_rewrite(){
        if(is_search() && !empty($_GET['s'])){
                wp_redirect(home_url("/search/"). urlencode(get_query_var('s')));
                exit();
        }
    }
    add_action('template_redirect', 'search_url_rewrite');






    add_action('comment_post', 'ajaxify_comments',20, 2);
    function ajaxify_comments($comment_ID, $comment_status){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        //If AJAX Request Then
            switch($comment_status){
                case '0':
                    //notify moderator of unapproved comment
                    wp_notify_moderator($comment_ID);
                case '1': //Approved comment
                    echo "success";
                    $commentdata=&get_comment($comment_ID, ARRAY_A);
                    $post=&get_post($commentdata['comment_post_ID']);
                    wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
                break;
                default:
                    echo "error";
            }
            exit;
        }
    }