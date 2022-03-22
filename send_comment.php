<?php

	require 'redbean.php';
	R::setup('mysql:host=localhost;dbname=exportbase', 'mysql', 'mysql');
	$user_name = $_POST['user_name'];
	$user_comment = $_POST['user_comment'];

	// добавляем комментарий
	$this_row = R::dispense('comments');
	$this_row->name = $user_name;
	$this_row->comment = $user_comment;
	$this_row->date = date("d.m.Y H:i");
	if( R::store($this_row) ) {
		echo 'Ваш комментарий успешно добавлен!';
	} else {
		echo 'Что-то пошло не так, попробуйте немного позже.';
	}

?>