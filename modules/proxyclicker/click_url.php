<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'functions.php';
   require_once 'core/sql.php';
   
    $listlinks_next = $sqlconnector->rlo("select * from {$pageController->variables->base_listlinks} where id = (select min(id) from {$pageController->variables->base_listlinks} where grupa='$modProxyclicker->grupa' and id > '$_GET[id_url]')");

    

    $listlinks = $sqlconnector->rlo("SELECT * FROM {$pageController->variables->base_listlinks} WHERE grupa='$modProxyclicker->grupa' and id = '$_GET[id_url]'");
    $proxy = $sqlconnector->rlo("SELECT * FROM {$pageController->variables->base_proxy} WHERE id = '$_GET[id_proxy]'");
    
    echo "<pre>";
    //print_r($_GET);
    echo "<table>";
    echo "<tr><td width=140px>url id:</td><td>$_GET[id_url]</td></tr>";
    echo "<tr><td>url:</td><td>$listlinks[link]</td></tr>";
    if ($modProxyclicker->curl=='1'){
        echo "<tr><td>agent id:</td><td>$_GET[id_agent]</td></tr>";    
        echo "<tr><td>agent name:</td><td>{$pageController->col_text($modProxyclicker->getAgentId($_GET[id_agent]),100)}</td></tr>";
        echo "<tr><td>ip:</td><td>$proxy[ip]</td></tr>";
        echo "<tr><td>port:</td><td>$proxy[port]</td></tr>";
    } else {
        echo "<tr><td>curl:</td><td><b style='color:red;'>disabled!</b></td></tr>";
    }
    echo "</table>";
    echo "</pre>";
    
    
    $modProxyclicker->curlbrowse(
            array(
                'url'=>$listlinks[link],
                'agentid'=>$_GET[id_agent],
                'ip'=>$proxy[ip],
                'port'=>$proxy[port]
            ));
?>
<script>
$(document).ready(function(){    
    <? if ($listlinks_next[id]>0){?>
        load_clickurl(<?=$modProxyclicker->time_url?>,<?=$_GET[id_proxy]?>,<?=$listlinks_next[id]?>,<?=$_GET[id_agent]?>);
    <?}else{?>
        load_proxy(<?=$modProxyclicker->time_proxy?>,<?=$modProxyclicker->nextProxy($_GET[id_proxy])?>);
    <?}?>
});
</script>