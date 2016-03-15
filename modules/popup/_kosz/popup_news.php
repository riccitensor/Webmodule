<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

require_once 'modules/popup/popup.php';
require_once 'projects/_radom/functions.php';
require_once 'core/funkcje.php';
require_once 'core/html.php';
require_once 'core/filter.php';

class popup_news extends popup {
    
    var $dzialyWidziane = array(); //visible 0-1
    var $dzialyIstniejace = array(); //czy istnieje rekord w bazie  (1=tak)
    
    public function form(){
        global $radom_functions;
        global $html;
        ?>
        <style>
            legend {}
            .popup_button {font-size:11px;width:60px;}
        </style>

        <form name="popup_form" enctype='multipart/form-data' method='post' action='<?=$_SERVER[REQUEST_URI]?>'>
            <input type=hidden name=id value='<?=$this->selectedRecord[id]?>'/>
            <fieldset>
                <legend>EDYTOR</legend>
                <table width=750 style='font-size:11px;'>                   
                    <tr>
                        <td>Tytuł</td>
                        <td><input type=text name='title' value='<?=$this->selectedRecord[title]?>' style='width:380px;'/></td>
                        <td>Data:</td>
                        <td><input type='text' disabled name='data' value='<?=date("Y-m-d",$this->selectedRecord[time_create]);?>'  style='width:100px;'/></td> 
                        <td>Godzina:</td>
                        <td><input type=text name='godzina' disabled value='<?=date("H:i:s",$this->selectedRecord[time_create]);?>'  style='width:60px;'/></td>
                    </tr>
                    
                    <tr><td>page_link</td><td><input type=text name='url_keywords' value='<?=$this->selectedRecord[url_keywords]?>'  style='width:380px;'/></td></tr>
                    <tr><td>Wprowadzenie</td><td><input type=text name='introduction' value='<?=$this->selectedRecord[introduction]?>'  style='width:380px;'/></td></tr>
                    <tr><td>Treść:</td><td colspan="5"><textarea name='content' style='height:300 px;width:550px;font-size:11px;line-height:14px;font-family:verdana;color:#034EA2;font-weight:normal;'><?=$this->selectedRecord[content]?></textarea></td></tr>
                    <tr><td>Status</td><td>
                        <? echo $html->html_select(array('name'=>'status','options'=>$radom_functions->status,'selected'=>$this->selectedRecord[status])); ?>
                    </td></tr>
                    
                    <tr><td>Działy: </td><td><table>                        
                        <tr><?for($xx=1;$xx<=17;$xx++){ if ($this->dzialyWidziane[$xx]==1){$checked='checked';}else{$checked='';};?>
                        <td><?=$html->html_checkbox(array('name'=>"dzial_$xx",'checked'=>$this->dzialyWidziane[$xx]==1)); ?></td>
                        <?}?></tr>
                    </table></td></tr>

                    <tr><td colspan=2>
                        <center>
                        <input class="popup_button" type=submit name=f id='f_s' value='ZAPISZ'  alt='NADPISUJE REKORD'/>
                        <input class="popup_button" type=button name=f id='f_a' value='DODAJ'  alt='DODAJE NOWY REKORD' onClick='document.adm.id.value="";document.adm.action="?f=ZAPISZ";document.adm.submit();'/>
                        <input class="popup_button" type=button name=f id='f_c' value='ZAMKNIJ' onClick='self.close();'/>
                        <input class="popup_button" type=button name=f id='f_d' value='SKASUJ' onClick='if(confirm("USUNĄĆ REKORD?")) {document.popup_form.action="?f=SKASUJ";document.popup_form.submit();};'/>
                        </center>
                    </td></tr>
            </table>
            </fieldset>
        </form>
    <?}    
    
    public function checkDzialy($id){
        global $sqlconnector;
        global $pageController;        
        $rs = $sqlconnector->query("SELECT * FROM {$pageController->variables->base_news_sort} WHERE news_id = '$id'");
        while($rek = mysql_fetch_assoc($rs)){  
            //echo "<pre>";print_r($rek);echo "</pre>";
            $this->dzialyIstniejace[$rek[typ]] = 1;
            $this->dzialyWidziane[$rek[typ]] = $rek['visible'];
        }
    }
}

global $popup_news; $popup_news = new popup_news($pageController->variables->base_news);

$popup_news->checkDzialy($id);


//$popup_news->closeWindow();

