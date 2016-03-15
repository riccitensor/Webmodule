<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

   require_once 'modules/barcode/functions.php';

   global $modBarcode; $modBarcode = new modBarcode();

   $modBarcode->barcode('test');
   

?>
