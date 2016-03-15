<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/logs.php';
   require_once 'core/sql.php';
   $info = $_GET['host_name'];
   $rekord = $sqlconnector->rlo("SELECT * FROM {$pageController->variables->base_logs} WHERE info='$info' ORDER by id DESC limit 1");
   echo $rekord['ip'];
?>