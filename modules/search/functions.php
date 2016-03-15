<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

class modSearch extends constructClass{
    
    var $table;
   
    public function input($params){
     
        return "<input name='search' id='search' onkeyup='search_loadpage(1)' type='text'/> ";
        
        //<input value='".$params['input_name']."' type='submit'/>
        
    }
    
    public function search($params){
        require_once 'core/sql.php';
        global $sqlconnector;
        global $pageController;
        return $sqlconnector->pagi("SELECT * FROM {$pageController->variables->base_news} WHERE
         (title like '%$params[title]%' or 
          content like '%$params[title]%' or 
          keywords like '%$params[title]%'or 
          introduction like '%$params[title]%' )",5,5);

    }
    
}

global $modSearch; $modSearch = new modSearch();

?>