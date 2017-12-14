<?php 

 class testfn{
    
    private $view = null;
    private $data = array();


    function __construct(){
    	$this->view = load_module('ui','template');
    }

    function lnk($carry,$item){
     return $carry . "<div><b><i>" . $item . "</i></b></div>";
    }

    function loop(){

    	$t = array(1,2,33,4,5,66);

    	$this->data['pik'] = array_reduce($t, array($this,'lnk'));
   
    	return $this->view->load('loop',$this->data);
    	// return 'loop.';
    }





 }