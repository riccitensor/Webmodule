<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/sql.php';
   require_once 'core/filter.php';
   $filter->wyczysc($_GET,$search,$column,$order);
   
$rs = $sqlconnector->pagi("SELECT
  {$pageController->variables->base_forum_post}.id,
  {$pageController->variables->base_forum_post}.title_id,
  {$pageController->variables->base_forum_post}.author_id,
  {$pageController->variables->base_forum_post}.time_create,
  {$pageController->variables->base_forum_post}.content,
  {$pageController->variables->base_members}.id as author_id,
  {$pageController->variables->base_members}.login as author_name
FROM {$pageController->variables->base_forum_post}
  INNER JOIN {$pageController->variables->base_members} ON {$pageController->variables->base_forum_post}.author_id = {$pageController->variables->base_members}.id
  WHERE title_id=$id    
  ORDER BY time_create DESC
",5,4);

require_once 'modules/emots/emots.php';
if ($rs!="") { ?>
<table class="viewpost">  
<thead><tr><th colspan="99" class="forum-color-<?=$rek[type]?>"><?=$rek[title];?></th></tr></thead>    

<tbody>    
<? if(!empty($rs)) {
while($rek=mysql_fetch_assoc($rs)){?>   
<tr>
  <td><?=date('Y-m-d H:i',$rek[time_create]);?></td> 
  <td><a href='/members/<?=$rek[author_id]?>' rel='nofollow'><?=$rek[author_name]?></a></td>
</tr>

<tr><td></td><td><?=emots(nl2br($rek[content]));?></td></tr> 
<?}}?>
</tbody>

<tfoot>
<tr><th></th><th colspan="99"> 
<ul class="pagi" id="area_buttons"><?=$sqlconnector->pager->renderAjax();?></ul>
</th></tr>
</tfoot>  
</table>

<? } else { echo NO_ITEMS_WITH_THIS_NAME; } ?>


<script>$("#area_buttons li").click(function(){ajaxloadpage(this.id);});</script> 