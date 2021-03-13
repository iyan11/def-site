<?php
if(isset($_SESSION['u_id'])){
	function index($db){
		
		new gen('account/index');
	}
	if(isset($url[2]) && !empty($url[2])){
		$ctrl = 'controllers/account/_'.$url[2].'Ctrl.php';//Создаем ссылку для подключения
		if(file_exists($ctrl)){
			include $ctrl;
		}else index($db);
	}else index($db);
}else{
	header('Location: /login');
	exit;
}
?>