<?php 

 class v3{
   


    function index(){
    	$obj = load_module('apis','v3');
    	return 'v3 loaded.' . call_route('apis','v3/foo') . $obj->foo1();
    }

    function foo(){
    	return 'Foo returned.';
    }

    function foo1(){
    	
    	$view = load_module('ui','template');
    	
    	$db = load_module('db','pdo_lib');

    	// $db->where(array("id"=>"4"));
      
        // $db->update("user",array("first_name"=>"admin..."));
        
        // print_r($t); 



        // $db->delete("user");

        $db->get('user');

        $r = $db->result();

        print_r($r);

    	return '...1test1...' . $view->load('index_theme');
    }


    function test_api(){
    	
    	$obj = load_module('apicollections','v10');

        $obj->collections('apartment','2');
         
    }


 }