<?php
/**
* M-Crypt
* Шифрование для пароля по ключу и паролю
*/
class mcrypt
{
	private $salt='wfwfa2f2qfaf3afsf3';//Соль для шифрования
	public function encrypt($data) {
		error_reporting(E_ERROR);
		$key = hash('SHA256', $this->salt, $data);
		$iv = mcrypt_create_iv($this->salt);
		$data = mcrypt_ecb(MCRYPT_BLOWFISH, $key, $data, MCRYPT_ENCRYPT, $iv);
		$data = base64_encode($data);
		return $data;
	}
	public function decrypt($data) {
		error_reporting(E_ERROR);
		$data = base64_decode($data);
		$key = hash('SHA256', $this->salt, $data);
		$iv = mcrypt_create_iv($this->salt);
		$data = mcrypt_ecb(MCRYPT_BLOWFISH, $key, $data, MCRYPT_DECRYPT, $iv);
		return $data;
	}
}