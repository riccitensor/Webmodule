<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    var $index_buttonName = "backup";
    var $index_insert = false;
    var $index_search = false;

    var $fonts = array(6,7,8,9,10.5,12,14,16,18,20,24,28,36);
    
    public function __construct($tableName = null) {
        $this->dir = $_SERVER['DOCUMENT_ROOT']."/temp/fonts";
        $this->dir_js = "/temp/fonts";
        parent::__construct($tableName);
    }

    public function lista(){
        $params['col'] = array(
           array('name' => 'title',              'title' => _ET_FILE),
           array('name' => 'ext',                'title' => _ET_EXT,                'width' => 25),
           array('name' => 'size',               'title' => _ET_SIZE,               'width' => 80),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE,        'width' => 120),
           array('name' => 'time_modification',  'title' => _ET_TIME_MODIFICATION,  'width' => 120),
           //array('name' => 'exec',               'title' => _ET_EXECUTE,            'width' => 16),
           array('name' => 'view',               'title' => _ET_VIEW,               'width' => 16),
           //array('name' => 'delete',             'title' => _ET_DEL,                'width' => 16),
        );
        $this->widok_files($params);
    }

    public function view(){
        $this->pageController->admin->warstwaA(0);
        echo "<style>table tr {border-bottom: solid 1px silver; } table tr td {padding: 10px;} @font-face { font-family: czcionka; src: url('/temp/fonts/$_GET[name]') format('truetype'); }</style>";
        echo "<table style=''>";        
        foreach ($this->fonts as $key => $value) {
            echo "<tr><td>{$value}px</td><td><div style='font-family: czcionka; font-size: {$value}px;'>{$value}px wielkość czcionki <br/> ĄĘŚĆŹŻÓ ąęśćźżó</div></td></tr>";
        }
        echo "</table>";
        
        /*<div style="margin:50px;">
        <div style="font-family: czcionka"> <?=$_GET['name'];?></div>
        <div style="font-family: czcionka"> ąęśćźżó</div>
        <div style="font-family: czcionka; font-size: 8px;">8px wielkość czcionki</div>
        <div style="font-family: czcionka; font-size: 10px;">10px wielkość czcionki</div>
        <div style="font-family: czcionka; font-size: 12px;">12px wielkość czcionki</div>
        <div style="font-family: czcionka; font-size: 16px;">16px wielkość czcionki</div>
        <div style="font-family: czcionka; font-size: 20px;">20px wielkość czcionki</div>
        <div style="font-family: czcionka; font-size: 24px;">24px wielkość czcionki</div>
        <div style="font-family: czcionka; font-size: 32px;">32px wielkość czcionki</div>
        </div>*/

        
        
        $this->pageController->admin->warstwaB();
    }

}

$operations = new operations("");

?>