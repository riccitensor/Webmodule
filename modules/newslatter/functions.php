<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';  
    
class modNewslatter extends constructClass {
    
    public function __construct(){
        global $pageController; $this->pageController =& $pageController;
        global $sqlconnector; $this->sqlconnector =& $sqlconnector;        
    }
    
    public function checkEmailExist($mail){
        $rek = $sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_newslatter} WHERE email = '$mail' LIMIT 1");
        if ($rek['id']==''){
            return 0;
        } else {
            return $rek['id'];
        }        
    }
    
    public function addEmail($mail){
        require_once 'core/sql.php';
        require_once 'core/funkcje.php';        
        global $sqlconnector;
        global $funkcje;
        global $pageController;        
        if ($this->checkEmailExist($mail)==0){
            $sqlconnector->query("INSERT INTO {$pageController->variables->base_newslatter} SET 
                email='$mail',
                hash='".$funkcje->RandomString(32)."',
                sending='1',
                time_create='".time()."'");
        }
    }
    
    public function unRegisterEmail($mail){
        require_once 'core/sql.php';
        require_once 'core/funkcje.php';        
        global $sqlconnector;
        global $funkcje;
        global $pageController;    
        
        $id = $this->checkEmailExist($mail);
        if ($id>0){            
            $sqlconnector->query("UPDATE {$pageController->variables->base_newslatter} SET 
                sending='0' WHERE id = '$id'");            
        }        
    }    
    
}

global $modNewslatter; $modNewslatter = new modNewslatter();

?>