<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';
require_once 'modules/profil/profilController.php'; 
require_once 'modules/profil/lang/lang.php'; 
$pageController->ilogged();
require_once 'core/funkcje.php';
require_once 'core/sql.php';
require_once 'modules/members/functions.php';

if ($_POST['typ']==3) {    
    require_once 'core/sql.php';
    require_once "projects/{$pageController->variables->project_name}/lib/members.php";
  
   $tab[base]=$pageController->variables->base_members;    
    if ($_POST[first_name]!="") {$tab[first_name] = $_POST[first_name]; }
    if ($_POST[last_name]!="") {$tab[last_name] = $_POST[last_name]; }
    if ($_POST[email2]!="") {$tab[email2] = $_POST[email2]; }
    if ($_POST[security_question]!="") {$tab[security_question] = $_POST[security_question]; }
    if ($_POST[answer]!="") {$tab[answer] = $_POST[answer]; }
    if ($_POST[description]!="") {$tab[description] = $_POST[description]; }
   $tab[where]="id = '$_SESSION[S_ID]'";
   $sqlconnector->update($tab);
}

$rs = $sqlconnector->query("SELECT * FROM {$pageController->variables->base_members} WHERE id='$_SESSION[S_ID]'");
while($wyniki = mysql_fetch_array($rs)) { $rek = $wyniki;  }

$profilController->warstwaA(); ?>

<div style="overflow: auto;">

<form action='<?='/profil/'?>' method=POST>
 <table class="profil_table" style="border: solid 0px red; width: 550px; float: left;">
  <tr><td> Login:</td>                   <td><?=$_SESSION[S_LOGIN]?></td></tr>
  
  <tr><td> <?=FIRST_NAME?>:</td> <td><input type='text' name='first_name' value='<?=$rek[first_name]?>'/></td></tr>
  <tr><td> <?=LAST_NAME?>:</td> <td><input type='text' name='last_name' value='<?=$rek[last_name]?>'/></td></tr>
  <tr><td> <?=E_MAIL?>:</td>                    <td><?=$rek[email]?></td></tr>  
  <tr><td> <?=SECOND_E_MAIL?>:</td> <td><input type='text' name='email2' value='<?=$rek[email2]?>'/></td></tr>
  <tr><td> <?=SECURITY_QUESTION?>:</td> <td><input type='text' name='security_question' value='<?=$rek[security_question]?>'/></td></tr>
  <tr><td> <?=ANSWER?>:</td> <td><input type='text' name='answer' value='<?=$rek[answer]?>'/></td></tr>
  
  <tr><td> Type:</td>                    <td><?=$modMembers->getType($rek[type])?></td></tr>
  <tr><td> id:</td>                         <td><?=$_SESSION[S_ID]?></td></tr>
  <tr><td> <?=LAST_IP?>:</td>                    <td><?=$rek[last_ip]?></td></tr>  
  <tr><td> <?=DATE_REGISTER?>:</td>       <td><?=date('Y-m-d H:i:s',$rek['time_create'])?></td></tr>
  <tr><td> <?=LAST_LOGED?>:</td>          <td><?=date('Y-m-d H:i:s',$rek['time_modification'])?></td></tr>
  <tr><td> <?=LOGGED_TIMES?>:</td>        <td><?=$rek[logged_times]?></td></tr>
  <tr><td> <?=POSTS?>:</td>               <td><?=$rek[post]?></td></tr>
  <tr><td><?=DESCRIPTION?>:</td><td><textarea name="description"><?=$rek[description]?></textarea></td></tr>
  
  <tfoot><tr><td></td><td colspan="99"><input class='submit' value='<?=SAVE?>' type='submit' alt='Submit'/></td></tr></tfoot>
  <input name='typ' type='hidden' value='3' />
 </table>
</form> 

<div style="float: right; border: solid 0px red; margin-right: 60px;">
   
    
    <img style="width: 128px; height: 128px; border: solid 1px silver; margin-left: 40px; margin-top: 60px;" alt="" src="/engine/<?=$pageController->variables->project_name?>/resources/avatars_128/<?=$_SESSION[S_ID]?>.jpg"/>
    
    
<form style="margin: 20px;" enctype="multipart/form-data" action="/engine/profil/general/upload_image.php" method="POST">
<table><tr><td>
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000"/>
    <input name="userfile" type="file"/>
    <input name="id" value="<?=$id?>" type="hidden"/><br/>
    <input type="submit" value="<?=SEND?>"/>
</td></tr></table>
</form>

</div> 
</div>

<hr/>
    
 
<?if($_SESSION[S_TYPE]==0){?>
<table class="profil_table">
 <tr><td>Type:</td><td><?=$modMembers->getMember($_SESSION[S_TYPE])?></td></tr>
</table>
<?}?>

<?if($_SESSION[S_TYPE]==99){?>
<table class="profil_table">
 <tr><td>Type:</td><td><form action='/engine/admin/index.php' method=POST><input value="Admin" type='submit'/></form></td></tr>
</table>
<?}?>

<?if($_SESSION[S_TYPE]==10) {?>
<table class="profil_table">
 <tr><td>Type:</td><td><form action='/engine/admin/index.php' method=POST><input value="Admin" type='submit'/></form></td></tr>
</table>
<?}?> 










<? $profilController->warstwaB(); ?>
