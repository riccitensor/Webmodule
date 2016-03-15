<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

 require_once 'core/funkcje.php';
 require_once 'core/sql.php';

class _pages extends constructClass {

    public $pageController;
    public $funkcje;
    public $komunikaty;

    public function __construct() {
        global $pageController; $this->pageController =& $pageController;
        global $funkcje; $this->funkcje =& $funkcje;
        global $sqlconnector; $this->sqlconnector =& $sqlconnector;
                
        $this->komunikaty['login']['label'] = "Sign in";
        $this->komunikaty['login']['login'] = "Login";
        $this->komunikaty['login']['email'] = "E-mail";
        $this->komunikaty['login']['login_incorrect'] = "Your username is incorrect";
        $this->komunikaty['login']['password'] = "Password";
        $this->komunikaty['login']['submit'] = "Log In";
        $this->komunikaty['register']['label'] = "Account registration";
        $this->komunikaty['register']['login'] = "Username";
        $this->komunikaty['register']['pass1'] = "Password";
        $this->komunikaty['register']['pass2'] = "Password";
        $this->komunikaty['register']['email'] = "Email";
        $this->komunikaty['register']['token'] = "Token";
        $this->komunikaty['register']['text'] = "By clicking, I certify that I agree with the Privacy Policy";
        $this->komunikaty['register']['submit'] = "Create my account";
        $this->komunikaty['register']['youhavebeen'] = "You have been registered.";
        $this->komunikaty['register']['success'] = "Registration successful. We have just sent you an activation link. Check your email and create your first definitions.";
        $this->komunikaty['login_enter']['label'] = "Your username";
        $this->komunikaty['login_enter']['Submit'] = "Send";
        $this->komunikaty['activate']['activated'] = "Your account has been activated.";
        $this->komunikaty['activate']['invalidlink'] = "Invalid link";
        $this->komunikaty['info']['page_404'] = "404. This page could not be found.";
        $this->komunikaty['info']['page_403'] = "403. Sorry, we need to check why this happened.";
        $this->komunikaty['reset']['email_recover_title'] = "To change password..";
        $this->komunikaty['reset']['email_recover_content'] = "Hello [LOGIN], <br/><br/> To change your password, please use the following link: <a href='http://".$_SERVER['SERVER_NAME']."/reset/[ID]/[LINK]'>http://".$_SERVER['SERVER_NAME']."/reset/[ID]/[LINK]</a> <br/><br/>Best regards,<br/>defin3.com Team ";        
        $this->komunikaty['reset']['email_reset_title'] = "Your password has ben changed";
        $this->komunikaty['reset']['email_reset_content'] = "Password was changed to [PASSWORD]";
        $this->komunikaty['reset']['info_send'] = "We have sent you an email.";
        $this->komunikaty['reset']['info_error'] = "The authorization code is not correct";
        $this->komunikaty['reset']['button'] = "Send email";
        $this->komunikaty['reset']['input_email_title'] = "Email:";
        $this->komunikaty['reset']['info_sendlinktoauthorization'] = "We have just sent you a link so that you can reset your password.";
        $this->komunikaty['reset']['info_email_empty'] = "Email cannot be empty";
        $this->komunikaty['reset']['info_nouserwiththisemail'] = "We cannot find such a user.";
        $this->komunikaty['password']['1'] = "Password cannot be empty";
        $this->komunikaty['password']['2'] = "Password cannot be empty";
        $this->komunikaty['password']['3'] = "Passwords do not match";

        if ($_GET['what']==''){ $this->index(); } 
        if ($_GET['what']=='index'){ $this->index(); }
        if ($_GET['what']=='register_complete'){ $this->register_complete(); }
        if ($_GET['what']=='activate'){ $this->activate(); }
        if ($_GET['what']=='403'){ $this->page_403(); }
        if ($_GET['what']=='404'){ $this->page_404(); }
        if ($_GET['what']=='login'){ $this->login(); }
        if ($_GET['what']=='login_incorrect'){ $this->login(array('login_incorrect'=>1)); }
        if ($_GET['what']=='login_enter'){ $this->login_enter(); }
        if ($_GET['what']=='logout'){ $this->logout(); }
        if ($_GET['what']=='register'){ $this->register(); }
        if ($_GET['what']=='recover'){ $this->recover(); }
        if ($_GET['what']=='reset'){ $this->reset(); }
        if ($_GET['what']=='changepass'){ $this->changePassword(); }

        $this->otherOperationsCheck();
    }

