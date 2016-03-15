<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {
    
    public function index() {
        $this->pageController->admin->warstwaA();
        phpinfo();
        $this->pageController->admin->warstwaB();
    }

}

$operations = new operations("");