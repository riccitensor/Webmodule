<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'modules/news/functions.php';
   
$pageController->cache(); 
$cache_tag = $pageController->cache->Get('news/news-tag-'.$id,'default',$pageController->variables->cache_time_news);
$cache_content = $pageController->cache->Get('news/news-content-'.$id,'default',$pageController->variables->cache_time_news);

if ((is_null($cache_tag)) or (is_null($cache_content))) {
  $rek = $modNews->getNews($id);
  $cache_tag = $pageController->warstwaTagi(array('title'=>$rek[title],'description'=>$rek[description],'keywords'=>$rek[keywords]));
  $pageController->cache->Put('news/news-tag-'.$id, $cache_tag);
  ob_start(); require 'ob.php'; $cache_content = ob_get_contents(); ob_end_clean();
  //$cache_content=' '.$rek[content];
  $pageController->cache->Put('news/news-content-'.$id, $cache_content);  
}

$pageController->warstwaA($cache_tag,"L");
echo $cache_content;

?>
<style>
#area {margin: 0%; border: solid 0px red;}
.viewpost thead tr th {font-size: 15px;  font-weight: bold; text-align: center;}
.viewpost {width: 100%;}
.viewpost tbody tr td:nth-child(1) {font-size: 9px; max-width: 80px; background-color: rgba(255,255,255,0.1);; text-align: center;}
.viewpost tbody tr td:nth-child(2) {padding-left: 5px; width: 100%;}
.viewpost tr td a {font-size: 9px; font-weight: bold;}
.viewpost tfoot tr th textarea {width: 99%;}
.viewpost tfoot tr th {padding-left: 3px;}
.viewpost tfoot tr th:nth-child(1) {padding-right: 3px;}
.viewpost tfoot tr th:nth-child(2) {padding-right: 3px;}
</style>

<script type='text/javascript' src='/engine/core/function.js'></script>
<script>
$(document).ready(function(){ajaxloadpage(1); });
function ajaxloadpage(page){$("#area").load("/engine/news/list.php?page="+page+"&id=<?=$id?>&search=" + urldecode(""));}
</script>

<div class="belka">comments</div>

<div id="area"></div>

<div style="margin-left: 5px; margin-right: 5px;">
<form action="/engine/forum/one/insert.php" method="POST">
<input value="Add" type='submit' style="float: right; height: 100px; width: 52px;"/>
<input value="<?=$id?>" type='hidden' name="id"/>
<textarea id="text" cols='' rows='' name='content' style="height: 100px; width: 92%;" style=''></textarea>
</form>
</div>

<?$pageController->warstwaB();?>