<?php
/**
* Выдает нужный контролллер
*/
class router
{
	public $db;
	function __construct($db)
	{
		$this->db = $db;
		$db->Query("SELECT * FROM `config`");
		if (!$db->NumRows() > 0){
			echo "Ошибка! В базе данных не указаны данные. Укажте их в таблице 'config'.";
			exit;
		} else {
			$conf = $db->FetchArray();
			if (!isset($conf['name'])) {
				echo "Ошибка! В базе данных не указано название сайта. Укажте его в таблице 'config'.";
				exit;				
			}
		}
		$path = parse_url($_SERVER['REQUEST_URI']);//Парсим строку запроса
		$url = explode('/', $path['path']);//Превращаем её в массив
		if(isset($url[1]) && !empty($url[1])){
					if(!array_key_exists($url[1], array('404'=>true,'index'=>true))){
					$ctrl = 'controllers/_'.$url[1].'Ctrl.php';//Создаем ссылку для подключения
					if(file_exists($ctrl)){
						include $ctrl;
					}else include 'controllers/_404Ctrl.php';
				}else include 'controllers/_404Ctrl.php';
		}else include 'controllers/_indexCtrl.php';
	}
}