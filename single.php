<?php
	if($post->post_type == 'post')
		include 'single-article.php';
	else if($post->post_type == 'event')
		include 'single-event.php';
	else if($post->post_type == 'casestudy')
		include 'single-article.php';
	else
		header('Location: /not-found/');
?>