    public function otherOperationsCheck(){}  

    public function register(){
        global $register;
        global $pageController;
        require_once 'core/register.php';

        $register->verify_login($_POST['Rlogin']);
        $register->verify_email($_POST['Remail']);
        $register->verify_token($_POST['captcha']);
        $register->verify_password($_POST['Rpass1'],$_POST['Rpass2']);
        $register->register();
        $this->pageController->warstwaA();
        ?>

        <style>
            .register {border: solid 0px red;width: 600px; text-align: left; margin-top: 10px; margin-left: 50px; padding-bottom: 12px;}
            .register table {width: 600px; margin-top: 7px; margin-bottom: 7px;}
            .register table tr {border: solid 0px green; height: 28px; color: #555555;}
            .register table tr td input,
            .register table tr td input:hover,
            .register table tr td input:focus {height: 20px; font-size: 12px; width: 200px;  border-radius: 5px; padding-left: 3px;}
            .register .account_registration {font-size: 20px;margin-bottom: 3px;}
            .register table tr td img {vertical-align: middle;}
            .register {margin-top: 15px;}
            .register table td:nth-child(2) {width: 210px; }
            .register table td:first-child { width: 180px;}
            .register input,.register input:hover,.register input:focus {width: 170px;}
            .register_info {border: solid 0px red; width: 350px; font-size: 11px;}
        </style>

        <form class="register" action='<?=$_SERVER['REQUEST_URI']?>' method=POST>
        <p><div class="account_registration"><?=$this->komunikaty['register']['label']?></div></p>
        <table>
        <tr><td>* <?=$this->komunikaty['register']['login']?>:</td><td><input type='text' name='Rlogin' value='<?=$_POST['Rlogin']?>'/></td><td><?=$register->viewError('login');?></td></tr>
        <tr><td>* <?=$this->komunikaty['register']['pass1']?>:</td><td><input type='password' name='Rpass1' value=''/></td><td><?=$register->viewError('pass');?></td></tr>
        <tr><td>* <?=$this->komunikaty['register']['pass2']?>:</td><td><input type='password' name='Rpass2' value=''/></td><td></td></tr>
        <tr><td>* <?=$this->komunikaty['register']['email']?>:</td><td><input type='text' name='Remail' value='<?=$_POST['Remail'] ?>'/></td><td><?=$register->viewError('email');?></td></tr>
        <tr><td>* <?=$this->komunikaty['register']['token']?>: <img src='engine/core/captcha.php' alt='' style=''/></td><td><input name='captcha' type='text'/></td><td><?=$register->viewError('token');?></td></tr>
        </table>
        <div class="register_info"><?=$this->komunikaty['register']['text']?></div>
        <input value="<?=$this->komunikaty['register']['submit']?>" align='center' type='submit' src='' alt='Submit' />
        </form><?
        $this->pageController->warstwaB();
    }

    public function activate(){
        $this->pageController->warstwaA();
        if (strlen($_GET['authorization'])==32) {
            $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_members} WHERE authorization='$_GET[authorization]' limit 1");
            while($rek = mysql_fetch_assoc($rs)){
                $newpassord = $this->funkcje->RandomString(10);
                $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_members} SET authorization='' WHERE id = '$rek[id]'");
                //$funkcje->sendMail("$_SERVER[SERVER_NAME] Account Activated", "Your new '$_SERVER[SERVER_NAME]' login is activated", "$_SERVER[SERVER_NAME]", $rek[email]);
                echo $this->funkcje->komunikat($this->komunikaty['activate']['activated']);
                $done = true;
            }
        }

