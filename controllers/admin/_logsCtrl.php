<?php
$db->Query("SELECT * FROM `admin_log`");
if($db->NumRows() > 0){
	$data['a_logs'] = $db->FetchAll();
} else $data['log_zero'] = 1;
new gen('admin/logs',$data);
?>