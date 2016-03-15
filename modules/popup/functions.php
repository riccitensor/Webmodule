<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/sql.php';
   require_once 'core/filter.php';
   
class modPopup extends constructClass {
    
    var $tableName;
    var $selectedRecord;
    
    public function __construct($tableName) {
        parent::__construct();
        $this->tableName = $tableName;
        $this->html = $html;        
        if ($_GET['operation']=='delete'){$this->delete($_GET[id]);}
        if ($_GET['operation']=='insert'){$this->insert();}
        if ($_GET['operation']=='update'){$this->update();}
        
    }
    
    public function select($id){
        $this->selectedRecord = $this->sqlconnector->rlo("SELECT * FROM $this->tableName WHERE id = '$id'");
    }

    public function delete($id){
        $this->sqlconnector->query("DELETE FROM $this->tableName WHERE id = '$id'");
        echo "<script type='text/javascript' src='/engine/lib/jquery/jquery-1.11.1.min.js'></script>";
        echo "<script>$(document).ready(function(){self.close();});</script>";
    }
    
    public function insert(){
        require_once 'core/sql.php';
        require_once 'core/filter.php';
        
        $text = "INSERT INTO $this->tableName SET \n";               
        $licznik=0;
        $separator='';
        foreach ($_POST as $key => $value) {
            //if ($key=='pid') {continue;}
            
            if ($key == 'pagelink'){
                $value = $this->filter->parse($value,'en_simple',1,1,1);
            }
            
            $text .= "$separator $key = '$value' ";
            if ($licznik==0) {
                $separator=", \n"; $licznik++;
            }
        }
        
        $text .= ", \n visible = 1 ";
        $text .= ", \n time_create = '".time()."'";
        $this->sqlconnector->query("$text");
        echo "<script type='text/javascript' src='/engine/lib/jquery/jquery-1.11.1.min.js'></script>";
        echo "<script>$(document).ready(function(){self.close();});</script>";
    }

    public function update(){
        require_once 'core/sql.php';
        require_once 'core/filter.php';
        //echo "UPDATE!";
        
        //$this->pageController->pr($_POST);
        
        
        $text = "UPDATE $this->tableName SET \n";               
        $licznik=0;
        $separator='';
        foreach ($_POST as $key => $value) {
            //if ($key=='pid') {continue;}
            
            if ($key == 'pagelink'){
                $value = $this->filter->parse($value,'en_simple',1,1,1);
            }
            
            $text .= "$separator $key = '$value' ";
            if ($licznik==0) {
                $separator=", \n"; $licznik++;
            }
        }                
        $text .= " \n WHERE id = $this->id";   
        $this->sqlconnector->query("$text");
        //echo "<pre>$text</pre>";
    }
    
    public function style(){?>
         <style>
            .popup_button {font-size:11px;width:60px;}
        </style>
    <?}
    
    public function buttonsOperations(){?>
        <?if ($this->id>0) {?><input class='popup_button' type='button' value='Zapisz'   alt='Nadpisuje rekord' onClick='document.popup_form.id.value="";document.popup_form.action="?operation=update&id=<?=$_GET[id]?>";document.popup_form.submit();'/><?}?>
        <input class='popup_button' type='button' value='Dodaj'   alt='Dodaje nowy rekord' onClick='document.popup_form.id.value="";document.popup_form.action="?operation=insert";document.popup_form.submit();'/>
        <input class='popup_button' type='button' value='Zamknij' onClick='self.close();'/>
        <?if ($this->id>0) {?><input class='popup_button' type='button' value='Usuń'  onClick='if(confirm("USUNĄĆ REKORD?")) {document.popup_form.action="?operation=delete";document.popup_form.submit();};'/><?}?>
    <?}    
    
}

?>