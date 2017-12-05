<?php 

 class v10{


     
       function collections(){

       	$args = func_get_args();

       	$entity = '';
       	$arg2 = '';
       	$arg3 = '';

       	$method = $_SERVER['REQUEST_METHOD'];
       	$method = strtolower($method);

       	if ($method == 'get'){
          $obj = load_module('apicollections','entity_get');
       	}else if ($method == 'post'){
          $obj = load_module('apicollections','entity_post');
       	}

       	$r = call_user_func_array(array($obj,'rest_call'), $args);

       	echo json_encode($r);

       	//entity_post
       	//entity_get

       	// print_r($_SERVER);



       }

       function c(){

       	 $r = array();
       	 $r[] = new foo();
       	 $r[] = 'calc';

       	 $fn = $r;
       	 $fn();
       	 

       }




 }


 class foo{
  

   function calc(){
   	echo 'calc called.';
   }


 }