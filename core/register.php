<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

   global $pageController; $pageController->inc(array('members','funkcje'));

class register extends constructClass {
    public $members; //class reference

    public $komunikaty;
    public $error = 0;
    public $is_empty = 1;

    public $statement_login;
    public $statement_pass;
    public $statement_email;
    public $statement_token;

    public $login;
    public $email;
    public $pass;

    public function __construct(){
        global $members; $this->members =& $members;        
        $this->komunikaty['login']['1'] = "Username cannot be empty.";
        $this->komunikaty['login']['2'] = "Only A-Z a-z 0-9 or _";
        $this->komunikaty['login']['3'] = "Too short. Should be min. 4 characters";
        $this->komunikaty['login']['4'] = "Too long. Should be max. 32 characters";
        $this->komunikaty['login']['5'] = "Login must be A-Z a-z 0-9 non space";
        $this->komunikaty['password']['1'] = "Password cannot be empty";
        $this->komunikaty['password']['2'] = "Password cannot be empty";
        $this->komunikaty['password']['3'] = "Passwords do not match";
        $this->komunikaty['email']['1'] = "Email cannot be empty";
        $this->komunikaty['email']['2'] = "Email is incorrect. Example: myemail@whateveryoulike.com";
        $this->komunikaty['token']['1'] = "Token is empty";
        $this->komunikaty['token']['2'] = "Token is incorrect.";
        $this->komunikaty['register']['email_in_base'] = "This email has already been used.";
        $this->komunikaty['register']['login_in_base'] = "This username has already been used";
        $this->komunikaty['register']['email_title'] = "$_SERVER[SERVER_NAME] You have been registered!";
        $this->komunikaty['register']['email_content'] = "Hello [LOGIN], <br/><br/> To activate your account, click on the link below. <br/> [LINK] <br/><br/>Best regards,<br/>defin3.com Team ";
        $this->komunikaty['register']['email_from'] = "$_SERVER[SERVER_NAME]";
        $this->komunikaty['register']['redirect'] = "/register_complete";
    }

    function verify_login($login){
        if ($login!='') {$this->is_empty=0;}
        $temp = $this->members->check_login($login);
        if ($temp>0){
            $this->statement_login = $this->komunikaty['login']["$temp"];
            $this->error=1;
        }
        $this->login=$login;
    }

    function verify_password($pass1,$pass2){
        if (($pass1!='') or ($pass2!='')) {$this->is_empty=0;}
        $temp = $this->members->check_password($pass1,$pass2);
        if ($temp>0){
            $this->statement_pass = $this->komunikaty['password']["$temp"];
            $this->error=1;
        }
        $this->pass=$pass1;
    }

    function verify_email($email){
        if ($email!='') {$this->is_empty=0;}
        $temp = $this->members->check_email($email);
        if ($temp>0){
            $this->statement_email = $this->komunikaty['email']["$temp"];
            $this->error=1;
        }
        $this->email=$email;
    }

    function verify_token($token){
        if ($token!='') {$this->is_empty=0;}
        $temp = $this->members->check_token($token,$_SESSION['captcha']);
        if ($temp>0){
            $this->statement_token = $this->komunikaty['token']["$temp"];
            $this->error=1;
        }
    }

    function register(){
        if ($this->error!=0){return 0;}
        if (($this->members->existLogin(array('login'=>$this->login))==1) and ($this->login!='')) {$this->error=1; $this->statement_login=$this->komunikaty['register']['login_in_base']; return 0;}
        if (($this->members->existEmail(array('email'=>$this->email))==1) and ($this->email!='')) {$this->error=1; $this->statement_email=$this->komunikaty['register']['email_in_base']; return 0;}
        if (empty($this->statement_login) &&  empty($this->statement_email)){
            $id = $this->members->Register(array('login'=>$this->login,'password'=>$this->pass,'email'=>$this->email));
            require_once 'core/sql.php';
            require_once 'core/funkcje.php';
            global $funkcje;
            global $sqlconnector;
            global $pageController; 
            $authorization = $funkcje->RandomString(32); 
            $link = "http://$_SERVER[SERVER_NAME]/activate/$authorization";
            $link = "<a href='$link'>$link</a>";            
            $this->komunikaty['register']['email_content'] = preg_replace('{(\[LINK\])}',$link,$this->komunikaty['register']['email_content']);
            $this->komunikaty['register']['email_content'] = preg_replace('{(\[LOGIN\])}',$this->login,$this->komunikaty['register']['email_content']);
            $sqlconnector->query("UPDATE {$pageController->variables->base_members} SET authorization='$authorization' WHERE id=$id");
            $funkcje->sendMail($this->komunikaty['register']['email_title'],
                               $this->komunikaty['register']['email_content'],
                               $this->komunikaty['register']['email_from'],
                               $this->email);
            header("location:{$this->komunikaty['register']['redirect']}"); exit;
        }
    }

    public function checkErrors(){
        if ($this->is_empty==0){
            if ($this->error==1){
                return 1;
            }
        }
        return 0;
    }

    public function viewError($type){
        if ($this->checkErrors()){
            if ($type=='login'){ return $this->statement_login; }
            if ($type=='pass'){ return $this->statement_pass; }
            if ($type=='email'){ return $this->statement_email; }
            if ($type=='token'){ return $this->statement_token; }
        }
    }

}

global $register; $register = new register();

?>