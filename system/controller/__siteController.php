<?php

class Controller
{
  var $view;
  function Controller()
  {
    session_start();
    include_once './system/config/systemConfig.php';
    include_once './system/function/systemFunction.php';
    include_once './system/function/customFunction.php';
    $this->config = $config;
    $this->url=explodeUrl($this->config['site']['path']);
    if($this->url[1]=='') $this->url[1] = 'index';
    $this->useragent = mobileDetect();

    include_once './system/controller/defaultController.php';
    switch($this->url[1])
    {
      // default
      case 'index':
        $this->view = new index();
        break;

      case 'og':
        $this->view = new og();
        break;

      case 'test':
        include_once './system/controller/testController.php';
        $this->view = new test();
        break;

      // application actions
      case 'uploader':
        include_once './system/controller/uploadController.php';
        $this->view=new uploader();
        break;

      case 'urloader':
        include_once './system/controller/uploadController.php';
        $this->view=new urloader();
        break;

      case 'generate':
        include_once './system/controller/imageController.php';
        $this->view=new generate();
        break;

      case 'genbackground':
        include_once './system/controller/imageController.php';
        $this->view=new genbackground();
        break;

      case 'facebookpost':
        include_once './system/controller/imageController.php';
        $this->view=new facebookpost();
        break;

      // member
      case 'signin':
        include_once './system/controller/memberController.php';
        $this->view=new signin();
        break;

      case 'logout':
        include_once './system/controller/memberController.php';
        $this->view=new logout();
        break;

      case 'register':
        include_once './system/controller/memberController.php';
        $this->view=new register();
        break;

      case 'member':
        include_once './system/controller/memberController.php';
        $this->view=new member();
        break;

      // admin
      case 'admin':
        adminChecker($_SESSION['facebookid'],$this->config,$this->url[1]);
        break;

      default:
        $this->view = new index();
        break;
    }
  }
}

?>
