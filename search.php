<?php get_header(); ?>

	<?php if (have_posts()) : ?>
		<h1>Search Results</h1>

		<?php while (have_posts()) : the_post();
			get_template_part("_post_list_item");
		endwhile; ?>

	<?php else : ?>
		<h2>No posts found. Try a different search?</h2>
		<?php get_search_form(); ?>
	<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>