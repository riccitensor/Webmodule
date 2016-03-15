 <? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

class modLazyloading extends constructClass {

    var $fileToLoad = '/engine/modules/lazyloading/test.php';
    var $iterations = 99999;
    var $idProcessed = 0;
    var $nextId = 0;
    
    ///////////var $recordsPerPage = 3;

    public function __construct($url='') {
        parent::__construct();
        $this->idProcessed = $_GET['id'];
        $this->nextId = $this->idProcessed + 1;        
        if ($url!='') {$this->fileToLoad = $url;}
        if ($_GET['operation']==''){ $this->index(); }
        if ($_GET['operation']=='page'){ 
            $this->loadPage(); 
            $this->loadPageScript();
        }
    }

    public function index(){
         $this->view();
    }

    public function view(){
        echo "<div class='scroll'><a href='$this->fileToLoad?operation=page&id=$news_id&typ=$typ'>next page</a></div>
        <script type='text/javascript' src='/engine/lib/jscroll-master/jquery.jscroll.js'></script>
        <script>$('.scroll').jscroll({ autoTriggerUntil: $this->iterations });</script>";
    }

    public function loadPage(){
        echo 'loadpage P';
    }

    public function loadPageScript(){
        echo "<div class='scroll'><h3>Page {$this->idProcessed}</h3><p>Content here...</p><a href='$this->fileToLoad?operation=page&id={$this->nextId}'>next page</a></div>";
        
        
        ?>
<script>

   // var height = $(document).scrollTop();
   // $(document).scrollTop(height+500);

</script>

<?
        
    }
    
    

}

?>