<?php
  // session_start();
  //创建1~15的随机数(用于生成十六进制的验证码)
  // mt_rand(0, 15);

  $_rnd_count = 4;
  
  //生成4位的十六进制验证码
  $code = ''; //存放验证码
  for ($i = 0; $i < $_rnd_count; $i++) {
    //将0~15转换成十六进制
    $code .= dechex(mt_rand(0, 15));
  }

  $_SESSION['code'] = $code;

  //设置验证码背景图大小
  $_width = 75;
  $_height = 25;

  //创建图像，作为验证码背景图
  $_img = imagecreatetruecolor($_width, $_height);

  //创建一块白布（用于作为验证码背景颜色）
  //int imagecolorallocate(resource image, int red, int green, int blue)
  $_white = imagecolorallocate($_img, 255, 255, 255);

  //背景颜色填充
  //bool imagefill(resource image, int x, int y, int color)
  imagefill($_img, 0, 0, $_white);

  //创建灰色画布（用于作为验证码边框颜色）
  $_gray = imagecolorallocate($_img, 150, 150, 150);

  //创建验证码边框
  //bool imagerectangle(resource image, intx1, int y1, int x2, int y2, int col);
  imagerectangle($_img, 0, 0, $_width - 1, $_height - 1, $_gray);

  //随机画出6个线条
  for ($i = 0; $i < 6; $i++) {
    $_rnd_color = imagecolorallocate($_img, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255));
    //bool imageline(resource image, int x1, inty1, int x2, int y2, int color);
    imageline($_img, 
                mt_rand(0, $_width), mt_rand(0, $_height), 
                mt_rand(0, $_width), mt_rand(0, $_height), 
                $_rnd_color
              );
  }

  //随机雪花
  for ($i = 0; $i < 100; $i++) {
    $_rnd_color = imagecolorallocate($_img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
    //bool imagestring(resourece image, int font, int x, int y, string s, int col);
    //如果font是1, 2, 3, 4 或 5，则使用内置字体
    imagestring($_img, 1, mt_rand(1, $_width), mt_rand(1, $_height), '*', $_rnd_color);
  }

  //输出验证码
  for($i = 0; $i < $_rnd_count; $i++) {
    imagestring($_img, mt_rand(3, 5), 
      // $i*$_width/$_rnd_count+mt_rand(1, 10), mt_rand(1, $_height/2), 
      $i * $_width / 4,
      $i,
      $_SESSION['code'][$i],
      imagecolorallocate($_img, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200))
      );
  }

  //输出验证码图像
  header('Content-Type:image/png');  //设置验证码背景图像格式
  imagepng($_img);
  imagedestroy($_img);  //销毁缓存的验证码背景图像。
?>