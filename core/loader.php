<?php 

 function call_route($package,$route=''){

 	$r = explode('/', $route);

 	$class = 'index';
 	$method = 'index';
 	$args = array();

 	if (isset($r[0])){
     $class = $r[0];
 	}

 	if (isset($r[1])){
      $method = $r[1];
 	}

 	if (isset($r[2])){
      $args = array_slice($r, 2);
 	}

 	$obj = load_module($package,$class);

 	if (!is_null($obj)){

 	  if (method_exists($obj, $method)){
        return call_user_func_array(array($obj,$method), $args);     
 	  }else{
        return 'no-route'; 
 	  }

 	}else{
 		return 'nl-route';
 	}

 }


 function load_module($package,$module){

 	$obj = null;

 	$class = $module;

 	$file__ = $package . '/' . $class . ".php";

 	if (file_exists($file__)){
      require_once($file__);
 	  $obj = new $class();
 	}

 	return $obj;
 
 }



 function load_macros(){
 	$dir = scandir("macros");
 	$dir = array_diff($dir, array('.','..'));
 	
 	foreach ($dir as $k=>$v){
     
      $file = "macros/" . $v;

      require_once($file);

 	}

 }