<?php
$data = "";
//Добавление новости начало
if(isset($_POST['add_news'])){
	$title = $_POST['title'];
	$preview = $_POST['preview'];
	$text = $_POST['text'];
	$author = $_SESSION['u_id'];
	$date = time();
	if(isset($_POST['post_vk'])) {
		$access_token = 'a2e42741a0f4ee825035097dc1338a377f287e686b442bb55a9c7c0f50fd6b2a09358fad83b12a7a0578a';
		$group_id = '202509922';
		$func = new func();
		$message = $func->clear($text);
		$params = array(
			'v'            => '5.124',
			'access_token' => $access_token,
			'owner_id'     => '-' . $group_id, 
			'from_group'   => '1', 
			'message'      => $message
		);
		file_get_contents('https://api.vk.com/method/wall.post?' . http_build_query($params));
		$post_vk = 1;
	}else $post_vk = 0;
	$db->Query("INSERT INTO `news` (`id`, `title`, `preview`, `text`, `author`, `date`, `on_vk`) VALUES (NULL, '{$title}', '{$preview}', '{$text}', '{$author}', '{$date}', '{$post_vk}');");
	$data['add_news_success'] = 1;
	$news_id = $db->LastInsert();
	$log_text = "Администратор добавил новость с id ".$news_id;
	$db->Query("INSERT INTO `admin_log` (`id`, `user_id`, `text`, `date`) VALUES (NULL, '{$author}', '{$log_text}', '{$date}');");
}
//Добавление новости конец
//Редактирование новости начало
if(isset($_POST['edit_news'])){
	$edit_news_id = $_GET['edit_news_id'];
	$title = $_POST['title'];
	$preview = $_POST['preview'];
	$text = $_POST['text'];
	$author = $_SESSION['u_id'];
	$date = time();
	$db->Query("UPDATE `news` SET `title` = '{$title}', `preview` = '{$preview}', `text` = '{$text}' WHERE `news`.`id` = '{$edit_news_id}';");
	$data['success_edit_news'] = 1;
	$log_text = "Администратор отредактировал новость с id ".$edit_news_id;
	$db->Query("INSERT INTO `admin_log` (`id`, `user_id`, `text`, `date`) VALUES (NULL, '{$author}', '{$log_text}', '{$date}');");
}
//Редактирование новости конец
//Удаление новости начало
if(isset($_GET['del_news_id'])){
	$func = new func();
	$id_del_news = $func->clear($_GET['del_news_id']);
	$db->Query("DELETE FROM `news` WHERE `news`.`id` = '{$id_del_news}';");
	$data['del_news_success'] = 1;
	$author = $_SESSION['u_id'];
	$date = time();
	$log_text = "Администратор удалил новость с id ".$id_del_news;
	$db->Query("INSERT INTO `admin_log` (`id`, `user_id`, `text`, `date`) VALUES (NULL, '{$author}', '{$log_text}', '{$date}');");

}
//Удаление новости конец
//редактирование новости вывод страницы начало
if(isset($_GET['edit_news_id'])){
	$func = new func();
	$edit_news_id = $func->clear($_GET['edit_news_id']);
	$db->Query("SELECT * FROM `news` WHERE `id` = '{$edit_news_id}';");
	if($db->NumRows() > 0){
		$data['edit_news_data'] = $db->FetchArray();
	}else $data['err_edit_news'] = 1;
}
//редактирование новости вывод страницы конец
//Прогрузка страницы
$db->Query("SELECT * FROM `news` ORDER BY `id` DESC");
if($db->NumRows() > 0){
	$data['edit_news'] = $db->FetchAll();
}else $data['edit_news_err'] = 1;
new gen('admin/news',$data);
?>