<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public function __construct($params) {
        parent::__construct($params);        
        if ($_GET['operation']=='login'){$this->login($_GET['dir']);}        
    }
    
    public function login($dir){
        header("location:$dir");
    }

}

$operations = new operations("");

?>