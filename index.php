<?php

	// Данные для БД нужно заменить тут, load_comments.php, delete_comment.php и send_comment.php

	require 'redbean.php';
	R::setup('mysql:host=localhost;dbname=exportbase', 'mysql', 'mysql');

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<title>Пост + комментарии</title>
	</head>
	<body style="background: #d4d4d4;">
		<div style="float: left; background: white; margin-left: 5%; margin-right: 5%; margin-top: 1%;">
			<div style="float: left;">
				<div style="float: left; width: 50%;">
					<img src="img.jpg" style="width: 100%; padding: 2%;">
				</div>
				<div style="float: right; width: 48%;">
					<h1 style="padding: 0 2%;">Факты о Швейцарии</h1>
					<p style="padding: 0 2%;">Швейцария расположена на стыке западной, центральной и южной Европы, не имеет выхода к морю и граничит с Италией на юге, Францией на западе, Германией на севере и Австрией и Лихтенштейном на востоке. Страна географически разделена между Альпами, швейцарским плато и Юрой, охватив общую площадь 41 285 км². В то время как Альпы занимают большую часть территории, население Швейцарии численностью примерно 8,5 млн человек в основном сосредоточено на плато, где расположены крупнейшие города, в том числе два глобальных — Цюрих и Женева.</p>
					<p style="padding: 0 2%;">Швейцария находится на перекрёстке германской и романской Европы и имеет четыре основных языковых и культурных региона: немецкий, французский, итальянский и романшский. Хотя большинство населения — немецкоязычное, швейцарское национальное самосознание уходит корнями в общий исторический опыт, общие ценности: федерализм, прямая демократия и альпийская символика. Из-за своего многоязычия Швейцария известна под разными названиями: Schweiz (в немецком языке); Suisse (французском); Svizzera (итальянском); и Svizra (романшском), однако на швейцарских монетах и марках вместо четырёх национальных языков используется латинское название страны: Confoederatio Helvetica, часто сокращённое до «Helvetia».</p>
					<p style="padding: 0 2%;">Швейцария — одна из самых развитых стран мира, с самым высоким номинальным богатством взрослого населения и восьмым по величине ВВП на душу населения. Она занимает передовые места по ряду международных показателей, включая экономическую конкурентоспособность и развитие человеческого потенциала. Цюрих, Женева и Базель вошли в десятку лучших городов мира по качеству жизни, при этом Цюрих занял второе место.</p>
				</div>
			</div>
		</div>
		<hr>
		<div style="float: left; background: white; margin-left: 5%; margin-top: 1%; width: 44%;">
			<div style="float: left; margin-left: 2%;">
				<h2>Написать комментарий</h2>
				<form method="POST" id="comment-form">
					<p><input type="text" name="user_name" placeholder="Имя" required></p>
					<p><textarea placeholder="Напишите комментарий..." name="user_comment" required></textarea></p>
					<p>
						<input type="text" name="captcha" size="25" required>
						<input type="submit" name="send_comment" value="Добавить">
					</p>
				</form>
			</div>
		</div>
		<div style="float: right; background: white; margin-right: 5%; margin-top: 1%; width: 44%;">
			<div style="float: left; margin-left: 2%; width: 90%;" id="comments_area">
				<h2>Все комментарии</h2>
				<div></div> <!-- комментарии подгружаются в этот див -->
			</div>
		</div>
		<script type="text/javascript">
			var first_num; var second_num; var answer;

			// функция загрузки комментариев
			function load_comments() {
				$('#comments_area div').html('');
				$.post('/load_comments.php', {}, function(data) {
					$('#comments_area div').html(data);
				});

				first_num = Math.floor(Math.random() * (20 - 1 + 1)) + 1;
				second_num = Math.floor(Math.random() * (20 - 1 + 1)) + 1;
				answer = first_num + second_num;
				$('input[name="captcha"]').attr('placeholder', 'Сколько будет ' + first_num + '+' + second_num + '? (капча)');
			}

			// загружаем комментарии при запуске
			$(document).ready(function() {
				load_comments();
			});

			// при нажатии на кнопку "добавить" проверяем капчу, добавляем комментарий в БД и обновляем блок комментариев - асинхронно
			$('#comment-form').on('submit', function(e) {
				e.preventDefault();
				var user_name = $('input[name="user_name"]').val();
				var user_comment = $('textarea[name="user_comment"]').val();
				if( $('input[name="captcha"]').val() == answer ) {
					$('input[name="user_name"]').val('');
					$('textarea[name="user_comment"]').val('');
					$('input[name="captcha"]').val('');
					$.post('/send_comment.php', {user_name: user_name, user_comment: user_comment}, function(data) {
						alert(data);
						load_comments();
					});
				} else {
					alert('Капча введена неверно!');
					alert(answer);
				}
			});
		</script>
	</body>
</html>