<?php
use Imagine\Image\ImageInterface;
use VRPilot\BroadcastMode;
use Imagine\Image\Point;
use Imagine\Image\Box;

ini_set("display_errors", "Off");
require_once("internal/vendor/autoload.php");

$imagine = new \Imagine\Gd\Imagine();
$palette = new \Imagine\Image\Palette\RGB();
$size  = new \Imagine\Image\Box($tv->getTvWidth(), $tv->getTvHeight());

switch ($tv->getBroadcastMode()) {
   case BroadcastMode::REGULAR:
      $black = $palette->color("#000", 100);
      $image = $imagine->create($size, $black);
      break;

   case BroadcastMode::TECHDIFF:
      $black = $palette->color("#131313", 100);
      $image = $imagine->create($size, $black);

      $split7 = $size->getWidth() / 7;
      $mid_bar = $size->getHeight() * .75;
      $mid_bar_10 = $size->getHeight() * .05;

      $draw = $image->draw();

      $draw->rectangle(new Point(0, 0), new Point($split7, $mid_bar), $palette->color("#fff"), true);
      $draw->rectangle(new Point($split7, 0), new Point($split7 * 2, $mid_bar), $palette->color("#ff0"), true);
      $draw->rectangle(new Point($split7 * 2, 0), new Point($split7 * 3, $mid_bar), $palette->color("#0ff"), true);
      $draw->rectangle(new Point($split7 * 3, 0), new Point($split7 * 4, $mid_bar), $palette->color("#0f0"), true);
      $draw->rectangle(new Point($split7 * 4, 0), new Point($split7 * 5, $mid_bar), $palette->color("#f0f"), true);
      $draw->rectangle(new Point($split7 * 5, 0), new Point($split7 * 6, $mid_bar), $palette->color("#f00"), true);
      $draw->rectangle(new Point($split7 * 6, 0), new Point($split7 * 7, $mid_bar), $palette->color("#00f"), true);

      $draw->rectangle(new Point(0, $mid_bar), new Point($split7, $mid_bar + $mid_bar_10), $palette->color("#00f"), true);
      $draw->rectangle(new Point($split7 * 2, $mid_bar), new Point($split7 * 3, $mid_bar + $mid_bar_10), $palette->color("#f0f"), true);
      $draw->rectangle(new Point($split7 * 4, $mid_bar), new Point($split7 * 5, $mid_bar + $mid_bar_10), $palette->color("#0ff"), true);
      $draw->rectangle(new Point($split7 * 6, $mid_bar), new Point($split7 * 7, $mid_bar + $mid_bar_10), $palette->color("#fff"), true);

      $bw = $split7 * 5 / 4;
      $draw->rectangle(new Point(0, $mid_bar + $mid_bar_10), new Point($bw, $size->getHeight()), $palette->color("#00214c"), true);
      $draw->rectangle(new Point($bw, $mid_bar + $mid_bar_10), new Point($bw * 2, $size->getHeight()), $palette->color("#fff"), true);
      $draw->rectangle(new Point($bw * 2, $mid_bar + $mid_bar_10), new Point($bw * 3, $size->getHeight()), $palette->color("#32006a"), true);

      $bw = $split7 / 3;
      $draw->rectangle(new Point($split7 * 5, $mid_bar + $mid_bar_10), new Point($split7 * 5 + $bw, $size->getHeight()), $palette->color("#000"), true);
      $draw->rectangle(new Point($split7 * 5 + $bw * 2, $mid_bar + $mid_bar_10), new Point($split7 * 5 + $bw * 3, $size->getHeight()), $palette->color("#1d1d1d"), true);
      break;
}

$options = array(
   "resolution-units" => ImageInterface::RESOLUTION_PIXELSPERINCH,
   "resolution-x" => $tv->getTvWidth(),
   "resolution-y" => $tv->getTvHeight(),
   "jpeg_quality" => $tv->getTvQuality(),
);

$image->show("jpg", $options);

// function image_gradientrect($img,$x,$y,$x1,$y1,$start,$end) {
//    if($x > $x1 || $y > $y1) {
//       return false;
//    }
//    $s = array(
//       hexdec(substr($start,0,2)),
//       hexdec(substr($start,2,2)),
//       hexdec(substr($start,4,2))
//    );
//    $e = array(
//       hexdec(substr($end,0,2)),
//       hexdec(substr($end,2,2)),
//       hexdec(substr($end,4,2))
//    );
//    $steps = $y1 - $y;
//    for($i = 0; $i < $steps; $i++) {
//       $r = $s[0] - ((($s[0]-$e[0])/$steps)*$i);
//       $g = $s[1] - ((($s[1]-$e[1])/$steps)*$i);
//       $b = $s[2] - ((($s[2]-$e[2])/$steps)*$i);
//       $color = imagecolorallocate($img,$r,$g,$b);
//       imagefilledrectangle($img,$x,$y+$i,$x1,$y+$i+1,$color);
//    }
//    return true;
// }

// $agent = $_SERVER["HTTP_USER_AGENT"];
// $refer = $_SERVER["HTTP_REFERER"];
// $host = $_SERVER["HTTP_HOST"];

// // putenv("GDFONTPATH=" . realpath("./internal/assets/fonts"));

// $im = imagecreatetruecolor($tv->getTvWidth(), $tv->getTvHeight());
// $w = imagecolorallocate($im, 255, 255, 255);
// $y = imagecolorallocate($im, 255, 255, 0);

// if ($tv->getBroadcastMode() === \VRPilot\BroadcastMode::REGULAR) {
//    image_gradientrect($im, 0, 0, $tv->getTvWidth(), $tv->getTvHeight(), "4e73df", "224abe");

//    $box = new \GDText\Box($im);
//    $box->setFontFace(realpath("./internal/assets/fonts/Nunito-Bold.ttf"));
//    $box->setFontColor(new \GDText\Color(255, 255, 255));
//    $box->setTextAlign("center", "center");
//    $box->setFontSize(32);
//    $box->setBox(0, 0, $tv->getTvWidth(), $tv->getTvHeight());
//    $box->draw("VRPilot\n");

//    $box->setFontFace(realpath("./internal/assets/fonts/Nunito-Regular.ttf"));
//    $box->setFontSize(32);
//    $box->setBox(0, 0, $tv->getTvWidth(), $tv->getTvHeight());
//    $box->draw("\n<%PKG.VERSION%>");
// } else if ($tv->getBroadcastMode() === \VRPilot\BroadcastMode::TECHDIFF) {
//    {
//       $img = new Image($im);
//       $SMTPE_white1 = new Overlay($img->getWidth() / 7, $img->getHeight() * .75, new Color(235, 235, 235, 255));
//    }
// }

// // imagettftext($im, 16, 0, 20, 42, $w, realpath("./internal/assets/fonts/consolab.ttf"), "VRPilot v<%PKG.VERSION%>");
// imagejpeg($im, null, $tv->getTvQuality());
?>