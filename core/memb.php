<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

class _memb extends constructClass {

    public $komunikaty;
    public $debug = 0;
    public $setAuthorization = 0;

    public function komunikat($text){
        if ($this->debug==1){
            echo "<pre>* $text</pre>";
        }
    }    
    
    public function existLogin($params){
        require_once 'sql.php';
        $this->komunikat("login: {$params['login']}");
        $params['login']=strtolower($params['login']);
        $params['login']=trim($params['login']);
        if ($params['login']==''){ $this->komunikat("login: empty"); return 1; }
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->variables->base_members} WHERE login='{$params['login']}' limit 1");
        if ($rek['id']>0){$this->komunikat("login: $params[login] exist"); return 1;}
        $this->komunikat("login: $params[login] not exist");
        return 0;
    }

    public function existEmail($params){
        require_once 'sql.php';
        $this->komunikat("email: {$params['email']}");
        $params['email']=strtolower($params['email']);
        $params['email']=trim($params['email']);
        if ($params['email']==''){ $this->komunikat("email: empty"); return 1; }
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->variables->base_members} WHERE email='{$params['email']}' limit 1");
        if ($rek['id']>0){$this->komunikat("email: $params[email] exist"); return 1;} 
        $this->komunikat("email: $params[email] not exist");
        return 0;
    }
    
    public function register($params){
        require_once 'sql.php';
        require_once 'core/logs.php';
        $params['login']=strtolower($params['login']);
        $params['email']=strtolower($params['email']);
        $params['password']=md5($params['password']);
        $id = $this->sqlconnector->insert("INSERT INTO {$this->variables->base_members} SET
            login='{$params['login']}',
            password='{$params['password']}',
            email='{$params['email']}',
            time_create='".time()."';");
        $this->logs->addlog("register", $params['login']);
        return $id;
    }
    
    public function updateLogin($params){        
        if ((isset($params['login'])) and (isset($params['email']))){
            require_once 'sql.php';
            $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_members} SET 
               login = '{$params['login']}' WHERE email = '{$params['email']}';"); 
        } else {
            if ($this->debug==1){ echo "<pre>login or email dont set</pre>"; }
        }        
    }

    public function updatePassword($params){
        if ((isset($params['password'])) and (isset($params['id']))){
            require_once 'sql.php';
            $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_members} SET 
               password = '".md5($params['password'])."' WHERE id = '{$params['id']}';"); 
        } else {
            if ($this->debug==1){ echo "<pre>password or id of member dont set</pre>"; }
        }   
    }

/******************************************************************************
                        REGISTER VALIDER
******************************************************************************/
    
    public function check_token($text1,$text2) {
        if($text1=="" || $text1==null) {return 1;} else
        if($text1!=$text2) {return 2;} else
        {return 0;}
            
        /*if ($text1=="" || $text1==null) {return "token is empty";} else
            if($text1==$text2){return "";}else{return "token is incorrect please rewrite";}*/
    }

    public function check_email($text){
        if ($text=="" || $text==null) {return 1;} else {
            if(preg_match("/^[A-Za-z0-9\.\_]+@[A-Za-z0-9]+(\.)[A-Za-z0-9]+$/", $text)) {
                return 0;
            }else{
                return 2;
            }
        }
    }

    public function check_login($text){
        $text=trim($text);
        if($text=="" || $text==null) {return 1;} else
        if(!preg_match("/^[A-Za-z_][A-Za-z0-9_]+$/", $text)) { return 2; } else
        if(!preg_match("/^[A-Za-z_][A-Za-z0-9_]{3,}$/", $text)) { return 3; } else
        if(!preg_match("/^[A-Za-z_][A-Za-z0-9_]{3,32}$/", $text)) { return 4; } else
        if(preg_match("/^[A-Za-z_][A-Za-z0-9_]+$/", $text)){ return 0;} else {return 5;}
    }

    public function check_password($text1,$text2){
        if($text1=="" || $text1==null) {return 1;} else
        if($text2=="" || $text2==null) {return 2;} else
        if($text2==$text1){return 0;}else{return 3;}
    }

    public function check_hasloMD5($text1,$text2){
        if($text1=="" || $text1==null) {return "no password selected";} else
        if($text1==$text2) {return "";}else{return "old password is incurret";}
    }
    
