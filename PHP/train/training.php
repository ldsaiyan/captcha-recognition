<?php
/**
 *
 */

const HOST = "http://jwgl.thxy.cn/";
const HOST_YZM = "http://jwgl.thxy.cn/yzm";

session_start();
$id = session_id();
$_SESSION['id'] = $id;
$cookieurl = dirname(__FILE__).'/../cookie/'.$_SESSION['id'].'.txt';

// get verify and get cookie
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,HOST);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,60);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieurl);
curl_exec($curl);
curl_close($curl);

//$headers = array('browserID:3205528320');
$fp = fopen(dirname(__FILE__)."/../image/yzm.jpg","w");
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,HOST_YZM);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,60);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieurl);
curl_setopt($curl, CURLOPT_HEADER, 0);
//curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl,CURLOPT_FILE,$fp);
//curl_setopt($curl, CURLOPT_ENCODING,'gzip');
curl_setopt ( $curl , CURLOPT_COOKIE,'browserID=3798227320');
$img = curl_exec($curl);

fclose($fp);
unlink($cookieurl);
curl_close($curl);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<img src="../image/yzm.jpg" alt="">
<form action="./set_dict.php">
    <input type="text" name="code">
    <input type="submit">
</form>
</body>
</html>