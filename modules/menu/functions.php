<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

class modMenu extends constructClass {

    function css(){?>
        <style>
        #mainmenu, #mainmenu ul {list-style: none; margin: 0; padding: 0;}
        #mainmenu ul {width: 160px;}
        #mainmenu ul li {clear: both;}
        #mainmenu > li {float: left; margin-right: 10px; position: relative;}
        #mainmenu > li li {position: relative;}
        #mainmenu > li ul {position: absolute; left: 0;}
        #mainmenu > li ul li ul {position: absolute; left: 160px; top: 0px;}
        ul ul {display: none;}
        ul li:hover > ul {display: block;}

        /*POZIOM 1*/
        #mainmenu {margin: 0px 0px; font-family: calibri, tahoma, arial; }
        #mainmenu > li > a {display: table; width: auto; padding: 8px;font-size:9px; border-radius: 3px; text-align: center; text-decoration: none; color: greenyellow; background-color: #444;}
        #mainmenu > li:hover > a {background: #444; color: greenyellow; }

        /*POZIOMY NIŻSZE*/
        #mainmenu ul {font-size: 12px; border-radius: 3px; background: #666; }
        #mainmenu ul li > a {color: #fff; font-size: 9px; display: block; padding: 5px; border-radius: 3px; text-decoration: none;}
        #mainmenu ul li:hover > a {color: #eee; background: #333;}

        .arrow {display: inline-block; margin: 0 5px 0; height: 0; vertical-align: top; content: ""; position: absolute;}
        #mainmenu > li > a > .arrow {top: 17px; right: 0; margin-right: -8px; border-top: 3px solid #333; border-right: 3px solid transparent; border-left: 3px solid transparent;}
        #mainmenu ul ul .arrow {top: 10px; right: 0; border-top: 3px solid transparent; border-right: 3px solid transparent; border-left: 3px solid #333; border-bottom: 3px solid transparent;}
        </style>
    <?}

    var $menu;
    var $return;

    public function insert($params){
        $el = explode("|", $params['name']);

        if (count($el)>0){$this->menu[$el['0']]['name']=$el['0'];}
        if (count($el)>1){$this->menu[$el['0']][$el['1']]['name']=$el['1'];}
        if (count($el)>2){$this->menu[$el['0']][$el['1']][$el['2']]['name']=$el['2'];}
        if (count($el)>3){$this->menu[$el['0']][$el['1']][$el['2']][$el['3']]['name']=$el['3'];}
        //if (count($el)>2){$this->menu[$el['0']][$el['1']][$el['2']]['name']=$el['2'];}

        if (count($el)==1){
            $this->menu[$el['0']]['link'] = $params['link'];
            $this->menu[$el['0']]['name'] = $el['0'];
        }
        if (count($el)==2){
            $this->menu[$el['0']][$el['1']]['link'] = $params['link'];
            $this->menu[$el['0']][$el['1']]['name'] = $el['1'];
        }
        if (count($el)==3){
            $this->menu[$el['0']][$el['1']][$el['2']]['link'] = $params['link'];
            $this->menu[$el['0']][$el['1']][$el['2']]['name'] = $el['2'];
        }
        if (count($el)==4){
            $this->menu[$el['0']][$el['1']][$el['2']][$el['3']]['link'] = $params['link'];
            $this->menu[$el['0']][$el['1']][$el['2']][$el['3']]['name'] = $el['3'];
        }
    }

    public function view(){
        global $pageController;
        $pageController->pr($this->menu);
    }

    public function table($name='mainmenu'){
        $this->return = "<ul id='$name'>";
        $this->el($this->menu);
        $this->return .= "</ul>";
        return $this->return;
    }

    public function el($params,$poz=0){
        if ($poz>0) $this->return.="<ul>\n";
        foreach ($params as $key => $value) {
            if (($key!='link') and ($key!='name')){
                $this->return.='<li>';
                if ($value[link]!=''){
                    $this->return.="<a href='$value[link]'>$value[name]</a>";
                } else {
                    $this->return.="<a href='#'>$value[name]</a>";
                }
                $this->el($value,$poz+1);
                $this->return.='</li>';
            }
        }
        if ($poz>0) $this->return.="</ul>\n";
    }

    public function versionA(){
        if ($_SESSION['S_ID']>0){
            $this->insert(array('name'=>'M','link'=>'/'));
            $this->insert(array('name'=>'M|strona główna','link'=>'/'));
            $this->insert(array('name'=>'M|Panel Administratora','link'=>'/engine/admin'));
            $this->insert(array('name'=>'M|Czyść CACHE','link'=>'/engine/admin/modules/cache/index.php?operation=clean'));
            $this->insert(array('name'=>'M|Wyloguj','link'=>'/logout'));
        } else {
            $this->insert(array('name'=>'M','link'=>'/'));
            $this->insert(array('name'=>'M|logowanie','link'=>'/engine/admin/modules/login/?operation=login&dir=/'));
            $this->insert(array('name'=>'M|logowanie przez Facebooka','link'=>"/engine/projects/{$this->pageController->variables->project_name}/pages/fcb/logowanie.php"));
        }
        $this->css();
        echo $this->table();
    }

}

global $modMenu; $modMenu = new modMenu();

?>