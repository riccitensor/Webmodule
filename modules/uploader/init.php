<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'modules/uploader/functions.php';
   

 
   if (!isset($modUploader)){$modUploader = new modUploader();}  
   
   $modUploader->script_name = '/engine/modules/uploader/init.php';
    
?>