<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public $enginePassword = true;
    public $privilage = array(10,1,-1);

    var $index_buttonName = "backup";
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

    public function exec($file){
        require_once $_SERVER['DOCUMENT_ROOT']."/temp/install/scripts/$file";
        require_once 'core/funkcje.php';
        global $funkcje;
        $this->pageController->admin->warstwaA("");
        $funkcje->kolorowanie_zapytania($sql);
        echo "<pre>Execute Query </pre>";
        $this->sqlconnector->query($sql);
        $this->pageController->admin->warstwaB();
    }

    public function index(){
        $this->pageController->admin->warstwaA('0');
        $this->widok_index();
        $this->pageController->admin->warstwaB();
    }

}

$operations = new operations(array('dir'=>"/temp/install/scripts"));

?>