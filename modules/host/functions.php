<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';


class modHost extends constructClass {
    
    public function getHost(){
        require_once 'core/logs.php';
        require_once 'core/sql.php';
        $info = $_GET['host_name'];
        $rekord = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_logs} WHERE info='$info' ORDER by id DESC limit 1");
        echo $rekord['ip'];
    }
    
    public function setHost(){
        require_once 'core/logs.php';
        $this->logs->addlog("host",$_GET[host_name]);
        //echo "sprawne";
    }
    
    public function __construct() {
        parent::__construct();
        
        if ($_GET['operation']=='get'){$this->getHost();}
        if ($_GET['operation']=='set'){$this->setHost();}
        
    }
    
}

global $modHost; $modHost = new modHost();

?>