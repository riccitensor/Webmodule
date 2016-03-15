<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

 require_once 'core/funkcje.php';
 require_once 'core/sql.php';


$t = $sqlconnector->query("SELECT * FROM {$pageController->variables->base_members}");

 
    foreach ($t as $row) {
        echo 'tttt'. $row['id'] . "\t";
        print $row['color'] . "\t";
        print $row['calories'] . "\n";
    }
 
 
 
echo 'test'.$sqlconnector->pager->renderFullNav();

?>
