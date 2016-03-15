<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public function lista(){
       $params['rs'] = $this->sqlconnector->pagi("SELECT * FROM {$this->tablename} WHERE info REGEXP '$this->search' and purpose='host' ORDER BY $this->column $this->order");
       $params['col'] = array(
           array('name' => 'id',                                                 'width' => 30 ,     'sort' => true),
           array('name' => 'info',                                                                   'sort' => true),
           array('name' => 'browser',                                            'width' => 70),
           array('name' => 'browser_version',                                    'width' => 70),
           array('name' => 'system',                                             'width' => 70),
           array('name' => 'ip',                 'title' => _ET_ADDRESS_IP,      'width' => 90),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE,     'width' => 120,     'sort' => true,   'func'=>'time'),
           array('name' => '',                   'title' => _ET_READ,            'width' => 16,                        'func'=>'read')
       );
       $this->widok_list($params);
    }
    
}

$operations = new operations("{$pageController->variables->base_logs}");

?>