/******************************************************************************
                        CHECK / PUT
******************************************************************************/
    public function putToSession(&$LoginDetails){        
        if ($LoginDetails['lang']==1) {$_SESSION['S_lang']="pl";} else {$_SESSION['S_lang']="en";}        
        $_SESSION['S_LOGIN']=$LoginDetails['login'];
        $_SESSION['S_PASSWORD']=$LoginDetails['password'];
        $_SESSION['S_ID']=$LoginDetails['id'];
        $_SESSION['S_TYPE']=$LoginDetails['type'];
        $_SESSION['S_EMAIL']=$LoginDetails['email'];
        $_SESSION['validity']=$LoginDetails['validity'];
        $_SESSION['logged_times']=++$LoginDetails['logged_times'];
        $_SESSION['zalogowany']=1;
        if ($this->pageController->variables->cookies=="on"){
            $member = Array('login'=>$_SESSION['S_LOGIN'],'password'=>$_SESSION['S_PASSWORD']);
            setcookie("member", serialize($member),time()+$this->pageController->variables->cookies_lifetime,'/');
        }
        if ($this->debug==1) {
            echo "<pre>"; print_r($_SESSION); echo "</pre>";
        }
    }
    
    public function destroySession(){
        $_SESSION['S_ID']=0;
        $_SESSION['S_LOGIN']="";
        $_SESSION['S_HASLO']="";
        $_SESSION['S_TYPE']=0;
        $_SESSION['S_EMAIL']="";
        $_SESSION['logged_times']=0;
        $_SESSION['zalogowany']=0;    
        $this->komunikat("destory");
    }
    
    
    public function login($params){
        if ($params['method']==''){
            echo "<pre>non method login selected</pre>";
            header("location:/login_incorrect.php"); exit;
            //return 0;
        }
        
     
        
        
        require_once 'core/funkcje.php';
        require_once 'core/logs.php';
        require_once 'core/sql.php';
        
        if ($params['method']=='id'){
            $this->komunikat("method ID");

            if ($params['id']==''){
                $this->komunikat("id is not set");
                header("location:/login_incorrect.php"); exit;
                //return 0;
            }            
            $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_members} WHERE id='{$params['id']}' limit 1");
            if ($rek['id']>0){ 
                $this->LoginDetails=$rek; 
                $this->putToSession($this->LoginDetails);                
                if ($rek['login']==''){
                    //header("location:/login_insert.php"); exit;
                    $this->komunikat("/login_insert.php");
                }
            } else {
                $this->destroySession();
            }       
        } else if ($params['method']=='email'){
            $this->komunikat("method EMAIL");
            $params['email'] = trim($params['email']);
            if ($params['email']==''){
                $this->komunikat("Email empty");
                header("location:/login_incorrect.php"); exit;
                //return 0;
            }            
            $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_members} WHERE email='{$params['email']}' limit 1");
            if ($rek['id']>0){ 
                $this->LoginDetails=$rek; 
                $this->putToSession($this->LoginDetails);                
                if ($rek['login']==''){
                    //header("location:/login_insert.php"); exit;
                    $this->komunikat("/login_insert.php");
                }
            } else {
                $this->destroySession();
            }            
        } else if ($params['method']=='classic'){   
            $this->komunikat("method CLASSIC");
            
            if ((!empty($params['something']) && (!empty($params['password'])))){                
                if ($this->check_email($params['something'])=="") {$EMAIL=$params['something'];} else {$LOGIN=$params['something'];}                                
                if ($EMAIL=='') {
                    //echo "<pre>";
                    //print_r($this);
                    //echo "</pre>";
                   
//                       echo "<pre>A ".print_r($params)." </pre>";
  //                     echo "SELECT * FROM {$this->variables->base_members} WHERE login='$LOGIN' and password='".md5($params['password'])."' limit 1";
  
                    
                    $rek=$this->sqlconnector->rlo("SELECT * FROM {$this->variables->base_members} WHERE login='$LOGIN' and password='".md5($params['password'])."' limit 1");
                } else {
    //                   echo "<pre>B ".print_r($params)." </pre>";
        
      
          
                    
                    
                    $rek=$this->sqlconnector->rlo("SELECT * FROM {$this->variables->base_members} WHERE email='$EMAIL' and password='".md5($params['password'])."' limit 1");
                }
                if ($rek['id']>0){
                    $this->LoginDetails = $rek;
                }               
                if ($this->setAuthorization=="on"){
                    if (($this->LoginDetails['authorization']!="") and ($this->LoginDetails['logged_times']==0)){
                        //return 0;
                        //header("location:/login_incorrect.php"); exit;
                    }
                }
                if (($this->LoginDetails['login']=="") and ($this->LoginDetails['email']=="")){
                    header("location:/login_incorrect.php"); exit;
                    $this->komunikat("/login_incorrect.php");
                }
                $this->putToSession($this->LoginDetails);                
            } else {                
                $this->destroySession();
            }   
        }
        
        if ($this->LoginDetails['id']>0){
            $this->sqlconnector->query("UPDATE {$this->variables->base_members} SET
                last_browser = '".$this->logs->getBrowser()."',
                last_browser_version = '".$this->logs->getBrowser('version')."',
                last_system = '".$this->logs->getSystem()."',
                last_ip = '".$_SERVER[REMOTE_ADDR]."',                
                time_modification = '".time()."',
                logged_times = '".$_SESSION[logged_times]."'
                WHERE id = '$LoginDetails[id]'");
            $this->logs->addlog("login","");
        } else {
            $this->komunikat("no Login Details!");
            header("location:/login_incorrect.php"); exit;
            //return 0;
        }
        return 1;
        //if (isset($params['redirectory'])){
            //header("location: $params[redirectory]"); exit;
        //}
    }
    
    public function logout(){
        if ($this->variables->cookies=="on"){
            setcookie('member','',0,'/');
        }
        session_start();
        header("Expires: Thu, 17 May 2001 10:17:17 GMT");
        header("Last-Modyfied:".gmdate("D, d M Y H:i:s"));
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        session_unset();
        session_destroy();
        header("location:/"); exit;
    }
    
    public function passwordReset($params=array()){
        require_once 'core/funkcje.php';
        require_once 'core/sql.php';
        $password = $this->funkcje->RandomString(12);
            $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->variables->base_members} 
                    WHERE id = '$params[id]' and authorization = '$params[code]'");        
            if ($rek['id']>0){
                $sql = "UPDATE {$this->variables->base_members} SET
                        password = '".md5($password)."'                
                        WHERE id = '$params[id]' and authorization = '$params[code]' and authorization != ''";
                if ($this->debug==1){ echo $sql; }
                $this->sqlconnector->query($sql);
                
                return array('password'=>$password,'email'=>$rek['email']);
            } else {
                return;
            }
    }
    
    public function setAuthorizationCode($params){        
        if ($params['email']!=''){
            require_once 'core/funkcje.php';
            require_once 'core/sql.php';
            $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->variables->base_members} 
                    WHERE email = '{$params['email']}' limit 1");  
            
            if ($rek['id']>0){
                $code = $this->funkcje->RandomString(32);
                $sql = "UPDATE {$this->variables->base_members} SET
                            authorization = '$code'                
                            WHERE email = '{$params['email']}'";
                            //echo "SQL = $sql";
                if ($this->debug==1){ echo $sql; }
                $this->sqlconnector->query($sql);
                return array('email'=>$params['email'],'login'=>$rek['login'],'code'=>1,'authorization'=>$code,'id'=>$rek['id']);
                
            } else {
                return array('code'=>2);
            }
                    
        } else {
            return 0;
        }
    }
    
    public function passwordChange($params){
        
    }
    

    
    
}

?>
