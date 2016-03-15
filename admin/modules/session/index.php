<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    var $index_insert = true;

    public function lista(){?>        
        <table class="lista">
            <th>Variable</th>
            <th>value</th>
        <tbody>
        <? foreach($_SESSION as $key => $value){?>
        <tr>  
          <td><?=$key?></td>
          <td><?=$value?></td>
        </tr>
        <?}?>
        </tbody>
        </table>
        <br/>
        <?
    }

}

$operations = new operations("");

?>