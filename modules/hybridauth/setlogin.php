<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'modules/hybridauth/functions.php';
   $modHybridauth->setLogin($_GET['id'],$_GET['login']);

?>