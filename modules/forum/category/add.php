<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   
   
   
if ($_SESSION['zalogowany']==1) {
 require_once 'modules/forum/functions.php';
 require_once 'core/funkcje.php';
 $kom_check_topic = $modForum->check_topic_full($_POST[title]);
 $kom_check_content = $modForum->check_content($_POST[content]);
 $kom_check_choice = $modForum->check_choice($_POST[choice]);
 $_POST[title] = strip_tags($_POST[title]);
 $_POST[content] = strip_tags($_POST[content]);
 if ($kom_check_topic=="" && $kom_check_content=="" && $kom_check_choice=="") {
   require_once 'core/sql.php';
   $nrwatku = $modForum->addForumRow($_SESSION[S_ID],$_POST[title],$_POST[choice]);
   $modForum->addPost($nrwatku, $_POST[content]);
   $modForum->updateStatsUserPosts($_SESSION[S_ID]);
   $modForum->updateStatsForumPosts($nrwatku);
   header("location: /forum/"); exit;
 }    
} else {
   header("location: /register.php"); exit;
}
if ($_POST[title]=="" && $_POST[content]=="" && $_POST[choice]=="") {} else { $wyswietl=1;  }

$pageController->warstwaA("");

?>

<style>
    .forum_newtopic {margin: 20px 50px; border: solid 0px red;}
    .forum_newtopic table tr td input {width:400px;}
    .forum_newtopic table td:nth-child(1) {width: 100px;}
    .forum_newtopic table td:nth-child(2) {width: 415px;}
    .forum_newtopic table tr td select {width:400px;}
    .forum_newtopic table tr td textarea {width:400px;}
</style>

<form class="forum_newtopic" action='/forum/add' method='post'>
 <table>
 <tr><td>Title:</td><td><input name='title' type='text' value='<?=$_POST[title]?>'/></td><td><?if($wyswietl==1){echo $kom_check_topic;}?></td></tr>
 <tr><td>Category:</td><td>
  <select name='choice'>
     <option selected='selected' label='none' value='none'>Select one</option>
     <option label='ideas' value='1'>ideas</option>
     <option label='offtopic' value='2'>offtopic</option>
     <option label='bugs' value='3'>bugs</option>
     <option label='software' value='5'>software</option>
     <option label='hardware' value='6'>hardware</option>
     <?if($_SESSION[S_TYPE]==99){echo "<option label='admin' value='7'>admin</option>}"; }?>
   </select>          
  </td><td><?if($wyswietl==1){echo $kom_check_choice;}?></td></tr>
 <tr><td>Content:</td><td><textarea cols='' rows='' name='content' style=''><?=$_POST[content]?></textarea></td><td><?if($wyswietl==1){echo $kom_check_content;}?></td></tr>
 <tfoot><tr><th></th><th><input name='submit' value='Send' type='submit'/></th></tr></tfoot>
 </table>
</form>

<?  $pageController->warstwaB(); ?>