<?php
if(isset($_GET['id'])){
	$func = new func();
	$id = intval ($func->clear($_GET['id']));
	if($id != ""){
		$db->Query("SELECT * FROM `pages` WHERE `id` = '{$id}';");
		if($db->NumRows() > 0){
			$data['pages'] = $db->FetchArray();
			new gen('pages',$data);
		} else {
			header('Location: /');
			exit;
		}
	} else {
		header('Location: /');
		exit;
	}
} else {
	header('Location: /');
	exit;
}
?>