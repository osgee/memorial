<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>欢迎</title>
</head>
<body>
	<?php
		class aes {
	 
	    static public $mode = MCRYPT_MODE_NOFB;
	     
	    static public function generateKey($length=32) {
	        if (!in_array($length,array(16,24,32)))
	            return False;
	 
	        $str = '';
	        for ($i=0;$i<$length;$i++) {
	            $str .= chr(rand(33,126));
	        }
	 
	        return $str;
	    }
	 
	    static public function encrypt($data, $key) {
	 
	        if (strlen($key) > 32 || !$key)
	            return trigger_error('key too large or key is empty.', E_USER_WARNING) && False;
	 
	        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, self::$mode);
	        $iv = mcrypt_create_iv($ivSize, (substr(PHP_OS,0,1) == 'W' ? MCRYPT_RAND : MCRYPT_DEV_URANDOM ));
	        $encryptedData = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, self::$mode, $iv);
	        $encryptedData = $iv . $encryptedData;
	 
	        return base64_encode($encryptedData);
	    }
	 
	    static public function decrypt($data, $key) {
	 
	        if (strlen($key) > 32 || !$key)
	            return trigger_error('key too large or key is empty.', E_USER_WARNING) && False;
	 
	        $data = base64_decode($data);
	        if (!$data)
	            return False;
	 
	        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, self::$mode);
	        $iv = substr($data, 0, $ivSize);
	 
	        $data = substr($data, $ivSize);
	 
	        $decryptData = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $data, self::$mode, $iv);
	 
	        return $decryptData;
	    }
	}

	function saveFile($fileName, $text) {
         if (!$fileName || !$text)
             return false; 
         if (makeDir(dirname($fileName))) {
             if ($fp = fopen($fileName, "w")) {
                 if (@fwrite($fp, $text)) {
                     fclose($fp);
                    return true;
                } else {
                     fclose($fp);
                     return false;
                 } 
             } 
         } 
        return false;
     } 

    function makeDir($dir, $mode = "0777") {
         if (!dir) return false;
 
         if(!file_exists($dir)) {
             return mkdir($dir,$mode,true);
         } else {
             return true;
         }
         
     }
    function startWith($str, $needle) {

    return strpos($str, $needle) === 0;

     }

	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		$auth1 = $_POST["auth1"];
		$auth2 = $_POST["auth2"];
		$auth3 = $_POST["auth3"];
		$hash = hash('sha256', base64_encode($auth1.$auth2.$auth3));
		$key = $hash;
		$filename = "index.html";
		$fileroot= "farewell";
		$split = "/";
		$file = $fileroot.$split.$filename;
		$enfilename = "index.txt";
		$enfile = $fileroot.$split.$enfilename;
		$encrypto = new aes();
		$keysize = 32;
		if(file_exists($filename)){
		$data = file_get_contents($filename);
		$endata = $encrypto->encrypt($data, substr($key, $keysize));
		echo "<a href=".$enfilename.">"."加密成功！文件存储在".$enfile."</a>";
		saveFile($enfilename, $endata);
		$endata = file_get_contents($enfilename);
        $data = $encrypto->decrypt($endata, substr($key, $keysize));
        echo $data;
		}else{
			$endata = file_get_contents($enfilename);
            $data = $encrypto->decrypt($endata, substr($key, $keysize));
            $constr = "<!DOCTYPE html>";
            if(startWith($data,$constr)){
            	echo $data;
            }else{
            	echo "<a href=\"..\\auth.html\">验证信息错误</a></br>";
            }
            
		}

	}
	else
	{
		echo "<a href=\"..\\auth.html\">请先验证！</a></br>";
	}

	
	?>
</body>
</html>

