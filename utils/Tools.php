<?php

namespace Utils;

	abstract class Tools {
		
		static public function getValue($key, $defaultValue = false)
		{
			if (!isset($key) OR empty($key) OR !is_string($key))
				return false;
			$ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : (isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue)));
	
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
	
		static public function getIsset($key)
		{
			if (!isset($key) OR empty($key) OR !is_string($key))
				return false;
			return isset($_POST[$key]) ? true : (isset($_GET[$key]) ? true : false);
		}
		
		static public function error($string) {
			global $smarty;
			$smarty->assign('resultat',Tools::erreur($string));
		}
		
		static public function checkMail($mail) {
			return filter_var($mail, FILTER_VALIDATE_EMAIL);	
		}
		
    public static function sendMail($email, $sujet, $message, $template = 1, $from=false, $replyTo=false){
		global $_CONFIG;
		
		if(!$from)
			$from = $_CONFIG['smtp']['user'];
		if(!$replyTo)
			$replyTo = $_CONFIG['smtp']['user'];
		
		if(PHPMailer::ValidateAddress($email)){
			$smarty = new Smarty;
			$smarty->template_dir=ROOT.'templates/mail/';
			$smarty->compile_dir=ROOT.'data/cache/templates/front_c/';
			
			$smarty->assign('contenu_mail', $message);
			$smarty->assign('base_url', 'http://'.$_SERVER['HTTP_HOST']);
			
			if($template==1)$html=$smarty->fetch('email.tpl');
			else $html=$message;
			
				
			$mail = new PHPMailer(false);
			if($_CONFIG['smtp']['method']=="phpmail") {$mail->IsMail();}
			$mail->AddReplyTo($replyTo, $replyTo);
			$mail->SetFrom($from, $from);
			$mail->AddAddress($email);
			$mail->Subject = $sujet;
			
			$mail->MsgHTML($html);
			if($mail->Send()) return true; else return false;
		}
        return false;
	}
	
	public static function getPOST($prefix="form_") {
		$updates = array();
		foreach($_POST as $k=>$v) {
			if(substr($k,0,strlen($prefix))==$prefix)
				$updates[str_replace($prefix,'',$k)] = $v;
		}
		return $updates;
	}
	
	public static function getGET($prefix="form_") {
		$updates = array();
		foreach($_GET as $k=>$v) {
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
