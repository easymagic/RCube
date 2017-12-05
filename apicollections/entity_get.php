<?php 

 class entity_get{
     
    private $filters = array(); 

    function rest_call($entity,$id=''){

       $db = load_module('db','pdo_lib');

       $r  = array("message"=>"ok");

       if (!empty($id)){

       	 $this->filters['id'] = $id;

       	 $db->where($this->filters);

       	 $db->get($entity);

       	 $db->result();

       	 $t = $db->row();

       }else{

       	 $this->load_external_filters($db,$entity);

       	 if (count($this->filters) > 0){
          $db->where($this->filters);   
       	 }

       	 $db->get($entity);

       	 $t = $db->result();

       }

       $r['data'] = $t;
      
       return $r;

    }


    private function load_external_filters($db,$table){
    	
    	$fields = $db->get_fields($table);

    	foreach ($fields as $k=>$v){
    	  $check = $v . "_filter";	
          if (isset($_REQUEST[$check])){
            $this->filters[$v] = $_REQUEST[$check];
          }
    	}


    	$this->load_random_filter($db,$table);


    }


    private function load_pagination_filter($db,$table){

    	if (isset($_REQUEST['limit_filter'])){
           $db->set_query_filters(" limit " . $_REQUEST['limit_filter']);
    	}

    	// $this->load_random_filter($db,$table);

    }


    private function load_random_filter($db,$table){

    	if (isset($_REQUEST['rand_filter'])){
           $db->set_query_filters(" order by rand() ");
    	}else{

    		$fields = $db->get_fields($table);

    		foreach ($fields as $k=>$v){

    			 $check1 = $v . "_asc";
    			 $check2 = $v . "_desc";

    			 if (isset($_REQUEST[$check1])){
                   $db->set_query_filters(" order by $v asc ");
                   break;
    			 }else if (isset($_REQUEST[$check2])){
                   $db->set_query_filters(" order by $v desc ");
                   break;
    			 }

    		}

    	}

    
       $this->load_pagination_filter($db,$table);

    }




 }

