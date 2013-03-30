<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h1><?php the_title(); ?></h1>
			<?php
		        // Declare some helper vars
		        $previous_year = $year = 0;
		        $previous_month = $month = 0;
		        $ul_open = false;

		        // Get the posts
		        $myposts = get_posts('numberposts=-1&orderby=post_date&order=DESC');
		    ?>
		    <?php foreach($myposts as $post) : ?>
		        <?php
		            setup_postdata($post);
		            $year = mysql2date('Y', $post->post_date);
		            $month = mysql2date('n', $post->post_date);
		            $day = mysql2date('j', $post->post_date);
		        ?>
		        <?php if($year != $previous_year || $month != $previous_month) : ?>
		            <?php if($ul_open == true) : ?>
		                </ul>
		            <?php endif; ?>
		            <b><?php the_time('F Y'); ?></b>
		            <ul class="month_archive">
		                <?php $ul_open = true; ?>
		            <?php endif; ?>
		            <?php $previous_year = $year; $previous_month = $month; ?>
		                <li class="<?php $category = get_the_category(); echo $category[0]->slug; ?>_color"><?php the_time('j'); ?><sup><?php the_time('S'); ?></sup> &ndash; <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		        <?php endforeach; ?>
		    </ul>
		</article>
	<?php endwhile; endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>