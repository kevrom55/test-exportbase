<?php

	require 'redbean.php';
	R::setup('mysql:host=localhost;dbname=exportbase', 'mysql', 'mysql');
	$comment_id = $_POST['comment_id'];

	$deleting_row = R::load('comments', $comment_id);
	R::trash($deleting_row); // удаляем комментарий

?>