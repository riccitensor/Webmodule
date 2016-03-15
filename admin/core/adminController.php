<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'admin/core/lang/en.php';
   require_once 'core/sql.php';
   require_once 'core/filter.php';
   require_once 'core/funkcje.php';
   require_once 'admin/core/operations.php';
   
class adminController {
    
    public $pageController;

    public function __construct(){
        global $pageController; $this->pageController=&$pageController;
        if (isset($_POST['first_run_password'])){
            $_SESSION['first_run_password']=md5($_POST['first_run_password']);
        }
        $this->pageController->skin($this->pageController->variables->template_admin);
    }

    public function warstwaA(){
        if ($this->pageController->variables->template_admin==""){
            $this->pageController->template_dir = $_SERVER['DOCUMENT_ROOT']."/template/{$this->pageController->variables->template_name}";
        }else{
            $this->pageController->template_dir = $_SERVER['DOCUMENT_ROOT']."/template/{$this->pageController->variables->template_admin}";
        }
        $this->pageController->warstwaA("");
        echo "<center>";
        $this->menu();
    }

    public function warstwaB(){
        //getMemory();
        //echo 'tttt='.memory_get_usage();
        echo "</center>";
        $this->pageController->warstwaB();
    }

    public function noItemWithThisName(){
        echo "<pre>".NO_ITEMS_WITH_THIS_NAME."</pre>";
    }

    public function menu(){?>
        <link rel='stylesheet' type='text/css' href='/engine/admin/core/css/admin.css'/>
        <script type='text/javascript' src='/engine/core/function.js'></script>
        <center>
        <?if($_SESSION['S_TYPE']==99){?>
        <div id="admin">
         <a href='/engine/admin/'><?=_MENU_HOME?></a>
         <a href='/engine/admin/modules/news/'><?=_MENU_NEWS?></a>
         <a href='/engine/admin/modules/contactus/'><?=_MENU_CONTACT_US?></a>
         <a href='/engine/admin/modules/menu/'><?=_MENU_MENU?></a>
         <a href='/engine/admin/modules/gallery/'><?=_MENU_GALLERY?></a>
        <!-- <a href='/engine/admin/modules/badlinks/'><?=_MENU_BADLINKS?></a>-->
         <a href='/engine/admin/modules/members/'><?=_MENU_MEMBERS?></a>
         <a href='/engine/admin/modules/forum/'><?=_MENU_FORUM?></a>
         <a href='/engine/admin/modules/video/'><?=_MENU_VIDEO?></a>
         <a href='/engine/admin/modules/votes/'><?=_MENU_VOTES?></a>
         <a href='/engine/admin/modules/logs/'><?=_MENU_LOGS?></a>
        <!-- <a href='/engine/admin/modules/notes/'><?=_MENU_NOTES?></a>-->
         <a href='/engine/admin/modules/settings/'><?=_MENU_SETTINGS?></a>
         <a href='/engine/admin/modules/projects/'><?=_MENU_PROJECTS?></a>
         <a href='/engine/admin/modules/template/'><?=_MENU_TEMPLATE?></a>
        </div>
        <?} else if ($_SESSION['S_TYPE']==10){?>
        <div id="admin">
         <a href='/engine/admin/'><?=_MENU_HOME?></a>
         <a href='/engine/admin/news/'><?=_MENU_NEWS?><</a>
         <a href='/engine/admin/badlinks/'><?=_MENU_BADLINKS?></a>
         <a href='/engine/admin/votes/'><?=_MENU_VOTES?></a>
         <a href='/engine/admin/logs/'><?=_MENU_LOGS?></a>
        </div>
        <?}?>
        </center>
        <br/><?
    }

    public function saveImageFM($params){
        $this->mkdir_resources('images');
        if (!file_exists($params['dir'])) { mkdir($params['dir'], 0777); }
        $file = $_FILES['plik_upload'];
        $file_tmp = $_FILES['plik_upload']['tmp_name'];
        $file_nazwa = $_FILES['plik_upload']['name'];
        $file_rozmiar = $_FILES['plik_upload']['size'];

        if(is_uploaded_file($file_tmp)) {
            if ( $file['type'] == 'image/png' or
                 $file['type'] == 'image/jpeg' or
                 $file['type'] == 'image/bmp' or
                 $file['type'] == 'image/gif') {

                require_once 'lib/graph/SimpleImage.php';
                $image = new SimpleImage();

                foreach ($params['format'] as $key => $value) {
                    if (!file_exists ("$params[dir]/$value[folder]/")) { mkdir("$params[dir]/$value[folder]/", 0777); }
                    $image->load($file_tmp);
                    if (($value[x]>0) and ($value[y]>0)){
                        $image->crop($value[x],$value[y]);
                        //$image->resize($value[x],$value[y]);
                    } else {
                        if ($value[x]>0){
                            //echo "X = $value[x] <br/>";
                            $image->resizeToWidth($value[x]);
                        } else if ($value[y]>0) {
                            //echo "Y = $value[y] <br/>";
                            $image->resizeToHeight($value[y]);
                        }
                    }
                    $image->formatConvert='jpeg';
                    $image->save("$params[dir]/$value[folder]/$file_nazwa");
                }
                if (!file_exists("$params[dir]/orginal/")) { mkdir("$params[dir]/orginal/", 0777); }
                move_uploaded_file($file_tmp, "$params[dir]/orginal/$file_nazwa");
            }
        }

    }

}

global $pageController; $pageController->admin = new adminController();

?>