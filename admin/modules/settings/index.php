<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public $privilage = array(10);

    function __construct($params){
        parent::__construct($params);
        if ($_GET['operation']=='change_multi'){
            require_once 'admin/modules/var/functions.php';
            $functions_var->changeMulti();
        }
    }

    public function index(){
        $this->pageController->admin->warstwaA();?>
            <style>
                input[type="text"] {width: 70px;}
            </style>
            <form id="foremka" action='index.php?operation=change_multi' method="POST">
            <table class="karta">
            <input name="back" type="hidden" value="/engine/admin/modules/settings"/>
                <tr><td>console</td><td><input name="console" type="hidden" value="off"/>
                        <input name="console" type="checkbox" <?if($this->pageController->variables->console=="on"){echo 'checked="checked"';}?>/>
                </td></tr>

                <tr><td>authorization</td><td><input name="set_authorization" type="hidden" value="off"/>
                        <input name="set_authorization" type="checkbox" <?if($this->pageController->variables->set_authorization=="on"){echo 'checked="checked"';}?>/>
                </td></tr>

                <tr><td>debug</td><td><input name="debug" type="hidden" value="off"/>
                        <input name="debug" type="checkbox" <?if($this->pageController->variables->debug=="on"){echo 'checked="checked"';}?>/>
                </td></tr>

                <tr><td>cache time video </td><td>
                        <input name="cache_time_video" type="text" value="<?=$this->pageController->variables->cache_time_video?>"/>
                </td></tr>

                <tr><td>cache time news</td><td>
                        <input name="cache_time_news" type="text" value="<?=$this->pageController->variables->cache_time_news?>"/>
                </td></tr>

                <tr><td>cache time index</td><td>
                        <input name="cache_time_index" type="text" value="<?=$this->pageController->variables->cache_time_index?>"/>
                </td></tr>

                <tr><td>cache time forum</td><td>
                        <input name="cache_time_forum" type="text" value="<?=$this->pageController->variables->cache_time_forum;?>"/>
                </td></tr>

                <tr><td>cache time left menu</td><td>
                        <input name="cache_time_left_menu" type="text" value="<?=$this->pageController->variables->cache_time_left_menu;?>"/>
                </td></tr>

                <tr><td>index redirector www</td><td><input name="test2" type="hidden" value="off"/>
                        <input name="test2" type="checkbox" <?if($test2=="on"){echo 'checked="checked"';}?>/>
                </td></tr>

                <tr><td>cookies</td><td><input name="cookies" type="hidden" value="off"/>
                        <input name="cookies" type="checkbox" <?if($this->pageController->variables->cookies=="on"){echo 'checked="checked"';}?>/>
                </td></tr>

                <tr><td>cookies lifetime</td><td>
                        <input name="cookies_lifetime" type="text" value="<?=$this->pageController->variables->cookies_lifetime?>"/>
                </td></tr>

                <tr><td>Time-trade-off</td><td><input name="tto" type="hidden" value="off"/>
                        <input name="tto" type="checkbox" <?if($this->pageController->variables->tto=="on"){echo 'checked="checked"';}?>/>
                </td></tr>            
            </table>
            </form>
            <div class="karta_button">
            <input onclick="formSubmit()" value='<?=_BUTTON_SAVE?>' type='submit'/>
            </div>
        <?$this->pageController->admin->warstwaB();
    }

}

$operations = new operations("");

?>