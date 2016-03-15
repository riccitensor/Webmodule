<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'functions.php';
   require_once 'core/sql.php';
   require_once 'core/funkcje.php'; 

   ?>
<div style="overflow:auto;">
<pre style='width: 400px; float: left;'>
<table>
<tr><td>id:</td><td style="width: 80px;"><?=$_GET[id_proxy]?></td></tr>
<tr><td>time to next url:</td><td><b id='next'>.</b></td></tr>
<tr><td>time to next proxy:</td><td><b id='next_proxy'>.</b></td></tr>
<tr><td>time to reset connect:</td><td><b id='reset_connect'>.</b></td></tr>
<tr><td>time script:</td><td><b id='time_script'>.</b></td></tr>
<tr><td>no changes time:</td><td><b id='no_changes_time'>.</b></td></tr>
</table></pre>

   
<pre style='width: 400px; float:right;'>
default time_url: <?=$modProxyclicker->time_url?> 
default time_proxy: <?=$modProxyclicker->time_proxy?> 
default time_curl: <?=$modProxyclicker->time_curl?> 
default time_restart: <?=$modProxyclicker->time_restart?> 
default curl: <?=$modProxyclicker->curl?> 
default grupa: <?=$modProxyclicker->grupa?>
</pre> 
</div>
<? if ($modProxyclicker->checkConnection()==false){?>
       <script>
            $(document).ready(function(){
                $("#area2").html("<pre style='background-color:#FF8888'>connection failed</pre>");
                reset_connect(<?=$modProxyclicker->time_restart?>,<?=$_GET[id_proxy]?>);
            });
       </script>
<? } else {   
   $array_links=array();   
   $proxy = $sqlconnector->rlo("SELECT * FROM {$pageController->variables->base_proxy} WHERE id = '$_GET[id_proxy]'");
   $listlinks = $sqlconnector->rlo("SELECT * FROM {$pageController->variables->base_listlinks} WHERE grupa='$modProxyclicker->grupa' and id = (select min(id) from {$pageController->variables->base_listlinks} where id > 0)");
   
   $modProxyclicker->update_try($_GET[id_proxy]);
   
   $agentId = $modProxyclicker->getAgentRand();
   //$funkcje->file_save($_SERVER['DOCUMENT_ROOT'].'/temp/proxy/save',$proxy[id]);
       
   if ($modProxyclicker->grupa==''){
        echo "<pre style='background-color:#FF8888'>grupa is not set</pre>";            
   }
   
   
   $check_url = "http://$_SERVER[SERVER_ADDR]/engine/modules/proxyclicker/check.php";
   $check = $modProxyclicker->curlbrowse(
            array(
                'url'=>$check_url,
                'agentid'=>$agentId,
                'ip'=>$proxy[ip],
                'port'=>$proxy[port],
                'timeout'=>$modProxyclicker->time_curl
            ));
    
   if ($check=='ok'){
        $modProxyclicker->update_connect($_GET[id_proxy]);        
   ?>
        <script>            
            $(document).ready(function(){                
                set_done("<?=date('Y:m:d H:i:s',time())." &nbsp;&nbsp;&nbsp; id:$proxy[id] &nbsp;&nbsp;&nbsp; $proxy[ip]:$proxy[port]"?>")
                load_clickurl(<?=$modProxyclicker->time_url?>,<?=$proxy[id]?>,<?=$listlinks[id]?>,<?=$agentId?>);
                $("#area2").html("<pre style='background-color:#88FF88'>proxy is set</pre>");
            });
        </script>
   <?} else {
       $modProxyclicker->update_failed($_GET[id_proxy]);
   ?>
        <script>
            $(document).ready(function(){
                load_proxy(<?=$modProxyclicker->time_proxy?>,<?=$modProxyclicker->nextProxy($_GET[id_proxy])?>);
            });
        </script>
   <?}
    
   }
?>