<?php
$_OPT['title'] =  "Вестник Эриандора - ".$_OPT['sub-title'];
?>
<script>
top_menu('news');
</script>
	<div class="container">
		<div class="panel panel-default panel-body">
		<h1>Вестник Эриандора</h1>
		<hr>
		<?php
		if(isset($data['err'])){
			echo "<h2>Новостей нет</h2>";
		}
		if(isset($data['news'])){
			foreach ($data['news'] as $news){
				if(isset($news['id'])){
		?>
		<div class="panel panel-default">
			<div class="panel-heading"><?=$news['title'];?></div>
			<div class="panel-body"><?=$news['preview'];?></div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-3">
						Автор: <b><?php
						$author_id = $news['author'];
						$db->Query("SELECT `login` FROM `accounts` WHERE `id` = {$author_id}");
						$author_all = $db->FetchArray();
						echo $author_all['login'];
						?></b>
					</div>
					<div class="col-sm-6">
						Дата публикации: <?php
						echo date("j.m.Y", $news['date'])." г.";
						?>
					</div>
					<div class="col-sm-3">
						<a class="btn btn-info btn-block" href="/news?id=<?=$news['id'];?>">Подробнее</a>
					</div>
				</div>
			</div>
		</div>	
		<?php
				}
			}
		}
		?>
		</div>
	</div>