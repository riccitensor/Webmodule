<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';  

require_once 'modules/menu/functions.php';

//$menu->insert(array('name'=>'menu','link'=>'/'));
//$menu->insert(array('name'=>'menu|strona główna','link'=>'/'));
//$menu->insert(array('name'=>'menu|Panel Administratora','link'=>'/engine/admin'));
//$menu->insert(array('name'=>'menu|czyść cache','link'=>'/engine/admin/cache'));
//$menu->insert(array('name'=>'menu|bb','link'=>'pageinfo3'));
//$menu->insert(array('name'=>'menu|cc','link'=>'pageinfo4'));
//$menu->insert(array('name'=>'menu|cc|xx','link'=>'pageinfo4'));
//$menu->insert(array('name'=>'menu|cc|xx|tt','link'=>'pageinfo4'));

//$menu->css();
//$menu->view();


            $menu->insert(array('name'=>'menu','link'=>'#'));
            $menu->insert(array('name'=>'menu|strona główna','link'=>'/'));
            $menu->insert(array('name'=>'menu|Panel Administratora','link'=>'/engine/admin'));
            $menu->insert(array('name'=>'menu|czyść cache','link'=>'/engine/admin/modules/cache/index.php?operation=clean'));
            $menu->insert(array('name'=>'menu|przykład','link'=>'/abc'));
            $menu->insert(array('name'=>'menu|przykład|B','link'=>'/abc'));
            $menu->insert(array('name'=>'menu|przykład|A','link'=>'/abc'));
            
            $menu->insert(array('name'=>'menu|przykład|C|tt','link'=>'/abc'));
            $menu->insert(array('name'=>'menu|przykład|D|tt','link'=>'/abc'));
            

            
            $menu->table('left');
            
            
?>


<style>
        ul ul {display: none;}
        ul li:hover > ul {display: block;}
    ul {padding: 0px; margin: 0px; list-style-type: none;
        padding: 0px; margin: 0px;}
    li {list-style-type: none;
        padding-left: 10px; margin: 0px;}    
</style>


<ul id="left">    
    <li>test1</li>
    <li>test2</li>
    <li>test3</li>
    <li><span class="left">Użytkownicy</span>
        <ul>
            <li>Zarządzaj użytkownikami</li>
            <li>Grupy użytkowników</li>
            <li>Rangi</li> 
        </ul>
    </li>
    <li>test4</li>
    
    
</ul>
        


