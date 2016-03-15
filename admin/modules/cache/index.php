<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public function __construct($params) {
        parent::__construct($params);
        if ($_GET['operation']=='clean'){$this->clean();}
    }

    public function clean(){
        $this->funkcje->rrmdir($_SERVER['DOCUMENT_ROOT']."/temp/cache-files");
        mkdir($_SERVER['DOCUMENT_ROOT']."/temp/cache-files");
        header("location:$_SERVER[HTTP_REFERER]");
    }

}

$operations = new operations("");

?>