<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

class forwarding {

    public $debug = 0;
    public $redirectory;
    public $pageController;

    public function __construct() {
        global $pageController; $this->pageController =& $pageController;
        $this->redirectory['login'] = "projects/{$this->pageController->variables->project_name}/pages/pages.php";
        $this->redirectory['login_incorrect'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        $this->redirectory['login_enter'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        $this->redirectory['register'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        $this->redirectory['register_complete'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        $this->redirectory['activate'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        $this->redirectory['logout'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        $this->redirectory['404'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        $this->redirectory['403'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        $this->redirectory['index'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        
        $this->redirectory['reset'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        
        $this->redirectory['contact'] = "projects/{$pageController->variables->project_name}/pages/contact.php";
        $this->redirectory['fcb']['link'] = "/engine/projects/{$pageController->variables->project_name}/pages/fcb/logowanie.php";
        $this->redirectory['fcb']['header'] = 1;
        $this->redirectory['recover'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        
        $this->redirectory['changepass'] = "projects/{$pageController->variables->project_name}/pages/pages.php";
        
        $this->redirectory['news'] = "projects/{$this->pageController->variables->project_name}/news/index.php";
        $this->redirectory['gallery'] = "projects/{$this->pageController->variables->project_name}/gallery/index.php";
        //$this->redirectory['register_complete']['link']  = "/engine/projects/{$pageController->variables->project_name}/pages/pages.php";
        //$this->redirectory['register_complete']['header'] = 1;
    }

    public function check($what=''){
        global $pageController;
        if ($what!=''){
           if ($this->redirectory["$what"]['header']==1){
               if ($this->debug){ echo "location: {$this->redirectory[$what]['link']}"; }
               //echo "location: {$this->redirectory[$what]['link']}";
               header("location: {$this->redirectory[$what]['link']}"); exit;
           } else {
               if ($this->debug){ echo "require_once: {$this->redirectory[$what]}"; }
               require_once "{$this->redirectory[$what]}";
           }
        }
    }

}

global $forwarding; $forwarding = new forwarding();

$forwarding->check($_GET['what']);

?>