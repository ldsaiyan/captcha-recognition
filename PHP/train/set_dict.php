<?php
/**
 *
 *
 *
 */


function run ($code) {
    $library = null;

    $getImage = amazing('yzm.jpg');
    $list = split_image($getImage);

    for ($i=0; $i<=3; $i++) {
        $codearr = substr($code,$i,1);
        $lib = library($list[$i]);

        $library == null ? $library = array(array($codearr => $lib)) : $library[$i][$codearr] = $lib;   //解决key不嫩重复问题
    }

    file_put_contents('../dict/dict_file.txt', print_r($library, true),FILE_APPEND);

    // 可视化
//    foreach ($list[0] as $row) {
//        echo '<br>';
//        foreach ($row as $column) {
//            print $column;
//        }
//    }

}

// library
function library ($list) {
    $lib = '';

    foreach ($list as $row) {
        foreach ($row as $column) {
            $lib .= $column;
        }
    }

    return $lib;
}


function extract_word ($getImage,$start,$length) {
    // pick up
    foreach ($getImage as $key => $value) {
        for ($i=0; $i<=$start; $i++) {
            unset($getImage[$key][$i]);
        }
        for ($i=143; $i>=$length; $i--) {
            unset($getImage[$key][$i]);
        }

    }

    return $getImage;
}


function split_image ($getImage) {
    for ($i=0; $i<count($getImage); $i++) {
        // 上下切割
        if ($i<=10) {
            unset($getImage[$i]);
            array_pop($getImage);
        }
    }

    // 左右切割
    $first = extract_word($getImage,31,53);
    $second = extract_word($getImage,53,75);
    $third = extract_word($getImage,73,95);
    $four = extract_word($getImage,95,118);

    $list = array();
    $list[] = $first;
    $list[] = $second;
    $list[] = $third;
    $list[] = $four;

    return $list;
}


function amazing ($filename) {

    $image = array();
    $lib = null;

    $im = imagecreatefromjpeg('../image/'.$filename);        //返回一个图像标识符，其表达了从给定字符串得来的图像。即从字符串中的图像流新建一图像
    list($width,$height) = getimagesize('../image/'.$filename);     // 从字符串中获取图像尺寸信息

    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($im, $x, $y);   //取得对应像素的颜色索引值
            $rgb = imagecolorsforindex($im, $rgb);  // 取得某索引的颜色 rgb
            if ($rgb['red'] <= 150 && $rgb['green'] <= 150 && $rgb['blue'] <= 150) {
                $image[$y][$x] = 1;
            } else {
                $image[$y][$x] = 0;
            }
        }
    }

    return $image;
}


$code = $_GET['code'];
run($code);
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
<!--<form action="./get.php">-->
<!--    <input type="submit" value="刷新">-->
<!--</form>-->
</body>
<script>
    window.location.href = 'training.php'
</script>
</html>