<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';
   require_once 'functions.php';
   
class operations extends _operations {
    
    var $index_author = false;
    var $index_search = false;
   
    public function __construct($params) {
        global $modUploaderChange; $this->modUploaderChange = $modUploaderChange;
        parent::__construct($params);
    }

    public function index(){
        $this->pageController->admin->warstwaA();        
        if ($_GET['id']>0){
            $this->modUploaderChange->form(array('type'=>1,'type_id'=>$_GET['id']));     
        } else {
            echo $this->funkcje->komunikat('Nie wybrano kategori do ktorej moga byc uploadowane pliki');
        }
        $this->widok_index();
        $this->pageController->admin->warstwaB();
        echo '<script>function op_lista(page){$("#area").load("index.php?operation=lista&id='.$_GET[id].'&column="+column+"&order="+order+"&page="+page+"&search="+urldecode($("#search").val()));}</script>';
    }

    public function lista(){
       $params['rs'] = $this->sqlconnector->pagi("SELECT * FROM {$this->tablename}  WHERE type=1 AND type_id=$_GET[id] ORDER BY $this->column $this->order");
       $params['col'] = array(
           array('name' => 'id',                                                'width' => 30,   'sort' => true), 
           array('name' => '',                   'title' => _ET_IMAGE,          'width' => 70,   'w'=>50,'h'=>50,   'imgdef'=>'/engine/core/basis/skin.gif',                   'func'=>'image', 'link'=>'/temp/upload/[id]/256x256.jpg', 'link_columns'=>array('id')),
           array('name' => 'file_name',          'title' => 'file name',                         'sort' => true),
           array('name' => 'file_format',        'title' => 'file format',      'width' => 100,  'sort' => true),
           array('name' => 'file_size',          'title' => 'file size',        'width' => 100,  'sort' => true),
           array('name' => 'file_ext',           'title' => 'file ext',         'width' => 50,   'sort' => true),
           
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE,    'width' => 120,  'sort' => true,   'func'=>'time'),
           array('name' => '',                   'title' => _ET_READ,           'width' => 16,                     'func'=>'read'),
           array('name' => '',                   'title' => _ET_EDIT,           'width' => 16,                     'func'=>'edit'),
           array('name' => '',                   'title' => _ET_DEL,            'width' => 16,                     'func'=>'delete')
       );
       $this->widok_list($params);
    }
    
    public function read($id){
        $this->pageController->admin->warstwaA();
        $params['rek'] = $this->sqlconnector->rlo("SELECT * FROM {$this->tablename} WHERE id = $id");
        if (($params['rek']['file_format']=='image/jpeg') or ($params['rek']['file_format']=='image/png')){        
            echo "<table class='karta'>";
            echo "<tr><td width='150' height='40'><img style='max-width:580px;' src='/temp/upload/$id/file'></a></td></tr>";
            echo "</table>";
        }
        $this->widok_read($params);
        $this->pageController->admin->warstwaB();
    }
    
    public function delete($id){
        $this->sqlconnector->query("DELETE FROM {$this->tablename} WHERE id = $id");
        header("location:$_SERVER[HTTP_REFERER]");
    }
}

$operations = new operations("{$pageController->variables->base_upload}");

?>