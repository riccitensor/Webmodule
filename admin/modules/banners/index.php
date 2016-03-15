<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public function index() {
        $this->pageController->admin->warstwaA("10");
        $this->widok_folders(array('dir'=>dirname(__FILE__)));
        $this->pageController->admin->warstwaB();
    }

}

$operations = new operations("");

?> 