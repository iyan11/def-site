<?php
$db->Query("SELECT * FROM `vk_logs_msg`");
if($db->NumRows() > 0){
	$data['vk_logs_msg'] = $db->FetchAll();
} else $data['log_zero'] = 1;
new gen('admin/vk_logs_msg',$data);
?>