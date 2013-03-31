<?php
    $content_length = (is_archive()) ? 70 : 90;
?>
<article <?php post_class() ?>>
    <header>
        <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
        <time datetime="<?php the_time(DATE_W3C) ?>" pubdate>Posted on <span><a href="/blog/<?php the_time('Y/n') ?>/"><?php the_time('F') ?></a> <?php the_time('jS') ?>, <a href="/blog/<?php the_time('Y') ?>/"><?php the_time('Y') ?></a></a></span></time>
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
    <p><?php echo trimWords(strip_tags(get_the_content_by_id(get_the_id())), $content_length); ?>&hellip; <a href="<?php the_permalink(); ?>">Continue reading</a></p>
</article>