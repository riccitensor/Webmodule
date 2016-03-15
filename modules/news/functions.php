<?
class modNews extends constructClass {

    public $type;
    
    public function __construct(){
        parent::__construct();        
        //$this->type[''] = 'Unknow';
        //$this->type['0'] = 'Unknow';
        $this->type['1'] = 'News';
        $this->type['2'] = 'Article';
        $this->type['3'] = 'Feuilleton';
        $this->type['4'] = 'Info';
        $this->type['5'] = 'Blog';    
        $this->type['10'] = 'Menu';  
        
        $this->type['20'] = 'Gallery';
        $this->type['30'] = 'Link';
    }
    
    public function getType($val) {
        return $this->type["$val"];
    }
    
    public function getNewsById($id){
        require_once 'core/sql.php';    
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_news} WHERE id='$id' limit 1");    
        $rek['exist'] = 1;    
        return $rek;
    }

    public function getNewsByPageLink($pagelink){
        require_once 'core/sql.php';    
        $rek = $sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_news} WHERE pagelink='$pagelink' limit 1");
        
        if ($rek[id]>0){
            $rek['exist'] = 1;
        }
        return $rek;
    }
    
    public function build_section_select($id){
        echo "<select name='section' class='choice_205'>";
        foreach ($this->type as $key => $value) {
            echo "<option ";
            if($id==$key){ echo 'selected="selected"';}
            echo "label='$value' value='$key'>$value</option>";
        }
        echo "</select>";
    }
        
    public function build_type_select($id){
        echo "<select name='type' class='choice_205'>";
        foreach ($this->type as $key => $value) {
            echo "<option ";
            if($id==$key){ echo 'selected="selected"';}
            echo "label='$value' value='$key'>$value</option>";
        }
        echo "</select>";
    }
                
    public function build_cat_select(){
        require_once 'core/sql.php';
        echo "<select name='cat'>";
        echo "<option label='none' value='0'>none</option>";
        
        if (!$this->sqlconnector->table_exists($this->pageController->variables->base_news_category)){
            return false;
        }
        
        $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_news_category}");
        $rs = $this->NewsCat();
        while($rek_cat = mysql_fetch_array($rs)) {
            echo "<option ";
            if ($rek['cat']==$rek_cat['id']) {echo "selected='selected'";}
            echo "label='$rek_cat[title]' value='$rek_cat[id]'>$rek_cat[title]</option>";
        }
        echo "</select>";
    }  

    public function NewsCat(){
        require_once 'core/sql.php';
        $tab = array();
        if ($this->sqlconnector->table_exists($this->pageController->variables->base_news_category)){
            $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_news_category}");
            while($rek = mysql_fetch_array($rs)){
                $id = $rek[id];
                $tab[$id]=$rek[title];
            }
            return $tab;
        }
        return false;
    }
    
    public function getNewsList(){
        require_once 'core/sql.php';
        return $this->sqlconnector->pagi("SELECT * FROM {$this->pageController->variables->base_news} WHERE visible=1 and content!='' ORDER BY id DESC");
    }    
    
    public function viewListNews(){
        require_once 'core/sql.php';
        $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_news}");
        while ($rek = mysql_fetch_array($rs)) {
            ?><div><b><a href="/news/<?=$rek[id]?>"><?=$rek[title]?></a></b></div>                
            <div><?=$rek[introduction]?></div>
            <div><br/><a href="/news/<?=$rek[id]?>" class="btn btn-info btn-sm">view</a></div>
            <hr/><?
        }
    }
    
}

global $modNews; $modNews = new modNews();

?>