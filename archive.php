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
			while (have_posts()) : the_post();
                get_template_part("_post_list_item");
            endwhile;
        ?>

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