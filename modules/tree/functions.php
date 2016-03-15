<?php

class modTree extends constructClass {
        
    var $menu;
    var $return;    
    var $menu2 = array();
    
    public function insert($params){        
        $this->menu2[] = array('name'=>$params['name'],'link'=>$params['link']);        
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
                $this->return.="<a href='$value[link]'>$value[name]</a>";
                $this->el($value,$poz+1);
                $this->return.='</li>';
            }
        }
        if ($poz>0) $this->return.="</ul>\n";
    }
//    
//    public function findPoz($tab, $id){
//        foreach ($tab as $key => $value) {
//            
//            echo "key = $key | value = $value <br/>";
//            
//            if (($key=='link') and ($value==$id)) {
//                return $value;
//            }
//            if (is_array($value)) {
//                $ret = $this->findPoz($value,$id);
//            }
//            if ($ret!='') return $ret;
//        }
//    }
    
    public function poz($poz=0){
        //echo 'test';
        //echo $this->findPoz($this->menu,$poz);
       // foreach ($params as $key => $value) {
            
            
       // }
        
        $name;
        foreach ($this->menu2 as $key => $value) {
            if ($value['link']==$poz){
                $name = $value['name'];
            }
        }
        echo "name = $name<br/>";
        $name = preg_replace("/(\|)/", "\|",$name);
        echo "name = $name<br/>";
        
        foreach ($this->menu2 as $key => $value) {
            if ($value['name']!=$name){   
                //preg_match( '#'.$name.'\|([\#-\˙ \!]+)#', $value['name'], $r );
                preg_match( '#'.$name.'\|([A-Za-z0-9\ \-])#', $value['name'], $r );
                //if (preg_match("/^$name\|[A-Za-z0-9]$/",$value['name'],$r)){
                    echo '-> '.$value['name'].'<br/>';
                    //print_r($r);
                    echo $r[1];
                //}
                if ($r[1]!=''){
                    $this->mm[$r[1]]=$value['link'];
                }                    
            }
        }
        
        foreach ($this->mm as $key => $value) {
            echo "key = $key | val = $value <br/>";
        }        
    }
    
    var $mm;
    
    
}

global $modTree; $modTree = new modTree();

?>