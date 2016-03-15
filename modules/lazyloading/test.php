<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'modules/lazyloading/functions.php';

class lazyloading extends modLazyloading {

    public function loadPage() {
        echo 'testowa strona załadowana';
    }
    
    public function index(){
        $this->pageController->warstwaA();
        parent::index();
        $this->pageController->warstwaB();
    }

}

global $modLazyloading; $modLazyloading = new lazyloading();

?>