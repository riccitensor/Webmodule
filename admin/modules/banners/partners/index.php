<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    var $index_insert = false;
    var $index_search = false;

    public function lista(){
        $params['col'] = array(
           array('name' => 'title',              'title' => _ET_FILE),
           array('name' => 'ext',                'title' => _ET_EXT,                'width' => 25),
           array('name' => 'size',               'title' => _ET_SIZE,               'width' => 80),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE,        'width' => 120),
           array('name' => 'time_modification',  'title' => _ET_TIME_MODIFICATION,  'width' => 120),
           array('name' => 'exec',               'title' => _ET_EXECUTE,            'width' => 16),
           array('name' => 'view',               'title' => _ET_VIEW,               'width' => 16),
           array('name' => 'delete',             'title' => _ET_DEL,                'width' => 16),
        );
        $this->widok_files($params);
    }

    public function index() {
        $this->pageController->admin->warstwaA("");
        $this->widok_upload('banner');
        parent::widok_index();
        $this->pageController->admin->warstwaB();
    }

    public function upload(){
        $file = $_FILES['plik_upload'];
        if ($file['type']=='image/png' or
        $file['type']=='image/jpeg' or
        $file['type']=='image/gif'){
            copy($file[tmp_name], $this->dir.'/'.$file['name']);
        }
        header("location:index.php");
    }

}

$operations = new operations(array('dir'=>"/temp/resources/{$pageController->variables->project_name}/banners/partners"));

?>