<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    var $index_insert = true;

    public function lista(){
       $params['rs'] = $this->sqlconnector->pagi("SELECT * FROM {$this->tablename} ORDER BY $this->column $this->order");
       $params['col'] = array(
           array('name' => 'id',                                                   'width' => 30,   'sort' => true),
           array('name' => 'link',                                                                  'sort' => true),
           array('name' => 'grupa',                                                'width' => 80,   'sort' => true),
           array('name' => 'time_modification',  'title' => _ET_TIME_MODIFICATION, 'width' => 120,  'sort' => true,   'func'=>'time'),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE,       'width' => 120,  'sort' => true,   'func'=>'time'),
           array('name' => '',                   'title' => _ET_READ,              'width' => 16,                     'func'=>'read'),
           array('name' => '',                   'title' => _ET_EDIT,              'width' => 16,                     'func'=>'edit'),
           array('name' => '',                   'title' => _ET_DEL,               'width' => 16,                     'func'=>'delete'),
       );
       $this->widok_list($params);
    }

}

$operations = new operations("{$pageController->variables->base_listlinks}");

?>