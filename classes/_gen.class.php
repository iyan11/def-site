<?php
/**
* Генерирует страницу
*/
class gen
{
	public function __construct($view,$data='')
	{
		$scripts = '';//Дефолтная переменная скриптов
		$_OPT['title'] = '';//Дефолтная переменная тайтл
		$db = new db();
		$db->Query("SELECT * FROM `config`");
		$conf = $db->FetchArray();
		$_OPT['sub-title'] = $conf['name'];
		$_OPT['style'] = $conf['style'];
		include "template/".$_OPT['style']."/inc/_header.php";
		include "template/".$_OPT['style']."/views/".$view.".view.php";
		include "template/".$_OPT['style']."/inc/_footer.php";
		$func = new func();
		$content = ob_get_contents();
		ob_end_clean();
		$content = str_replace('{!TITLE!}', $_OPT['title'] , $content);
		$content = str_replace('{!STYLE!}', $_OPT['style'] , $content);
		$content = str_replace('{!SCRIPTS!}', $scripts , $content);
		echo $content;
	}
}
