<? 

class modTools extends constructClass {    
    
    var $path = '/engine/modules/tools/init.php';    
    var $tablename = '';
    var $id = 0;   
    var $type = array(1,2,20);
    
    public function __construct($params=array()){
        parent::__construct();
        
        if ($_SESSION['S_TYPE'] < 99){ return; }
        
        $this->tablename = $this->pageController->variables->base_news;
        if (isset($params['path'])){ $this->path = $params['path']; }
        if ($_GET['operation']=='up'){ $this->col_up($_GET['id'],explode('|',$_GET['type'])); }
        if ($_GET['operation']=='dn'){ $this->col_dn($_GET['id'],explode('|',$_GET['type'])); }
        if ($_GET['operation']=='upup'){ $this->col_upup($_GET['id']); }
        if ($_GET['operation']=='dndn'){ $this->col_dndn($_GET['id']); }
        if ($_GET['operation']=='delete'){ $this->col_delete($_GET['id']); }        
    }
    
    public function getType(){
        $temp = '';
        foreach ($this->type as $value) {
            $licznik++;
            if ($licznik>1){
                $temp .= '|';
            }
            $temp.=$value;
        }
        return $temp;
    }

    public function viewAddButton(){
        if ($_SESSION['S_TYPE'] < 99){ return; }
        echo "<div style='top:0px;left:0px;  overflow:auto; margin-top: 15px;'>";
        echo "<img style='float:left; cursor:pointer;' onclick='popup($this->id);event.stopPropagation()' src='/engine/modules/tools/graf/add.png'>";
        echo "</div>";
    }
    
    
    
    public function viewButtons($params) {
        if ($_SESSION['S_TYPE'] < 99){ return; }
        echo $this->buttons($params);
    }
    
    public function viewFull($params) {
        if ($_SESSION['S_TYPE'] < 99){ return; }
        echo $this->buttons(array('up'=>true,'dn'=>true,'upup'=>true,'dndn'=>true,'delete'=>true,'edit'=>true,'id'=>$params['id']));
    }
    
    public function buttons($params){
        $buttons = '';
        $buttons .= "<div style='position:absolute;top:0px;right:0px;'>";
        if (isset($params['id'])){ $this->id = $params['id']; }
        if (isset($params['edit'])){ $buttons .= $this->button_edit(); }
        if (isset($params['up'])){ $buttons .= $this->button_up(); }
        if (isset($params['dn'])){ $buttons .= $this->button_dn(); }
        if (isset($params['upup'])){ $buttons .= $this->button_upup(); }
        if (isset($params['dndn'])){ $buttons .= $this->button_dndn(); }
        if (isset($params['delete'])){ $buttons .= $this->button_delete(); }    
        $buttons .= "</div>";
        return $buttons;
    }
    
    public function button_up(){
        return "<a onclick='event.stopPropagation()' href='$this->path?operation=up&id=$this->id&type={$this->getType()}'><img src='/engine/modules/tools/graf/up.gif'></a>";
    }
    
    public function button_dn(){
        return "<a onclick='event.stopPropagation()' href='$this->path?operation=dn&id=$this->id&type={$this->getType()}'><img src='/engine/modules/tools/graf/dn.gif'></a>";
    }
    
    public function button_dndn(){
        return "<a onclick='event.stopPropagation()' href='$this->path?operation=dndn&id=$this->id'><img src='/engine/modules/tools/graf/dndn.gif'></a>";
    }
    
    public function button_upup(){
        return "<a onclick='event.stopPropagation()' href='$this->path?operation=upup&id=$this->id'><img src='/engine/modules/tools/graf/upup.gif'></a>";
    }
    
    public function button_delete(){
        return "<a onclick='event.stopPropagation()' href='$this->path?operation=delete&id=$this->id'><img src='/engine/modules/tools/graf/x.gif'></a>";

    }
    
    public function button_edit(){
        return "<img onclick='popup($this->id);event.stopPropagation()' src='/engine/modules/tools/graf/e.gif'>";
    }    
    
    public function col_up($id,$type=array()){
        $temp=' and (';        
        foreach ($type as $key => $value) {
            if ($value > 0){ 
                $licznik++; 
                if ($licznik>1) {
                    $temp .= " or ";
                }
                $temp .= " type='$value' "; 
            }            
        }
        $temp.=') ';
        if ($licznik>0){$sqlType=$temp;}                
        require_once 'core/sql.php';
        $params['record'] = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE id=$id $sqlType limit 1");
        $params['prev_record'] = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE col >= {$params['record']['col']} and id!={$params['record']['id']} $sqlType ORDER by col ASC limit 1");
        if (($params['record']['col']==$params['prev_record']['col'])){
            $col = $params['record']['col']+1;
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '$col' WHERE id = {$params[record][id]}");
        } else
        if (($params['record']['id']>0)==($params['prev_record']['id']>0)){
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '{$params['record']['col']}' WHERE id = {$params['prev_record']['id']}");
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '{$params['prev_record']['col']}' WHERE id = {$params['record']['id']}");
        }
        header("location: $_SERVER[HTTP_REFERER]");
    }

    public function col_dn($id,$type=array()){
        $temp=' and (';        
        foreach ($type as $key => $value) {
            if ($value > 0){ 
                $licznik++; 
                if ($licznik>1) {
                    $temp .= " or ";
                }
                $temp .= " type='$value' "; 
            }            
        }
        $temp.=') ';
        if ($licznik>0){$sqlType=$temp;}        
        require_once 'core/sql.php';
        $params['record'] = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE id=$id $sqlType limit 1");
        $params['next_record'] = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE col <= '{$params['record']['col']}' and id!='{$params['record']['id']}' $sqlType ORDER by col DESC limit 1");
        if (($params['record']['col']==$params['next_record']['col'])){
            
            //echo $this->pageController->pr($params);
            
            $col = $params['next_record']['col']+1;
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '$col' WHERE id = {$params['next_record']['id']}");
        } else
        if (($params['record']['id']>0)==($params['next_record']['id']>0))
        {
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '{$params['record']['col']}' WHERE id = {$params['next_record']['id']}");
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '{$params['next_record']['col']}' WHERE id = {$params['record']['id']}");
        }
        header("location: $_SERVER[HTTP_REFERER]");
    }    
    
    public function col_upup($id){
        require_once 'core/sql.php';
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE col = (SELECT max(col) FROM {$this->tablename}) limit 1");
        if ($rek['id']>0){
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = col-1 WHERE id!=$id ");
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = $rek[col] WHERE id=$id ");
        }
        header("location: $_SERVER[HTTP_REFERER]");
    }
    
    public function col_dndn($id){
        require_once 'core/sql.php';
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE col = (SELECT min(col) FROM {$this->tablename}) limit 1");
        if ($rek['id']>0){
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = col+1 WHERE id!=$id ");
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = $rek[col] WHERE id=$id ");
        }
        header("location: $_SERVER[HTTP_REFERER]");
    }
    
    public function col_delete($id){
        require_once 'core/sql.php';
        $this->sqlconnector->query("UPDATE {$this->tablename} SET visible='0' WHERE id=$id");
        header("location: $_SERVER[HTTP_REFERER]");
    }

}



?>