if ($_POST[f]=='ZAPISZ'){    
    for($xx=1;$xx<=17;$xx++){
        if ($popup_news->dzialyIstniejace[$xx]!=1){            
            $col = $radom_functions->getMaxInType($xx);
            $query = " INSERT INTO {$pageController->variables->base_news_sort} SET typ='$xx', news_id='$id', col='$col'"; 
            $sqlconnector->query("$query");
            $pageController->pr($query);
        }
    }
        
    $dzial_visible = '';
    $dzial_hidden = '';
    for($xx=1;$xx<=17;$xx++){
        if ($_POST["dzial_$xx"]==1){
            if ($dzial_visible!='') {$dzial_visible.=' or ';}
            $dzial_visible .= "typ = '$xx'";
        } else {
            if ($dzial_hidden!='') {$dzial_hidden.=' or ';}
            $dzial_hidden .= "typ = '$xx'";
        }
    }
    if ($dzial_visible!=''){
        $dzial_visible = " ($dzial_visible) and ";
    }
    if ($dzial_hidden!=''){
        $dzial_hidden = " ($dzial_hidden) and ";
    }
    
    
    $query1 = "UPDATE {$pageController->variables->base_news_sort} SET visible = '1' WHERE $dzial_visible news_id = '$id' ";
    $sqlconnector->query($query1);
    $pageController->pr($query1);
    
    if ($dzial_hidden!=''){
        $query2 = "UPDATE {$pageController->variables->base_news_sort} SET visible = '0' WHERE $dzial_hidden news_id = '$id' ";
        $sqlconnector->query($query2);
        $pageController->pr($query2);
    }
    
    
    
    
    
    
    function findEmptyNr($params){
        $baza_wynikow = array();
        while($rek = mysql_fetch_assoc($params['rs'])){            
            $baza_wynikow[] = $rek["$params[column]"];            
        }        
        $exist = 0;
        foreach ($baza_wynikow as $key => $value) {
            //echo $rek["$params[column]"]."wwww <br/>";
            if ($value==$params['value']){                
                $exist = 1;
            }
        }        
        if ($exist==0) {            
            return $params[value];
        }

        for ($xx=1;$xx<=100;$xx++){
            $exist = 0;
            foreach ($baza_wynikow as $key => $value) {
                //echo "x == ".$value." == ".$params['value']."$xx"."<br/>";
                if ($value==$params['value']."$xx"){
                    $exist = 1;
                }
            }
            
            if ($exist==0) {                
                return $params[value]."$xx";
            }
        }
    }
    
    //$_POST[url_keywords] = 'abc';
    $url_keywords = $filter->parse($_POST[url_keywords],'en_simple',1);
    $params['value'] = $url_keywords;
    $params['rs'] = $sqlconnector->query("SELECT * FROM {$pageController->variables->base_news} WHERE url_keywords like '$url_keywords%' and id != '$id'");
    $params['column'] = 'url_keywords';
    
    //echo "<br/>-> ".findEmptyNr($params);
    $url_keywords = findEmptyNr($params);
    
    
    $sqlconnector->query("UPDATE {$pageController->variables->base_news} SET
            title='$_POST[title]' , 
            content = '$_POST[content]',
            url_keywords = '$url_keywords',
            introduction = '$_POST[introduction]',
            status='$_POST[status]',
            time_modification = '".time()."'            
            WHERE id = '$id'");
    
    for ($xx=1;$xx<=17;$xx++){        
        $funkcje->file_delete($_SERVER['DOCUMENT_ROOT']."/temp/cache-files/news/typ-$xx/news-id-$id.cache");
    }
    $popup_news->checkDzialy($id);    
    $radom_functions->generateArrayLastToView();
} else if ($_GET[f]=='SKASUJ'){
    //$popup_news->delete($id);
    //echo "UPDATE {$pageController->variables->base_news_sort} WHERE news_id = '$id' ";
   // echo "<br/><br/>";
    $sqlconnector->query("UPDATE {$pageController->variables->base_news_sort} SET visible = '0' WHERE news_id = '$id' ");
    $sqlconnector->query("UPDATE {$pageController->variables->base_news} SET status = '4' WHERE id = '$id' ");
}

$popup_news->select($id);

//$pageController->pr($_POST);
//$pageController->pr($_GET);
//$pageController->pr($popup_news->dzialyWidziane);



$popup_news->form();

require_once 'lib/tinymce/init.php';

//$sqlconnector->query("        REPLACE INTO {$pageController->variables->base_news_sort} (news_id,typ) VALUES (3,3);");

?>