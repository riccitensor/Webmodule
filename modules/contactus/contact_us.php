<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
$pageController->warstwaA("","L");

require_once 'modules/contactus/functions.php';
require_once "projects/{$pageController->variables->project_name}/lib/members.php";

$modContactus->check_author($_POST['author']);
$modContactus->check_title($_POST['title']);
$modContactus->check_content($_POST['content']);
$modContactus->check_choice($_POST['choice']);
//$modContactus->check_token($_POST['captcha'],$_SESSION['captcha']);

$modContactus->save();

?>

<style>
   .contact_us {margin-left: 50px; margin-top: 15px; margin-bottom:15px;}
   .contact_us table td:nth-child(1) {width: 180px; background-color: none;}
   .contact_us input[type=text] {width: 400px; background-color: none;}
   .contact_us select {width: 400px; background-color: none;}
   .contact_us textarea {width: 400px; }
</style>

<? if ($modContactus->submitted()) { ?>
<br/><center><b><?=$modContactus->komunikaty['thanks']?></b></center>
<? } else { ?>
   
<form class="contact_us" action='<?=$PHP_SELF;?>' method='post'>
<table>
 <thead><th colspan="99"><h1>Contact Us </h1></th></thead>
 <tr><td colspan="99">Fields marked * are required<br/><br/></td></tr>
 <tr><td>* Author:</td><td><input name="author" type="text" value="<?=$_POST[author]?>"/><?=$modContactus->viewError('author')?></td></tr>
 <tr><td>* Title:</td><td><input name="title" type="text" value="<?=$_POST[title]?>"/><?=$modContactus->viewError('title')?></td></tr>
 <tr><td>* Category:</td><td>
   <select name="choice">
    <option <?if($_POST['choice']==0){echo "selected='selected'";}?> label="none" value="0">Select one</option>
    <option <?if($_POST['choice']==1){echo "selected='selected'";}?> label="General Questions" value="1">General Questions</option>
    <option <?if($_POST['choice']==2){echo "selected='selected'";}?> label="Bug report" value="2">Bug report</option>
    <option <?if($_POST['choice']==3){echo "selected='selected'";}?> label="Suggestions" value="3">Suggestions</option>
    <option <?if($_POST['choice']==4){echo "selected='selected'";}?> label="Others" value="4">Others</option>
   </select>
   <?=$modContactus->viewError('choice')?>
 </td></tr>
 <tr><td>* Token: <img src='/engine/core/captcha.php' alt='' style='vertical-align: middle'/></td><td><input  name='captcha' type='text' /><?=$modContactus->viewError('token')?></td></tr>
 <tr><td>* Content:</td><td><textarea name="content"><?= $_POST[content] ?></textarea></td></tr>
 <tr><td></td><td><input name="submit" value="Send" type="submit"/><?=$modContactus->viewError('content')?></td></tr>
</table>
</form>

<? } $pageController->warstwaB(); ?>