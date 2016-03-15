<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/sql.php';
   
class modComments extends constructClass {       
   
    public function insert($params){
        $this->sqlconnector->query("INSERT INTO {$this->pageController->variables->base_comments} SET        
            author_id='$_SESSION[S_ID]',
            content='$params[comment]',
            time_create='".time()."'
        ");
    }
    
    public function delete($id  ){
        
    }
    
}

global $modComments; $modComments = new modComments();

?>