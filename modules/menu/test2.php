<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';  

require_once 'modules/menu/functions.php';

$menu->insert(array('name'=>'menu','link'=>'/'));
$menu->insert(array('name'=>'menu|strona główna','link'=>'/'));
$menu->insert(array('name'=>'menu|Panel Administratora','link'=>'/engine/admin'));
$menu->insert(array('name'=>'menu|czyść cache','link'=>'/engine/admin/modules/cache/index.php?operation=clean'));
$menu->insert(array('name'=>'menu|przykład','link'=>'/abc'));
$menu->insert(array('name'=>'menu|przykład|A','link'=>'/abc'));
$menu->insert(array('name'=>'menu|przykład|B','link'=>'/abc'));
$menu->insert(array('name'=>'menu|przykład|C|tt','link'=>'/abc'));
$menu->insert(array('name'=>'menu|przykład|D|tt','link'=>'/abc'));




?>
        
<div style="float: left; width: 250px; height: 50px; background-color: silver;">
<?

$menu->view();
$menu->table();
//echo $pageController->sample_text();
?></div>


<script>



</script>    