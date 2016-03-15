<?php

class _skin{

    public $name;
    public $dir;
    public $pageController;

    public function __construct($name){
        $this->init($name);
    }

    public function init($name){
        global $pageController; $this->pageController=&$pageController;
        $this->name = $name;
        $this->dir = "/template/{$this->name}";
    }

    public function warstwaC1(){echo "<div id='content'>";}

    public function warstwaC2(){echo "</div>";}

    public function warstwaL(){}

    public function checkCX($id){
        if ($id=='A'){
            if ($this->pageController->warstwa_menu=="L"){
                $this->warstwaL();
                $this->warstwaC1();
            }
        }
        
        if ($id=='B'){
            if ($this->pageController->warstwa_menu=="L"){
                $this->warstwaC2();
            }
        }
    }

}

?>