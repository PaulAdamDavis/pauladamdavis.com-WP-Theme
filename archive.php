<?php get_header(); ?>

	<?php if (have_posts()) : ?>

    	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    	<?php if (is_category()) { ?>
    	    <h1>Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h1>
    	<?php } elseif( is_tag() ) { ?>
    	    <h1>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h1>
    	<?php } elseif (is_day()) { ?>
    	    <h1>Archive for <?php the_time('F jS, Y'); ?></h1>
    	<?php } elseif (is_month()) { ?>
    	    <h1>Archive for <?php the_time('F, Y'); ?></h1>
    	<?php } elseif (is_year()) { ?>
    	    <h1>Archive for <?php the_time('Y'); ?></h1>
    	<?php } elseif (is_author()) { ?>
    	    <h1>Author Archive</h2>
    	<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    	    <h1>Blog Archives</h1>
    	<?php } ?>

		<?php

			$year = $wp_query->query_vars['year'];
			$month = $wp_query->query_vars['monthnum'];

			while (have_posts()) : the_post(); ?>

			<article <?php post_class() ?>>
				<header>
					<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
					<time datetime="<?php the_time('Y-m-d') ?>" pubdate>Posted on <span><a href="/blog/<?php the_time('Y/n') ?>/"><?php the_time('F') ?></a> <?php the_time('jS') ?>, <a href="/blog/<?php the_time('Y') ?>/"><?php the_time('Y') ?></a></a></span></time>
					<span class="comments"><?php comments_popup_link( 'No comments yet', 'Just one comment', '% comments', '', 'Comments are off for this post'); ?></span>
					<span class="category">
    				    Posted in <?php
                            $igc = 0;
                            foreach((get_the_category()) as $category) {
                                if ($category->cat_name != 'uncategorized') {
                                    if($igc != 0) { echo ', '; };
                                    $igc++;
                                    echo '<a href="' . get_category_link( $category->term_id ) . '" title="View all posts in '. $category->name .'" class="'. $category->slug .'_color">' . $category->name.'</a>';
                                }
                            }
                        ?>
                    </span>
				</header>
				<p><?php echo trimWords(strip_tags(get_the_content_by_id(get_the_id())), 70); ?>&hellip; <a href="<?php the_permalink(); ?>">Continue reading</a></p>
			</article>
		<?php endwhile; ?>

		<?php if (show_posts_nav()) : ?>
			<nav class="nextPrevLinks">
				<div class="alignleft"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
				<div class="alignright"><?php next_posts_link('Older Entries &raquo;','') ?></div>
			</nav>
		<?php endif; ?>


	<?php else :

		if ( is_category() ) {
			printf("<h1>Sorry, but there aren't any posts in the %s category yet.</h1>", single_cat_title('',false));
		} else if ( is_date() ) {
			echo("<h1>Sorry, but there aren't any posts with this date.</h1>");
		} else if ( is_author() ) {
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h1>Sorry, but there aren't any posts by %s yet.</h1>", $userdata->display_name);
		} else {
			echo("<h1>No posts found.</h1>");
		}

	endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>