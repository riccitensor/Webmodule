<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

   require_once 'modules/less/functions.php';

   global $modLess; $modLess = new modLess();

   $modLess->convert(array(
    'input'=>'/engine/modules/less/input.less',
    'output'=>'/engine/modules/less/output.css'));
   
   
   
?>