<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';
   require_once 'modules/news/functions.php';

class operations extends _operations {

    var $index_insert = true;
    var $column ='col';

    public function lista(){
       global $modNews;
       $params['rs'] = $this->sqlconnector->pagi("SELECT * FROM {$this->tablename} WHERE title REGEXP '$this->search' ORDER BY $this->column $this->order");
       $params['col'] = array(
           array('name' => 'id',                                             'width' => 30,   'sort' => true), 
           array('name' => 'dir',                'title' => _ET_DIR,         'width' => 120,  'sort' => true),
           //array('name' => 'title',              'title' => _ET_TITLE,                        'sort' => true,   'func'=>'link', 'link'=>'/news/[id]', 'link_columns'=>array('id')),
           array('name' => 'title',              'title' => _ET_TITLE,                        'sort' => true,   'func'=>'link', 'link'=>'selected/?id=[id]', 'link_columns'=>array('id')),
           array('name' => 'author_name',        'title' => _ET_AUTHOR,      'width' => 110),
           array('name' => 'label',              'title' => _ET_LABEL,       'width' => 50),
           array('name' => 'col',                'title' => _ET_COL,         'width' => 100,  'sort' => true,   'func'=>'col'),
           array('name' => 'type',               'title' => _ET_TYPE,        'width' => 70,   'sort' => true,   'func'=>'list', 'list'=>$modNews->type),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE, 'width' => 120,  'sort' => true,   'func'=>'time'),
           array('name' => 'visible',            'title' => _ET_VIS,         'width' => 16,                     'func'=>'visible'),
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
          type='20',
          time_create='".time()."';
       ";
       return $tmp;
    }

}

$operations = new operations("{$pageController->variables->base_news}");

?>