<? set_include_path(get_include_path().PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/engine');
   ob_start("ob_gzhandler");
   session_start();
   require_once $_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.php';
   //ini_set('max_execution_time', 500);

   PHP_OS == "Windows" || PHP_OS == "WINNT" ? define("SEPARATOR", "\\") : define("SEPARATOR", "/");
  
class constructClass {
    public function __construct() {
        global $pageController; $this->pageController =& $pageController;
        global $sqlconnector; $this->sqlconnector =& $sqlconnector;
        global $funkcje; $this->funkcje =& $funkcje;
        global $filter; $this->filter =& $filter;
        global $xhtml; $this->xhtml =& $xhtml;
        global $members; $this->members =& $members;
        global $logs; $this->logs =& $logs;
        global $id; $this->id =& $id;
        global $variables; $this->variables =& $variables;
        global $pages; $this->pages =& $pages;
    }
}
   
   
class pageController extends constructClass {
    public $template_name='default';
    public $template_dir='';
    public function __construct($params=array()){
        if ($this->debug==0){
            //error_reporting(0);
        } else {
            ini_set('display_errors', 1);
            ini_set('error_reporting', E_ALL);
        }
        // $this->pr($_POST);
        // $this->pr($_GET);
        // var_dump(debug_backtrace());        
        global $variables; $this->variables =& $variables;
        $this->template_name = $this->variables->template_name;          
        $this->walider();        
        $this->czyZalogowany();
        $this->cookies();
        if($this->variables->tto=="on"){ header('location:/ssss'); }
    }

    public function inc($params=''){
        //$this->pr($params);
        foreach ($params as $key => $value) {
            if ($value=='members'){
                if (file_exists($_SERVER['DOCUMENT_ROOT']."/engine/projects/{$this->variables->project_name}/lib/members.php")){
                    require_once "projects/{$this->variables->project_name}/lib/members.php";
                } else {
                    require_once "core/memb.php";
                    global $members; $members = new _memb();
                }
            } else if ($value=='funkcje') {
                require_once "core/funkcje.php";
            } else if ($value=='sql') {
                require_once "core/sql.php";
            } else if ($value=='filter') {
                require_once "core/filter.php";
            } else if ($value=='register') {
                require_once "core/register.php";
            } else if ($value=='pages') {
                require_once "projects/{$this->variables->project_name}/pages/pages.php";
            }
        }
    }

    public function cookies(){
        global $members;
        if($this->variables->cookies!="on"){return false;}
        if($_SESSION['zalogowany']==1){return false;}
        if(isset($_COOKIE["member"])){
            $member = unserialize(stripslashes($_COOKIE['member']));
            $this->inc(array('members'));
           // if (!$members->login(array('method'=>'classic','login'=>$member['login'],'password'=>$member['password']))){
           //     setcookie('member','',0,'/');
           // }
        }
    }

    public function walider(){ //a-zA-Z0-9 - ? ^ * [ ] ( ) n @ # ;:._ąćęłńóśźżĄĆĘŁŃÓŚŹŻ,/=
        define(WZORZEC,'{([^a-zA-Z0-9\-\+\?\^\*\%\[\]\(\)\n\@\#\|\{\} ;:._ąćęłńóśźżĄĆĘŁŃÓŚŹŻ,/=])}');
        foreach ($_GET as $key => $value) { $_GET[$key]=preg_replace(WZORZEC,'',$_GET[$key]);}
        foreach ($_POST as $key => $value) { if ($key=="html") {continue;} $_POST[$key]=preg_replace(WZORZEC,'',$_POST[$key]);}
        global $id;
        if (isset($_GET['id'])){$_GET['id']=$_GET['id']+0; $id=$_GET['id']; }
        if (isset($_POST['id'])){$_POST['id']=$_POST['id']+0; $id=$_POST['id']; }
    }

    public function ilogged($link=null){
        if($link==null){
            if($_SESSION['zalogowany']<1){header('location:/');exit;}
        }else{
            if($_SESSION['zalogowany']<1){header("location:$link");exit;}
        }
    }

    public function cache(){
        if ($this->cache==""){
            require_once 'lib/Cache_v2.5/Cache.class.php';
            require_once 'lib/Cache_v2.5/drivers/CacheFileDriver.class.php';
            //require_once 'lib/Cache_v2.5/drivers/CacheAPCDriver.class.php';
            $this->cache=new Cache();
            //$this->cache->AddDriver('apcDriver',new CacheAPCDriver($_SERVER['DOCUMENT_ROOT'].'/temp/apc'));
            $this->cache->AddDriver('fileDriver',new CacheFileDriver($_SERVER['DOCUMENT_ROOT'].'/temp/cache-files'));
        }
    }

    public function login($login,$password,$redirectory=''){        
        $this->inc(array('members')); global $members;
        $members->login(array('method'=>'classic','something'=>$login,'password'=>$password));
    }

    public function logout(){        
        $this->inc(array('members')); global $members;
        $members->logout();
    }

    public function czyZalogowany(){
        if ($_SESSION['zalogowany']!=1){
            if ($_POST['chcesielogowac']==1){
                $this->login($_POST['login'], $_POST['haslo']);
            }
        }else{
            if ($_POST['wyloguj']==1){
                $this->logout();
            }
        }
        if(isset($_POST['lang_choice'])){
            if ($_POST['lang_choice']==1){
                $_SESSION['S_lang']="pl";
            } else {
                $_SESSION['S_lang']="en";
            }
        }
        if($_SESSION['S_lang']==""){$_SESSION['S_lang']="en";}
    }

    public function warstwaA($tagi='',$menu=''){
        $this->warstwa_menu=$menu;
        $this->skin($this->template_name);
        require_once "$this->template_dir/object.php";
        if (($this->variables->console=='on') and ($this->debug==1)) $this->debuger->console();
        $this->skin->template_warstwaA($tagi);
    }

    public function warstwaB(){
        $this->skin->template_warstwaB();
    }

    public function skin($name){
        //echo "skin() name = $name <br/>";
        if ($name==''){return false;}
        $this->template_name=$name;
        $this->template_dir=$_SERVER['DOCUMENT_ROOT']."/template/".$name;
    }

    public function warstwaTagi($params){
        if (isset($params['refresh'])){ $data .= '<meta http-equiv="refresh" content="'.$params['refresh'].'";http://www.example.org/ />'; }        
        if (isset($params['title'])){ $data .= '<title>'.$params['title'].'</title>';}
        if (isset($params['description'])){ $data .= '<meta name="description" content="'.$params['description'].'"/>';}
        if (isset($params['keywords'])){ $data .= '<meta name="keywords" content="'.$params['keywords'].'"/>';}
        if (isset($params['charset'])){ $data .= '<meta http-equiv="content-type" content="text/html; charset='.$params['charset'].'"/>';}
        if (isset($params['lang'])){ $data .='<meta http-equiv="content-language" content="'.$params['lang'].'"/>'; }
        if (isset($params['author'])){ $data .='<meta name="author" content="'.$params['author'].'"/>'; }
        if (isset($params['days'])){ $data .='<meta name="revisit-after" content="'.$params['days'].' days"/>'; }
        if (isset($params['robots'])){ $data .='<meta name="robots" content="'.$params['robots'].'"/>'; }
        if (isset($params['classification'])){ $data .='<meta name="classification" content="'.$params['classification'].'"/>'; }
        $data .= '<meta http-equiv="content-type" content="text/html; charset=utf-8"/>';
        $data .= '<meta http-equiv="X-UA-Compatible" content="IE=9"/>';
        $data .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
        if ($params['fcb'] == true){
            $data .= '<meta property="fb:app_id" content="'.$this->variables->fcb_appid.'"/>';
            $data .= '<meta property="fb:admins" content="'.$this->variables->fcb_appid.'"/>';
            $data .= '<meta property="og:site_name" content="'.$_SERVER['SERVER_NAME'].'"/>';
            if (isset($params['title'])){$data .= '<meta property="og:title" content="'.$params['title'].'"/>';}
            if (isset($params['title'])){$data .= '<meta name="fb_title" content="'.$params['title'].'"/>';}
            if (isset($params['type'])){$data .= '<meta property="og:type" content="'.$params['type'].'"/>';}
            if (isset($params['url'])){$data .= '<meta property="og:url" content="http://'.$_SERVER['SERVER_NAME'].$params['url'].'"/>';}
            if (isset($params['image'])){$data .= '<meta property="og:image" content="http://'.$_SERVER['SERVER_NAME'].$params['image'].'"/>';}
            if (isset($params['description'])){ $data .= '<meta property="og:description" content="'.$params['description'].'"/>';}
        }
        return $data;
    }

    public function col_text($text,$max=20){
        $ilosc=strlen($text);
        if($max<$ilosc){
            return substr($text,0,($ilosc-($ilosc-$max)))."...";
        }else{
            return $text;
        }
    }

    public function sample_text($znaki=0){
        $text = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.';
        if ($znaki==0){
            return $text;
        }else{
            $ilosc=strlen($text);
            while ($ilosc<$znaki){
                $text.=" ".$text;
                $ilosc=strlen($text);
            }
            return $this->col_text($text,$znaki);
        }
    }

    public function pr($val){
        echo "<pre>";
        print_r($val);
        echo "</pre>";
    }

    public function ronce($filename){
        if (is_file($_SERVER['DOCUMENT_ROOT'].'/engine/'.$filename)){
            require_once $filename;
        } else {
            echo "<pre style='background-color:#FF8888'>file don't exist: '$filename' </pre>";
            exit;
        }
    }
    
    
    public function bootkomunikat($tresc,$t=''){        
        if ($t=='s'){ $class='alert-success'; } else
        if ($t=='w'){ $class='alert-warning'; } else    
        if ($t=='d'){ $class='alert-danger'; } else   
        { $class='alert-info'; }
        $temp = "<div class='alert $class'>$tresc</div>";
        return $temp;
    }
    
    
}



global $pageController; $pageController = new pageController();

?>