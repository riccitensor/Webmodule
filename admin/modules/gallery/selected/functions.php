<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';
   require_once 'modules/uploader/functions.php';   

class modUploaderChange extends modUploader{
    
    var $script_name = '/engine/admin/projects/meble/gallery/functions.php';
    var $path_upload = '/temp/upload';
    
    public function convert(){
        require_once 'lib/graph/SimpleImage.php';
        $image = new SimpleImage();        
        $image->load("$_SERVER[DOCUMENT_ROOT]/$this->path_upload/$this->upload_id/file");        
        $image->formatConvert='jpeg';
        $image->resizeToWidth(500);
        $image->save("$_SERVER[DOCUMENT_ROOT]/$this->path_upload/$this->upload_id/500xN.jpg");
        $image->crop(256,256);
        $image->save("$_SERVER[DOCUMENT_ROOT]/$this->path_upload/$this->upload_id/256x256.jpg");
    }
    
}
   
$modUploaderChange = new modUploaderChange();

?>