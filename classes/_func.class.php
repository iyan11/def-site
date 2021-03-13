<?php
/**
* Функции
*/
class func
{
	public function status($status='success',$text='')
	{
		return json_encode(array('status'=>$status,'text'=>$text));
	}
	public function clear($data,$type='str')
	{
		$data = trim($data);
		//$data = mysql_escape_string($data);
		$data = strip_tags($data);
		$data = htmlspecialchars($data);
		$data = ($type == 'str')?strval($data):intval($data);
		return $data;
	}
	public function isMail($mail)
	{
		if(is_array($mail) && empty($mail) && strlen($mail) > 255 && strpos($mail,'@') > 64) return false;
			return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]{2,20}+\.)+[a-z]{2,6}$/ix", $mail)) ? false : strtolower($mail);
	}
	public function isPassword($password)
	{
		if(is_array($password) && empty($password) && strlen($password) > 255) return false;
			return (!preg_match('/(?=^.{7,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/',$password)) ? false : $password;
	}
	public function isUrl($url)
	{
		if(is_array($url) && empty($url) && strlen($url) > 255) return false;
			if (substr($url, 0, 7) == 'http://' || substr($url, 0, 8) == 'https://'){
				return $url;
			}else return false;
	}
	public function IsPayeer($payeer)
	{
		return (!preg_match("/^P[0-9]{6,9}+$/ix", $payeer)) ? false : strtolower($payeer);
	}
	public function genKey($count = 8){
		$arr = array('a','b','c','d','e','z','q',
					 'A','E','I','O','U','Y','B',
					 'C', 'D', 'F', 'G', 'H', 'J',
					 'K', 'L', 'M', 'N', 'P', 'Q',
					 'R', 'S', 'T', 'V', 'W', 'X',
					 'Y', 'Z','w','e','t','y','u',
					 'i','p','n','1','2','3','4',
					 '5','6','7','8','9','0','j',
					 'h','m');
		$arr_c = count($arr) - 1;
		$key = '';
		for ($i=0; $i < $count; $i++) {
			$r = mt_rand(0,$arr_c);
			$key .= $arr[$r];
		}
		return $key;
	}
}