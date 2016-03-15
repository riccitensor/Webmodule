<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';
   
class operations extends _operations {

    public function lista(){
       $params['rs'] = $this->sqlconnector->pagi("SELECT {$this->pageController->variables->base_votes}.* ,
                                                alias1.id as author_id,
                                                alias1.login as who_login
                                             FROM {$this->pageController->variables->base_votes}
                                                LEFT JOIN {$this->pageController->variables->base_members} alias1 ON alias1.id = {$this->pageController->variables->base_votes}.author_id
                                             WHERE alias1.login REGEXP  '$this->search'
                                                ORDER BY $this->column $this->order");

       $params['col'] = array(
           array('name' => 'id',                                                'width' => 30,   'sort' => true),
           array('name' => 'who_login',          'title' => _ET_LOGIN,                           'sort' => true),
           array('name' => 'what',               'title' => _ET_WHAT,           'width' => 130,  'sort' => true),
           array('name' => 'what_id',            'title' => _ET_WHAT_ID,        'width' => 60,   'sort' => true),
           array('name' => 'vote',               'title' => _ET_VOTE,           'width' => 50,   'sort' => true),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE,    'width' => 120,  'sort' => true,   'func'=>'time'),
           array('name' => '',                   'title' => _ET_READ,           'width' => 16,                     'func'=>'read'),
           array('name' => '',                   'title' => _ET_EDIT,           'width' => 16,                     'func'=>'edit'),
           array('name' => '',                   'title' => _ET_DEL,            'width' => 16,                     'func'=>'delete')
       );
       $this->widok_list($params);
    }

}

$operations = new operations("{$pageController->variables->base_votes}");

?>