<?php 

 class index{
   
   
    function index(){
      
      $view = load_module('ui','template');
      
      return $view->load('custom_template',array("label"=>"loaded custom template."));
      
    }
 
 
 }
