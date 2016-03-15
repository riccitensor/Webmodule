<?php

require_once 'modules/fcbconnect/lib/facebook.php';

class modFcbconnect extends constructClass {
    
    public $facebook;
    public $user;
    public $logoutUrl;
    public $loginUrl;
    public $user_profile;
    public $kom_login;
    
    public function init(){
        $this->facebook = new Facebook(array(
          'appId'  => $this->pageController->variables->fcb_appid,
          'secret' => $this->pageController->variables->fcb_secret,
        ));
        $this->user = $this->facebook->getUser();
        if ($this->user) {
          try {
            $this->user_profile = $this->facebook->api('/me');
          } catch (FacebookApiException $e) {
            error_log($e);
            $this->user = null;
          }
        }
        if ($this->user) {
          $this->logoutUrl = $this->facebook->getLogoutUrl();
        } else {
          $this->loginUrl = $this->facebook->getLoginUrl(array(//user_birthday,  publish_stream, user_location,user_work_history,user_hometown,,   user_photos  
              'scope' => 'email, read_stream',
          ));
        }
    }
    
    public function login(){
        if ($this->user) {
            $email = $this->user_profile['email'];
            require_once 'core/sql.php';
            require_once 'core/funkcje.php';
            require_once "projects/{$this->pageController->variables->project_name}/lib/members.php";

            if ($this->members->existEmail(array('email'=>$email))==1){
                //if ($this->members->logujeZEmaila($email)){
                
                $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_members} WHERE email='$email' LIMIT 1");
                //$this->pageController->pr($rek); exit;
                if ($rek['login']==''){                    
                    $_SESSION['S_ID']=0;
                    
                    $_SESSION['FCB_ID']=$rek['id'];
                    
                    $_SESSION['zalogowany']=0;
                    header("location:/engine/projects/{$this->pageController->variables->project_name}/pages/fcb/logowanie_reg.php"); exit;
//                    header("location: /engine/projects/{$this->pageController->variables->project_name}/pages/fcb/logowanie_reg.php".$this->facebook->getLoginUrl(array(//user_birthday,  publish_stream, user_location,user_work_history,user_hometown,,   user_photos  
//                      'scope' => 'email, read_stream',
//                    )));
                } else {                    
                    $_SESSION['S_ID']=$rek['id'];
                    $_SESSION['S_LOGIN']=$rek['login'];
                    $_SESSION['S_EMAIL']=$rek['email'];
                    $_SESSION['zalogowany']=1; 
                    header("location:/");
                    exit;
                }
                //}
            } else {
                $haslo = $this->funkcje->RandomString(10);
                //$this->members->Register("",$haslo,$email);
                $this->members->Register(array('login'=>'','password'=>$haslo,'email'=>$email));
                $this->funkcje->sendMail("$_SERVER[SERVER_NAME] your account passoword", "Your password is $haslo thanks for registration", $_SERVER['SERVER_NAME'], $email);
                header("location: /engine/projects/{$this->pageController->variables->project_name}/pages/fcb/logowanie_reg.php"); exit;
            }

            $url = $_SERVER['HTTP_REFERER'];
            if ($url=="") {$url = "/";}
            header("location: $url");
        } else {
            header("location: {$this->loginUrl}");
        }
    }

    public function register(){
        if ($_POST['login']!=""){
            require_once 'core/sql.php';
            require_once "projects/{$this->pageController->variables->project_name}/lib/members.php";    

            $this->kom_login = $this->members->check_login($_POST['login']);
            if ($this->kom_login=="") {
               if ($this->members->existLogin(array('login'=>$_POST['login']))==1){
                   $this->kom_login="login in the base";
               }
               if ($this->kom_login=="") {
                   $this->members->UpdateLogin(array('login'=>$_POST['login'], 'email'=>$this->user_profile['email']));
                   if ($this->members->login(array('method'=>'email','email'=>$this->user_profile['email']))){
                       $_SESSION['zalogowany']=1;   
                   }
                   header("location: /");
               }
            }
        }
    }

    public function logout(){
        $this->facebook = new Facebook(array(
          'appId'  => $this->pageController->variables->fcb_appid,
          'secret' => $this->pageController->variables->fcb_secret,
        ));
        $this->user = $this->facebook->getUser();
        if ($this->user) {
          try {
            $this->user_profile = $this->facebook->api('/me');
          } catch (FacebookApiException $e) {
            error_log($e);
            $this->user = null;
          }
        }
        if ($this->user) {
          $this->logoutUrl = $this->facebook->getLogoutUrl();
        } else {
          $this->loginUrl = $this->facebook->getLoginUrl();
        }
        if ($this->user) {
           header("location: $this->logoutUrl");
        } else {
           header("location: /");
        }
    }
    
    
}

global $modFcbconnect; $modFcbconnect = new modFcbconnect();

?>