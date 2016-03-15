<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
require_once 'modules/profil/profilController.php'; 

require_once 'modules/profil/lang/lang.php'; 

if ($_POST[typ]==2) {
    
   $pageController->ilogged();
   require_once 'core/filter.php';  
   require_once 'core/sql.php';  
   
   if ($_POST[lang_choice]==1) {
        $_SESSION[S_lang] = "pl";
        $lang=1;
   } else {
        $_SESSION[S_lang] = "en";
        $lang=0;
   }   
   
   $tab[base]=$pageController->variables->base_members;    
   if ($_POST[Rwaga]!="") {$tab[waga] += $_POST[Rwaga]; $_SESSION[waga]=$tab[waga];}
   if ($_POST[Rwzrost]!="") {$tab[wzrost] += $_POST[Rwzrost]; $_SESSION[wzrost]=$tab[wzrost];}  
   if ($_POST[Rwiek]!="") {$tab[wiek] += $_POST[Rwiek]; $_SESSION[wiek]=$tab[wiek];}
   if ($_POST[choice]!="") {$tab[plec] += $_POST[choice]; $_SESSION[plec]=$tab[plec];}
   if ($_POST[lang]!="") {$tab[lang]=$lang; $_SESSION[S_lang]=$tab[lang];}
   if ($_POST[type_of_body]!="") {$tab[type_of_body]=$_POST[type_of_body]; $_SESSION[type_of_body]=$tab[type_of_body];}
   if ($_POST[blood_type]!="") {$tab[blood_type]=$_POST[blood_type]; $_SESSION[blood_type]=$tab[blood_type];}

   $tab[where]="id = '$_SESSION[S_ID]'";
   $sqlconnector->update($tab);
  // header("location:/profil/"); exit;
}
$profilController->warstwaA(); ?>

<form action='<?=$_SERVER[PHP_SELF]?>' method=POST>
 <table class="profil_table">     
       
  <?if ($pageController->variables->base_gymtia_diet!="") {?>
  <tr><td><?=BODY_WEIGHT?>:</td><td><input type='text' name='Rwaga' value='<?=$_SESSION[waga]?>'></td><td></td></tr>
  <tr><td><?=BODY_HEIGHT?>:</td><td><input type='text' name='Rwzrost' value='<?= $_SESSION[wzrost]?>'></td></tr>
  <tr><td><?=AGE?>:</td><td><input type='text' name='Rwiek' value='<?= $_SESSION[wiek]?>'></td></tr>
  <tr><td><?=SEX?>:</td><td>
   <select name='choice'>
    <option <? if ($_SESSION[plec]==0) {echo 'selected="selected"';} ?> label='<?=UNKNOWN?>' value='0'><?=UNKNOWN?></option>
    <option <? if ($_SESSION[plec]==1) {echo 'selected="selected"';} ?> label='<?=WOMAN?>' value='1'><?=WOMAN?></option>
    <option <? if ($_SESSION[plec]==2) {echo 'selected="selected"';} ?> label='<?=MAN?>' value='2'><?=MAN?></option>
   </select>
  </td></tr>
  <tr><td><?=LANGUAGE?>:</td><td>
   <select name='lang_choice'>
    <option <? if ($_SESSION[S_lang]=="en") {echo 'selected="selected"';} ?> label='EN English' value='0'>EN English</option>
    <option <? if ($_SESSION[S_lang]=="pl") {echo 'selected="selected"';} ?> label='PL Polish' value='1'>PL Polish</option>
   </select>
  </td></tr>
  
  <tr><td><?=BLOOD_TYPE?>:</td><td>
   <select name='blood_type'>
    <option <? if ($_SESSION[blood_type]=="0") {echo 'selected="selected"';} ?> label='<?=UNKNOWN?>' value='0'><?=UNKNOWN?></option> 
    <option <? if ($_SESSION[blood_type]=="1") {echo 'selected="selected"';} ?> label='ABRh+' value='1'>ABRh+</option>
    <option <? if ($_SESSION[blood_type]=="2") {echo 'selected="selected"';} ?> label='ABRh-' value='2'>ABRh-</option>
    <option <? if ($_SESSION[blood_type]=="3") {echo 'selected="selected"';} ?> label='ARh+' value='3'>ARh+</option>
    <option <? if ($_SESSION[blood_type]=="4") {echo 'selected="selected"';} ?> label='ARh-' value='4'>ARh-</option>    
    <option <? if ($_SESSION[blood_type]=="5") {echo 'selected="selected"';} ?> label='BRh+' value='5'>BRh+</option>
    <option <? if ($_SESSION[blood_type]=="6") {echo 'selected="selected"';} ?> label='BRh-' value='6'>BRh-</option>        
    <option <? if ($_SESSION[blood_type]=="3") {echo 'selected="selected"';} ?> label='0Rh+' value='3'>0Rh+</option>
    <option <? if ($_SESSION[blood_type]=="4") {echo 'selected="selected"';} ?> label='0Rh-' value='4'>0Rh-</option>    
   </select>
  </td></tr> 
  
  <tr><td><?=TYPE_OF_BODY?>:</td><td>
   <select name='type_of_body'>
    <option <? if ($_SESSION[type_of_body]=="0") {echo 'selected="selected"';} ?> label='<?=UNKNOWN?>' value='0'><?=UNKNOWN?></option>
    <option <? if ($_SESSION[type_of_body]=="1") {echo 'selected="selected"';} ?> label='Ektomorfik' value='1'>Ektomorfik</option>
    <option <? if ($_SESSION[type_of_body]=="2") {echo 'selected="selected"';} ?> label='Endomorfik' value='2'>Endomorfik</option>
    <option <? if ($_SESSION[type_of_body]=="3") {echo 'selected="selected"';} ?> label='Mezomorfik' value='3'>Mezomorfik</option>
   </select>
  </td></tr>  
  
  
  <?}?>
  <tfoot><tr><td></td><td colspan="99"><input class='submit' value='<?=SAVE?>' type='submit' alt='Submit'/></td></tr></tfoot>
 </table>
 <input name='typ' value='2' type='hidden'/>
</form>

<? $profilController->warstwaB(); ?>
