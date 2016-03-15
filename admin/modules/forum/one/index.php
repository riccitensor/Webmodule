<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';
   
class operations extends _operations {    
    
    public function index(){
        parent::index($params);
        echo '<script>function op_lista(page){$("#area").load("index.php?operation=lista&id='.$_GET[id].'&column="+column+"&order="+order+"&page="+page+"&search="+urldecode($("#search").val()));}</script>';
    }

    public function lista(){
       $params['rs'] = $this->sqlconnector->pagi("SELECT
                        {$this->pageController->variables->base_forum_post}.id,
                        {$this->pageController->variables->base_forum_post}.title_id,
                        {$this->pageController->variables->base_forum_post}.author_id,
                        {$this->pageController->variables->base_forum_post}.time_create,
                        {$this->pageController->variables->base_forum_post}.content,
                        {$this->pageController->variables->base_members}.id as author_id,
                        {$this->pageController->variables->base_members}.login as author_name
                        FROM {$this->pageController->variables->base_forum_post}
                        INNER JOIN {$this->pageController->variables->base_members} ON {$this->pageController->variables->base_forum_post}.author_id = {$this->pageController->variables->base_members}.id
                        WHERE title_id='$_GET[id]' and content REGEXP '$this->search'
                        ");
            
       $params['col'] = array(
       array('name' => 'id',                                                         'width' => 30 ,   'sort' => true),
       array('name' => 'title',                'title' => _ET_TITLE,                                   'sort' => true, 'func'=>'link', 'link'=>'one/index.php?id=[id]', 'link_columns'=>array('id')),
       array('name' => 'author_name',          'title' => _ET_WHO,                   'width' => 120,   'sort' => true, 'func'=>'link', 'link'=>'/members/[author_id]', 'link_columns'=>array('author_id')),
       array('name' => 'time_modification',    'title' => _ET_TIME_MODIFICATION,     'width' => 120,   'sort' => true,  'func'=>'time'),
       array('name' => 'time_create',          'title' => _ET_TIME_CREATE,           'width' => 120,   'sort' => true,  'func'=>'time'),
      // array('name' => 'type',                 'title' => _ET_TYPE,                  'width' => 16,    'sort' => true),
       array('name' => '',                     'title' => _ET_READ,                  'width' => 16,                     'func'=>'read'),
       array('name' => '',                     'title' => _ET_EDIT,                  'width' => 16,                     'func'=>'edit'),
       array('name' => '',                     'title' => _ET_DEL,                   'width' => 16,                     'func'=>'delete')
       );
       $this->widok_list($params);
    }
    
}

$operations = new operations("{$pageController->variables->base_forum_post}");

?>