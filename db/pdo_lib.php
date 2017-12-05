<?php 
 
  class pdo_lib{

      private static $connection = null;
      private $command_result = null;
      private $query_result = null;
      private $recordset = array();
      private $insert_id = 0;

      private $where_clause = array();

      private $query_filters = '';


      function __construct(){
        $this->init_connection();
      }

      private function init_connection(){
      	
      	if (is_null(self::$connection)){

	      	try {
	      	  self::$connection = new PDO(DB_DRIVER . "host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);	
	      	} catch (Exception $e) {
	      		echo $e->getMessage();
	      	  self::$connection = null;	
	      	}

      	}
      	 
      }

      function exec($sql_command){
       $this->command_result = self::$connection->exec($sql_command);
       return $this->command_result;
      }

      function query($sql){
        $this->query_result = self::$connection->query($sql . $this->get_query_filters());
        return $this->query_result;
      }

      function where($criteria=array()){
        $this->where_clause = $criteria;
      }

      private function get_where_clause(){
      	
      	if (count($this->where_clause) > 0){
	      $r = $this->where_clause;
	      $rr = array();
	      foreach ($r as $k=>$v){
	        $rr[] = "$k='$v'";
	      } 
	      $this->reset_filter();

	        return ' where (' . implode(' and ', $rr) . ')';           
      	}else{
      		return '';
      	}

      }

      private function _result_($type){
        $r = array();
        while ($dt = $this->query_result->fetch($type)) {
          $r[] = $dt;
        }
        return $r;
      }

      function result(){
       $this->recordset = $this->_result_(PDO::FETCH_OBJ);
       return $this->recordset;
      }

      function result_assoc(){
        $this->recordset = $this->_result_(PDO::FETCH_ASSOC);
        return $this->recordset;
      }


      function row(){
      	if (isset($this->recordset[0])){
            return $this->recordset[0];
      	}else{
      		return array();
      	}
      }

      function get_fields($table){
	      
	      $fields = array();
	      $sql = 'show columns from ' . $table;
	      $this->query($sql);

	      $result = $this->result_assoc();
	      foreach ($result as $k=>$v){
           $fields[] = $v['Field'];
	      }

	      return $fields;      	

      }

      private function filter_fields($table,$post_data=array()){
	     
	     $r = array();
	     $flds = $this->get_fields($table);
	     foreach ($post_data as $k=>$v){
	        if (in_array($k, $flds)){
	          $r[$k] = $v;
	        }
	     }
	     return $r;       

      }


      function insert($table,$post_data=array()){

      	$new_post_data = $this->filter_fields($table,$post_data);

      	$keys = array_keys($new_post_data);
      	$values = array_values($new_post_data);

      	$prepared_values = array();
      	
      	foreach ($keys as $k=>$v){

      		 $prepared_values[] = ":$v";

      	}

      $sql = "insert into $table (" . implode(',', $keys) . ") values (" . implode(",", $prepared_values) . ")";
      
      $stmt = self::$connection->prepare($sql);
      $stmt->execute($new_post_data); 

      $this->insert_id = self::$connection->lastInsertId();

      return $this->insert_id;

      }

      function update($table,$post_data=array()){
	     
	     $where = $this->get_where_clause();

	     $new_post_data = $this->filter_fields($table,$post_data);

	     $r = array();
	     $rr = array();
	     
	     foreach ($new_post_data as $k=>$v){
	       $r[] = "$k=?"; //'$v'
	       $rr[] = $v;
	     }

	     $sql = "update $table set " . implode(' , ', $r) . " $where ";

	     $stmt = self::$connection->prepare($sql);
	     
	     return $stmt->execute($rr);

      }

      private function reset_filter(){
      	$this->where_clause = array();
      }


      function delete($table){
       
       $where = $this->get_where_clause();
       $sql = "delete from $table $where";
       
       $this->exec($sql);

      }


      function get($table){
        
        $where = $this->get_where_clause();
      	$sql = "select * from $table $where ";

      	 // echo $sql;

      	$this->query($sql);

      }


      function set_query_filters($r){
       $this->query_filters[] = $r;
      }

      function get_query_filters(){
      	return implode(' ', $this->query_filters);
      }




  }
