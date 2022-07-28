<?php
class createImage
{
  function Create($source, $part_x, $part_y, $part_w, $part_h, $mirror_h, $mirror_v, $wb, $directpost)
  {

    if($mirror_h==1) $mirror_h='true';
    if($mirror_v==1) $mirror_v='true';
    $source = 'upload/'.$source;

    //get the input file extension and create a GD resource from it
    $ext = pathinfo($source, PATHINFO_EXTENSION);
    if($ext == "jpg" || $ext == "jpeg") $image = imagecreatefromjpeg($source);
    elseif($ext == "png") $image = imagecreatefrompng($source);
    elseif($ext == "gif") $image = imagecreatefromgif($source);

    //get the image size
    $size = getimagesize($source);
    $height = $size[1];
    $width = $size[0];

    //white balance
    if($wb !== '') $wb = '_'.$wb;

    //draw kaneshiro
    if($mirror_v == 'true' && $mirror_h == 'true')
      $kaneshiro = imagecreatefrompng('images/object/kaneshiro_vh'.$wb.'.png');
    elseif($mirror_v == 'true' && $mirror_h !== 'true')
      $kaneshiro = imagecreatefrompng('images/object/kaneshiro_v'.$wb.'.png');
    elseif($mirror_v !== 'true' && $mirror_h == 'true')
      $kaneshiro = imagecreatefrompng('images/object/kaneshiro_h'.$wb.'.png');
    else
      $kaneshiro = imagecreatefrompng('images/object/kaneshiro'.$wb.'.png');
    imagecopyresampled($image, $kaneshiro, $part_x, $part_y, 0, 0, $part_w, $part_h, 693, 883);
    @imagedestroy($kaneshiro);

    switch ($directpost) {
      case 1:
        header('Content-Type: image/png');
        $filename=time();
        $save = "./temp/".$filename.".png";
        imagepng($image,$save,9,null);
        $url="facebookpost/?photo=".$filename;
        header("Location: $url");
        break;

      case 2:
        header('Content-Type: image/png');
        $filename = date('YmdHis').'_'.md5($source).'.png';
        $save = "./upload/".$filename;
        imagepng($image,$save,9,null);
        echo $filename;
        break;

      default:
        header('Content-Type: image/png');
        header("Content-Transfer-Encoding: binary");
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=金城武樹.png');

        imagepng($image,null,9,null);
        @imagedestroy($image);
        break;
    }
  }
}
?>
