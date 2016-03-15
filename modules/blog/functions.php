<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/sql.php';
   require_once 'core/filter.php';
   
class modBlog extends constructClass {       
   
    public $komunikaty=array();
    public $error=0;
    
    function __construct(){
        parent::__construct();        
        
        $this->komunikaty['error']['title']="title is empty";
        $this->komunikaty['error']['content']="content is empty";        
        
        if ($_POST['insert']==1) {                
             $_POST['title'] = $this->filter->parse($_POST['title'],"pl_full",1);
             $_POST['content'] = $this->filter->parse($_POST['content'],"pl_full",1);             
             $_POST['pagelink'] = $this->filter->parse($_POST['title'],"en_simple",1,1,1);
             
             if ($_POST['title']==''){$this->statement_title = $this->komunikaty['error']['title']; $this->error=1;}
             if ($_POST['content']==''){$this->statement_content = $this->komunikaty['error']['content']; $this->error=1;}
                                          
             
             if ($this->error!=1){
                 $this->insert(array('title'=>$_POST['title'],'content'=>$_POST['content'],'pagelink'=>$_POST['pagelink']));
                 //header('location:/dblog/'.$_SESSION[S_ID].'/datainserted');
             }
        }
        
        if ($_POST['update']==1) {  
            
            
            
            
            $_POST['content'] = $this->filter->parse($_POST['content'],"pl_full",1);            
        }
        
        
        
    }
    
    public function viewError($type){
        if ($this->error==1){   
            if ($type=='title'){ return $this->statement_title; }
            if ($type=='content'){ return $this->statement_content; }          
        }
    }

    public function insert($params){
        $this->sqlconnector->query("INSERT INTO {$this->pageController->variables->base_news} SET        
            author_id='$_SESSION[S_ID]',
            author_name='$_SESSION[S_LOGIN]',
            title='$params[title]',
            pagelink='$params[pagelink]',
            content='$params[content]',
            time_create='".time()."'
        ");
    }
    
    public function viewListNews($id=0){
        require_once 'core/sql.php';
        $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_news} WHERE author_id = $id ORDER BY id DESC ");
        while ($rek = mysql_fetch_array($rs)) {
            ?><div><b><a href="/dblog/<?=$rek['id']?>/<?=$rek['author_name']?>/<?=$rek[id]?>/<?=$rek[pagelink]?>"><?=$rek['title']?></a></b></div>                
            <input data-role="tagsinput" value="<?=$rek[content]?>"/>

            <hr/><?
        }
    }
    

    
}

//global $modBlog; $modBlog = new modBlog();

?>