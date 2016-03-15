<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class _operations {

    var $privilage = array();
    var $enginePassword=false;

    var $tablename;

    var $index_insert = false;
    var $index_columnName = 'title';
    var $index_buttonName = _BUTTON_INSERT;
    var $index_author = true;
    var $index_search = true;

    var $dir = '';
    var $dir_js = '';

    var $column = 'id';
    var $order = 'desc';
    var $search = '';

    function __construct($params){
        $this->tablename = $params;
        global $pageController; $this->pageController =& $pageController;
        global $sqlconnector; $this->sqlconnector =& $sqlconnector;
        global $filter; $this->filter =& $filter;
        global $funkcje; $this->funkcje =& $funkcje;
        global $id;
        if (!$this->checkPrivilage($_SESSION[S_TYPE])){ $this->nonprivilage(); }
        if (!$this->checkEnginePassword()){  $this->nonenginepassword(); }
        $this->filter->wyczysc($_GET,$this->search,$this->column,$this->order);
        if ($params['dir']!=''){
            $this->dir = $_SERVER['DOCUMENT_ROOT'].$params['dir'];
            $this->dir_js = $params['dir'];
        }

        if ($_GET['operation']==''){ $this->index(); }
        if ($_GET['operation']=='read'){ $this->read($id); }
        if ($_GET['operation']=='view'){ $this->view($_GET['name']); }
        if ($_GET['operation']=='exec'){ $this->exec($_GET['name']); }
        if ($_GET['operation']=='copy'){ $this->copy($id); }
        if ($_GET['operation']=='visible'){ $this->visible($id); }
        if ($_GET['operation']=='edit'){ $this->edit($id); }
        if ($_GET['operation']=='lista'){ $this->lista(); }
        if ($_GET['operation']=='update'){ $this->update($_GET['id']); }
        if ($_GET['operation']=='delete'){ $this->delete($_GET['id']); }
        if ($_GET['operation']=='delete_file'){ $this->delete_file($_GET['name']); }
        if ($_GET['operation']=='save_file'){ $this->save_file($_GET['name']); }
        if ($_GET['operation']=='insert'){ $this->insert($_GET['id']); }
        if ($_GET['operation']=='upload'){ $this->upload($_POST['id']); }
        if ($_GET['operation']=='col_up'){ $this->col_up($_GET['id']); }
        if ($_GET['operation']=='col_dn'){ $this->col_dn($_GET['id']); }
        if ($_GET['operation']=='col_upup'){ $this->col_upup($_GET['id']); }
        if ($_GET['operation']=='col_dndn'){ $this->col_dndn($_GET['id']); }
    }

    function checkPrivilage($who){
        if ($who==99){return true;}
        if (($who==null) or ($who=='')) {$who=-1;}
        foreach ($this->privilage as $key => $value) {
            if ($who==$value){
                return true;
            }
        }
    }

    function checkEnginePassword(){
        if ($this->enginePassword==false){
            return true;
        }
        if ($_SESSION['first_run_password']!=$this->pageController->variables->admin_password){
            return false;
        } else {
            return true;
        }
    }

    public function nonenginepassword(){
        $this->pageController->admin->warstwaA();
            $this->html_engine_password();
        $this->pageController->admin->warstwaB();
        exit;
    }

    public function nonprivilage(){
        $this->pageController->admin->warstwaA();
            $this->html_logowanie();
        $this->pageController->admin->warstwaB();
        exit;
    }

    function html_engine_password(){?>
        <center>
        <form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
         <table style="width:350px; margin-top: 50px; margin-bottom: 50px;">
             <thead><tr><th colspan="99">Engine password</th></tr></thead>
             <tr><td>password:</td><td> <input class="choice_205" type="password" name="first_run_password"/></td></tr>
             <tr><td><input type='submit' value='Enter'/></td></tr>
         </table>
        </form>
        </center>
    <?}

    function html_logowanie(){
        if ($_SESSION['zalogowany']!=1){?>
        <center>
        <form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
         <table style="width:350px; margin-top: 50px; margin-bottom: 50px;">
             <thead><tr><th colspan="99">Server panel</th></tr></thead>
           <tr><td>login:</td><td> <input class="choice_205" type="text" name="login"/></td></tr>
           <tr><td>password:</td><td> <input class="choice_205" type="password" name="haslo"/></td></tr>
           <tr><td><input type="hidden" name="chcesielogowac" value="1"/>
             <input type='submit' value='Enter'/>
           </td></tr>
         </table>
        </form>
        </center>
        <?
        }else{?>
        <center>
        <form method="post" action="/">
         <table style="width:350px; margin-top: 50px; margin-bottom: 50px;">  
           <thead><tr><th colspan="99">Server panel</th></tr></thead>
           <tr><td>You are logged as: <strong><?=$_SESSION['S_LOGIN']?></strong> without permissions
                   to view this page. Please logged on the website as an administrator/moderator
                   or contact with a developer through the <a href="/contact_us.php"><i>contact form</i></a>
               </td></tr>
           <tr><td><input type="hidden" name="chcesielogowac" value="1"/>
             <input type='submit' value='Exit'/>
           </td></tr>
         </table>
        </form>
        </center>
        <?}
    }

    public function save_file($name){}
    
    public function upload($id){}
    
    public function lista($params=array()){}
    
    public function delete($id){
        $this->sqlconnector->query("DELETE FROM {$this->tablename} WHERE id = $id");
        header('location:index.php');
    }

    public function index(){
        $this->pageController->admin->warstwaA('99');
        $this->widok_index();
        $this->pageController->admin->warstwaB();
    }

    public function delete_file($name){
        if ($this->dir==''){
            echo "dir is not set";
        } else {
            @unlink("$this->dir/$name");
            echo "delete -> $this->dir/$name";
            header("location:index.php");
        }
    }

    public function visible($id){
        global $sqlconnector;
        $rs = $sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE id=$id");
        if ($rs['visible']!=0) {
            $rs['visible']=0;
        } else {
            $rs['visible']=1;
        }
        $sqlconnector->query("UPDATE {$this->tablename} SET visible = '".$rs['visible']."' WHERE id = $id");
        echo "<img src='/engine/admin/core/graphics/function/vis-{$rs['visible']}.png'/>";
    }

    public function read($id){ 
        $this->pageController->admin->warstwaA('99');
        $params[rek] = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE id = $id");
        //$params[label] = "MEMBER";
        $this->widok_read($params);
        $this->pageController->admin->warstwaB();
    }

    public function edit($id){
        $this->pageController->admin->warstwaA('99');
        $params[rek] = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE id = $id");
        $params[label] = "EDIT";
        $this->widok_edit($params);
        $this->pageController->admin->warstwaB();
    }

    public function update($id){
        global $sqlconnector;
        $params[baza] = $this->tablename;
        $params[omin] = array('validity');
        $sql = $this->widok_update($params, $_POST);
        $sqlconnector->query($sql);
        header("location: index.php"); exit;
    }

    public function insert($id){
        global $sqlconnector;
        
        $sql = $this->widok_insert($this->tablename,$_POST);
        echo "aa $sql";
        $sqlconnector->query($sql);
        
        header("location: index.php"); exit;
    }

    public function copy($id){
        global $sqlconnector;
        $new_id = $sqlconnector->DuplicateMySQLRecord($this->tablename,"id",$id);
        $rs = $sqlconnector->query("UPDATE {$this->tablename} WHERE id=$id");
        header("location: index.php"); exit;
    }

    public function view($name){
        global $funkcje;
        $this->pageController->admin->warstwaA('99');
        echo "<pre>";
        show_source("$this->dir/$name");
        //echo $funkcje->file_load("$this->dir/$name");
        echo "</pre>";
        $this->pageController->admin->warstwaB();
    }

    public function exec($name){
        global $funkcje;
        $this->pageController->admin->warstwaA('99');
        $command = "sh $_SERVER[DOCUMENT_ROOT]/temp/backup/sh/$name";
        echo "<pre>$command</pre>";
        system($command);
        $this->pageController->admin->warstwaB();
    }

    public function col_up($id){
        $params['record'] = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE id=$id limit 1");
        $params['prev_record'] = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE col >= {$params['record']['col']} and id!={$params['record']['id']} ORDER by col ASC limit 1");
        if (($params['record']['col']==$params['prev_record']['col'])){
            $col = $params['record']['col']+1;
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '$col' WHERE id = {$params[record][id]}");
        } else
        if (($params['record']['id']>0)==($params['prev_record']['id']>0)){
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '{$params['record']['col']}' WHERE id = {$params['prev_record']['id']}");
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '{$params['prev_record']['col']}' WHERE id = {$params['record']['id']}");
        }
        header('location:index.php');
    }

    public function col_dn($id){
        $params['record'] = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE id=$id limit 1");
        $params['next_record'] = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE col <= '{$params['record']['col']}' and id!='{$params['record']['id']}' ORDER by col DESC limit 1");
        if (($params['record']['col']==$params['next_record']['col'])){
            $col = $params['next_record']['col']+1;
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '$col' WHERE id = {$params['next_record']['id']}");
        } else
        if (($params['record']['id']>0)==($params['next_record']['id']>0)){
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '{$params['record']['col']}' WHERE id = {$params['next_record']['id']}");
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = '{$params['next_record']['col']}' WHERE id = {$params['record']['id']}");
        }
        header('location:index.php');
    }
    
    public function col_upup($id){
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE col = (SELECT max(col) FROM {$this->tablename}) limit 1");
        if ($rek['id']>0){
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = col-1 WHERE id!=$id ");
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = $rek[col] WHERE id=$id ");
        }
        header('location:index.php');
    }
    
    public function col_dndn($id){
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE col = (SELECT min(col) FROM {$this->tablename}) limit 1");
        if ($rek['id']>0){
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = col+1 WHERE id!=$id ");
            $this->sqlconnector->query("UPDATE {$this->tablename} SET col = $rek[col] WHERE id=$id ");
        }
        header('location:index.php');
    }
    
    
//------------------------------------------------------------------------------
//                              WIDOKI
//------------------------------------------------------------------------------
    
    function widok_read($params){
        if (!isset($params[label])){$params[label]="READ";}
        echo "<table class='karta'>";
        echo "<tr><td width='150' height='40'><h1>$params[label]</h1></td><td></td></tr>";
        foreach($params[rek] as $key => $value){
            if (($key == "time_create") or ($key == "time_modification") or ($key == "time_publish")){
                echo "<tr><td>$key</td><td>".$this->col_date($value)."</td></tr>";
                continue;
            }
            if ($this->omin($params['omin'],$key)){ continue; }
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }
        echo "</table>";
        echo "<div class='karta_button'>";
        echo "<form style='float: right;' action='index.php' method=POST><input value='back' type='submit'/></form>";
        echo "</div>";
    }

    function omin($table,$key){
        if ($table!='') {
            foreach ($table as $omin) {
                if ($key == $omin) {
                    return true;
                }
            }
        }
        return false;
    }

    function widok_list($params){
        if ($params[rs]!="") {
            echo '<table class="lista">';
            foreach ($params[col] as $key){
                $col = "<th ";
                 if ($key[sort]){ $col.= "class='pointer' "; }
                 if ($key[width]){ $col .= "width='{$key[width]}px' "; }
                 if ($key[sort]){ $col .= "onclick=\"op_sortcol('{$key[name]}')\""; }
                $col .= ">";
                 if ($key[sort]){ $col.= "<span id='{$key[name]}'></span>"; }
                 if ($key[title]!='') { $col .= "{$key[title]}"; } else { $col .= "{$key[name]}";}
                $col .= "</th>";
                 echo $col;
            }
            echo '<tbody>';
            while($rek = mysql_fetch_assoc($params[rs])){
                $col2 = "<tr>";
                foreach ($params[col] as $key) {
                    if ($key[func]!='') {
                        $col2 .= "<td>";
                        if ($key[func]=='delete'){ $col2 .= $this->col_delete($rek['id']); }
                        if ($key[func]=='image'){
                            $temp = "$key[link]"; 
                            foreach ($key['link_columns'] as $link_column) {
                                $temp = preg_replace("/\[$link_column\]/", "{$rek[$link_column]}", $temp);
                            }
                            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$temp)){
                                $temp=$key['imgdef'];
                            }
                            $col2 .= $this->col_params(array('operation'=>'image','imgdir'=>$temp,'w'=>$key[w],'h'=>$key[h]));
                        }
                        if ($key[func]=='read'){ $col2 .= $this->col_read($rek['id']); }
                        if ($key[func]=='view'){ $col2 .= $this->col_view_file($rek['id']); }
                        if ($key[func]=='edit'){ $col2 .= $this->col_edit($rek['id']); }
                        if ($key[func]=='ip'){ $col2 .= long2ip($rek[$key['name']]); }
                        if ($key[func]=='time'){ $col2 .= $this->col_date($rek[$key['name']]); }
                        if ($key[func]=='timeg'){ $col2 .= $this->col_time($rek[$key['name']]); }                        
                        
                        if ($key[func]=='copy'){ $col2 .= $this->col_copy($rek['id']); }
                        if ($key[func]=='visible'){ $col2 .= $this->col_visible($rek['id'],$rek['visible']); }
                        if ($key[func]=='list'){ $col2 .= $key['list']["{$rek[$key['name']]}"]; }
                        if ($key[func]=='link'){ 
                            $temp = "<a href='$key[link]'>{$rek[$key[name]]}</a>";
                            foreach ($key['link_columns'] as $link_column) {
                                $temp = preg_replace("/\[$link_column\]/", "{$rek[$link_column]}", $temp);
                            }
                            $col2 .= $temp;
                        }
                        if ($key[func]=='col'){ $col2 .= $this->col_params(array('operation'=>'col','id'=>$rek['id']))."($rek[col])"; }
                        $col2 .= "</td>";
                    } else { 
                        if ($key['chars']!=null){
                            $col2 .= "<td>".$this->pageController->col_text($rek[$key['name']],$key['chars'])."</td>";
                        } else {
                            $col2 .= "<td>".$this->pageController->col_text($rek[$key['name']])."</td>";
                        }
                    }
                }
                $col2 .= "</tr>";
                echo $col2;
            }
            echo "</tbody></table>";
        } else {
            $this->pageController->admin->noItemWithThisName();

        }
        echo "<ul class='pagi' id='area_buttons'>{$this->sqlconnector->pager->renderAjax()}</ul>";
        echo "<script>";
        echo "$('#area_buttons li').click(function(){op_lista(this.id);});";
        echo "$(document).ready(function(){ znaczkiWM();});";
        echo "</script>";
    }

    public function widok_index(){
        if ($this->index_insert==true){$insert = "<input value='$this->index_buttonName' type='submit'/>";}
        echo "<script>$(document).ready(function(){op_lista(1);}); column='$this->column'; order='$this->order'; </script>";
        echo "<form action='index.php?operation=insert' method=POST>";
        echo "<table class='formularz'>
        <thead>
        <tr>";
        //"._SEARCH.":
        if ($this->index_search) {
            echo "<th>";
            if (file_exists('icon.png')){
                echo "<img src='icon.png'/>";
            } else {
                echo "<img src='/engine/core/basis/file.png'/>";
            }
            echo "</th><th><input onkeyup='op_lista()' id='search' name='title' type='text' value=''/></th>"; }
        echo "<th>$insert</th>";
        //echo "<th>".$this->widok_modulinmodul()."</th>";
        
        echo "</tr>
        </thead>
        </table>
        </form>
        <div id='area'></div>";
    }

    function widok_folders($params=array()){
        echo "<div class='komunikat'>";
        $folders = $this->funkcje->getFiles($params['dir'].SEPARATOR,'d');
        foreach ($folders as $key => $value) {
            echo "<form action='$value/'><input type='submit' value='$value'/></form>";
        }
        echo "</div>";
    }

    function widok_modulinmodul(){
        $params['dir'] = $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['SCRIPT_NAME']).'/';
        $folders = $this->funkcje->getFiles($params['dir'],'d');
        echo '<pre>';
        foreach ($folders as $key => $value) {
            echo "<input type='button' value='$value' onclick='javascript:window.location.href=\"$value\"' />";
        }
        echo '</pre>';
    }

    function widok_edit($params){
        echo "<form name='myform' id='myform' action='index.php?operation=update' method='post'>";
        echo "<table class='karta'>";
        echo "<tr><td width='150' height='40'><h1>$params[label]</h1></td><td></td></tr>";
        echo "<tr><td>id</td><td><input disabled value='{$params[rek][id]}'/></td></tr>";
        foreach($params[rek] as $key => $value){
            if (($key == 'id') or ($key == 'time_create') or ($key == 'time_modification') or ($key == 'time_publish') or ($key == 'submit')){continue;}
            //if ($this->omin($params['omin'],$key)){ continue; }
            if ($this->omin($params['omin'],$key)){ continue; }
            echo "<tr><td>$key</td><td><input name='$key' type='text' value='$value'/></td></tr>";
        }
        echo "<tr><td>time_publish</td><td><input disabled value='{$this->col_date($params[rek][time_publish])}'/></td></tr>";
        echo "<tr><td>time_modification</td><td><input disabled value='{$this->col_date($params[rek][time_modification])}'/></td></tr>";
        echo "<tr><td>time_create</td><td><input disabled value='{$this->col_date($params[rek][time_create])}'/></td></tr>";
        echo "<tr><td><input onclick='document.myform.submit();' name='submit' value='Save' type='submit' /></td></tr>";
        echo "<input name='id' value='{$params[rek][id]}' type='hidden'/>";
        echo "</table>";
        echo "</form>";
    }

    function widok_update($params, $post){
       $tmp = "UPDATE $params[baza] SET ";
       $licznik = 0;
       foreach ($post as $key => $value) {
           if (($key == 'id') or ($key == 'time_create') or ($key == 'time_modification') or ($key == 'submit')){continue;}
           if (($key == 'author_id') and ($value == '')) {continue;}
           if ($this->omin($params['omin'],$key)){ continue; }
           if ($licznik>0){ $tmp .= ", ";}
           $tmp .= "$key = '$value'";
           $licznik++;
       }
       $tmp .= ", time_modification = '".time()."'";
       $tmp .= " WHERE id = $post[id] ";
       return $tmp;
    }

    function widok_insert($baza, $post){
       if ($this->index_author==true){
           $author = " author_id='$_SESSION[S_ID]', ";
       }
       $tmp = "INSERT INTO $baza SET
          $author
          pagelink='".$this->filter->parse($post[title],'en_simple',1,1,1)."',
          $this->index_columnName='$post[title]',
          time_create='".time()."';
       ";
       return $tmp;
    }

    public function widok_files($params){
        global $funkcje;
        if ($this->funkcje->checkDir($this->dir,true)) {
            echo '<table class="lista">';
            foreach ($params[col] as $key){
                $col = "<th ";
                 if ($key[width]){ $col .= "width='{$key[width]}px' "; }
                $col .= ">";
                 if ($key[title]!='') { $col .= "{$key[title]}"; } else { $col .= "{$key[name]}";}
                $col .= "</th>";
                 echo $col;
            }
            echo '<tbody>';
            $files = $this->funkcje->getFiles($this->dir);
            foreach ($files as $file) {
                $col2 = "<tr>";
                foreach ($params[col] as $key) {
                    if ($key['name']!='') {
                        $col2 .= "<td>";
                        if ($key['name']=='title'){ $col2 .= "$file"; }
                        if ($key['name']=='size'){ $col2 .= number_format(filesize("$this->dir/$file")/1024,1,'.','')." kb";}
                        if ($key['name']=='ext'){  $ext = pathinfo("$this->dir/$file"); $col2 .= "$ext[extension]"; }
                        if ($key['name']=='delete'){ $col2 .= $this->col_params(array('operation'=>'delete_file','info'=>"Czy napewno skasować plik: $file",'name'=>$file));}
                        if ($key['name']=='time_create'){ $col2 .= date("Y-m-d H:i",filectime("$this->dir/$file")); }
                        if ($key['name']=='time_modification'){ $col2 .= date("Y-m-d H:i",filemtime("$this->dir/$file")); }                        
                        if ($key['name']=='view'){ $col2 .= $this->col_params(array('operation'=>'view','name'=>$file));}
                        if ($key['name']=='exec'){ $col2 .= $this->col_params(array('operation'=>'exec','name'=>$file));}
                        $col2 .= "</td>";
                    }
                }
                $col2 .= "</tr>";
                echo $col2;
            }
            echo "</tbody></table><br/>";
        }
    }

    public function widok_upload($name){?>
        <table class="formularz">
        <thead>
        <tr>
        <th><?=$name?>:</th>
        <th><form action="index.php?operation=upload" method="post" enctype="multipart/form-data"><input type="file" name="plik_upload" /></th>
        <th><input type="submit" value="Send"/></form></th>
        </tr>
        </thead>
        </table>
    <?}


