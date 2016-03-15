<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/funkcje.php';

class modUploader extends constructClass {
    
    var $type = 1;//news|article|galler (ma 1)
    var $type_id = 0;//rekord z bazy
    var $script_name = '/engine/modules/uploader/functions.php';
    var $upload_id = 0;
    
    public function __construct(){
        parent::__construct();        
        
        if ($_POST['type']>0){
            $this->type = $_POST['type'];
        }
        if ($_POST['type_id']>0){
            $this->type_id = $_POST['type_id'];
        }
        
        if ($_GET['operation']=='upload'){  $this->save(); }        
    }

    public function save(){
        require_once 'core/sql.php';        
        foreach ($_FILES[plik_upload] as $key => $value) {
            //echo " $key = >  $value <br/>";
        }
        $file_ext = pathinfo($_FILES[plik_upload][name], PATHINFO_EXTENSION);        
        $this->upload_id = $this->sqlconnector->insert("INSERT INTO {$this->pageController->variables->base_upload} SET
              file_name='{$_FILES[plik_upload][name]}',
              file_format='{$_FILES[plik_upload][type]}',
              file_size='{$_FILES[plik_upload][size]}',
              file_ext='{$file_ext}',
              type='{$this->type}',
              type_id='{$this->type_id}',
              time_create='".time()."'
        ");        

        $this->funkcje->mkdir("$_SERVER[DOCUMENT_ROOT]/temp/upload/$this->upload_id");
        move_uploaded_file($_FILES['plik_upload']['tmp_name'],"$_SERVER[DOCUMENT_ROOT]/temp/upload/$this->upload_id/file");
        
        if ($this->funkcje->isImage($_FILES['plik_upload']['type'])){
            $this->convert();
        }        
        header("location:$_SERVER[HTTP_REFERER]");
    }
    
    public function convert(){
        
    }    
    
    public function form($param=array()){
          echo "<form enctype='multipart/form-data' action='$this->script_name?operation=upload' method='POST'>
              <tr><td>img:</td><td><input name='plik_upload' type='file' style='width:600px;'/></td></tr>
              <tr><td></td><td>
              <input type='hidden' name='MAX_FILE_SIZE' value='2000000000' />";        
          if ($param[type]>0){
              echo "<input type='hidden' name='type' value='$param[type]'/>";
          }
          if ($param[type_id]>0){
              echo "<input type='hidden' name='type_id' value='$param[type_id]'/>";
          }
          echo "<input type='submit' value='"._ADD."' />
          </td></tr></form>";
        
        
        //<input type='hidden' name='id'  value='$id'/>
        //<input type='hidden' name='id' value=''/>
    }
    
    public function files(){
        
        
        
        
    }

    
}

?>