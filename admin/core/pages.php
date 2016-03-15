<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

 require_once 'core/funkcje.php';
 require_once 'core/sql.php';

class pages_admin {

    var $pageController;
    var $funkcje;

    public function __construct() {
        global $pageController; $this->pageController =& $pageController;
        global $funkcje; $this->funkcje =& $funkcje;
        global $sqlconnector; $this->sqlconnector =& $sqlconnector;
        $pageController->skin("{$pageController->variables->template_admin}");
        if ($_GET['operation']==''){ $this->index(); } 
        if ($_GET['operation']=='index'){ $this->index(); }
        if ($_GET['operation']=='403'){ $this->page_403(); }
        if ($_GET['operation']=='404'){ $this->page_404(); }
        $this->otherOperationsCheck();
    }

    public function otherOperationsCheck(){}

    public function page_403(){
        $this->pageController->warstwaA(); 
        echo $this->funkcje->komunikat("403 access denial");
        $this->pageController->warstwaB();
    }

    public function page_404(){
        $this->pageController->warstwaA(); 
        echo $this->funkcje->komunikat("404 page not found");
        $this->pageController->warstwaB();
    }

    public function index(){
        $this->pageController->warstwaA();
        echo $this->funkcje->komunikat("index");
        $this->pageController->warstwaB();
    }

}

global $pages_admin; $pages_admin = new pages_admin();

?>