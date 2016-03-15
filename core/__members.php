<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

class ob_members {

    public $komunikaty;

    public function __construct(){
        global $variables; $this->variables =& $variables;
        global $sqlconnector; $this->sqlconnector =& $sqlconnector;
        global $pageController; $this->pageController =& $pageController;
        global $funkcje; $this->funkcje =& $funkcje;
    }

    public function exist_login($LOGIN){
        require_once 'sql.php';
        global $sqlconnector;
        $LOGIN=strtolower($LOGIN);
        $rs=$sqlconnector->query("SELECT * FROM {$this->variables->base_members} WHERE login='$LOGIN'");
        while($rek=mysql_fetch_array($rs)){
            return 1; break;
        }
        return 0;
    }

    public function exist_email($EMAIL){
        require_once 'sql.php';
        global $sqlconnector;
        $EMAIL=strtolower($EMAIL);
        $rs=$sqlconnector->query("SELECT * FROM {$this->variables->base_members} WHERE email='$EMAIL'");
        while($rek = mysql_fetch_array($rs)){
            return 1; break;
        }
        return 0;
    }

    public function Register($LOGIN,$HASLO,$EMAIL){
        require_once 'sql.php';
        require_once 'core/logs.php';
        global $sqlconnector;
        global $logs;
        $LOGIN=strtolower($LOGIN);
        $HASLO=md5($HASLO);
        $EMAIL=strtolower($EMAIL);
        $id = $sqlconnector->insert("INSERT INTO {$this->variables->base_members} SET login='$LOGIN',password='$HASLO',email='$EMAIL',time_create='".time()."';");
        $logs->addlog("register", "$LOGIN");
        return $id;
    }

    public function UpdateLogin($login,$email) {
        require_once 'sql.php';
        global $sqlconnector;
        $sqlconnector->query("UPDATE {$this->variables->base_members} SET login = '$login' WHERE email = '$email';"); 
    }

