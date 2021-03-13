<?php
if(isset($_SESSION['u_id'])){
	if($_SESSION['lvl_admin'] >= 10){
		function index($db){
			new gen('admin/index');
		}
		if(isset($url[2]) && !empty($url[2])){
			$ctrl = 'controllers/admin/_'.$url[2].'Ctrl.php';//Создаем ссылку для подключения
			if(file_exists($ctrl)){
				include $ctrl;
			}else index($db);
		}else index($db);
	}else new gen('404');
}else{
	header('Location: /');
	exit;
}	
?>