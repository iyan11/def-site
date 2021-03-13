<?php
error_reporting(0);
$func = new func();
if (!isset($_REQUEST)) {
    return;
}


//Строка для подтверждения адреса сервера из настроек Callback API
$confirmationToken = '6d9e3729';
//Ключ доступа сообщества
$token = '61b869c2b54b8a6d56ace2c83ec3e71d1447aa8a99asd2203da269bbeb2337f7317d90427d054711c3asd';
// Secret key
$secretKey = 'AWD332r3ffwasDFAfWbynyj6asdh4yh5hasdasasd';
//Версия 
$v = '5.124';
//Название монет
$money_name_i = "монета";
$money_name_r = "монету";
$money_name_d = "монет";
$money_name_v = "монеты";

//Получаем и декодируем уведомление
$data = json_decode(file_get_contents('php://input'));
// проверяем secretKey
if(strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0)
    return;
$request_params = array();


//Переменные
$date = time();
$userId = $data->object->message->from_id;
$msg_complate = "";

$text = $func->clear($data->object->message->text);
switch ($data->type) {
    case 'confirmation':
        echo $confirmationToken;
        break;
    //Если это уведомление о новом сообщении...
    case 'message_new':
		$i = 0;
		$complate_msg = 0;
		
		//admin
		$a_msg = 0;
		$db->Query("SELECT * FROM `vk_users` WHERE `user` = '{$userId}';");
		if($db->NumRows() > 0){
			$db_user_info = $db->FetchArray();
			if ($db_user_info['admin'] >= 10){
				$db_user_admin_lvl = $db_user_info['admin'];
				switch($text){
					case '-Помощь': case '-помощь':
						$msg_complate = 'Здравствуйте, уважаемый администратор '.$db_user_admin_lvl.' уровня <br> Вам доступны команды: <br> -Помощь - для вызова справки.';
						$a_msg = 1;
						break;
					case '-Пользователи': case '-пользователи': case '-Users': case '-users':
						$db->Query("SELECT * FROM `vk_users`;");
						if($db->NumRows() > 0){
							$num = $db->NumRows();
							$num ++;
							$msg_complate = "Количество зарегестрированных пользователей: ".$num."<br>";
							$user_data = $db->FetchAll();
							foreach ($user_data as $usr_data){
								if($usr_data['id'] != ""){
									$user_data_id = $usr_data['user'];
									$user_data_id1 = $usr_data['id'];
									$user_data_money = $usr_data_money;
									$user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_data_id}&access_token={$token}&v={$v}"));
									$user_data_firstname = $user_info->response[0]->first_name;
									$user_data_lastname = $user_info->response[0]->last_name;
									$msg_complate .= "id:".$user_data_id1." Имя: ".$user_data_firstname." ".$user_data_lastname.". @id".$user_data_id."<br>";
								}
							}
							
						}
						$a_msg = 1;
						break;
					default:
						break;
				}
			}
		}
		
		
		//анон чат
		if($a_msg == 0){
		$db->Query("SELECT * FROM `rnd_chat` WHERE `user_id1` = '{$userId}';");
		if($db->NumRows() > 0){
				$AsReed_id_user = $userId;
				$rnd_msg_chat = $db->FetchArray();
				$complate_msg = 1;			
			//Выход
			if($text == "!Выход"){
				$msg_user2_id = $rnd_msg_chat['user_id2'];
				$msg_complate = "Чат завершен, введите команду \"Анонимный чат\" для поиска нового собеседника.";
				$peer_ids = $userId.",".$rnd_msg_chat['user_id2'];
				$rnd_id = rand();
				$request_params += ['random_id' => $rnd_id, 'peer_ids' => $peer_ids, 'access_token' => $token, 'v' => $v];
				$request_params += ['message' => $msg_complate];
				$get_params = http_build_query($request_params);
				file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
				$rnd_chat_id = $rnd_msg_chat['id'];
				$db->Query("DELETE FROM `rnd_chat` WHERE `rnd_chat`.`id` = {$rnd_chat_id};");
			}else{
				$msg_complate = $func->clear($data->object->message->text);
				$status = $rnd_msg_chat['status'];
				if($status == 0){
					$userId = $data->object->message->from_id;
					$msg_complate = "Мы ещё не нашли собеседника";
				} else $userId = $rnd_msg_chat['user_id2'];
				file_get_contents("https://api.vk.com/method/messages.markAsRead?peer_id={$AsReed_id_user}&access_token={$token}&v={$v}");
			}
		} else {
			$db->Query("SELECT * FROM `rnd_chat` WHERE `user_id2` = '{$userId}';");
			if($db->NumRows() > 0){
					$AsReed_id_user = $userId;
					$rnd_msg_chat = $db->FetchArray();
					$complate_msg = 1;
				//Выход
				if($text == "!Выход"){
					$msg_user2_id = $rnd_msg_chat['user_id2'];
					$msg_complate = "Чат завершен, введите команду \"Анонимный чат\" для поиска нового собеседника.";
					$peer_ids = $userId.",".$rnd_msg_chat['user_id1'];
					$rnd_id = rand();
					$request_params += ['random_id' => $rnd_id, 'peer_ids' => $peer_ids, 'access_token' => $token, 'v' => $v];
					$request_params += ['message' => $msg_complate];
					$get_params = http_build_query($request_params);
					file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
					$rnd_chat_id = $rnd_msg_chat['id'];
					$db->Query("DELETE FROM `rnd_chat` WHERE `rnd_chat`.`id` = {$rnd_chat_id};");
				}else{
					$msg_complate = $func->clear($data->object->message->text);
					$status = $rnd_msg_chat['status'];
					if($status == 0){
						$userId = $data->object->message->from_id;
						$msg_complate = "Мы ещё не нашли собеседника";
					} else $userId = $rnd_msg_chat['user_id1'];
					file_get_contents("https://api.vk.com/method/messages.markAsRead?peer_id={$AsReed_id_user}&access_token={$token}&v={$v}");
				}
			}
		}
		}
		//Конец анон чата
		
		
		
		//Мини игры
		if($a_msg == 0 && $complate_msg == 0){
			$db->Query("SELECT * FROM `vk_mini_games` WHERE `user_id` = '{$userId}';");
			if ($db->NumRows() > 0){
				$vk_mini_games_table = $db->FetchArray();
				if ($text == "Выход"){
					$id = $vk_mini_games_table['id'];
					$db->Query("DELETE FROM `vk_mini_games` WHERE `vk_mini_games`.`id` = {$id};");
					$msg_complate = "Вы успешно вышли из меню мини-игр.<br> Для помощи введите: \"Помощь\"";
				}else {
					$db->Query("SELECT * FROM `vk_mini_games_list`");
					if($db->NumRows() > 0){
						$text = (int)$text;
						$db->Query("SELECT * FROM `vk_mini_games_list` WHERE `id` = '{$text}' AND `status` = 1");
						if($db->NumRows() > 0){
							$game = $db->FetchAll();
							$id_game = $game[0]['id'];
							switch ($id_game){
								//игры по Id
								
								//1 - Кости
								case 1:
									$msg_complate .= "В разработке, введите: \"Выход\"";
									break;
								
								//Если игры ещё нет в кейсе выше - то код ниже
								default:
									$msg_complate .= "Простите, игра не найдена или введено не корректное число, повторите ввод. <br>";
									//Список игр
									$db->Query("SELECT * FROM `vk_mini_games_list`");
									$games_list = $db->FetchAll();
									$is_game = 0;
									foreach ($games_list as $game){
										if($game['id'] != "" && $game['status'] != 0){
											$msg_complate .= $game['id']." - ".$game['name'].".<br>";
										}
									}
									if($is_game == 1) $msg_complate .= "Введите цифру с игрой для начала игры. <br> Для выхода введите: \"Выход\"";
									else $msg_complate .= "Пока игр нет, всё в разработке!<br>Для выхода введите: \"Выход\"<br>";
									break;
							}
						}else{
							$msg_complate .= "Простите, игра не найдена или введено не корректное число, повторите ввод. <br>";
							//Список игр
							$db->Query("SELECT * FROM `vk_mini_games_list`");
							$games_list = $db->FetchAll();
							$is_game = 0;
							foreach ($games_list as $game){
								if($game['id'] != "" && $game['status'] != 0){
									$msg_complate .= $game['id']." - ".$game['name'].".<br>";
								}
							}
							if($is_game == 1) $msg_complate .= "Введите цифру с игрой для начала игры. <br> Для выхода введите: \"Выход\"";
							else $msg_complate .= "Пока игр нет, всё в разработке!<br>Для выхода введите: \"Выход\"<br>";
						}
						
					} else $msg_complate .= "Пока игр нет, всё в разработке!<br>Для выхода введите: \"Выход\"<br>";
				}
					$complate_msg = 1;
			}
		}
		//Конец Мини игр
		
		
		for (;$i < 1;){
			$msg_id = $data->object->message->conversation_message_id;
			if($a_msg == 0 && $complate_msg == 0){
				$unread_msg = json_decode(file_get_contents("https://api.vk.com/method/messages.getConversations?access_token={$token}&filter=unread&v={$v}"));
				$txt = $unread_msg->response->items[0]->last_message->text;
				if (isset($txt)){
					$text = $func->clear($unread_msg->response->items[0]->last_message->text);
					$userId = $data->object->message->from_id;
					$userId2 = $unread_msg->response->items[0]->last_message->peer_id;
					if ($userId2 == $userId) $i = 2;
					$userId = $unread_msg->response->items[0]->last_message->peer_id;
					$user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$userId}&access_token={$token}&v={$v}"));
					$user_name = $user_info->response[0]->first_name;
				}else {
					$userId = $data->object->message->from_id;
					$text = $func->clear($data->object->message->text);
					$i = 2;
					$user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$userId}&access_token={$token}&v={$v}"));
					$user_name = $user_info->response[0]->first_name;
				}
			
				//message SQL
				$db->Query("SELECT * FROM `vk_msgs` WHERE `msg` = '{$text}'");
				if ($db->NumRows() > 0){
					$text_db = $db->FetchArray();
					$msg_complate = $text_db['description'];
				}else{
					//commands
					switch ($text){
							
							
						case 'Анонимный чат': case 'анонимный чат': case 'Анон чат': case 'анон чат':
							$db->Query("SELECT `id`, `user_id1` FROM `rnd_chat` WHERE `user_id2` IS NULL AND `status` = 0");
							if ($db->NumRows() > 0){
								$id = $db->FetchArray();
								$id_chat = $id['id'];
								$usr1_id = $id['user_id1'];
								if ($usr1_id != $userId){
									$msg_complate = "Мы нашли собеседника, общайтесь. Для выхода введите \"!Выход\"";
									$db->Query("UPDATE `rnd_chat` SET `user_id2` = '{$userId}', `status` = '1' WHERE `rnd_chat`.`id` = {$id_chat};");
									$peer_ids = $usr1_id.",".$userId;
									$rnd_id = rand();
									$request_params += ['random_id' => $rnd_id, 'peer_ids' => $peer_ids, 'access_token' => $token, 'v' => $v];
									$request_params += ['message' => $msg_complate];
									$get_params = http_build_query($request_params);
									file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
								} else $msg_complate = "Мы ищем собеседника, ждите. Для выхода введите \"!Выход\"";
							}else {
								$db->Query("INSERT INTO `rnd_chat` (`id`, `user_id1`, `user_id2`, `status`) VALUES (NULL, '{$userId}', NULL, '0');");
								$msg_complate = "Мы ищем собеседника, ждите. Для выхода введите \"!Выход\"";
							}
							break;
						
						
						case 'Мини игры': case 'мини игры': case 'Мини игра': case 'мини игры': case 'игры': case 'Игры': case 'Играть': case 'играть': 
							$db->Query("SELECT * FROM `vk_mini_games` WHERE `user_id` = '{$userId}';");
							if($db->NumRows > 0){
								$msg_complate = "Ошибка, повторите ввод.";
							}else {
								$db->Query("INSERT INTO `vk_mini_games` (`id`, `user_id`, `game_id`, `status`) VALUES (NULL, '{$userId}', NULL, '0');");
								$msg_complate = "Добро пожаловать в нашу игровую комнату, выберите игру, в которую вы хотите сиграть:<br>";
								$db->Query("SELECT * FROM `vk_mini_games_list`");
								if($db->NumRows() > 0){
									//Список игр
									$games_list = $db->FetchAll();
									$is_game = 0;
									foreach ($games_list as $game){
										if($game['id'] != "" && $game['status'] != 0){
											$msg_complate .= $game['id']." - ".$game['name'].".<br>";
										}
									}
									if($is_game == 1) $msg_complate .= "Введите цифру с игрой для начала игры. <br> Для выхода введите: \"Выход\"";
									else $msg_complate .= "Пока игр нет, всё в разработке!<br>Для выхода введите: \"Выход\"<br>";
								} else $msg_complate .= "Пока игр нет, всё в разработке!<br>Для выхода введите: \"Выход\"<br>";
							}
							$msg_complate .= "Для выхода введите:\"Выход\"";
							break;
						
						
						case 'Баланс': case 'баланс': case 'Money': case 'money':
							$db->Query("SELECT `money` FROM `vk_users` WHERE `user` = '{$userId}';");
							if($db->NumRows() > 0){
								$money = $db->FetchArray();
								$msg_complate = "Ваш баланс: ".$money['money']." ".$money_name_d.".";
							}else $msg_complate = "Ошибка";
							break;
						
						
						default:
							$msg_complate = "{$user_name}, я не понимаю тебя. Введи: помощь. Или: Помощь.";
							break;
					}
				}
			}else $i = 2;
		}
		
		
			//adduser
			$db->Query("SELECT * FROM `vk_users` WHERE `user` = '{$userId}';");
			if($db->NumRows() > 0){
				
			}else{
				$db->Query("INSERT INTO `vk_users` (`id`, `user`, `date_reg`, `money`, `vip`, `admin`) VALUES (NULL, '{$userId}', '{$date}', '0', '0', '0');");
			}
			//конец adduser
			
			
			
			//Logs + отправка сообщения
			$db->Query("SELECT * FROM `vk_logs_msg` WHERE `msg` = '{$text}' AND `froms` = '{$userId}' AND `date` = '{$date}' AND `conversation_message_id` = '{$msg_id}';");
			if($db->NumRows() > 0){
				
			} else {
				$db->Query("INSERT INTO `vk_logs_msg` (`id`, `msg`, `froms`, `date`, `conversation_message_id`) VALUES (NULL, '{$text}', '{$userId}', '{$date}', '{$msg_id}');");
				$id_msg = $db->LastInsert();
				$request_params += ['random_id' => $id_msg, 'user_id' => $userId, 'access_token' => $token, 'v' => $v];
				$request_params += ['message' => $msg_complate];
				//Отправка сообщения
				$get_params = http_build_query($request_params);
				file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
			}
			//Конец Logs + отправка сообщения
			
			
			echo('ok');
			break;

    
	
    case 'group_join':
        echo('ok');
        break;
	case 'message_reply':
		echo('ok');
        break;
	case 'message_typing_state':
		echo('ok');
        break;
	case 'message_edit':
		echo('ok');
        break;
	case 'message_deny':
		echo('ok');
        break;
	case 'like_add':
		echo('ok');
        break;
	case 'wall_post_new':
		echo('ok');
        break;
	case 'group_change_settings':
		echo('ok');
        break;
	case 'wall_reply_new':
		echo('ok');
        break;
}
?>