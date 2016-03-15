<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'functions.php';
   require_once 'core/sql.php';   
   require_once 'core/funkcje.php';  
     
   
   //$licznik = 0 + $funkcje->file_load($_SERVER['DOCUMENT_ROOT'].'/temp/proxy/save');
   
   if ($_GET[id_proxy]>0){
       $proxy_next[id] = $_GET[id_proxy];
   } else {
       $proxy_next = $sqlconnector->rlo("select * from {$pageController->variables->base_proxy} where id = (select min(id) from {$pageController->variables->base_proxy} where id > '$licznik')");
   }

$pageController->skin('default');
$pageController->warstwaA(); ?>    

<style>
    td {font-size: 9px;}
    tr {padding: 0px; margin: 0px;}
    
</style>



<script>
    
time = 0;


czas_odOstatniejZmiany = 0;
rekord_weryfikujacy = 0;
rekord_ostatni = 0;

function timeScript(){
    time++;
    //alert(time);
    if (rekord_ostatni==rekord_weryfikujacy) {
        czas_odOstatniejZmiany++;
    } else {
        rekord_weryfikujacy = rekord_ostatni;
        czas_odOstatniejZmiany=0;
    }    
    if (czas_odOstatniejZmiany>3){
        czas_odOstatniejZmiany=0;
        load_proxy(<?=$modProxyclicker->time_proxy?>,rekord_ostatni+1);
    }
    
    
    $("#time_script").html(time);
    $("#no_changes_time").html(czas_odOstatniejZmiany);
    
    
    
}





function set_done(text){
    $("#area3").prepend(text+"<br/>");
}


function reset_connect(czas,id_proxy){
    czas=czas-1;
    if (czas<=0) {
        //alert('aaa');
        $("#area1").load("connect.php?id_proxy="+id_proxy);
        $("#area2").html("<pre style='background-color:#FFFF88'>searching proxy</pre>");
    } else {
        $("#reset_connect").html(czas); 
        setTimeout("reset_connect("+czas+","+id_proxy+")",1000);
    }
}


function load_proxy(czas,id_proxy){ 
    rekord_ostatni = id_proxy; //do odwieszenia
    czas=czas-1;
    if (czas<=0) {
        $("#area1").load("connect.php?id_proxy="+id_proxy);
        $("#area2").html("<pre style='background-color:#FFFF88'>searching proxy</pre>");
    } else {
        $("#next").html('.');
        $("#next_proxy").html(czas);
        setTimeout("load_proxy("+czas+","+id_proxy+")",1000);
    }
}

function load_clickurl(czas,id_proxy,id_url,id_agent){
    czas=czas-1;
    if (czas<=0) {
        $("#area2").load("click_url.php?id_proxy="+id_proxy+"&id_url="+id_url+"&id_agent="+id_agent);
    } else {        
        $("#next").html(czas);        
        setTimeout("load_clickurl("+czas+","+id_proxy+","+id_url+","+id_agent+")",1000);
    } 
}
$(document).ready(function(){
    load_proxy(1,<?=$proxy_next[id]?>);
    //timeScript();
    
});
var myVar=setInterval(function(){timeScript()},1000);
</script>

<br/>
<div id="area1"></div>

<hr/>

<div id="area2"></div>
<hr/>

<pre style="background-color: #88FF88" id="area3"></pre>

<? $pageController->warstwaB(); ?>