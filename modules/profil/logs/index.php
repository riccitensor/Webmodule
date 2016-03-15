<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';

require_once 'modules/profil/profilController.php'; 
require_once 'modules/profil/lang/lang.php'; 

$pageController->ilogged();
$profilController->warstwaA(); 
?>
<script>
$(document).ready(function(){ajaxloadpage(1); });
function ajaxloadpage(page){$("#area").load("/engine/modules/profil/logs/list.php?page="+page+"&search=" + urldecode($("#search").val()));}
</script>



<div id="area"></div>

<? $profilController->warstwaB(); ?>
