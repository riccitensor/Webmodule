<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';  
    
   require_once 'core/sql.php';


class modProxyclicker extends constructClass {

    var $agent = array();    
    var $time_url = 1; //next url
    var $time_proxy = 1; //next proxy
    var $time_curl = 1; //request
    var $time_restart = 25; //reset connection
    var $curl = 0;
    
    var $grupa = 'ps4';
    
    public function getAgentRand(){
        return rand(0, count($this->agent) - 1);
    }
    
    public function getAgentId($id){
        return $this->agent[$id];
    }    
    
    public function __construct(){

        //CHROME
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36');        
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36');
        
        //FF
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');
        
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.1; rv:25.0) Gecko/20100101 Firefox/25.0');
        array_push($this->agent, 'Mozilla/5.0 (Windows NT 6.1; rv:14.0) Gecko/20100101 Firefox/14.0.1');
        
        //IE
        array_push($this->agent, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)');
        array_push($this->agent, 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)');
        array_push($this->agent, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; BTRS102886; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET4.0C; FDM; AskTbSGT/5.15.4.23821)');
        array_push($this->agent, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729)');
                
        //OPERA
        array_push($this->agent, 'Opera/9.80 (Windows NT 6.1; Win64; x64) Presto/2.12.388 Version/12.10');
                
        //SAFARI
        //array_push($this->agent, 'Mozilla/5.0 (Linux; U; Android 2.1-update1; pl-pl; U20i Build/2.1.1.A.0.6) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17');
        
    }

    function curlbrowse($params) {        
        if ($this->curl!='1'){
            echo "<pre style='background-color:#FF8888'>curl disabled</pre>";
            return file_get_contents($params['url']);
        }
        
        
        
        
        
//        $loginpassw = 'username:password';
//        $proxy_ip = 'proxy ip';
//        $proxy_port = 'proxy port';
//        $url = 'http://www.domain.com';

        //$loginpassw = '';
        //$proxy_ip = 'ip';
        //$proxy_port = 'port';
        //$url = 'http://93.105.150.98/host_set/test_proxy';
        //echo "<pre>"; print_r($params); echo "</pre>";
        
        $ch = curl_init();        
        curl_setopt($ch, CURLOPT_URL, $params['url']);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, $params['port']);
        curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
        curl_setopt($ch, CURLOPT_PROXY, $params['ip']);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $loginpassw);
        curl_setopt($ch, CURLOPT_HEADER, 0); //1 nie dziala 0 dziala
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        if ($params['timeout']>0){
            echo "<pre style='background-color:#88FF88'>set timeout = $params[timeout]</pre>";            
            curl_setopt($ch, CURLOPT_TIMEOUT, $params['timeout']);
        }
        
        $agent = $this->getAgentId($params['agentid']);
        if ($agent==''){
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12');
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT,  $agent);
        }

//        $header=array(
//          'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12',
//          'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
//          'Accept-Language: en-us,en;q=0.5',
//          'Accept-Encoding: gzip,deflate',
//          'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
//          'Keep-Alive: 115',
//          'Connection: keep-alive',
//        );
//        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    
    public function update_try($id){
        if ($this->curl=='1'){
            $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_proxy} SET try = try + 1 WHERE id = '$id'");
        }
    }
    
    public function update_connect($id){
        if ($this->curl=='1'){
            $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_proxy} SET connect = connect + 1 WHERE id = '$id'");
        }
    }
    
    public function update_failed($id){
        if ($this->curl=='1'){
            $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_proxy} SET failed = failed + 1 WHERE id = '$id'");
        }
    }
      
    
    
    public function nextProxy($id){     
        $proxy_failed_next = $this->sqlconnector->rlo("select * from {$this->pageController->variables->base_proxy} where id = (select min(id) from {$this->pageController->variables->base_proxy} where id > '$id')");
        //$proxy_failed_next = $this->sqlconnector->rlo("select * from {$this->pageController->variables->base_proxy} where try=0 and id = (select min(id) from {$this->pageController->variables->base_proxy} where try=0 and id > '$id')");
        //$proxy_failed_next = $this->sqlconnector->rlo("select * from {$this->pageController->variables->base_proxy} where connect>0 and id = (select min(id) from {$this->pageController->variables->base_proxy} where connect>0 and id > '$id')");
        return $proxy_failed_next[id];
    }
    
    public function checkConnection(){
        if ($sock = @fsockopen('www.google.com',80,$num,$error, 5)){
            return true;
        } else {
            return false;
        }
    }    

}

global $modProxyclicker; $modProxyclicker = new modProxyclicker();

?>