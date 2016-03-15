<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/sql.php';
   require_once 'core/filter.php';
   
   $filter->wyczysc($_GET,$search,$column,$order);
   $rs = $sqlconnector->pagi("SELECT * FROM {$pageController->variables->base_logs} WHERE who LIKE '$_SESSION[S_LOGIN]' ORDER BY id DESC",15,10);
   
if ($rs!="") { ?>
<table class="lista">
 <th width="30px">id</th>
 <th width="50px">purpose</th>  
 <th>who</th> 
 <th width="120px">Browser</th>
 <th width="80px">Browser Ver.</th>
 <th width="80px">System</th>
 <th width="50px">Lang</th>
 <th width="100px">IP</th>
 <th width="150px">Date</th>

 <tbody>
<?while($rek = mysql_fetch_assoc($rs)){?>
<tr>
  <td><?=$rek[id];?></td>
  <td><?=$rek[purpose];?></td>
  <td><?=$rek[who];?></td>

  <td><?=$rek[browser];?></td>
  <td><?=$rek[browser_version];?></td>
  <td><?=$rek[system];?></td>
  <td></td>
  <td><?=$rek[ip];?></td>
  <td><?=date('Y-m-d H:i:s',$rek[time_create]);?></td>

</tr>
<?}?>
 </tbody>
</table>
<? } else { echo NO_ITEMS_WITH_THIS_NAME; } ?>

<ul class="pagi" id="area_buttons"><?=$sqlconnector->pager->renderAjax();?></ul>
<script>$("#area_buttons li").click(function(){ajaxloadpage(this.id);});</script>