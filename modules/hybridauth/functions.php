<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once "modules/hybridauth/lib/hybridauth/Hybrid/Auth.php";

  // ini_set('display_errors', 1);
  // ini_set('error_reporting', E_ALL);  
   
class modHybridauth extends constructClass {   
    
    public function __construct() {
        parent::__construct();    
        $this->config();
    }
    
    public function config(){
        $this->config = array(
            "base_url" => "http://www.defin3.com/engine/modules/hybridauth/lib/hybridauth/",
            "providers" => array (
                "OpenID" => array ( "enabled" => true ),
                "Yahoo" => array ( "enabled" => true, "keys"    => array ( "id" => "", "secret" => "" ),),
                "AOL"  => array ( "enabled" => true ),
                "Google" => array ( "enabled" => true, "keys"    => array ( "id" => "", "secret" => "" ),),
                "Facebook" => array ( "enabled" => true, "keys"    => array ( "id" => "142168975939823", "secret" => "4589f9ec17a5f385e2275c0f641770f1" ), ),
                "Twitter" => array ( "enabled" => true, "keys"    => array ( "key" => "", "secret" => "" ) ),
                "Live" => array ( "enabled" => true, "keys"    => array ( "id" => "", "secret" => "" ) ),
                "MySpace" => array ( "enabled" => true, "keys"    => array ( "key" => "", "secret" => "" ) ),
                "LinkedIn" => array ( "enabled" => true, "keys"    => array ( "key" => "", "secret" => "" ) ),
                "Foursquare" => array ( "enabled" => true, "keys"    => array ( "id" => "", "secret" => "" ) ),
            ), 
            "debug_mode" => false, "debug_file" => "",
	);
    }
    
    public function initfacebook(){       
                
        //$this->pageController->pr($this->config);
        if( isset( $_GET["error"] ) ){
		$this->error = '<b style="color:red">' . trim( strip_tags(  $_GET["error"] ) ) . '</b><br /><br />';
	}
	if( isset( $_GET["provider"] ) && $_GET["provider"] ):
		try{
			$hybridauth = new Hybrid_Auth( $this->config );
			$provider = @ trim( strip_tags( $_GET["provider"] ) );
			$adapter = $hybridauth->authenticate( $provider );
			//$hybridauth->redirect( "profile.php?provider=$provider" );
		}
		catch( Exception $e ){
			switch( $e->getCode() ){ 
				case 0 : $this->error = "Unspecified error."; break;
				case 1 : $this->error = "Hybriauth configuration error."; break;
				case 2 : $this->error = "Provider not properly configured."; break;
				case 3 : $this->error = "Unknown or disabled provider."; break;
				case 4 : $this->error = "Missing provider application credentials."; break;
				case 5 : $this->error = "Authentication failed. The user has canceled the authentication or the provider refused the connection."; break;
				case 6 : $this->error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again."; 
					     $adapter->logout(); 
					     break;
				case 7 : $this->error = "User not connected to the provider."; 
					     $adapter->logout(); 
					     break;
			} 
			$this->error .= "<br /><br /><b>Original error message:</b> " . $e->getMessage(); 
			$this->error .= "<hr /><pre>Trace:<br />" . $e->getTraceAsString() . "</pre>";
		}
        endif;
    }    
    
    public function register($params){
        require_once 'core/sql.php';
        require_once "projects/{$this->pageController->variables->project_name}/lib/members.php"; 
        require_once 'core/logs.php';        
        $params['email'] = trim($params['email']);
        if ($params['email']==''){
            return; 
        }
        if ($this->members->exist_email($params['email'])==0){       
            $params['email']=strtolower($params['email']);
            $id = $this->sqlconnector->query("INSERT INTO {$this->pageController->variables->base_members} SET login='',password='',email='{$params['email']}',time_create='".time()."';");
            $this->logs->addlog("register", "$LOGIN");
        }
    }

    public function login($params){
        require_once 'core/sql.php';
        require_once "projects/{$this->pageController->variables->project_name}/lib/members.php"; 
        require_once 'core/logs.php';
        //$this->pageController->pr($_SESSION);
        if ($params[email]==''){ return; }
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_members} WHERE email='$params[email]' limit 1");
        if ($rek['id']>0) {
            if ($rek['login']!=''){
                $_SESSION[S_ID]=$rek['id'];
                $_SESSION[S_LOGIN]=$rek['login'];
                $_SESSION[S_EMAIL]=$rek['email'];
                $_SESSION['zalogowany']=1;
                header('location:/');
            } else {
                $this->setLogin($rek['id']);
            }
        }
    }

    public function setLogin($_id,$_log=''){
        require_once 'core/sql.php';
        require_once "projects/{$this->pageController->variables->project_name}/lib/members.php";
        require_once 'core/logs.php';

        if (!$this->members->exist_login($_log)){
            $_log = trim($_log);
            if ($_log!=''){
                $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_members} SET
                    login='$_log'
                    WHERE id = '$_id' and login=''
                ");
                $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_members} 
                    WHERE login = '$_log'");
                //echo 'login zatwierdzony!';
                $this->login(array('email'=>$rek['email']));
                header('location: /');
            }
        }
        $this->pageController->warstwaA(); ?>
          <div class="jumbotron">
            <h1 class="lets_define" style="font-size: 44px;">Lets get started</h1>
            <p><div class="form-inline">
            <div class="form-group">
                <form action="<?="/engine/modules/hybridauth/setlogin.php"//$_SERVER["PHP_SELF"]?>" method="GET" >

                    <input type="hidden" name="id" value="<?=$_id?>"/>
                    <input type="text" name="login" class="form-control" placeholder="Choose your username"/>
                    <button class="btn btn-default btn-info tip-bottom" type="submit" value="Sign in">Sign in</button>
                </form>
            </div></div></p>
          </div>
        <? $this->pageController->warstwaB();
    }

}

global $modHybridauth; $modHybridauth = new modHybridauth();

?>