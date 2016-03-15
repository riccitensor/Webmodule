<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'modules/tellafriend/functions.php';
   
   $modTellafriend->add(array('who_id'=>$_GET['id'],'ip'=>$_SERVER['REMOTE_ADDR']));

?>