<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';  

require_once 'modules/tree/functions.php';



            $menu->insert(array('name'=>'abc','link'=>'10'));
            $menu->insert(array('name'=>'menu','link'=>'1'));
            $menu->insert(array('name'=>'menu|pp','link'=>'11'));
            $menu->insert(array('name'=>'menu|strona główna','link'=>'2'));
            $menu->insert(array('name'=>'menu|Panel Administratora','link'=>'3'));
            $menu->insert(array('name'=>'menu|czyść cache','link'=>'4'));
            $menu->insert(array('name'=>'menu|przykład','link'=>'5'));
            $menu->insert(array('name'=>'menu|przykład|A','link'=>'6'));
            $menu->insert(array('name'=>'menu|przykład|B','link'=>'7'));
            $menu->insert(array('name'=>'menu|przykład|C|tt','link'=>'8'));
            $menu->insert(array('name'=>'menu|przykład|C|yy','link'=>'8'));
            $menu->insert(array('name'=>'menu|przykład|D|tt','link'=>'9'));
            

?>
        
<div style="float: left; width: 250px; height: 50px; background-color: #999999;">
<?

//$menu->view();
//$menu->table();

$menu->poz(5);


//echo $pageController->sample_text();
?></div>
