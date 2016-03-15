<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    var $index_buttonName = "backup";
    var $index_insert = true;
    var $index_search = false;

    public function __construct($tableName = null) {
        $this->dir = $_SERVER['DOCUMENT_ROOT']."/temp/backup/files";
        $this->dir_js = "/temp/backup/files";
        parent::__construct($tableName);
    }

    public function insert(){
        //$command = "zip -r $_SERVER[DOCUMENT_ROOT]/temp/backup/files/engine_".date("Y-m-d_H-i-s").".zip $_SERVER[DOCUMENT_ROOT]/engine/";
        $command = "tar -czf $_SERVER[DOCUMENT_ROOT]/temp/backup/files/engine_".date("Y-m-d_H-i-s").".tar $_SERVER[DOCUMENT_ROOT]/engine/";
        //echo "cmd = $command";
        system($command);
        header("location:index.php");
    }

    public function lista(){
        $params['col'] = array(
           array('name' => 'title',              'title' => _ET_FILE),
           array('name' => 'ext',                'title' => _ET_EXT,                'width' => 25),
           array('name' => 'size',               'title' => _ET_SIZE,               'width' => 80),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE,        'width' => 120),
           array('name' => 'time_modification',  'title' => _ET_TIME_MODIFICATION,  'width' => 120),
           //array('name' => 'exec',               'title' => _ET_EXECUTE,            'width' => 16),
           array('name' => 'view',               'title' => _ET_VIEW,               'width' => 16),
           array('name' => 'delete',             'title' => _ET_DEL,                'width' => 16),
        );
        $this->widok_files($params);
    }

}

$operations = new operations("");

?>