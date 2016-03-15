<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public function index(){
        $this->pageController->admin->warstwaA();
        if ($this->funkcje->checkDir($this->dir,true)) {
            $kod = $this->funkcje->file_load($this->dir.'kod');
        ?>
        <form action='index.php?operation=save_file' method='POST'>
         <table class="karta">
          <tr><td>kod:</td><td><textarea name='kod'><?=$kod?></textarea></td></tr>
          <tr><td>Save</td><td><input name='submit' value='Save' type='submit' /></td></tr>
         </table>
         <input name="id" value="<?=$id?>" type="hidden"/>
        </form        
        <?}
        $this->pageController->admin->warstwaB();
    }

    public function save_file($name){
        $this->funkcje->file_save("{$this->dir}kod", stripslashes($_POST[kod]));
        $this->pageController->admin->warstwaA("10");
        echo "kod został zakutalizowany <br/><br/><a href='index.php'>Edytuj dalej kod</a><br/><br/>";  
        $this->pageController->admin->warstwaB(); 
    }

}

$operations = new operations(array('dir'=>"/temp/resources/{$pageController->variables->project_name}/banners/"));

?>