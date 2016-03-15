<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public $privilage = array(10);

    public function lista(){
       $params['rs'] = $this->sqlconnector->pagi("SELECT * FROM {$this->tablename} WHERE author_name REGEXP '$this->search' ORDER BY $this->column $this->order");
       $params['col'] = array(
           array('name' => 'id',                                             'width' => 30,   'sort' => true),
           array('name' => 'purpose',            'title' => _ET_PURPOSE,     'width' => 70,   'sort' => true),
           array('name' => 'info',               'title' => _ET_INFO),
           array('name' => 'author_name',        'title' => _ET_WHO,         'width' => 110,  'sort' => true),
           array('name' => 'browser',            'title' => _ET_BROWSER,     'width' => 110,  'sort' => true),
           array('name' => 'browser_version',    'title' => _ET_BROWSER_VER, 'width' => 110,  'sort' => true),
           array('name' => 'system',             'title' => _ET_SYSTEM,      'width' => 110,  'sort' => true),
           array('name' => 'ip',                 'title' => _ET_ADDRESS_IP,  'width' => 95,   'sort' => true),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE, 'width' => 120,  'sort' => true,   'func'=>'time'),
           array('name' => '',                   'title' => _ET_READ,        'width' => 16,                     'func'=>'read'),
       );
       $this->widok_list($params);
    }

}

$operations = new operations("{$pageController->variables->base_stats   }");

?>