<?php
$data = "";
//Добавление новости начало
if(isset($_POST['add_pages'])){
	$title = $_POST['title'];
	$text = $_POST['text'];
	$author = $_SESSION['u_id'];
	$date = time();
	$db->Query("INSERT INTO `pages` (`id`, `title`, `text`, `author`, `date`) VALUES (NULL, '{$title}', '{$text}', '{$author}', '{$date}');");
	$data['add_pages_success'] = 1;
	$pages_id = $db->LastInsert();
	$log_text = "Администратор добавил страницу с id ".$pages_id;
	$db->Query("INSERT INTO `admin_log` (`id`, `user_id`, `text`, `date`) VALUES (NULL, '{$author}', '{$log_text}', '{$date}');");
}
//Добавление новости конец
//Редактирование новости начало
if(isset($_POST['edit_pages'])){
	$edit_pages_id = $_GET['edit_pages_id'];
	$title = $_POST['title'];
	$text = $_POST['text'];
	$author = $_SESSION['u_id'];
	$date = time();
	$db->Query("UPDATE `pages` SET `title` = '{$title}', `text` = '{$text}' WHERE `pages`.`id` = '{$edit_pages_id}';");
	$data['success_edit_pages'] = 1;
	$log_text = "Администратор отредактировал страницу с id ".$edit_pages_id;
	$db->Query("INSERT INTO `admin_log` (`id`, `user_id`, `text`, `date`) VALUES (NULL, '{$author}', '{$log_text}', '{$date}');");
}
//Редактирование новости конец
//Удаление новости начало
if(isset($_GET['del_pages_id'])){
	$func = new func();
	$id_del_pages = $func->clear($_GET['del_pages_id']);
	$db->Query("DELETE FROM `pages` WHERE `pages`.`id` = '{$id_del_pages}';");
	$data['del_pages_success'] = 1;
	$author = $_SESSION['u_id'];
	$date = time();
	$log_text = "Администратор удалил страницу с id ".$id_del_pages;
	$db->Query("INSERT INTO `admin_log` (`id`, `user_id`, `text`, `date`) VALUES (NULL, '{$author}', '{$log_text}', '{$date}');");

}
//Удаление новости конец
//редактирование новости вывод страницы начало
if(isset($_GET['edit_pages_id'])){
	$func = new func();
	$edit_pages_id = $func->clear($_GET['edit_pages_id']);
	$db->Query("SELECT * FROM `pages` WHERE `id` = '{$edit_pages_id}';");
	if($db->NumRows() > 0){
		$data['edit_pages_data'] = $db->FetchArray();
	}else $data['err_edit_pages'] = 1;
}
//редактирование новости вывод страницы конец
//Прогрузка страницы
$db->Query("SELECT * FROM `pages` ORDER BY `id` DESC");
if($db->NumRows() > 0){
	$data['edit_pages'] = $db->FetchAll();
}else $data['edit_pages_err'] = 1;
new gen('admin/pages',$data);
?>