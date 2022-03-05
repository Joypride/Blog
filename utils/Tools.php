<?php

namespace Utils;

	abstract class Tools {
		
		static public function getValue($key, $defaultValue = false)
		{
			if (!isset($key) || empty($key) || !is_string($key))
				return false;
			$ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $defaultValue));
	
			if (is_string($ret) === true)
				$ret = urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret)));
			return !is_string($ret)? $ret : stripslashes($ret);
		}
		
		static public function getSValue($key)
		{
			$string = self::getValue($key);
			$string = addslashes($string);
			$string = strip_tags($string);
			$string = str_replace(array("\r\n", "\r", "\n"), '<br>', $string);
			return $string;
		}

		static public function getSession($key, $defaultValue = false)
		{
			if (!isset($key) || empty($key) || !is_string($key))
				return false;
			$ret = (isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue);
	
			if (is_string($ret) === true)
				$ret = urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret)));
			return !is_string($ret)? $ret : stripslashes($ret);
		}
	
		static public function getIsset($key)
		{
			if (!isset($key) || empty($key) || !is_string($key))
				return false;
			return isset($_POST[$key]) ? true : (isset($_GET[$key]) ? true : false);
		}
		
		static public function checkMail($mail) {
			return filter_var($mail, FILTER_VALIDATE_EMAIL);	
		}
	
	public static function getPOST($prefix="form_") {
		$updates = array();
		foreach($_POST as $k=>$v) {
			if(substr($k,0,strlen($prefix))==$prefix)
				$updates[str_replace($prefix,'',$k)] = $v;
		}
		return $updates;
	}
	
	public static function convertImage($src,$dst,$quality=100) {
		$img_info = getimagesize($src);
		switch ($img_info[2]) {
		  case IMAGETYPE_GIF  : $src = imagecreatefromgif($src);  break;
		  case IMAGETYPE_JPEG : $src = imagecreatefromjpeg($src); break;
		  case IMAGETYPE_PNG  : $src = imagecreatefrompng($src);  break;
		}
		imagejpeg($src, $dst, $quality);
		@unlink($src);
		
	}
}
?>
