<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

 require_once 'modules/redactors/functions.php';

global $modRedactors; $modRedactors = new modRedactors();

$modRedactors->viewSite();


?>