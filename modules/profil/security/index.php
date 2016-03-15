<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';
require_once 'modules/profil/profilController.php'; 
require_once 'modules/profil/lang/lang.php'; 
$pageController->ilogged();

if ($_POST[typ]==3) {
    require_once 'core/sql.php';
    require_once "projects/{$pageController->variables->project_name}/lib/members.php";
    require_once 'core/funkcje.php';
    $rs = $sqlconnector->query("SELECT * FROM {$pageController->variables->base_members} WHERE id='$_SESSION[S_ID]'");
    while($wyniki = mysql_fetch_array($rs)) { $rek = $wyniki;  }
    
    
    $Kom_pass1 = $members->check_password($_POST[Rpass1], $_POST[Rpass2]);        
    $oldpassword = $rek[password];      
    $Kom_oldpassword = $members->check_hasloMD5($oldpassword, md5($_POST[Rpass3]));
    //echo "_SESSION[S_ID]==$_SESSION[S_ID],  _POST[Rpass1]==$_POST[Rpass1]";
    if (empty($Kom_pass1) &&
        empty($Kom_oldpassword)) {
        $members->UpdatePassword($_SESSION[S_ID], $_POST[Rpass1]);
        $Kom_oldpassword="new password updated";
    }
    $_POST[typ]="";
}
$profilController->warstwaA(); ?>

<form action='<?=$_SERVER[PHP_SELF]?>' method=POST>
 <table class="profil_table">
  <tr><td> <?=PASSWORD_OLD?>:</td>    <td><input type='password' name='Rpass3' value=''></td><td><?if($Kom_oldpassword!=""){echo"$Kom_oldpassword";}?></td></tr>
  <tr><td> <?=PASSWORD_NEW?>:</td>    <td><input type='password' name='Rpass1' value=''></td><td><?if($Kom_pass1!=""){echo"$Kom_pass1 <br/>";}?></td></tr>
  <tr><td> <?=PASSWORD_RETYPE?>:</td> <td><input type='password' name='Rpass2' value=''></td><td></td></tr>
  <tfoot><tr><td></td><td colspan="99"><input class='submit' value='<?=SAVE?>' type='submit' alt='Submit'/></td></tr></tfoot>
  <input name='typ' value='3' type='hidden' />
 </table>
</form>   

<? $profilController->warstwaB(); ?>