        if ($done != true) {
            echo $this->funkcje->komunikat($this->komunikaty['activate']['invalidlink']);
        }
        $this->pageController->warstwaB();
    }

    public function register_complete(){
        $this->pageController->warstwaA(); 
        echo $this->funkcje->komunikat($this->komunikaty['register']['success']);
        $this->pageController->warstwaB();
    }

    public function page_403(){
        $this->pageController->warstwaA(); 
        echo $this->funkcje->komunikat($this->komunikaty['info']['page_403']);
        $this->pageController->warstwaB();
    }

    public function page_404(){
        $this->pageController->warstwaA(); 
        echo $this->funkcje->komunikat($this->komunikaty['info']['page_404']);
        $this->pageController->warstwaB();
    }

    public function login($params=''){
        global $login_incorrect;
        if ($_SESSION['zalogowany']==1) { header("location: /");}
        $this->pageController->warstwaA(); ?>
        <style>
            .form_logowanie {margin: 50px; margin-left: 150px;}
            .form_logowanie td:nth-child(1) { width: 150px; padding-left: 5px;}
            .form_logowanie td:nth-child(2) { width: 220px; padding-left: 5px;}
            .form_logowanie th h1 {margin-bottom: 30px;}
        </style>

        <form method="post" action="/login.php">
            <table class="form_logowanie">
                <th colspan="99"><h1><?if ($params['login_after_registration']==1){ echo $this->komunikaty['register']['youhavebeen'];} else { echo $this->komunikaty['login']['label'];}?></h1> </th>
                <tr><td><?=$this->komunikaty['login']['login']?>:</td><td><input type="text" name="login"/></td><td><?if($params['login_incorrect']==1){echo $this->komunikaty['login']['login_incorrect'];}?></td></tr>
                <tr><td><?=$this->komunikaty['login']['password']?>:</td><td><input type="password" name="haslo"/></td></tr>
                <tr><td><input value="<?=$this->komunikaty['login']['submit']?>" align='center' type='submit' src='' alt='Submit' /></td><td></td><td></td></tr>
             </table>
             <input type="hidden" name="chcesielogowac" value="1" />
        </form>
        <?$this->pageController->warstwaB();
    }
    
    public function logout(){
        $this->pageController->logout();
    }

    public function index(){
        $this->pageController->warstwaA();
        echo $this->funkcje->komunikat("index");
        $this->pageController->warstwaB();
    }

    public function recover(){
        // $this->komunikaty['reset']['email_content'] = "Password was changed to [PASSWORD]";
        // $this->komunikaty['reset']['email_content'] = preg_replace('{(\[PASSWORD\])}',$r['password'],$this->komunikaty['reset']['email_content']);
        // echo $this->komunikaty['reset']['email_content'];
        
        if ($_POST['email']!=''){
            $this->pageController->inc(array('members')); global $members;       
            $r = $members->setAuthorizationCode(array('email'=>$_POST['email']));
            if ($r['code']==1){
                require_once 'core/funkcje.php';    
                
                $this->komunikaty['reset']['email_recover_content'] = preg_replace('{(\[LOGIN\])}',$r['login'],$this->komunikaty['reset']['email_recover_content']);
                
                $this->komunikaty['reset']['email_recover_content'] = preg_replace('{(\[LINK\])}',$r['authorization'],$this->komunikaty['reset']['email_recover_content']);
                $this->komunikaty['reset']['email_recover_content'] = preg_replace('{(\[ID\])}',$r['id'],$this->komunikaty['reset']['email_recover_content']);
                
                $this->funkcje->sendMail($this->komunikaty['reset']['email_recover_title'],$this->komunikaty['reset']['email_recover_content'],$_SERVER['SERVER_NAME'],$r['email']);
                $this->pageInformation(array('info'=>$this->komunikaty['reset']['info_sendlinktoauthorization'],'type'=>'s'));
            } else if ($r['code']==2) {
                $this->pageInformation(array('info'=>$this->komunikaty['reset']['info_nouserwiththisemail'],'type'=>'d'));
            }
        } else {        
            $this->pageController->warstwaA();
            ?>
            <form action='<?=$_SERVER['REQUEST_URI']?>' method='POST' style="max-width: 400px; margin-left: 20%; margin-right: 20%:">
              <div class="form-group">
                <label for="exampleInputEmail1"><?=$this->komunikaty['reset']['input_email_title']?> <b style="color: red;">&nbsp; </b></label>
                <div class="input-group">
                    <div class="input-group-addon">@</div>
                    <input class="form-control" type="email" value='<?=$_POST['email']?>' name="email" id="exampleInputEmail1" placeholder="Enter email"/>
                </div>
              </div>

              <button type="submit" class="btn btn-default btn-primary"><?=$this->komunikaty['reset']['button']?></button>
            </form>
            <?
            $this->pageController->warstwaB();            
        }        
    }
    
    public function reset(){
        if ($_POST['reset']==1) {
            require_once 'core/sql.php';
            require_once "projects/{$this->pageController->variables->project_name}/lib/members.php";
            require_once 'core/funkcje.php';
            $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_members} WHERE id='$_GET[id]' and authorization='$_GET[code]'");

            if ($_GET['code']==''){
                $Kom_pass1 = "Authorization code is empty!";
            } else if ($rek['authorization']!=$_GET['code']){
                $Kom_pass1 = "Authorization code is not currect!";
            } else {
                
                $komid = $members->check_password($_POST[pass1], $_POST[pass2]);
                echo '$komid'.$komid.'<br/>';
                $Kom_pass1 = $this->komunikaty['password'][$komid];
                echo $Kom_pass1.'<br/>';
            }
            
            //$this->pageController->pr($_GET);
            //$this->pageController->pr($rek);            
            
            if ($Kom_pass1=='') {
                global $members;
                $members->UpdatePassword(array('id'=>$rek['id'],'password'=>$_POST['pass1']));
                $Kom_oldpassword="new password updated";                
                $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_members} SET authorization='' WHERE id='$_GET[id]' and authorization='$_GET[code]'");
                $members->login(array('method'=>'id','id'=>$rek['id']));
                header("location: /");
            }
            $_POST['reset']="";
        }
        $this->pageController->warstwaA(); ?>

        <form action='<?=$_SERVER[REQUEST_URI]?>' method=POST>
           <div class="form-group">
              <label for="exampleInputEmail1"><b style="color: red;">&nbsp;<?=$Kom_pass1?> </b></label>
              <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-key"></i></div>
                  <input class="form-control" type="password" value='' name="pass1" placeholder="Enter new password"/>
              </div>
              <br/>
              <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-key"></i></div>
                  <input class="form-control" type="password" value='' name="pass2" placeholder="Repeat new password"/>
              </div>
           </div> 
           <input type="hidden" name="reset" value="1"/>
           <button class="btn btn-info">Send</button>
        </form>   
        <?$this->pageController->warstwaB();
        
        
        
        /* $this->pageController->inc(array('members')); global $members;       
        $r = $members->passwordReset(array('code'=>$_GET['code'],'id'=>$_GET['id']));        
        if ($r['password']!=''){
            require_once 'core/funkcje.php';
            global $funkcje;
            $this->komunikaty['reset']['email_reset_content'] = preg_replace('{(\[PASSWORD\])}',$r['password'],$this->komunikaty['reset']['email_reset_content']);
            $funkcje->sendMail($this->komunikaty['reset']['email_reset_title'],$this->komunikaty['reset']['email_reset_content'],$_SERVER['SERVER_NAME'],$r['email']);
            $this->pageInformation(array('info'=>$this->komunikaty['reset']['info_send'],'type'=>'s'));
        } else {
            $this->pageInformation(array('info'=>$this->komunikaty['reset']['info_error'],'type'=>'d'));
        }*/
    }

    public function login_enter(){
        $this->pageController->warstwaA();?>
        <style>
            td {padding:10px;}
        </style>
        <form method="POST" action="<?=$PHP_SELF;?>">
         <table>
             <tr><td colspan="3"><h1><?=$this->komunikaty['login_enter']['label']?></h1></td></tr>
             <tr>
                 <td><input name="login" type="text" value=""/></td>
                 <td><?=$fcbconnect_functions->kom_login?></td>
             </tr>
             <tr>
                 <td><input type="submit" value="<?=$this->komunikaty['login_enter']['Submit']?>" /></td>
             </tr>
         </table>
        </form>
        <?$this->pageController->warstwaB();
    }
    
    public function pageInformation($params){
        $this->pageController->warstwaA();
        echo $this->komunikat($params['info'],$params['type']);
        $this->pageController->warstwaB();
    }
    
    public function komunikat($tresc,$t=''){        
        if ($t=='s'){ $class='alert-success'; } else
        if ($t=='w'){ $class='alert-warning'; } else    
        if ($t=='d'){ $class='alert-danger'; } else   
        { $class='alert-info'; }
        $temp = "<div class='alert $class'>$tresc</div>";
        return $temp;
    }


}

?>