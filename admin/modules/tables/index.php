<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public $enginePassword = true;

    public function index() {
        $this->pageController->admin->warstwaA("0");
        $this->widok_index();
        $this->pageController->admin->warstwaB();
    }

    public function lista(){
        $info = $this->sqlconnector->query("SHOW TABLE STATUS FROM {$this->pageController->variables->db_name} WHERE Name like '%$_GET[search]%'");
        ?>
        <table class="lista">
            <th>Name</th>
            <th>Data Size</th>
            <th>Index Size</th>
            <th>Total Size</th>
            <th>Total Rows</th>
            <th>Average Size Per Row</th>
            <th>D</th>
        <tbody>
        <? while($array = mysql_fetch_array($info)) {
        $total = $array[Data_length]+$array[Index_length];
        ?>
        <tr>
          <td><?=$array[Name]?></td>
          <td><?=number_format(($array[Data_length]/1024)/1024,2)?> mb</td>
          <td><?=number_format(($array[Index_length]/1024),2)?> kb</td>
          <td><?=number_format(($total/1024)/1024,2)?> mb</td>
          <td><?=$array[Rows]?></td>
          <td><?=number_format(($array[Avg_row_length]/1024),2)?> kb</td>
          <td><?=$this->col_params(array('operation'=>'delete','info'=>"Czy napewno skasować tablice: $array[Name]",'name'=>$array[Name]))?></td>
        </tr>
        <?}?>
        </tbody>
        </table>
        <br/>
    <?}

    public function delete($name){
        $this->sqlconnector->query("DROP TABLE $_GET[name]");
        //echo "DROP TABLE $_GET[name]";
        header("Location:index.php"); exit;
    }

    public function delete_all(){
        ini_set('display_errors', 1);
        ini_set('error_reporting', E_ALL);
        $rs = $this->sqlconnector->query("SHOW TABLE STATUS FROM {$this->pageController->variables->db_name} WHERE Name like '%$_GET[search]%'");
        while($array = mysql_fetch_array($rs)) {
            try {
                echo "del: $array[Name] <br/>";
                $this->sqlconnector->query("DROP TABLE $array[Name]");
            } catch(Exception $e) {
                echo "Blad Exception DROP TABLE $array[Name] <br/>";
            }
        }
        //echo "DROP TABLE $_GET[name]";
        header("Location:index.php"); exit;
    }
}

$operations = new operations("");

?>