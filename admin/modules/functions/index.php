<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public function index(){
        $this->pageController->admin->warstwaA();?>
            <div id="area">
            <table class="lista">
                <th>Name</th>
                <th>func_exists</th>
                <th>isAvailable</th>
            <tbody>
            <tr><td>mail</td><td><?=$this->func_exists('mail');?></td><td><?=$this->isAvailable('mail');?></td></tr>
            <tr><td>system</td><td><?=$this->func_exists('system');?></td><td><?=$this->isAvailable('system');?></td></tr>
            <tr><td>exec</td><td><?=$this->func_exists('exec');?></td><td><?=$this->isAvailable('exec');?></td></tr>
            <tr><td>passthru</td><td><?=$this->func_exists('passthru');?></td><td><?=$this->isAvailable('passthru');?></td></tr>
            <tr><td>test555</td><td><?=$this->func_exists('test555');?></td><td><?=$this->isAvailable('test555');?></td></tr>
            </tbody>
            </table>
            </div>
            <br/>
        <?$this->pageController->admin->warstwaB();
    }
    
    function func_exists($funkcja) {
        if (function_exists($funkcja)) {
            //echo "Funkcja <strong>$funkcja</strong> jest dostepna na serwerze.";
            echo "on";
        }
        else {
            echo "off";
            //echo "Funkcja <strong>$funkcja</strong> nie jest dostepna na serwerze.";
        }
    }

    function isAvailable($func){
        if (ini_get('safe_mode')) return false;
        $disabled = ini_get('disable_functions');
        if ($disabled){
            $disabled = explode(',',$disabled);
            $disabled = array_map('trim',$disabled);
            return !in_array($func, $disabled);
        }
        return true;
    }

}

$operations = new operations("");

?>