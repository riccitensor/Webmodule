<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public function __construct($params) {
        parent::__construct($params);
        if ($_GET['operation']=='change'){$this->change();}
    }

    public function checkTemplateSamplePNG($file){
        if (file_exists($_SERVER['DOCUMENT_ROOT']."/template/$file/sample.png")){
            echo "/template/$file/sample.png";
        } else {
            echo "/engine/core/basis/skin.gif";
        }
    }

    public function widok_index() {
        ?>
        <style>
            .admin_template_img { margin: 5px; width: 100px; height: 60px;}
        </style>
        <div id="area">
        <table class="lista">
          <th width="180px"><?=_ET_PREVIEW?></th>
          <th width=""><?=_ET_TEMPLATE_NAME?></th>
          <th width="16px"><?=_ET_VIEW?></th>
          <th width="16px"><?=_ET_EXECUTE?></th>
          <th width="16px"><?="set"?></th>
          <th width="16px"><?="admin"?></th>
        <tbody>
        <? $files = $this->funkcje->getFiles($_SERVER['DOCUMENT_ROOT'].'/template/');
        foreach ($files as $file) {?>
           <tr>
             <td><img class="admin_template_img"src="<?$this->checkTemplateSamplePNG($file)?>"/></td>
             <td><?="$file"?></td>
             <td><?=$this->col_view_file($file)?></td>
             <td><?=$this->col_exec('index.php?operation=change&template_name='.$file); ?></td>
             <td><? if ($this->pageController->variables->template_name==$file) {echo "SET";} ?></td>
             <td><? if ($this->pageController->variables->template_admin==$file) {echo "SET";} ?></td>
           </tr>
        <?}?>
        </tbody>
        </table>
        </div>
    <?}

    public function change(){
        require_once 'admin/modules/var/functions.php';
        global $functions_var;
        $functions_var->zmienWartosc("template_name", $_GET['template_name']);
        header('location: index.php');
    }

    public function view(){
        $this->pageController->skin("$_GET[name]");
        $this->pageController->warstwaA('');
        echo "<div style='margin:50px; text-align:justify;'>".$this->pageController->sample_text(5000)."</div>";
        $this->pageController->warstwaB();
    }
}

$operations = new operations("");

?>