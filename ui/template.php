<?php 

 class template{

    



    function load($view,$__data__=array()){

         extract($__data__);

         $r = '';

         $__file__  = DEFAULT_THEME_PATH . $view . ".php";

         if (file_exists($__file__)){
           ob_start();	
           include($__file__);
           $r = ob_get_contents();
           ob_end_clean();
         }

         return $r;

    }




 }