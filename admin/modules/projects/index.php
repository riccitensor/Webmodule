<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    var $index_buttonName = "backup";
    var $index_insert = false;
    var $index_search = false;

    public function __construct($tableName = null) {
        $this->dir = $_SERVER['DOCUMENT_ROOT']."/engine/projects/";
        $this->dir_js = "/engine/projects";
        parent::__construct($tableName);
    }

    public function lista(){
        $params[col] = array(
           array('name' => 'title',              'title' => _ET_FILE),
           //array('name' => 'ext',                'title' => _ET_EXT,                'width' => 25),
           //array('name' => 'size',               'title' => _ET_SIZE,               'width' => 80),
           //array('name' => 'time_create',        'title' => _ET_TIME_CREATE,        'width' => 120),
           //array('name' => 'time_modification',  'title' => _ET_TIME_MODIFICATION,  'width' => 120),
           array('name' => 'exec',               'title' => _ET_EXECUTE,            'width' => 16),
           //array('name' => 'view',               'title' => _ET_VIEW,               'width' => 16),
           //array('name' => 'delete',             'title' => _ET_DEL,                'width' => 16),
        );
        $this->widok_files($params);
    }

    public function exec($name) {
        require_once 'admin/modules/var/functions.php';
        global $functions_var;
        $functions_var->zmienWartosc("project_name", $name);
        header('location: index.php');
    }

}

$operations = new operations("");

?>