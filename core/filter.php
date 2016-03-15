<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

class filter {

    public $pl_full = '{([^a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9\-\ \.\:\^\(\)\_\,])}';
    public $en_full = '{([^a-zA-Z0-9\-\ \.\:\^\(\)\_])}';
    public $en_simple = '{([^a-zA-Z0-9\-\_])}';
    public $en_simplegp = '{([^a-zA-Z0-9\-\_\*\?])}'; //gwiazdka pytajnik

    public $debug = 0;

    function parse($text,$pattern,$trim=0,$space=0,$lower=0){
        if($trim==1){ $text = trim($text); }
        if($space==1){ $text = str_replace(' ','-',$text); }//preg_replace('ą','a',$text);
        if($lower==1){ $text = strtolower($text); }
        //echo "t1 = $text<br/>";
        if($this->${pattern}!=''){
            $text = preg_replace($this->${pattern},'',$text);
        }else{
            echo '<pre>parse -> pattern is empty</pre>';
        }
        //echo "t2 = $text <br/>";
        $this->clean_space($text);
        return $text;
    }

    function clean_space($text){
        $text = preg_replace("/(\t)+/", "\t",$text);
        $text = preg_replace("/\r\n/", "",$text);//tutaj chyba spacje dodac trzeba zamiast pustki ""
        return preg_replace("/ +/"," ",$text);
    }
    
    function brtospace($text){
        $text=preg_replace('{(\<br\>)}',' ',$text);
        $text=preg_replace('{(\<br\/\>)}',' ',$text);
        $text=preg_replace('{(\<br \/\>)}',' ',$text);
        return $text;
    }
    
    function mysql_pl_search($text){
        $t1 = array('e','o','a','s','l','z','c','n');
        $t2 = array('ę','ó','ą','ś','ł','ż','ć','ń');
        $t3 = array('ę','ó','ą','ś','ł','ź','ć','ń');
        $t4 = array('E','O','A','S','L','Z','C','N');
        $t5 = array('Ę','Ó','Ą','Ś','Ł','Ż','Ć','Ń');
        $t6 = array('Ę','Ó','Ą','Ś','Ł','Ź','Ć','Ń');

        $zakodowane = array( '$&X1', //E
                             '$&X2', //O
                             '$&X3', //A
                             '$&X4', //S
                             '$&X5', //L
                             '$&X6', //Z
                             '$&X7', //C
                             '$&X8'); //N

        $text = str_replace($t1,$zakodowane,$text);
        $text = str_replace($t2,$zakodowane,$text);
        $text = str_replace($t3,$zakodowane,$text);
        $text = str_replace($t4,$zakodowane,$text);
        $text = str_replace($t5,$zakodowane,$text);
        $text = str_replace($t6,$zakodowane,$text);
        $new = array('(e|ę|E|Ę)','(o|ó|O|Ó)','(a|ą|A|Ą)','(s|ś|S|Ś)','(l|ł|L|Ł)','(z|ż|ź|Z|Ż|Ź)','(c|ć|C|Ć)','(n|ń|N|Ń)','(E|Ę)');
        return '^((.*)'.str_replace($zakodowane, $new, $text).')$*';
    }

    function wyczysc($get,&$search,&$column,&$order){
        $search = $get['search'];
        if ($this->debug) {echo "<pre>przed = $search"; }
        $search = $this->mysql_pl_search($search); 
        if ($this->debug) {echo "<br/>po = $search </pre>"; }
        if ($get['column']!=''){
            $column = $this->parse($get['column'],'pl_full');
        }
        if ($get['order']!=''){
            $order = $this->parse($get['order'],'pl_full');
        }
        if ($column=="") {$column="id";}
        if (($order==1) or ($order=='desc')) {$order="desc";} else {$order="asc";}
    }

    function usunOgonki($text){
        $text=preg_replace('ą','a',$text);
        $text=preg_replace('ć','c',$text);
        $text=preg_replace('ę','e',$text);
        $text=preg_replace('ś','s',$text);
        $text=preg_replace('ł','l',$text);
        $text=preg_replace('ń','n',$text);
        $text=preg_replace('ó','o',$text);
        $text=preg_replace('ź','z',$text);
        $text=preg_replace('ż','z',$text);
        return $text;
    }

    public function string($text,$min=3,$max=0){
        $text = trim($text);
        if ($text=="" || $text==null){return 1;} else
        if(!preg_match("/^[A-Za-z0-9_ @\.]{".$min.",}$/", $text))  {return 2; } else
        if ($max!=0) if(!preg_match("/^[A-Za-z0-9_ @\.]{".$min.",".$max."}$/", $text)) {return 3; }
    }

}

global $filter; $filter = new filter();

?>