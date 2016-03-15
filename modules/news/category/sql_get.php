<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
    require_once 'core/sql.php';
    $rs = $sqlconnector->pagi("SELECT * FROM {$pageController->variables->base_news} ORDER BY id DESC");
   
?>
