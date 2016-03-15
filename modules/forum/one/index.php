<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
$pageController->warstwaA("");?> 

<script type='text/javascript' src='/engine/core/function.js'></script>
<script>
$(document).ready(function(){ajaxloadpage(1); });
function ajaxloadpage(page){$("#area").load("/engine/modules/forum/one/list_cache.php?page="+page+"&id=<?=$id?>&search=" + urldecode(""));}
</script>

<div id="area">1</div>

<div style="margin-left: 5px; margin-right: 5px;">
<form action="/engine/modules/forum/one/insert.php" method="POST">
<input value="Add" type='submit' style="float: right; height: 100px; width: 55px;"/>
<input value="<?=$id?>" type='hidden' name="id"/>
<textarea id="text" cols='' rows='' name='content' style="height: 100px; width: 93%;" style=''></textarea>
</form>
</div>

<style>
#area {margin: 0%; border: solid 0px red;}
.viewpost thead tr th {font-size: 15px;  font-weight: bold; text-align: center;}
.viewpost {width: 100%;}
.viewpost tbody tr td:nth-child(1) {font-size: 9px; max-width: 180px; width: 180px; background-color: rgba(255,255,255,0.1); background-color: white; text-align: center;}
.viewpost tbody tr td:nth-child(2) {padding-left: 5px; width: 100%;}
.viewpost tr td a {font-size: 9px; font-weight: bold;}
.viewpost tfoot tr th textarea {width: 99%;}
.viewpost tfoot tr th {padding-left: 3px;}
.viewpost tfoot tr th:nth-child(1) {padding-right: 3px;}
.viewpost tfoot tr th:nth-child(2) {padding-right: 3px;}
/*.viewpost tbody tr { border-top: solid 1px red;}*/

</style>

<? $pageController->warstwaB(); ?>