<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post();

        $format = get_post_format($post->ID);
        $link_url = get_post_meta($post->ID, 'link_url', true);

    ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1>
                    <?php
                        if ($format === 'link' && $link_url) :
                            echo '<a href="'. $link_url .'">'. get_the_title() .'</a> <span class="arrow">&#10142;</span>';
                        else :
                            echo get_the_title();
                        endif;
                    ?>
                </h1>
				<time datetime="<?php the_time(DATE_W3C) ?>" pubdate>Posted on <span><a href="/blog/<?php the_time('Y/n') ?>/"><?php the_time('F') ?></a> <?php the_time('jS') ?>, <a href="/blog/<?php the_time('Y') ?>/"><?php the_time('Y') ?></a></a></span></time>
				<span class="comments"><?php comments_popup_link( 'No comments yet', 'Just one comment', '% comments', '', 'Comments are off for this post'); ?></span>
				<?php if (!$format) : ?>
                    <span class="category_link">
    				    Posted in <?php
                            $igc = 0;
                            foreach((get_the_category()) as $category) :
                                if ($category->cat_name != 'uncategorized') :
                                    if($igc != 0) { echo ', '; };
                                    $igc++;
                                    echo '<a href="' . get_category_link( $category->term_id ) . '" title="View all posts in '. $category->name .'" class="'. $category->slug .'_color">' . $category->name.'</a>';
                                endif;
                            endforeach;
                        ?>
                    </span>
                <?php endif; ?>
			</header>
            <?php the_content('<p>Read the rest of this entry &raquo;</p>'); ?>
		</article>

		<div id="comments_box">
			<?php comments_template(); ?>
		</div>

	<?php endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
    <?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>