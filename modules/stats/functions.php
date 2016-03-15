<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

class modStats extends constructClass {
    

    public function cookie(){
        

        
        if(!isset($_COOKIE['history'])){
            //setcookie('history',uniqid(),0,'/');
            require_once 'core/sql.php';
            $this->sqlconnector->query("INSERT INTO {$this->pageController->variables->base_stats} SET
                
                
            ");
            
        }
    }
    
    public function getParams(){
        
        
        $params['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
        
        
        $this->pageController->pr($params);
    }
    
    
    
}

global $modStats; $modStats = new modStats();

?>