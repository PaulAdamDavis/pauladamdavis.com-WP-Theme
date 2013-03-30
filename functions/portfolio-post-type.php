<?php

	require_once "class.jw_custom_posts.php";
		
	$portfolioItem = new JW_Post_Type('Portfolio Item', array(
	   'supports' => array('title', 'excerpt', 'thumbnail', 'editor', 'post_tag')
	));
	
	$portfolioItem->add_taxonomy('Difficulty');
	$portfolioItem->add_taxonomy('Language');
	
	$portfolioItem->add_meta_box('Snippet Info', array(
	  'Associated URL' => 'text',
	  'GitHub Link' => 'text',
	  'Additional Notes' => 'textarea',
	  'Original Snippet' => 'checkbox'
	));