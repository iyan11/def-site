<?php
$db->Query("SELECT * FROM `account_logs`");
if($db->NumRows() > 0){
	$data['u_logs'] = $db->FetchAll();
} else $data['log_zero'] = 1;
new gen('admin/u_logs_enter',$data);
?>