// ****************** COLUMNY *************************************************

    function col_view_file($name){
        return "<a href='index.php?operation=view&name=$name'><img src='/engine/admin/core/graphics/function/look.png' alt='view'/></a>";
    }

    function col_read($id){
        return "<a href='index.php?operation=read&id=$id'><img src='/engine/admin/core/graphics/function/look.png' alt='read'/></a>";
    }

    function col_copy($id){
        return "<img class='pointer' onclick='op_copy(\"$id\",\"Czy wykonać kopię rekordu:\",\"\")' src='/engine/admin/core/graphics/function/copy.png' alt='copy'/>";
    }

    function col_edit($id){
        return "<a href='index.php?operation=edit&id=$id'><img src='/engine/admin/core/graphics/function/edit.png' alt='edit'/></a>";
    }

    function col_delete_file($file,$info="Czy napewno skasować plik?",$dir=""){
        return "<img class='pointer' onclick='op_del_file(\"$file\",\"$info\",\"$dir\")' src='/engine/admin/core/graphics/function/delete.png' alt='delete' />";
    }

    function col_delete($id,$info = ''){
        return "<img class='pointer' onclick='op_del(\"$id\",\"Czy napewno skasować rekord:\",\"\")' src='/engine/admin/core/graphics/function/delete.png' alt='delete' />";
    }

    function col_delete_name($name,$info = 'delete?',$target = 'delete.php',$dir = ''){
        echo "$name | $info | $target";
        return "<img class='pointer' onclick='op_del_name(\"$name\",\"$info\",\"$target\",\"$dir\")' src='/engine/admin/core/graphics/function/delete.png' alt='delete' />";
    }

    function col_params($params){
        if ($params['target']==''){
            $params['target']='index.php';
        }
        $path = $params['dir'].$params['target'];
        if ($params['operation']=='delete'){
            $path .="?operation=delete&name=$params[name]";
            $icon = "src='/engine/admin/core/graphics/function/delete.png' alt='delete'";
            return "<img class='pointer' onclick='op_params(\"$path\",\"$params[info]\")' $icon />";
        }
        if ($params['operation']=='delete_file'){
            $path .="?operation=delete_file&name=$params[name]";
            $icon = "src='/engine/admin/core/graphics/function/delete.png' alt='delete'";
            return "<img class='pointer' onclick='op_params(\"$path\",\"$params[info]\")' $icon />";
        }
        if ($params['operation']=='view'){
            return "<a href='index.php?operation=view&name=$params[name]'><img src='/engine/admin/core/graphics/function/look.png' alt='view'/></a>";
        }
        if ($params['operation']=='exec'){
            return "<a href='index.php?operation=exec&name=$params[name]'><img src='/engine/admin/core/graphics/function/exec.png' alt='exec'/></a>";
        }
        if ($params['operation']=='image'){
            if (!isset($params[w])){$params[w]=16;}
            if (!isset($params[h])){$params[h]=16;}
            return "<img src='$params[imgdir]' width='$params[w]' height='$params[h]'/>";
        }
        if ($params['operation']=='col'){
            return "
            <a href='index.php?operation=col_up&id=$params[id]'><img src='/engine/admin/core/graphics/function/up.gif' alt='up'/></a>
            <a href='index.php?operation=col_dn&id=$params[id]'><img src='/engine/admin/core/graphics/function/dn.gif' alt='dn'/></a>
            <a href='index.php?operation=col_upup&id=$params[id]'><img src='/engine/admin/core/graphics/function/upup.gif' alt='upup'/></a>
            <a href='index.php?operation=col_dndn&id=$params[id]'><img src='/engine/admin/core/graphics/function/dndn.gif' alt='dndn'/></a>
            ";
        }
    }

    function col_exec($destination){
        return "<a href='$destination'><img src='/engine/admin/core/graphics/function/exec.png' alt='exec'/></a>";
    }

    function col_time($time){
        return gmdate("H:i:s", $time);
    }
    
    function col_date($date){
        if($date<1){
            return "N/A";
        } else {
            return date('Y-m-d H:i',$date);
        }
    }

    function col_ip($ip){
        if($ip==""){
            return "N/A";
        } else {
            return $ip;
        }
    }

    function col_visible($id,$flaga){
        return "<div class='pointer' id='vis$id' onclick='op_visible(\"$id\")'><img src='/engine/admin/core/graphics/function/vis-$flaga.png' alt='visible'/></div>";
    }

    public function pagelink(){
        if ($_POST['pagelink']=='') {$_POST['pagelink']=$_POST['title'];}
        $_POST['pagelink'] = $this->filter->parse($_POST['pagelink'],'en_simple');
        $pagelink = $this->filter->parse($_POST['pagelink'],'en_simple',1);
        $params['value'] = $pagelink;
        $params['rs'] = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_news} WHERE pagelink like '$pagelink%' and id != '$_POST[id]'");
        $params['column'] = 'pagelink';
        $_POST['pagelink'] = $this->funkcje->findEmptyNr($params);
    }
    
    public function generateButton($params){
        echo "<form action='$params[link]'><input type='submit' value='$params[title]'/></form>";
    }
    

}

?>