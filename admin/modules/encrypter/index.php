<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public function lista(){
       $search = $_GET['search'];
       ?>
        <table class="karta">
        <tr><td>hasło: </td><td><?=$search?></td></tr>
        <tr><td>md5: </td><td><?if(function_exists(md5)) { echo md5($search); } else { echo "function don't exist";}?></td></tr>
        <tr><td>sha1: </td><td><?if(function_exists(sha1)) { echo sha1($search); } else { echo "function don't exist";}?></td></tr>
        <tr><td>sha256: </td><td><?if(function_exists(sha256)) { sha256($search); } else { echo "function don't exist";}?></td></tr>
        <tr><td>sha512: </td><td><?if(function_exists(sha512)) { sha512($search); } else { echo "function don't exist";}?></td></tr>
        </table>
       <?
    }

}

$operations = new operations("");

?>