<?php get_header(); ?>

	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post();
		get_template_part("_post_list_item");
	endwhile; ?>

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