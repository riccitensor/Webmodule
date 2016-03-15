<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

   require_once 'core/logs.php';
   
   $logs->addlog("host",$_GET[host_name]);
   
   //echo "sprawne";
?>