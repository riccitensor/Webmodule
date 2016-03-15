<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   $pageController->skin("default");
   $pageController->warstwaA();

?>
test2

<script>    
function popup(id){
    window.open("/engine/modules/popup/popup_news.php?id="+id,"","width=800,height=300");
}
popup(<?=$_GET['id']?>);
</script>



<script>

//$(document).ready(function() {
//
//var popupHeight = parseInt($('#elementThatWillGetTaller').css('height')); // parseInt if we get a '200px'
//
//// code to set window height - I know it can be done because I've seen osCommerce do it
//});

</script>

<? $pageController->warstwaB(); ?>