<?php
$_OPT['title'] =  "Страницы - Админ панель - ".$_OPT['sub-title'];
?>
<script src="../ckeditor/ckeditor.js"></script>
<div class="row panel panel-default panel-body">
<div class="col-sm-3">
	<?php require_once "template/".$_OPT['style']."/inc/admin_menu.php";?>
</div>
<div class="col-sm-9">
<script>
top_menu('admin');
admin_menu('a_pages');

function del_id(id,title){
	$('#modal_pages_title_del').text(title);
	$('#modal_pages_href_del').attr('href','/admin/pages?del_pages_id=' + id);
}
</script>
<?php
	if(isset($data['add_pages_success'])){
		if($data['add_pages_success'] == 1){
		?>
		<div class="alert alert-success">Страница успешно размещена<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
		<?php
		}
	}
	if(isset($data['del_pages_success'])){
		if($data['del_pages_success'] == 1){
		?>
		<div class="alert alert-success">Страница успешно удалена<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
		<?php
		}
	}
	if(isset($data['err_edit_pages'])){
		if($data['err_edit_pages'] == 1){
		?>
		<div class="alert alert-danger">Ошибка удаления страницы<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
		<?php
		}
	}
	if(isset($data['success_edit_pages'])){
		if($data['success_edit_pages'] == 1){
		?>
		<div class="alert alert-success">Страница успешно изменена<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
		<?php
		}
	}
?>

<ul class="nav nav-tabs" id="pages_menu">
  <li><a href="#add_pages" data-toggle="tab"><?php
											if(isset($data['edit_pages_data']) && isset($_GET['edit_pages_id'])) echo "Редактировать страницу - ".$data['edit_pages_data']['title'];
											else echo "Добавить страницу";
											?></a></li>
  <li><a href="#edit_pages" data-toggle="tab">Редактор страниц</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane fade active" name="add_pages" id="add_pages">
	<form role="form" method="post">
  <div class="form-group">
    <label for="exampleInputtitle1">Заголовок</label>
    <input type="text" name="title" class="form-control" id="exampleInputtitle1" placeholder="Заголовок" required <?php if(isset($data['edit_pages_data']) && isset($_GET['edit_pages_id'])) echo "value=\"".$data['edit_pages_data']['title']."\"";?>>
  </div>
  <hr>
  <div class="form-group">
    <label for="exampleInputtitle1">Текст страницы</label>
    <textarea name="text" id="text" class="form-control" rows="10" cols="80">
                <?php if(isset($data['edit_pages_data']) && isset($_GET['edit_pages_id'])) echo $data['edit_pages_data']['text']; else echo "Текст страницы";?>
    </textarea>
  </div>
  <hr>
  
  <input type="hidden" <?php if(isset($data['edit_pages_data']) && isset($_GET['edit_pages_id'])) echo "name=\"edit_pages\""; else echo "name=\"add_pages\"";?> value="1">
  <button type="submit" class="btn btn-default">Отправить</button>
</form>
  </div>
  
  
  
  <div class="tab-pane fade" id="edit_pages">
	<?php
		if(isset($data['edit_pages_err'])){
			echo "<h2>Страниц нет</h2>";
		}
		if(isset($data['edit_pages'])){
			foreach ($data['edit_pages'] as $pages){
				if(isset($pages['id'])){
		?>
		<div class="panel panel-default">
			<div class="panel-heading">id: <?=$pages['id'];?> - <?=$pages['title'];?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-3">
						Автор: <b><?php
						$author_id = $pages['author'];
						$db->Query("SELECT `login` FROM `accounts` WHERE `id` = {$author_id}");
						$author_all = $db->FetchArray();
						echo $author_all['login'];
						?></b>
					</div>
					<div class="col-sm-5">
						Дата публикации: <?php
						echo date("j.m.Y", $pages['date'])." г.";
						?>
					</div>
					<div class="col-sm-4">
						<a class="btn btn-info btn-xs-block" href="/pages?id=<?=$pages['id'];?>">Подробнее</a>
						<a class="btn btn-success btn-xs-block" href="/admin/pages?edit_pages_id=<?=$pages['id'];?>">Редактировать</a>
						<a class="btn btn-danger btn-xs-block"  data-toggle="modal" data-target="#del_modal" OnClick="del_id(<?=$pages['id'];?>,'<?=$pages['title'];?>')">Удалить</a>
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
		$('#pages_menu a:first').tab('show')
	})
    CKEDITOR.replace( 'text' );
</script>

<!-- Modal -->
<div class="modal fade" id="del_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Удалить страницу</h4>
      </div>
      <div class="modal-body">
        Вы действительно хотите удалить страницу: <b><span id="modal_pages_title_del"></span></b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <a type="button" class="btn btn-danger" id="modal_pages_href_del" href="#">Удалить</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->