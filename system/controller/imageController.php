<?php

class imageController extends View
{
  var $model;
  function __construct ()
  {
    include './system/controller/partial/__construct.php';
  }
}
class generate extends imageController
{
  function __construct()
  {
    parent::__construct();

    include './system/class/createImage.php';

    //post attribute
    @$source = $_POST['source'];
    @$part_x = $_POST['part_x'];
    @$part_y = $_POST['part_y'];
    @$part_w = $_POST['part_w'];
    @$part_h = $_POST['part_h'];
    @$mirror_h = $_POST['mirror_h'];
    @$mirror_v = $_POST['mirror_v'];
    @$wb = $_POST['wb'];
    @$directpost = $_POST['directpost'];

    //create object
    $obj = new createImage();
    $obj -> Create($source, $part_x, $part_y, $part_w, $part_h, $mirror_h, $mirror_v, $wb, $directpost);
  }
}
class genbackground extends imageController
{
  function __construct()
  {
    parent::__construct();

    include './system/class/createImage.php';

    //post attribute
    @$source = $_POST['source'];
    @$part_x = $_POST['part_x'];
    @$part_y = $_POST['part_y'];
    @$part_w = $_POST['part_w'];
    @$part_h = $_POST['part_h'];
    @$mirror_h = $_POST['mirror_h'];
    @$mirror_v = $_POST['mirror_v'];
    @$wb = $_POST['wb'];
    @$directpost = 2;

    //create object
    $obj = new createImage();
    $obj -> Create($source, $part_x, $part_y, $part_w, $part_h, $mirror_h, $mirror_v, $wb, $directpost);
  }
}
class facebookpost extends imageController
{
  function __construct()
  {
    parent::__construct();

    if(isset($_GET['photo'])) {
      $photo = "./temp/".$_GET['photo'].".png";
      if(file_exists($photo)) {
        require_once('./system/extension/php-sdk/facebook.php');

        $config = array(
        'appId' => '',
        'secret' => '',
        'fileUpload' => true,
        );

        $facebook = new Facebook($config);
        $user_id = $facebook->getUser();

        if($user_id) {
          try {
            $user = $facebook->api('/'.$user_id.'/?fields=albums.fields(id,name)');
            $albums=$user['albums']['data'];
            for($i=0;$i<count($albums);$i++) {
              if($albums[$i]['name']=='Timeline Photos') {
                $timelinealbumid=$albums[$i]['id'];
                break;
              }
            }
            $ret_obj = $facebook->api('/'.$timelinealbumid.'/photos', 'POST', array('source' => '@' . $photo));
            //redirect to users facebook
            $url="https://www.facebook.com/".$user_id;
            header("Location: $url");
          } catch(FacebookApiException $e) {
            $login_url = $facebook->getLoginUrl( array('scope' => 'user_photos,photo_upload'));
            error_log($e->getType());
            error_log($e->getMessage());
            header("Location: $login_url");
          }
        } else {
          $login_url = $facebook->getLoginUrl( array( 'scope' => 'user_photos,photo_upload') );
          header("Location: $login_url");
        }
      } else {
        header("Location: index.php");
      }
    } else {
      header("Location: index.php");
    }
  }
}
