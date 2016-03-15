<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

require_once 'modules/popup/functions.php';
require_once 'core/funkcje.php';
require_once 'core/xhtml.php';
require_once 'core/filter.php';

class popup_news extends modPopup {
    
    public function form(){?>
      <form name="popup_form" enctype='multipart/form-data' method='POST' action='<?=$_SERVER['REQUEST_URI']?>'>
        <fieldset>
          <legend>EDYTOR</legend>
          <table width='750' style='font-size:12px;'>
            <tr>
                <td>Tytuł</td><td><input type='text' name='title' value='<?=$this->selectedRecord['title']?>' style='width:380px;'/></td>
                <?if($this->id>0){?><td>Data:</td><td><input type='text' disabled name='data' value='<?=date("Y-m-d",$this->selectedRecord['time_create']);?>'  style='width:100px;'/></td> <?}?>
                <?if($this->id>0){?><td>Godzina:</td><td><input type='text' disabled name='godzina'  value='<?=date("H:i:s",$this->selectedRecord['time_create']);?>'  style='width:60px;'/></td><?}?>
            </tr>
            <tr><td>pagelink</td><td><input type='text' name='pagelink' value='<?=$this->selectedRecord['pagelink']?>'  style='width:380px;'/></td></tr>
            <tr><td>Wprowadzenie</td><td><input type='text' name='introduction' value='<?=$this->selectedRecord['introduction']?>'  style='width:380px;'/></td></tr>
            <tr><td>Treść:</td><td colspan="5"><textarea name='content' style='height:300 px;width:550px;font-size:11px;line-height:14px;font-family:verdana;color:#034EA2;font-weight:normal;'><?=$this->selectedRecord[content]?></textarea></td></tr>
            <tr><td>Typ</td><td><?=$this->xhtml->html_select(array('name'=>'type','options'=>array(1=>'news',20=>'gallery'),'selected'=>$this->selectedRecord[type]));?></td></tr>
            

            
            <tr><td colspan='2'><center><?$this->buttonsOperations();?></center></td></tr>
          </table>
        </fieldset>
      </form>

      <?if($this->id>0){?><a target="_blank" href="/engine/admin/modules/gallery/selected/?id=<?=$this->id?>"> zarzadzaj Galeria! </a><?}?>


    <?}
    
}

global $popup_news; $popup_news = new popup_news($pageController->variables->base_news);

$popup_news->select($id);
$popup_news->form();
require_once 'lib/tinymce/init.php';

?>
