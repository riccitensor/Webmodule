<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

require_once 'core/sql.php';
require_once 'core/funkcje.php';
require_once 'modules/forum/functions.php';

$pageController->warstwaA("");

$rs = $sqlconnector->pagi("SELECT
 {$pageController->variables->base_forum_topic}.title,
 {$pageController->variables->base_forum_topic}.id,
 {$pageController->variables->base_forum_topic}.time_create,
 {$pageController->variables->base_forum_topic}.type,
 {$pageController->variables->base_forum_topic}.counter,
 {$pageController->variables->base_members}.id as author_id,
 {$pageController->variables->base_members}.login as author_name
 FROM {$pageController->variables->base_forum_topic}
  INNER JOIN {$pageController->variables->base_members} ON {$pageController->variables->base_forum_topic}.author_id = {$pageController->variables->base_members}.id
  ORDER BY time_create DESC",40,10);

?>

<table class="forum">    
<? if ($rs!="") while($rek=mysql_fetch_assoc($rs)){?>   
 <tr class="forum-color-<?=$rek[type]?>">
  <td><?=date('m-d H:i',$rek[time_create]);?></td> 
  <td><a href='/forum/<?=$rek[id]?>'><?=$rek[title]?></a></td> 
  <td><?=$rek[counter];?></td>     
  <td><a href='/members/<?=$rek[author_id]?>'><?=$rek[author_name]?></td> 
  <td><?=$modForum->getTopicTyp($rek[type]);?></td> 
 </tr>
<?}?>  
<tfoot>
 <tr>
  <th><form action='/forum/add' method=POST><input value="NEW TOPIC" type='submit'/></form></th>
  <th><div class='pagi'><?=$sqlconnector->pager->renderFullNav();?></div></th>
 </tr></tfoot>  
</table>

<?$pageController->warstwaB(); ?>