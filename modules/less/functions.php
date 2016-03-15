<? 

class modLess extends constructClass {
    
    var $input;
    var $output;
    
    public function __construct() {
        parent::__construct();        
       // $input = $_SERVER['DOCUMENT_ROOT']."/template/{$pageController-variables}";        
        $this->output = $_SERVER['DOCUMENT_ROOT'].'/temp/styles.css';
    }
    
    
    public function convert($params){
        if (isset($params['input'])){$this->input =  $_SERVER['DOCUMENT_ROOT'].$params[input];}
        if (file_exists($this->input)) { 
            $this->input = $_SERVER['DOCUMENT_ROOT'].$params['input'];
        } else {
            echo 'input dont exist';
            return;
        }
        if (isset($params['output'])){$this->output =  $_SERVER['DOCUMENT_ROOT'].$params[output];}
                
        require_once 'modules/less/lib/lessc.inc.php';
        $this->less = new lessc();
        $this->less->setFormatter("compressed");
        //$less->setFormatter("classic");
        try {
            $this->less->checkedCompile($this->input, $this->output);
        } catch (exception $e) {
            echo "fatal error: " . $e->getMessage();
        }
    }
    

    
}


?>