    public function UpdatePassword($id,$HASLO){
        require_once 'sql.php';
        global $sqlconnector;
        $HASLO=md5($HASLO);
        $sqlconnector->query("UPDATE {$this->variables->base_members} SET password = '$HASLO' WHERE id = '$id';");
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
    public function _putToSession(&$LoginDetails){
        $_SESSION['S_LOGIN']=$LoginDetails['login'];
        $_SESSION['S_PASSWORD']=$LoginDetails['password'];
        $_SESSION['S_ID']=$LoginDetails['id'];
        $_SESSION['S_TYPE']=$LoginDetails['type'];
        $_SESSION['S_EMAIL']=$LoginDetails['email'];
        $_SESSION['validity']=$LoginDetails['validity'];
        $_SESSION['logged_times']=++$LoginDetails['logged_times'];
        $_SESSION['zalogowany']=1;
        if ($this->variables->cookies=="on"){
            $member = Array('login'=>$_SESSION['S_LOGIN'],'password'=>$_SESSION['S_PASSWORD']);
            setcookie("member", serialize($member),time()+$this->variables->cookies_lifetime,'/');
        }
    }

    public function putToSession(&$LoginDetails){
        $this->_putToSession($LoginDetails);
    }

    public function loginNiewypelniony(&$LOGIN){
        if ($LOGIN=="") {
            //header("location: /engine/projects/{$this->variables->project_name}/pages/fcb/logowanie_reg.php"); exit;
        }
    }

    public function logujeZEmaila($email){
        require_once 'core/logs.php';
        require_once 'core/sql.php';
        global $sqlconnector;
        global $logs;
        $rs = $sqlconnector->query("SELECT * FROM {$this->variables->base_members} WHERE email='$email' limit 1");

        while($rek = mysql_fetch_array($rs)){$LoginDetails=$rek; $czyJestKtosTaki=1;}

        $this->loginNiewypelniony($LoginDetails['login']);
        $this->putToSession($LoginDetails);
        if ($LoginDetails['lang']==1) {$_SESSION['S_lang']="pl";} else {$_SESSION['S_lang']="en";}

        $sqlconnector->query("UPDATE {$this->variables->base_members} SET
        last_browser = '".$logs->getBrowser()."',
        last_browser_version = '".$logs->getBrowser('version')."',
        last_system = '".$logs->getSystem()."',
        last_ip = '".$_SERVER[REMOTE_ADDR]."',
        time_modification = '".time()."',
        logged_times = '".$_SESSION[logged_times]."'
        WHERE id = '$LoginDetails[id]'");
        $logs->addlog("login","");
        if ($czyJestKtosTaki==1){
            return 1;
        }else{
            $_SESSION['S_LOGIN']="";
            $_SESSION['S_HASLO']="";
            $_SESSION['S_ID']=0;
            return 0;
        }
    }

    public function loginSOMETHINGandMD5($SOMETHING,$PASSWORD){
        if($this->check_email($SOMETHING)=="") {$EMAIL=$SOMETHING;} else {$LOGIN=$SOMETHING;}
        require_once 'core/sql.php';
        require_once 'core/funkcje.php';
        require_once 'core/logs.php';  
        global $base_logs;
        global $set_authorization;
        if (!isset($EMAIL)) {
            $rs = $sqlconnector->query("SELECT * FROM {$this->variables->base_members} WHERE login='$LOGIN' and password='$PASSWORD' limit 1");
        }else{
            $rs = $sqlconnector->query("SELECT * FROM {$this->variables->base_members} WHERE email='$EMAIL' and password='$PASSWORD' limit 1");
        }
        while($rek = mysql_fetch_array($rs)) { $LoginDetails = $rek; $czyJestKtosTaki=1; }

        if ($czyJestKtosTaki==1){
            $this->putToSession($LoginDetails);
            return 1;
        } else {
            return 0;
        }
    }

    public function test(){
        require_once 'core/logs.php';
        $logs->addlog("login","");
    }

    public function sprawdzamLogin($SOMETHING,$HASLO){
        //echo "sprawdzamLogin s: $SOMETHING h: $HASLO<br/>";
        if ((!empty($SOMETHING)) && (!empty($HASLO))){
            if ($this->check_email($SOMETHING)=="") {$EMAIL=$SOMETHING;} else {$LOGIN=$SOMETHING;}
            require_once 'core/sql.php';
            require_once 'core/funkcje.php';
            require_once 'core/logs.php';

            global $sqlconnector;

            if (!isset($EMAIL)) {
                $rs=$sqlconnector->query("SELECT * FROM {$this->variables->base_members} WHERE login='$LOGIN' and password='".md5($HASLO)."' limit 1");
            }else{
                $rs=$sqlconnector->query("SELECT * FROM {$this->variables->base_members} WHERE email='$EMAIL' and password='".md5($HASLO)."' limit 1");
            }

            while($rek = mysql_fetch_array($rs)) { $LoginDetails = $rek; $czyJestKtosTaki=1;}
            //echo "A:$set_authorization B:$LoginDetails[authorization] <br/>";
            if ($set_authorization=="on"){
                if (($LoginDetails['authorization']!="") and ($LoginDetails['logged_times']==0)){
                    return 0; exit;
                }
            }
            if (($LoginDetails['login']=="") and ($LoginDetails['email']=="")){
                header("location:/login_incorrect.php"); exit;
            }

            $this->loginNiewypelniony($LoginDetails['login']);
            $this->putToSession($LoginDetails);
            if ($LoginDetails[lang]==1) {$_SESSION['S_lang']="pl";} else {$_SESSION['S_lang']="en";}

            $sqlconnector->query("UPDATE {$this->variables->base_members} SET
            last_browser = '".$logs->getBrowser()."',
            last_browser_version = '".$logs->getBrowser('version')."',
            last_system = '".$logs->getSystem()."',
            last_ip = '".$_SERVER[REMOTE_ADDR]."',
            time_modification = '".time()."',
            logged_times = '".$_SESSION[logged_times]."'
            WHERE id = '$LoginDetails[id]'");
            $logs->addlog("login","");
        }
        if ($czyJestKtosTaki==1){
            return 1;
        } else {
            $_SESSION['S_LOGIN']="";
            $_SESSION['S_HASLO']="";
            $_SESSION['S_ID']=0;
            return 0;
        }
    }

    public function login($params){
        if (empty($params['login'])) { return false; }
        if ((empty($params['password'])) and (empty($params['md5']))) {
            return false;
        }
        if ($this->check_email($params['login'])==0) {
            $EMAIL=$params['login'];
        } else {
            $LOGIN=$params['login'];
        }

        if ($params['md5']=="1"){
            $HASLO = md5($params['password']);
        }else{
            $HASLO = $params['password'];
        }
        require_once 'core/sql.php';
        require_once 'core/funkcje.php';
        require_once 'core/logs.php';
        global $sqlconnector;
        if (!isset($EMAIL)) {
            $LoginDetails=$sqlconnector->rlo("SELECT * FROM {$this->variables->base_members} WHERE login='$LOGIN' and password='$HASLO' limit 1");
        }else{
            $LoginDetails=$sqlconnector->rlo("SELECT * FROM {$this->variables->base_members} WHERE email='$EMAIL' and password='$HASLO' limit 1");
        }

        if ($set_authorization=="on"){
            if (($LoginDetails['authorization']!="") and ($LoginDetails['logged_times']==0)){
                return 0;
            }
        }

        if (($LoginDetails['login']=="") and ($LoginDetails['email']=="")){
            header("location:/login_incorrect.php"); exit;
        }
        $this->putToSession($LoginDetails);
        if ($LoginDetails[lang]==1) {$_SESSION['S_lang']="pl";} else {$_SESSION['S_lang']="en";}

        $sqlconnector->query("UPDATE {$this->variables->base_members} SET
        last_browser = '".$logs->getBrowser()."',
        last_browser_version = '".$logs->getBrowser('version')."',
        last_system = '".$logs->getSystem()."',
        last_ip = '".$_SERVER[REMOTE_ADDR]."',
        time_modification = '".time()."',
        logged_times = '".$_SESSION[logged_times]."'
        WHERE id = '$LoginDetails[id]'");
        $logs->addlog("login","");

        if (isset($params['redirectory'])){
            header("location: $params[redirectory]"); exit;
        }
    }

}

?>