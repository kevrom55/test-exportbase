<?php

	require 'redbean.php';
	R::setup('mysql:host=localhost;dbname=exportbase', 'mysql', 'mysql');

	// циклом выводим комментарии, от свежого к старому
	$query_conditions = R::findAll('comments', 'ORDER BY id DESC');
	foreach ($query_conditions as $key => $value) {
		echo '
		<div style="background: #ededed; border-left: 5px solid #c73d28; padding: 1% 2%; width: 100%;" id="' . $value['id'] . '">
			<span><b>' . $value['name'] . '</b></span>&nbsp&nbsp&nbsp' . $value['date'] . '&nbsp&nbsp&nbsp<a href="javascript: void(0)" class="delete_comment">[удалить]</a><br><br>
			<span>' . $value['comment'] . '</span>
		</div><br>';
	}

?>

<script type="text/javascript">
	// при клике на кнопку "удалить" - отправляем ajax-запрос на удаление комментария
	$('.delete_comment').on('click', function() {
		if( confirm('Вы уверены, что хотите удалить комментарий?') ) {
			var comment_id = $(this).closest('div').attr('id');
			$.post('/delete_comment.php', {comment_id: comment_id}, function(data) {
				alert('Комментарий успешно удалён!');
				$('.delete_comment').closest('div[id="' + comment_id + '"]').remove();
			});
		}
	});
</script>