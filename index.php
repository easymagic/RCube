<?php
  
  session_start();

  define('SYS_PATH', 'core/');

  require_once(SYS_PATH . "loader.php");

  load_macros();
  
  require_once("config.php");


  $query_request_ = $_REQUEST['__q__'];

  
  $_response_ = call_route(PACKAGE_MOUNT,$query_request_);


  echo $_response_;