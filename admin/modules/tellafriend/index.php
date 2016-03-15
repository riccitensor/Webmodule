<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    var $index_insert = true;

    public function lista(){
       $params['rs'] = $this->sqlconnector->pagi("SELECT * FROM {$this->tablename} WHERE id REGEXP '$this->search' ORDER BY $this->column $this->order");
       $params['col'] = array(
           array('name' => 'id',                                                   'width' => 30,   'sort' => true), 
           array('name' => 'ip',                                                                                      'func'=>'ip' ),
           array('name' => 'who_id',                                               'width' => 100),
           array('name' => '',                   'title' => _ET_READ,              'width' => 16,                     'func'=>'read'),
           array('name' => '',                   'title' => _ET_EDIT,              'width' => 16,                     'func'=>'edit'),
           array('name' => '',                   'title' => _ET_DEL,               'width' => 16,                     'func'=>'delete'),
       );
       $this->widok_list($params);
    }

}

$operations = new operations("{$pageController->variables->base_tellafriend}");

?>