<?php
function Def_News($db){
	$db->Query("SELECT * FROM `news` ORDER BY `id` DESC");
	if($db->NumRows() > 0){
		$data['news'] = $db->FetchAll();
	}else $data['err'] = 1;
	new gen('news',$data);
}
if(isset($_GET['id'])){
	$func = new func();
	$id_news = intval ($func->clear($_GET['id']));
	if($id_news != ""){
		$db->Query("SELECT * FROM `news` WHERE `id` = {$id_news}");
		if($db->NumRows() > 0){
			$data['one_news'] = $db->FetchArray();
			new gen ('news_one',$data);
		}else Def_News($db);
	}else Def_News($db);
}else Def_News($db);
?>