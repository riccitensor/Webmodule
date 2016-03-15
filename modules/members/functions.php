<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';  
    
class modMembers extends constructClass {
    
    public $type;
    
    public function __construct(){
        parent::__construct();
        $this->type['0'] = 'block';
        $this->type['1'] = 'User';
        $this->type['5'] = 'Bot';
        $this->type['10'] = 'Moderator';
        $this->type['99'] = 'Admin';
    }
        
    public function getType($val) {
        return $this->type["$val"];
    }
    
    public function getMember($params=''){
        require_once 'core/sql.php';
        if ($params[id]!=''){
            return $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_members} WHERE id=$params[id] LIMIT 1");
        } else
        if ($params[login]!=''){
            return $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_members} WHERE login='$params[login]' LIMIT 1");
        } else {
            return $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_members} WHERE id=$_SESSION[S_ID] LIMIT 1");
        }
        
    }
}

global $modMembers; $modMembers = new modMembers();

?>