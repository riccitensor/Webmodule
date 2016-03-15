<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';
   require_once 'modules/members/functions.php';

class operations extends _operations {

    //var $column = 'login';
    //var $order = 'asc';

    public function lista(){
       global $modMembers;
       $params['rs'] = $this->sqlconnector->pagi("SELECT * FROM {$this->tablename} WHERE login REGEXP '$this->search' ORDER BY $this->column $this->order");
       $params['col'] = array(
       array('name' => 'id',                                                    'width' => 30 ,   'sort' => true),
       //array('name' => '',                     'title' => _ET_IMAGE,            'width' => 32,                     'func'=>'image', 'link'=>'/temp/resources/gymtia/icons_public_24/[id].png', 'link_columns'=>array('id')),
       array('name' => 'login',                                                                   'sort' => true , 'func'=>'link', 'link'=>'/members/[id]', 'link_columns'=>array('id')),
       array('name' => 'email',                                                 'width' => 70,    'sort' => true),
       array('name' => 'last_ip',              'title' => _ET_LAST_IP,          'width' => 90,    'sort' => true),
       array('name' => 'logged_times',         'title' => _ET_LOGGED_TIMES,     'width' => 60,    'sort' => true),
       array('name' => 'time_modification',    'title' => _ET_LOGGED_LAST,      'width' => 120,   'sort' => true,  'func'=>'time'),
       array('name' => 'time_create',          'title' => _ET_DATE_REGISTER,    'width' => 120,   'sort' => true,  'func'=>'time'),
       
       array('name' => '',                     'title' => '',            'width' => 16,   'w'=>16,'h'=>16,  'func'=>'image', 'link'=>'/engine/admin/core/graphics/members/[type].png', 'link_columns'=>array('type')),
           
           
       array('name' => 'type',                 'title' => _ET_PERMISSION,       'width' => 120,   'sort' => true,  'func'=>'list', 'list'=>$modMembers->type),
       array('name' => '',                     'title' => _ET_READ,             'width' => 16,                     'func'=>'read'),
       array('name' => '',                     'title' => _ET_EDIT,             'width' => 16,                     'func'=>'edit'),
       array('name' => '',                     'title' => _ET_DEL,              'width' => 16,                     'func'=>'delete')
       );
       $this->widok_list($params);
    }

    public function widok_insert() {
       $this->pagelink();
       $tmp = "INSERT INTO $this->tablename SET
          login='$_POST[title]',
          password='f561aaf6ef0bf14d4208bb46a4ccb3ad',
          type='1',
          time_create='".time()."';
       ";
       return $tmp;
    }

}

$operations = new operations("{$pageController->variables->base_members}");

?>