<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

   require_once 'modules/tools/init.php';
   require_once 'core/sql.php';

$rs = $sqlconnector->query(" SELECT * FROM {$pageController->variables->base_news} ORDER by col DESC LIMIT 5");
while ($rek = mysql_fetch_array($rs)) {
    echo "<div class='news'>$rek[title]";
        //echo $pageController->sample_text(1202);
        $modTools->viewFull(array('id'=>$rek['id']));
    echo "</div>";    
}

?>

<style>
    .news {
        height: 50px;
        width: 300px;
        border: solid 1px silver;
        margin: 1px;
        overflow: hidden;
        position: relative;
    }
</style>
