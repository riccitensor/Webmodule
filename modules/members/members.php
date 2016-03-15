<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';
   require_once 'modules/members/functions.php';


$pageController->warstwaA("","L");

if ($id>0) {
//------------------------------------------------------------------------------
//                            MEMBER
//------------------------------------------------------------------------------
?>
<center>
<br/>
<table>
   <thead><th style="width:16px;"></th> <th style="width:100px;">Parametr</th><th>Value</th></thead>
   <? require_once 'core/sql.php';
      require_once 'core/funkcje.php';
   $rs = $sqlconnector->query("SELECT * FROM {$pageController->variables->base_members} WHERE id=$id");
   while($rek = mysql_fetch_array($rs)) {?>
       <tr><td></td>   <td> id: </td>               <td><?=$rek[id]?></td></tr>
       <tr><td></td>   <td> login: </td>            <td><?=$rek[login]?></td></tr>
       <tr><td></td>   <td> register time: </td>    <td><?=date('Y-m-d H:i:s',$rek['time_create']);?></td></tr>
       <tr><td></td>   <td> last logged: </td>      <td><?if($rek[logged_last]=="0"){echo "N/A";} else {echo date('Y-m-d H:i',$rek['time_modification']);}?></td></tr>       
       <tr><td></td>   <td> logged times: </td>     <td><?=$rek[logged_times]?></td></tr>       
       <tr><td></td>   <td> type: </td>             <td><img id="icon" alt="member" src="/engine/modules/members/graphics/members/<?=$rek[type];?>.png"/> <?=$modMembers->getType($rek[type])?></td></tr>
       <tr><td></td>   <td> posts: </td>            <td><?=$rek[post]?></td></tr>
   <?}?>
</table>
</center>
<?if($pageController->variables->project_name=="gymtia"){$rs=$sqlconnector->query("SELECT * FROM {$pageController->variables->base_gymtia_diet} WHERE author_id=$id and visible=0");?>
<br/>
<center>
 <table class="lista_gymtia">
 <th>Public diet plans</th><th>url</th>
 <? while($rek = mysql_fetch_array($rs)) { ?>
  <tr><td><a href="/diet/<?=$rek[id]?>"><?= "diet: $rek[title]"; ?></a></td>
   <td> <? if ($rek[visible]!=1) {
    echo "<a href="."http://$_SERVER[SERVER_NAME]/diet/$rek[id]"."><img src='/engine/projects/gymtia/graf/view/$rek[visible].png'/></a>";
   }?></td>
  </tr>
 <?}?>
 </table>
</center>
<br/>
<?}

} else {
//------------------------------------------------------------------------------
//                            MEMBER'S
//------------------------------------------------------------------------------
    require_once 'core/sql.php';
    require_once 'core/funkcje.php';
    $rs = $sqlconnector->pagi("SELECT * FROM {$pageController->variables->base_members}");
?>
<br/>
<center>
<table style="margin-left:2%;margin-right:2%; width: 96%;">
<thead>
  <th width=28px>id</th>
  <th>login</th>
  <th width=60px>log. times</th>
  <th width=140px>logged last</th>
  <th width=140px>date registered</th>
  <th width=25px></th>
  <th width=80px></th></thead>
<?while($rek = mysql_fetch_assoc($rs)){?>
<tr>

    <td><?=$rek['id']?></td>
    <td><a href='/members/<?=$rek[id]?>' rel='nofollow'><?=$rek[login]?></a></td>
    <td><?=$rek[logged_times]?></td>
    <td><?if($rek[time_modification]=="0"){echo "N/A";} else {echo date('Y-m-d H:i',$rek[time_modification]);}?></td>
    <td><?=date('Y-m-d H:i',$rek[time_create])?></td>
    <td><img id="icon" width=18px alt="member" src="/engine/modules/members/graphics/members/<?=$rek[type];?>.png"/></td>
    <td><?=$modMembers->getType($rek[type])?></td>

</tr>
<?}?>
<tfoot><tr><td colspan="99"><div class="pagi"><?=$sqlconnector->pager->renderFullNav($_GET[topic]);?></div></td></tr></tfoot>
</table>
</center>

<?} 

$pageController->warstwaB(); ?>