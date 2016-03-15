<?

class modTellafriend extends constructClass {
    
    public function add($params){  
        require_once 'core/sql.php';        
        if ($params['ip']==''){ return; }
        if ($params['who_id']>0) {
            $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_members} WHERE id = '$params[who_id]'");
            if ($rek[id]<1){
                return;
            }
        } else {
            return;
        }
        
        $exist = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_tellafriend} WHERE ip = '".ip2long($params[ip])."' and who_id = '$params[who_id]'");
        
        if ($exist['id']>0) {return;}
        
        $this->sqlconnector->query("INSERT INTO {$this->pageController->variables->base_tellafriend} SET            
            ip='".ip2long($params[ip])."',
            who_id='$params[who_id]',
            time_create='".time()."'        
        ");
    }
    
    public function generateUrl($params){
        if ($params['id']<1){return;}        
        return $_SERVER['SERVER_NAME']."/$params[id]/tellafriend/";        
    }
    
}

global $modTellafriend; $modTellafriend = new modTellafriend();

?>