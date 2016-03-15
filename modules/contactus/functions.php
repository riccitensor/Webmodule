<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/filter.php';
   
class modContactus extends constructClass {
       
    public $error=0;
    public $is_empty=1;
    
    public $statement_author;
    public $statement_title;
    public $statement_content;
    public $statement_choice;
    public $statement_token;
    
    public $author;
    public $title;
    public $content;
    public $choice;
    
    public $submitted;
    public $komunikaty;
    
    public $choiceName;
    
    public function __construct() {
        parent::__construct();
        
        $this->komunikaty['thanks'] = "Thank you for sending us a message. We will try to answer it as soon as possible";
        $this->komunikaty['author']['1'] = "The author field cannot be empty";
        $this->komunikaty['author']['2'] = "The author field is too short (min 4 characters)";
        $this->komunikaty['author']['3'] = "The author field is too long (max 32 characters)";
        $this->komunikaty['title']['1'] = "The title field is empty";
        $this->komunikaty['title']['2'] = "The title field is too short (min 4 characters)";
        $this->komunikaty['title']['3'] = "The title field is too long (max 80 characters)";
        $this->komunikaty['content']['1'] = "The content field is empty";
        $this->komunikaty['content']['2'] = "The content field is too short (min 4 characters)";
        $this->komunikaty['content']['3'] = "The content field is too long (max N characters)";        
        $this->komunikaty['choice']['1'] = "Not selected";
        $this->komunikaty['token']['1'] = "The token is empty";
        $this->komunikaty['token']['2'] = "The token is incorrect";        
        
        $this->choiceName['0'] = 'N/A';
        $this->choiceName['1'] = 'General Questions';
        $this->choiceName['2'] = 'Bug report';
        $this->choiceName['3'] = 'Suggestions';
        $this->choiceName['4'] = 'Others';
    }

    public function getChoiceName($val){
        return $this->choiceName["$val"];
    }
    
    public function check_author($val,$min=3,$max=32){        
        if ($val!='') {$this->is_empty=0;}       
        $temp = $this->filter->string($val,$min,$max);
        if ($temp>0){
            $this->statement_author = $this->komunikaty['author']["$temp"];
            $this->error=1;
        }
        $this->author=$val;
    }
    
    public function check_title($val,$min=3,$max=80){
        if ($val!='') {$this->is_empty=0;}      
        $temp = $this->filter->string($val,$min,$max);
        if ($temp>0){
            $this->statement_title = $this->komunikaty['title']["$temp"];
            $this->error=1;
        }
        $this->title=$val;
    }
    
    public function check_content($val,$min=3){
        if ($val!='') {$this->is_empty=0;}
        $temp = $this->filter->string($val,$min);
        if ($temp>0){
            $this->statement_content = $this->komunikaty['content']["$temp"];
            $this->error=1;
        }
        $this->content=$val;
    }
    
    public function check_choice($val=0){
        //echo "val = '$val'";
        if (($val=='') or ($val==0)) {            
            $this->statement_choice = $this->komunikaty['choice']["1"];
        } else {
            $this->is_empty=0;
        }
        $this->choice=$val;
    }
    
    public function check_token($val,$val2){
        if ($val!='') {$this->is_empty=0;}       
        $temp = $this->members->check_token($val,$val2);
        if ($temp>0){
            $this->statement_token = $this->komunikaty['token']["$temp"];
            $this->error=1;
        }
    }
    
    public function save(){ 
        global $sqlconnector;
        if ($this->error==0){
            require_once 'core/sql.php';
            $sqlconnector->query("INSERT INTO {$this->pageController->variables->base_contactus} SET
              author_name = '$this->author',
              content = '$this->content',
              title = '$this->title',
              type = '".($this->choice+0)."',
              time_create = '".time()."'
            ");
            //return 'jest ok';
            $this->submitted = 1;
        } else {
            $this->submitted = 0;
        }
    }
    
    public function submitted(){
        if ($this->submitted){
            return 1;
        } else {
            return 0;
        }
    }    
    
    public function checkErrors(){
        if ($this->is_empty==0){
            if ($this->error==1){
                return 1;
            }
        }
        return 0;
    }
    
    public function viewError($type){
        if ($this->checkErrors()){
            if ($type=='author'){ return $this->statement_author; }
            if ($type=='title'){ return $this->statement_title; }
            if ($type=='choice'){ return $this->statement_choice; }
            if ($type=='content'){ return $this->statement_content; }
            if ($type=='token'){ return $this->statement_token; }            
        }
    }
    
}

global $modContactus; $modContactus = new modContactus();

?>