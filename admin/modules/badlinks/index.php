<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public function lista(){
       $params['rs'] = $this->sqlconnector->pagi("SELECT * FROM {$this->tablename} WHERE link REGEXP '$this->search' ORDER BY $this->column $this->order");
       $params['col'] = array(
           array('name' => 'id',                                                   'width' => 30,   'sort' => true),
           array('name' => 'link',               'title' => _ET_LINK,                               'sort' => true,   'func'=>'link', 'link'=>'[link]', 'link_columns'=>array('link')),
           array('name' => 'counter',            'title' => _ET_COUNTER,           'width' => 60,   'sort' => true),
           array('name' => 'time_modification',  'title' => _ET_TIME_MODIFICATION, 'width' => 120,  'sort' => true,   'func'=>'time'),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE,       'width' => 120,  'sort' => true,   'func'=>'time'),
       );
       $this->widok_list($params);
    }

}

$operations = new operations("{$pageController->variables->base_badlinks}");

?>