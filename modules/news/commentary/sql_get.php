<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
$rs = $sqlconnector->query("SELECT * FROM {$pageController->variables->base_forum_topic} WHERE id='$topic'");
while($wyniki = mysql_fetch_array($rs)) { 
   $rek=$wyniki;
}

$rs = sql_pagi_ajax("SELECT
  {$pageController->variables->base_forum_post}.id,
  {$pageController->variables->base_forum_post}.title_id,
  {$pageController->variables->base_forum_post}.author_id,
  {$pageController->variables->base_forum_post}.time_create,
  {$pageController->variables->base_forum_post}.post,
  {$pageController->variables->base_members}.id as author_id,
  {$pageController->variables->base_members}.login as author_name
FROM {$pageController->variables->base_forum_post}
  INNER JOIN {$pageController->variables->base_members} ON {$pageController->variables->base_forum_post}.author_id = {$pageController->variables->base_members}.id
  WHERE title_id=$topic        
  ORDER BY time_create DESC
",5,4);
?>

<table class="viewpost">  
<thead><tr><th colspan="99" style="background-color:<?=$funkcje->getTopicColor($rek[typ]);?>"><?=$rek[title];?></th></tr></thead>    

<tbody>    
<? if (!empty($rs)) {
while($rek=mysql_fetch_assoc($rs)){?>   
<tr>
  <td><?=date('Y-m-d',$rek[time_create]);?></td> 
  <td><a href='/members/<?=$rek[author_id]?>' rel='nofollow'><?=$rek[author_name]?></a></td>
</tr>
<tr>
  <td><?=date('H:i',$rek[time_create]);?></td><td><?=emots(nl2br($rek[post]));?></td>
</tr> 
<?}
} else {echo "";}
?>
</tbody>

<tfoot>
<tr><th colspan="99"> 
<div id='pagi'><input style="margin-right:150px;" id = "click" value="Send" type='submit'/><?=$sqlconnector->pager->renderFullNav();?></div>
</th></tr>
<tr><th colspan="99">
<textarea id="text" cols='' rows='' name='content' style=''></textarea>
</th></tr>
</tfoot>  
</table>

<script>
    
$("#click").click(function(){
   var text = $('textarea#text').val();
   $.post("/engine/news/commentary/add.php", { topic: "<?=$topic?>", content: text,external_id:<?=$external_id?> } , function(data) {
   if (topic==0){ topic=data; }
    //alert("Data Loaded: " + data);
});

 t=setTimeout("paginationAjaxStart()",500);
});
</script>