<?php
    $content_length = (is_archive()) ? 70 : 90;
    $format = get_post_format($post->ID);
    $link_url = get_post_meta($post->ID, 'link_url', true);
?>
<article <?php post_class() ?>>
    <header>

        <?php
            if ($format === 'link' && $link_url) :
                echo '<h1><a class="grey" href="'. $link_url .'">'. get_the_title() .' &#10142;</a></h1>';
            elseif ($format === 'aside') :
                    echo '<h1>'. get_the_title() .'</h1>';
            else :
                echo '<h1><a href="'. get_permalink() .'">'. get_the_title() .'</a></h1>';
            endif;
        ?>

        <time datetime="<?php the_time(DATE_W3C) ?>" pubdate>Posted on <span><a href="/blog/<?php the_time('Y/n') ?>/"><?php the_time('F') ?></a> <?php the_time('jS') ?>, <a href="/blog/<?php the_time('Y') ?>/"><?php the_time('Y') ?></a></a></span></time>
        <span class="comments"><?php comments_popup_link( 'No comments yet', 'Just one comment', '% comments', '', 'Comments are off for this post'); ?></span>
        <?php if (!$format) : ?>
            <span class="category_link">
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
        <?php else : ?>
        <span class="category_link">
            <a href="<?php the_permalink(); ?>">#</a>
        </a>
        <?php endif; ?>
    </header>
    <?php
        if ($format === 'link' || $format === 'aside') :
            the_content();
        else :
            echo '<p>'.trimWords(strip_tags(get_the_content_by_id(get_the_id())), $content_length).'&hellip; <a href="'. get_permalink() .'">Continue reading</a></p>';
        endif;
    ?>
</article>