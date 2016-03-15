<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public $privilage = array(10,1,-1);
    public $enginePassword = true;

    public function index(){
        require_once 'functions.php';
        require_once 'core/xml.php';
        global $xmlVariables;
        if ($_GET['file']=='') {
           $xmlVariables->load($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.xml');
        } else {
           $xmlVariables->load($_SERVER['DOCUMENT_ROOT'].'/temp/backup/xml_samples/'.$_GET['file']);
        }
        $this->pageController->admin->warstwaA("0");
        ?>
        <style>
            input{width: 200px;}
            .menu_delete { width: 280px;}
            
        </style>
        <table class="karta" style=" width: 600px; float: left; margin-left: 70px; margin-bottom: 20px;">
            <thead><tr colspan="99"><th>Variables</th></tr></thead>
        <tbody><tr><td colspan="99">
        <form id="form" action='index.php?operation=save_file' method='post'>
        <input type="submit" value="save & generate"/>
        <input id="add" type="button" value="<?=_BUTTON_INSERT?>"/>
        <div style="overflow:auto;  margin-top: 10px;">
           <div style="float:left; width:205px;">name/key</div>
           <div>value</div>
        </div>
        <? foreach( $xmlVariables->xml as $tab ) {?>
            <div>
                <input class="input" name="n<?=$id?>" value="<?=$tab[name]?>"/>
                <input class="input" name="v<?=$id?>" value="<?=$tab[value]?>"/>
                <?/*<img src="/engine/admin/core/graphics/function/delete.png" onclick="del(this);" />*/?>
                <input class="menu_delete" src="/engine/admin/core/graphics/function/delete.png" onclick="del(this);" type="button" value="del"/>
            </div>
        <?$id++?>
        <?}
        ?></form>
        </td></tr></tbody>
        </table>
        <div style="width:110px; border:solid 0px red; float: right; margin-right: 100px; margin-top: 80px;">
        <? $files = $this->funkcje->getFiles($_SERVER['DOCUMENT_ROOT'].'/temp/backup/xml_samples/','f');
        foreach ($files as $file) {?>           
          <form style="width:100px;" action="/engine/admin/modules/var/index.php" method="GET">
            <input type="submit" value="<?=$file?>"/>
            <input type="hidden" name="file" value="<?=$file?>"/>
          </form>
        <?}?>
        </div>
        <script>
            function del(item) { $(item).parent().remove(); }
            var id=<?=($id+0)?>;
            $(document).ready( function() { 
                $("#add").click( function() {
                    $('#form').append('<div><input class="input" name="n'+id+'" value=""/> <input class="input" name="v'+id+'" value=""/> <input src="/engine/admin/graphics/function/delete.png" onclick="del(this);" type="button" value="del"/></div>');
                    
                    
                    //alert("add");
                    id++;
                });
            });
        </script><?
        $this->pageController->admin->warstwaB();
    }

    public function lista(){}
    
    public function save_file($name = null){
        require_once 'core/xml.php';
        global $xmlVariables;
        $co = 1;
        $tab1 = array();
        $tab2 = array();
        $licznik = 1;

        foreach ($_POST as $key => $value) {
            if ($co==1) {
                $tab1[$licznik] = $value;
                $co = 2;
            } else {
                $tab2[$licznik] = $value;
                $co = 1;
                if ($tab1[$licznik]!="") $xmlVariables->xml_addvalue($tab1[$licznik], $tab2[$licznik]);
                $licznik++;
            }
        }
        $xmlVariables->save($_SERVER['DOCUMENT_ROOT']."/temp/backup/xml_variables/variables_".date("Y-m-d_H-i-s").".xml");
        $xmlVariables->save($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.xml');
        $temp = $xmlVariables->generate_variables();
        $this->funkcje->file_save($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.php',$temp);
        header("location:index.php");
    }

}

$operations = new operations("");

?>