<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

class logs {
    public function __construct(){
        global $variables; $this->variables =& $variables;
        global $pageController; $this->pageController =& $pageController;
    }

    public function addlog($operation,$info=""){
        require_once 'sql.php';
        require_once 'funkcje.php';
        global $pageController;
        global $sqlconnector;
        $sqlconnector->query("INSERT INTO {$this->variables->base_logs} SET
          author_name='$_SESSION[S_LOGIN]',
          purpose='$operation',
          ip='$_SERVER[REMOTE_ADDR]',
          addr='$_SERVER[REMOTE_HOST]',
          info='$info',
          browser='".$this->getBrowser("")."',
          browser_version='".$this->getBrowser("version")."',
          system='".$this->getSystem()."',
          lang='$_SERVER[HTTP_ACCEPT_LANGUAGE]',
          user_agent='$_SERVER[HTTP_USER_AGENT]',
          time_create='".time()."';");
    }

    public function getSystem(){
        $platform = 'Unknown';
        if (preg_match('/linux/i', $_SERVER['HTTP_USER_AGENT'])) {$platform='linux';} else
        if (preg_match('/macintosh|mac os x/i', $_SERVER['HTTP_USER_AGENT'])) {$platform='mac';} else
        if (preg_match('/windows|win32/i', $_SERVER['HTTP_USER_AGENT'])) {$platform='windows';}
        return $platform;
    }

    public function getBrowser($what='browser'){
        $u_agent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { $ub = "MSIE"; $browser = 'Internet Explorer';  } else
        if(preg_match('/Firefox/i',$u_agent)) { $ub = "Firefox"; $browser = 'Mozilla Firefox';} else
        if(preg_match('/Chrome/i',$u_agent)) { $ub = "Chrome"; $browser = 'Google Chrome';} else
        if(preg_match('/Safari/i',$u_agent)) { $ub = "Safari"; $browser = 'Apple Safari';} else
        if(preg_match('/Opera/i',$u_agent)) { $ub = "Opera"; $browser = 'Opera'; } else
        if(preg_match('/Netscape/i',$u_agent)) { $ub = "Netscape"; $browser = 'Netscape';}
        $known = array('Version',$ub,'other');
        $pattern = '#(?<browser>'.join('|',$known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern,$u_agent,$matches)){
            // we have no matching number just continue
        }
        if ($what!='version') {return $browser;}
        // see how many we have
        $i=count($matches['browser']);
        if ($i!=1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version")<strripos($u_agent,$ub)){
                $version=$matches['version'][0];
            } else {
                $version=$matches['version'][1];
            }
        } else {
            $version=$matches['version'][0];
        }
        // check if we have a number
        if ($version==null || $version=="") {$version="?";}
        return $version;
    }

}

global $logs; $logs=new logs();

?>