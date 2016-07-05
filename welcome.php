<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>欢迎</title>
</head>
<body>
	<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		$auth1 = $_POST["auth1"];
		$auth2 = $_POST["auth2"];
		$auth3 = $_POST["auth3"];
		$hash = hash('sha256', base64_encode($auth1.$auth2.$auth3));
		$file = "liankan/".$hash."/1.pdf";
		if(file_exists($file))
		{
			echo "<h2>欢迎</h2>";
			echo "<h4>应声</h4>";
			echo "<a href=\"liankan/".$hash."/1.pdf\">第一期</a></br>";
			echo "<a href=\"liankan/".$hash."/2.pdf\">第二期</a></br>";
			echo "<a href=\"liankan/".$hash."/3.pdf\">第三期</a></br>";
			echo "<a href=\"liankan/".$hash."/4.pdf\">第四期</a></br>";
			echo "<a href=\"liankan/".$hash."/5.pdf\">毕业纪念册</a></br>";
			echo "百度云地址：<a href=\"liankan/".$hash."/yun.html\">百度云</a></br>";
		}
		else
		{
			echo "<a href=\"auth.html\">验证信息错误</a></br>";
		}

	}
	else
	{
		echo "<a href=\"auth.html\">请先验证！</a></br>";
	}

	
	?>
</body>
</html>

