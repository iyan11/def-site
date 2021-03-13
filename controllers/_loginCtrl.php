<?php
if(isset($_POST['login'])){
	$func = new func();
	$login = $func->clear($_POST['login']);
	$pass = $func->clear($_POST['password']);
	if($login != "" && $pass != ""){
		$md5_pass = md5($pass);
		$db->Query("SELECT `id`,`lvl_admin` FROM `accounts` WHERE `login` = '{$login}' AND `password` = '{$md5_pass}'");
		if($db->NumRows() > 0){
			$time = time();
			$u = $db->FetchArray();
			$u_id = $u['id'];
			$db->Query("UPDATE `accounts` SET `last_login` = '{$time}' WHERE `accounts`.`id` = '{$u_id}';");
			function GetIP() {
				if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
					$ip = $_SERVER['HTTP_CLIENT_IP'];
				} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else {
					$ip = $_SERVER['REMOTE_ADDR'];
				}
				return $ip;
			}
			$ip = GetIP();
			$browser = $_SERVER['HTTP_USER_AGENT'];
			$db->Query("INSERT INTO `account_logs` (`id`, `id_acc`, `time`, `ip`, `browser`) VALUES (NULL, '{$u_id}', '{$time}', '{$ip}', '{$browser}');");
			$_SESSION['u_id'] = $u_id;
			$_SESSION['lvl_admin'] = $u['lvl_admin'];
			header('Location: /');
			exit;
		}else{
			$data['err'] = 2;
			new gen('login',$data);
		}
	}else{
		$data['err'] = 1;
		new gen('login',$data);
	}
}else new gen('login');
?>