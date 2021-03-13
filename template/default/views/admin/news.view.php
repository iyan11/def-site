<?php
$_OPT['title'] =  "Новости - Админ панель - ".$_OPT['sub-title'];
?>
<script src="../ckeditor/ckeditor.js"></script>
<div class="row panel panel-default panel-body">
<div class="col-sm-3">
	<?php require_once "template/".$_OPT['style']."/inc/admin_menu.php";?>
</div>
<div class="col-sm-9">
<script>
top_menu('admin');
admin_menu('a_news');

function del_id(id,title){
	$('#modal_news_title_del').text(title);
	$('#modal_news_href_del').attr('href','/admin/news?del_news_id=' + id);
}

</script>

<?php
	if(isset($data['add_news_success'])){
		if($data['add_news_success'] == 1){
		?>
		<div class="alert alert-success">Новость успешно размещена<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
		<?php
		}
	}
	if(isset($data['del_news_success'])){
		if($data['del_news_success'] == 1){
		?>
		<div class="alert alert-success">Новость успешно удалена<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
		<?php
		}
	}
	if(isset($data['err_edit_news'])){
		if($data['err_edit_news'] == 1){
		?>
		<div class="alert alert-danger">Ошибка удаления новости<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
		<?php
		}
	}
	if(isset($data['success_edit_news'])){
		if($data['success_edit_news'] == 1){
		?>
		<div class="alert alert-success">Новость успешно изменена<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
		<?php
		}
	}
?>
	<!-- Nav tabs -->
<ul class="nav nav-tabs" id="news_menu">
  <li><a href="#add_news" data-toggle="tab"><?php
											if(isset($data['edit_news_data']) && isset($_GET['edit_news_id'])) echo "Редактировать новость - ".$data['edit_news_data']['title'];
											else echo "Добавить новость";
											?></a></li>
  <li><a href="#edit_news" data-toggle="tab">Редактор новостей</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane fade active" name="add_news" id="add_news">
	<form role="form" method="post">
  <div class="form-group">
    <label for="exampleInputtitle1">Заголовок</label>
    <input type="text" name="title" class="form-control" id="exampleInputtitle1" placeholder="Заголовок" required <?php if(isset($data['edit_news_data']) && isset($_GET['edit_news_id'])) echo "value=\"".$data['edit_news_data']['title']."\"";?>>
  </div>
  <hr>
  <div class="form-group">
    <label for="exampleInputtitle1">Превью</label>
    <textarea name="preview" id="preview" class="form-control" rows="10" cols="80">
                <?php if(isset($data['edit_news_data']) && isset($_GET['edit_news_id'])) echo $data['edit_news_data']['preview']; else echo "Текст превью";?>
    </textarea>
  </div>
  <hr>
  <div class="form-group">
    <label for="exampleInputtitle1">Текст новости</label>
    <textarea name="text" id="text" class="form-control" rows="10" cols="80">
                <?php if(isset($data['edit_news_data']) && isset($_GET['edit_news_id'])) echo $data['edit_news_data']['text']; else echo "Текст новости";?>
    </textarea>
  </div>
  <hr>
  <div class="checkbox">
    <label>
		<?php if(isset($data['edit_news_data']) && isset($_GET['edit_news_id'])){
			if ($data['edit_news_data']['on_vk'] == 1) echo "<b>Пост выложен вк</b>";
			else echo "<b>Поста нет вк</b>";
		}else echo "<input type=\"checkbox\" name=\"post_vk\" value=\"post\" checked> Выложить пост ВК";
		?>
    </label>
  </div>
  
  <input type="hidden" <?php if(isset($data['edit_news_data']) && isset($_GET['edit_news_id'])) echo "name=\"edit_news\""; else echo "name=\"add_news\"";?> value="1">
  <button type="submit" class="btn btn-default">Отправить</button>
</form>
  </div>
  
  
  
  <div class="tab-pane fade" id="edit_news">
	<?php
		if(isset($data['edit_news_err'])){
			echo "<h2>Новостей нет</h2>";
		}
		if(isset($data['edit_news'])){
			foreach ($data['edit_news'] as $news){
				if(isset($news['id'])){
		?>
		<div class="panel panel-default">
			<div class="panel-heading">id: <?=$news['id'];?> - <?=$news['title'];?></div>
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
					<div class="col-sm-5">
						Дата публикации: <?php
						echo date("j.m.Y", $news['date'])." г.";
						?>
					</div>
					<div class="col-sm-4">
						<a class="btn btn-info btn-xs-block" href="/news?id=<?=$news['id'];?>">Подробнее</a>
						<a class="btn btn-success btn-xs-block" href="/admin/news?edit_news_id=<?=$news['id'];?>">Редактировать</a>
						<a class="btn btn-danger btn-xs-block"  data-toggle="modal" data-target="#del_modal" OnClick="del_id(<?=$news['id'];?>,'<?=$news['title'];?>')">Удалить</a>
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
</div>
</div>

<script>
	$(function () {
		$('#news_menu a:first').tab('show')
	})
	CKEDITOR.replace( 'preview' );
    CKEDITOR.replace( 'text' );
</script>

<!-- Modal -->
<div class="modal fade" id="del_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Удалить новость</h4>
      </div>
      <div class="modal-body">
        Вы действительно хотите удалить новость: <b><span id="modal_news_title_del"></span></b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <a type="button" class="btn btn-danger" id="modal_news_href_del" href="#">Удалить</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->