<?php

$config = array
(
  'site' => array(
    'parent' => '../../',
    'path' => 'http://'.$_SERVER['HTTP_HOST'].str_replace('index.php','',$_SERVER['PHP_SELF']),
    'url' => 'https://tree.unlink.men/',
    'name'  => '金城武樹產生器',
    'title' => '金城武樹產生器',
    'description' => 'I SEED YOU. 每 28 秒，就有 1 棵樹被砍掉。自己的金城武，自己種。',
    'copyright' => 'just for fun',
    'shortcut-icon' => 'https://tree.unlink.men/images/favicon.png',
    'apple-touch-icon' => ''
  ),
  'setting' => array(
    'enable-database' => false,
    'enable-navbar-search' => false,
    'enable-member-system' => false
  ),
  'member' => array(
    'default-page' => 'member'
  ),
  'database' => array(
    'host'  => '',
    'user'  => '',
    'pass'  => '',
    'db'  => ''
  ),
  'admin' => array(
    '000000000000000'
  ),
  'google' => array(
    'analytics-id'  => 'UA-00000000-00'
  ),
  'facebook' => array(
    'fanpage' => '',
    'app-id' => '',
    'app-secret' => '',
    'privacy-policy' => ''
  ),
  'og' => array(
    'title' => '金城武樹產生器',
    'type'  => 'website',
    'url' => 'https://tree.unlink.men/',
    'image' => 'https://tree.unlink.men/images/fb.png',
    'sitename'  => '金城武樹產生器',
    'description' => 'I SEED YOU. 每 28 秒，就有 1 棵樹被砍掉。自己的金城武，自己種。'
  )
);

?>
