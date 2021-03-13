<?php
$_OPT['title'] =  $data['one_news']['title']." - Вестник Эриандора - ".$_OPT['sub-title'];
?>
<script>
top_menu('news');
</script>
	<div class="container">
		<div class="panel panel-default panel-body">
		<h1><?=$data['one_news']['title'];?> - Вестник Эриандора</h1>
		<hr>
		<div class="panel panel-default">
			<div class="panel-heading"><?=$data['one_news']['title'];?></div>
			<div class="panel-body"><?=$data['one_news']['text'];?></div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-3">
						Автор: <b><?php
						$author_id = $data['one_news']['author'];
						$db->Query("SELECT `login` FROM `accounts` WHERE `id` = {$author_id}");
						$author_all = $db->FetchArray();
						echo $author_all['login'];
						?></b>
					</div>
					<div class="col-sm-6">
						Дата публикации: <?php
						echo date("j.m.Y", $data['one_news']['date'])." г.";
						?>
					</div>
					<div class="col-sm-3">
						<a class="btn btn-danger btn-block" onclick="history.back();return false;">Назад</a>
					</div>
				</div>
			</div>
		</div>	
		</div>
	</div>