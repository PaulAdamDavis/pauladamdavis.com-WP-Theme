<?php get_header(); ?>

	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
				<time datetime="<?php the_time('Y-m-d') ?>" pubdate>Posted on <span><a href="/blog/<?php the_time('Y/n') ?>/"><?php the_time('F') ?></a> <?php the_time('jS') ?>, <a href="/blog/<?php the_time('Y') ?>/"><?php the_time('Y') ?></a></a></span></time>
				<span class="comments"><?php comments_popup_link( 'No comments yet', 'Just one comment', '% comments', '', 'Comments are off for this post'); ?></span>
				<span class="category <?php $category = get_the_category(); echo $category[0]->slug; ?>_color">
				    Posted in <?php
                        $igc = 0;
                        foreach((get_the_category()) as $category) {
                            if ($category->cat_name != 'uncategorized') {
                                if($igc != 0) { echo ', '; };
                                $igc++;
                                echo '<a href="' . get_category_link( $category->term_id ) . '" title="View all posts in '. $category->name .'">' . $category->name.'</a>';
                            }
                        }
                    ?>
                </span>
			</header>
			<?php if (has_post_thumbnail()) { ?>
		        <a href="<?php the_permalink() ?>">
		            <?php
                	    $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(2000, 2000), false, '' );
                        echo '<img style="top: 0px; right: 0px;" class="postThumb" src="'. get_bloginfo("template_url") .'/timthumb.php?src='. $src[0] .'&w=620&q=90&a=t&zc=1" />';
                    ?>
                </a>
            <?php } ?>
			<p><?php echo trimWords(strip_tags(get_the_content_by_id(get_the_id())), 90); ?>&hellip; <a href="<?php the_permalink(); ?>">Continue reading</a></p>
		</article>
	<?php endwhile; ?>

	<?php if (show_posts_nav()) : ?>
		<nav class="nextPrevLinks">
			<div class="alignleft"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
			<div class="alignright"><?php next_posts_link('Older Entries &raquo;','') ?></div>
		</nav>
	<?php endif; ?>

	<?php else : ?>
		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that isn't here.</p>
		<?php get_search_form(); ?>
	<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>