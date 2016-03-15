<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';
   require_once 'modules/contactus/functions.php';

class operations extends _operations {

    public function lista(){
       global $modContactus;
       $params['rs'] = $this->sqlconnector->pagi("SELECT * FROM {$this->tablename} WHERE author_name REGEXP '$this->search' ORDER BY $this->column $this->order");
       $params['col'] = array(
           array('name' => 'id',                                             'width' => 30,   'sort' => true),
           array('name' => 'title',              'title' => _ET_TITLE,                        'sort' => true),
           array('name' => 'author_name',        'title' => _ET_AUTHOR,      'width' => 210,  'sort' => true),
           array('name' => 'type',               'title' => _ET_TYPE,        'width' => 110,  'sort' => true,   'func'=>'list', 'list'=>$modContactus->choiceName),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE, 'width' => 120,  'sort' => true,   'func'=>'time'),
           array('name' => '',                   'title' => _ET_READ,        'width' => 16,                     'func'=>'read'),
       );
       $this->widok_list($params);
    }

}

$operations = new operations("{$pageController->variables->base_contactus}");

?>