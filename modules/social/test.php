<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

   require_once 'modules/social/functions.php';


 $pageController->warstwaA("");  
   ?>

<div style="width: 300px; border: solid 1px red; height: 400px; overflow: hidden;">
  <?$modSocial->likebuttons();
    $modSocial->css();
  
  ?>
</div>
 <?

$pageController->warstwaB("");
?>