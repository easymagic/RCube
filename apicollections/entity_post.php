<?php 

 class entity_post{
 	

    function rest_call($entity,$id=''){

       $db = load_module('db','pdo_lib');

       $r  = array("message"=>"ok");

       if (!empty($id)){

       	 $this->filters['id'] = $id;

       	 $db->where($this->filters);

       	 $db->update($entity,$_REQUEST);
         
         $r['message'] = 'updated';
         unset($_REQUEST['__q__']);
         $r['data'] = $_REQUEST;   

       }else{

       	 $new_id = $db->insert($entity,$_REQUEST);

       	 $r['new_id'] = $new_id;
       	 $r['data'] = array(
           "new_id"=>$new_id
       	 ); 

       }
      
       return $r;

    }



 }