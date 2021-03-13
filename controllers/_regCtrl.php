<?php
if(isset($_POST['login'])){
	//Array ( [login] => asd [password] => asd [re_password] => asd [email] => serverscrazy@gmail.com [terms] => complate [policy] => complate )
	$func = new func();
	$login = $func->clear($_POST['login']);
	$pass = $func->clear($_POST['password']);
	$re_pass = $func->clear($_POST['re_password']);
	$email = $func->isMail($_POST['email']);
	if(isset($_POST['terms']) && isset($_POST['policy'])){
		if(isset($pass) && isset($re_pass)){
			if($pass != "" && $re_pass != ""){
				if($pass == $re_pass){
					if(isset($login)){
						if($login != ""){
							if(isset($email)){
								if($email != ""){
									$time_reg = time();
									$db->Query("INSERT INTO `accounts` (`id`, `login`, `password`, `mail`, `lvl_admin`, `date_reg`, `last_login`) VALUES (NULL, '{$login}', MD5('{$pass}'), '{$mail}', '0', '{$time_reg}', '{$time_reg}');");
									$u_id = $db->LastInsert();
									$_SESSION['u_id'] = $u_id;
									$_SESSION['lvl_admin'] = "0";
									header('Location: /');
									exit;
								}else{
									$data['err'] = 5;
									new gen('reg',$data);
								}
							}else{
								$data['err'] = 5;
								new gen('reg',$data);
							}
						}else{
							$data['err'] = 4;
							new gen('reg',$data);
						}
					}else{
						$data['err'] = 4;
						new gen('reg',$data);
					}
				}else{
					$data['err'] = 3;
					new gen('reg',$data);
				}
			}else{
				$data['err'] = 2;
				new gen('reg',$data);
			}
		}else{
			$data['err'] = 2;
			new gen('reg',$data);
		}
	}else{
	$data['err'] = 1;
	new gen('reg',$data);
	}
}else new gen('reg');
?>