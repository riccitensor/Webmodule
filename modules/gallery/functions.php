 <? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
    require_once 'core/sql.php';

class modGallery extends constructClass {

    public function getGallery($id){
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_news} WHERE id='$id' limit 1");
        if (!isset($rek)) {
            $this->pageController->warstwaA("");
            echo "<pre>gallery not exist</pre>";
            $this->pageController->warstwaB();
        }
        return $rek;
    }

    public function getGalleryFiles($id){
        require_once 'core/funkcje.php';
        $files = $funkcje->getFiles("$_SERVER[DOCUMENT_ROOT]/temp/resources/{$this->pageController->variables->project_name}/images/$id/mini/");
        $tmp = '<div class="gallery">';
        foreach ($files as $file) {
            $tmp .= '<div class="gallery_img">';
            $tmp .= "<a href='/temp/resources/{$this->pageController->variables->project_name}/images/$id/orginal/$file'>";
            $tmp .= "<img src='/temp/resources/{$this->pageController->variables->project_name}/images/$id/mini/$file'/>";
            $tmp .= '</a>';
            $tmp .= '</div>';
        }
        $tmp .= '</div>';
        return $tmp;
    }
}

global $modGallery; $modGallery = new modGallery();

?>