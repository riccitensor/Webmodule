<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
function generate_content($rs,$topic,$pager){
    //echo "page=".$_GET[page];
$zmienna = "
<br/>
<center>"; 

while($rek = mysql_fetch_assoc($rs)) { 
$zmienna .= "<div id='newsm'>
<div id='newsm_title'>* <a href='news/$rek[id]'>$rek[title]</a></div>
<div id='newsm_time'>$rek[author]".date('Y-m-d H:i:s',$rek[time_create])."</div>
<div id='newsm_content'>$rek[content]</div>
</div>
<br/>";
}

$zmienna .= "</center>

 <div id='pagi'>".$sqlconnector->pager->renderFullNav()."</div>
";

return $zmienna;
}

