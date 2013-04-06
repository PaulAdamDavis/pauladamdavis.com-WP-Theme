</div><!-- end #main -->

<aside id="sidebar">

    <div id="carbonads-container">
        <div class="carbonad">
            <div id="azcarbon"></div>
            <script type="text/javascript">
                var z = document.createElement("script");
                z.type = "text/javascript";
                z.async = true;
                z.src = "http://engine.carbonads.com/z/12728/azcarbon_2_1_0_HORIZ";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(z, s);
            </script>
        </div>
    </div>

	<h1>Paul is a freelance designer, award-winning developer, podcaster, speaker, music lover, drummer and general nerd.</h1>

	<p>He periodically speaks about code &amp; stuff with Tom Ashworth and guests on <a href="http://lessthanbang.com" class="ltb">Less&nbsp;Than&nbsp;Bang</a></p>

	<p>Paul works under the pseudonym <a href="http://codebymonkey.com" class="red">Code&nbsp;By&nbsp;Monkey</a>. Get in touch.</p>
	<p>He is the creator of <a href="http://kodery.com" alt="Kodery">Kodery</a>, an online snippet storage tool for teams. It is used by everyone from lone developers to agency teams.</p>
	<p>Paul lives in <a target="_blank" href="http://maps.google.co.uk/maps?q=Rochester,+United+Kingdom&amp;hl=en&amp;sll=51.38979,0.503732&amp;sspn=0.077983,0.181789&amp;vpsrc=0&amp;hnear=Rochester,+Medway,+United+Kingdom&amp;t=m&amp;z=13" title="Rochester">Rochester</a>, United Kingdom.</p>

	<form method="get" action="/" class="search_box">
		<input type="search" name="s" placeholder="Search&hellip;" />
		<button type="submit">Go</button>
	</form>

	<h3 class="gap_top">Instagram</h3>
	<?php
        /*****
            GET INSTAGRAM DATA
            ---
            NOTE: This API key only works on my domain
        *****/
        $token = '213.f59def8.5df6aa3e1f01400796abe633d3c38db6';
        $userID = 213; // Yep, I was the two hundred and thirteenth user
        $count = 30;
        $url = "https://api.instagram.com/v1/users/self/media/recent?access_token=". $token ."&count=". $count;
        $instagram = get_transient("instagram");
        if (!$instagram) :
            $array = file_get_contents($url);
            $data = $array;
            if ($data) :
                set_transient("instagram", $data, 60 * 60 * 1); // Stored for one hour. 60s X 60m X 1h (don't really need the hour there)
                $instagram = $data;
            endif;
        endif;
        $instagram = json_decode($instagram);
        $i = 0;
        while($i <= ($count-1)) {
            $data = ($instagram) ? $instagram->data[$i] : false;
            if ($data) :
                $thumb = $data->images->thumbnail->url;
                $full = $data->images->standard_resolution->url;
                $caption = (!empty($data->caption)) ? $data->caption->text : '';
                echo '<a rel="instagram" href="'. $full .'"><img class="instagram_thumb" src="'. $thumb .'" /></a>';
            endif;
            $i++;
        }

	?>
	<div class="clear"></div>

	<h3 class="gap_top_bigger">Tweets <a href="http://twitter.com/pauladamdavis">#</a></h3>
	<?php
        /*****
            GET TWEETS
            ---
            TODO: Convert to use API v1.1
        *****/
	    $twitterFeed = 'http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=pauladamdavis';
	    include_once(ABSPATH . WPINC . '/feed.php');
	    $rss = fetch_feed(array(
	        $twitterFeed
	    ));
	    foreach ($rss->get_items(0, 3) as $item):
	        echo '<div class="tweet">';
	            echo '<p>'. linkify_twitter_status(substr(strip_tags($item->get_title()), 15)) .' <span class="opacity">&mdash; <small><a href="'. $item->get_link() .'">'. _ago($item->get_date('U')) .' ago</a></small></span></p>';
	        echo '</div>';
	    endforeach;
	?>

</aside>