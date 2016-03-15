<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';
   $pageController->ronce('modules/news/functions.php');

class operations extends _operations {

    var $index_insert = true;
    var $column = "col";
    var $order = "desc";

    public function lista(){
       global $modNews;       
       $params['rs'] = $this->sqlconnector->pagi("SELECT * FROM {$this->pageController->variables->base_news} WHERE title REGEXP '$this->search' ORDER BY $this->column $this->order");
       $params['col'] = array(
           array('name' => 'id',                                             'width' => 30,   'sort' => true), 
           array('name' => 'dir',                'title' => _ET_DIR,         'width' => 120,   'sort' => true),
           array('name' => 'title',              'title' => _ET_TITLE,                        'sort' => true,   'func'=>'link', 'link'=>'/news/[id]', 'link_columns'=>array('id')),
           array('name' => 'author_name',        'title' => _ET_AUTHOR,      'width' => 110),
           array('name' => 'label',              'title' => _ET_LABEL,      'width' => 50),
           array('name' => 'col',                'title' => _ET_COL,         'width' => 100,   'sort' => true,   'func'=>'col'),
           array('name' => 'type',               'title' => _ET_TYPE,      'width' => 70,   'sort' => true,   'func'=>'list', 'list'=>$modNews->type),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE, 'width' => 120,  'sort' => true,   'func'=>'time'),
           array('name' => 'visible',            'title' => _ET_VIS,         'width' => 16,                     'func'=>'visible'),
           array('name' => '',                   'title' => _ET_COPY,        'width' => 16,                     'func'=>'copy'),
           array('name' => '',                   'title' => _ET_EDIT,        'width' => 16,                     'func'=>'edit'),
           array('name' => '',                   'title' => _ET_DEL,         'width' => 16,                     'func'=>'delete'),
       );
       $this->widok_list($params);
    }

    public function widok_insert() {
       $maxcol = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE col = (select max(col) from {$this->tablename} where col > 0)");
       $this->pagelink();
       if ($this->index_author==true){
           $author = " author_id='$_SESSION[S_ID]', ";
       }
       $tmp = "INSERT INTO $this->tablename SET
          $author
          $this->index_columnName='$_POST[title]',
          pagelink='$_POST[pagelink]',
          col = '".($maxcol[col]+1)."',
          type='1',
          time_create='".time()."';
       ";
       return $tmp;
    }

    public function update(){
        $this->pagelink();
        $params['baza'] = $this->tablename;
        $params['omin'] = array('html','validity');
        $_POST['content'] = addslashes($_POST['html']);
        if ($_POST['author_name']=='') {$_POST['author_name']=$_SESSION['S_LOGIN'];}
        if ($_POST['keywords']=='') {$_POST['keywords']=$_POST['title'];}
        if ($_POST['description']=='') {$_POST['description']=$_POST['title'];}
        if ($_POST['label']=='') {$_POST['label']=$_POST['label'];}
        $sql = $this->widok_update($params, $_POST);
        echo "sql = $sql";
        $this->sqlconnector->query($sql);
        header("location: index.php"); exit;
    }

    public function copy($id){
        $new_id = $this->sqlconnector->DuplicateMySQLRecord($this->tablename,"id",$id);
        $rs = $this->sqlconnector->query("UPDATE {$this->tablename} SET
        forum_id = '0'
        WHERE id='$id'");
        header("location: index.php"); exit;
    }

    public function delete_file(){
        global $id;
        $file = $_GET['file'];
        unlink("$_SERVER[DOCUMENT_ROOT]/temp/resources/{$this->pageController->variables->project_name}/news_img/$id/$file");
        header("Location:index.php?operation=edit&id=$id"); exit;
    }

    public function widok_edit($id) {
        global $modNews;
        global $id;
        $this->funkcje->mkdir_resources('news_img');
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE id = '$id'");
        ?>
        <form name="myform" id="myform" action='index.php?operation=update' method='post'>
        <table class="karta">
         <tr>
             <td>Title:</td><td><input name='title' type='text' value='<?=$rek['title']?>'/></td>
             <td><? $modNews->build_type_select($rek['type']);?></td>
             <td><?=date("Y-m-d H:i:s",$rek[time_create])?></td>

         </tr>
         <tr><td>Introduction:</td><td colspan="3"><input style="width: 620px;" name='introduction' value='<?=$rek['introduction']?>'/></td></tr>
         <tr><td>pagelink:</td><td><input name='pagelink' type='text' value='<?=$rek['pagelink']?>'/></td></tr>
         <tr><td>Author:</td><td><input name='author_name' type='text' value='<?=$rek['author_name']?>'/></td></tr>
         <tr><td>Keywords:</td><td> <input name='keywords' type='text' value='<?=$rek['keywords']?>'/></td></tr>
         <tr><td>Description:</td><td><input name='description' type='text' value='<?=$rek['description']?>'/></td></tr>
         <tr><td>Label:</td><td><input name='label' type='text' value='<?=$rek['label']?>'/></td></tr>
         <tr><td>Dir:</td><td> <input name='dir' type='text' value='<?=$rek['dir']?>'/></td></tr>
         <tr><td>Col:</td><td> <input name='col' type='text' value='<?=$rek['col']?>'/></td></tr>
         <tr></tr>
<!--     <tr><td>link:</td><td><a href="/news/<?=$id?>"/>/news/<?=$id?></a></td></tr>
         <tr><td>link:</td><td><a href="/post/<?=$id?>"/>/post/<?=$id?>/</a></td></tr>
         <tr><td>link:</td><td><a href="/post/<?=$id?>/<?=$rek['pagelink']?>/"/>/post/<?=$id?>/<?=$rek['pagelink']?>/</a></td></tr>
         <tr><td>link:</td><td><a href="/<?=$rek['pagelink']?>"/>/<?=$rek['pagelink']?>/</a></td></tr>-->
         <tr><td>Content:</td><td colspan="3"><textarea  id="editor1" name='html'><?=stripslashes($rek['content']);?></textarea></td></tr>
         <tr></tr>
        <input name='id' value='<?=$id?>' type='hidden'/>
        </table>
        </form>
        <input onclick="document.myform.submit();" name='submit' value='<?=_BUTTON_SAVE?>' type='submit' />
        <hr/>     
        <table style="width: 950px;">  
            <? $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_upload}  WHERE type=1 AND type_id=$_GET[id] ORDER BY id DESC");
                while ($rek = mysql_fetch_array($rs)){
                    echo "<tr style='border-bottom: solid 1px silver; '>";
                    echo "<td><img style='padding: 3px; width:40px; height: 40px;' src='/temp/upload/$rek[id]/256x256.jpg'/></td>";
                    echo "<td>/temp/upload/$rek[id]/500xN.jpg <br/>/temp/upload/$rek[id]/256x256.jpg</td>";
                    echo "</tr>";
                }
            ?>
        </table> 
        <?//="/engine/admin/modules/gallery/selected/index.php?id=$_GET[id]";?>
        <?//$this->generateButton(array('link'=>"/engine/admin/modules/gallery/selected/index.php\?\i\d=$_GET[id]",'title'=>'Wgraj grafikę!'));?>

        
        <?php require_once 'lib/tinymce/init.php';}
}

$operations = new operations("{$pageController->variables->base_news}");

?>