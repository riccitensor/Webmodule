<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public $privilage = array(10);

    public function index(){
        $this->pageController->admin->warstwaA();?>
            <div style="width: 28%; float: left; margin: 0px; padding: 0px; margin-left: 2%; margin-bottom:15px;  border: solid 0px red;"> 
                <div class='komunikat'>
                <img src='core/graphics/system/linux.png' alt=''/> <?=time()?><br/>
                <img src='core/graphics/system/time.png' alt=''/> <?=date('Y-M-d H:i:s',time())?><br/>
                <img src='core/graphics/system/time.png' alt=''/> <?=date('Y-m-d H:i:s',time())?>
                </div>
                <div class='komunikat'>
                <img src='core/graphics/system/database.png' alt=''/> Videos: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_video}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Videos.category: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_video_category}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Topics: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_forum_topic}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Posts: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_forum_post}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Members: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_members}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> News: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_news}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Contact Us: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_contactus}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Bad links Report: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_badlinks}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Votes: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_votes}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Logs: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_logs}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Notes: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_notes}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Gallery: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_gallery}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Quiz: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_quiz}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Quiz.category: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_quiz_category}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Quiz.courses: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_quiz_courses}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Quiz.answers: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_quiz_answers}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Quiz.session: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_quiz_session}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Quiz.tree: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_quiz_tree}")?><br/>
                <img src='core/graphics/system/database.png' alt=''/> Proxy: <?=$this->zliczanie("SELECT * FROM {$this->pageController->variables->base_proxy}")?>
                </div>
                </div>
            <div style=" padding: 0px; margin: 0px; margin-right: 2%; width: 68%; float: right; border: solid 0px red;"> 
            <div class='komunikat' style="overflow: auto; "><?=$tmp?>
            <? $files = $this->funkcje->getFiles($_SERVER['DOCUMENT_ROOT'].'/engine/admin/modules/'); 
            foreach ($files as $file) {
               if ($this->istmp($file) != true) {?>  
                <a href='/engine/admin/modules/<?=$file?>/'>
                <div style="border: solid 0px red; width: 50px; height: 70px; float: left;">
                    <div style="width: 32px; height: 32px; border: solid 0px blue; margin: 9px;">
                        <?if(file_exists($_SERVER['DOCUMENT_ROOT']."/engine/admin/modules/$file/icon.png")){
                            echo "<img class='module_image' src='/engine/admin/modules/$file/icon.png'/>";
                        } else {
                            echo "<img class='module_image' src='/engine/core/basis/file.png'/>";
                        }?>
                    </div>
                    <div style=" text-align: center; overflow: hidden;"><?=$file?></div>
                </div>
                </a>
               <?}
            }
            ?>
            </div>
            <div style=" padding: 0px; margin: 0px;  border: solid 0px red;"> 
            <? $files = $this->funkcje->getFiles($_SERVER['DOCUMENT_ROOT'].'/engine/admin/projects/'); 
            foreach ($files as $file) {?>
                <div class='komunikat' style="float:left;">
                    <div style="width:80px; height: 55px;">
                        <div style="overflow:auto; "> 
                            <img style="float:left;margin-right: 12px;" class="module_image" src="/engine/admin/modules/projects/icon.png"/>
                            <?if ($this->pageController->variables->project_name==$file){
                               echo "<div> <b>is set</b> </div>"; 
                            }?>
                        </div>
                        <div style="margin-top: 7px;"><a href='/engine/admin/projects/<?=$file?>'><?=$file?></a></div>
                    </div>
                </div><?
            }?>
            </div>
            <div class='komunikat' style="overflow: auto; width: 100%; "><?=$tmp?>
            <? $files = $this->funkcje->getFiles($_SERVER['DOCUMENT_ROOT'].'/engine/modules/');
            foreach ($files as $file) {
               if ($this->istmp($file) != true) {?>
                <div style="border: solid 0px red; width: 50px; height: 70px; float: left;">
                    <div style="width: 32px; height: 32px; border: solid 0px blue; margin: 9px;">
                        <?if(file_exists($_SERVER['DOCUMENT_ROOT']."/engine/modules/$file/icon.png")){
                            echo "<img class='module_image' src='/engine/modules/$file/icon.png'/>";
                        } else {
                            echo "<img class='module_image' src='/engine/core/basis/file.png'/>";
                        }?>
                    </div>
                    <div style=" text-align: center; overflow: hidden;"><?=$file?></div>
                </div>
               
               <?}/* <a href='/engine/admin/modules/<?=$file?>/'></a>  */
            }
            ?>
            </div>
            </div>
            <style>
                .komunikat { margin: 4px; margin-top: 8px;}
                .module_image {width:32px; height: 32px;}
            </style>
        <?$this->pageController->admin->warstwaB();
    }

    function zliczanie($sql){
        global $sqlconnector;
        $ile = "<b style='color:red;'>BASE doesn't exist!</b>";
          $temp = $sqlconnector->select($sql);
        if ($temp!="") {
         $ile = mysql_num_rows($temp);
         //$ile = $temp->num_rows;
        }
        return $ile;
    }

    function istmp($text){
       if(!preg_match("/^[_][A-Za-z0-9_]+$/", $text)){ return false; } else {return true;}
    }

}

$operations = new operations("");

?>