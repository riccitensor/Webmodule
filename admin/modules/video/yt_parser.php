<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

//http://www.youtube.com/watch?v=o8Y9-JlSRXw
class website {

    private $strona;
    private $url;

    public function __construct( $url ) {
	$this -> strona = file_get_contents( $url );
        $this -> url = $url;
    }

    public function title(){
        global $filter;
        preg_match( '#meta name="title" content="([\#-\˙ \!]+)#', $this->strona, $r );
        $temp = $this->ogonki($r[1]);
        $temp = $filter->brtospace($temp);
        $temp = strip_tags($temp);
        return $temp;
    }

    public function keywords(){
        global $filter;
        preg_match( '#meta name="keywords" content="([\#-\˙ \!]+)#', $this->strona, $r );
        $temp = $this->ogonki($r[1]);
        $temp = $filter->brtospace($temp);
        $temp = strip_tags($temp);
        return $temp;
    }

    public function description(){
        global $filter;
        preg_match( '#meta name="description" content="([\#-\˙ \!]+)#', $this->strona, $r );
        $temp = $this->ogonki($r[1]);
        $temp = $filter->brtospace($temp);
        $temp = strip_tags($temp);
        return $temp;
    }

    public function url(){
        return $this -> url;
    }

    public function hash(){
        preg_match( '#http\:\/\/www.youtube.com\/watch\?v\=([0-9A-Za-z_-]+)#', $this->url, $r );
        return $r[1];
    }

    public function content(){
        global $filter;
        preg_match( '#<p id="eow-description" >([\#-\˙ \"\!]+)</p>#', $this->strona, $r );
        $temp = $this->ogonki($r[1]);
        $temp = $filter->brtospace($temp);
        $temp = strip_tags($temp);
        return $temp;
    }

    public function onlyaz09($text){
        // $text="    rrrrA Axczxcz xc33 333 333333 3333AAAxx!!!???$^#xz z - fsd z^%%$^$%^$%^^%$^#^@zz 00001 111";

        //zamiana wszystkich spacji na myslniki
        $wzorzec ='{([ ])}';
        $zamiana ='-';
        $text = preg_replace($wzorzec, $zamiana, $text);

        //usuwanie wszystkich znakow ktoren ie pasuja do wzoru
        $wzorzec ='{([^a-zA-Z0-9\-])}';
        $zamiana ='';
        $text = preg_replace($wzorzec, $zamiana, $text);

        //zamiana na male litery
        $text=strtolower($text);

        //usuwanie duzej ilosci myslnikow
        $wzorzec ='{\-\-\-\-\-}';  $zamiana ='-'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\-\-\-\-}';  $zamiana ='-'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\-\-\-}';  $zamiana ='-'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\-\-}';  $zamiana ='-'; $text = preg_replace($wzorzec, $zamiana, $text);

        return $text;
    }
    public function ogonki($text){
        $wzorzec ='{\ą}';  $zamiana ='a'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\ć}';  $zamiana ='c'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\ę}';  $zamiana ='e'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\ś}';  $zamiana ='s'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\ł}';  $zamiana ='l'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\ó}';  $zamiana ='o'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\ź}';  $zamiana ='z'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\ż}';  $zamiana ='z'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\ń}';  $zamiana ='n'; $text = preg_replace($wzorzec, $zamiana, $text);

        $wzorzec ='{\Ą}';  $zamiana ='A'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\Ć}';  $zamiana ='C'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\Ę}';  $zamiana ='E'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\Ś}';  $zamiana ='S'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\Ł}';  $zamiana ='L'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\Ó}';  $zamiana ='O'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\Ź}';  $zamiana ='Z'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\Ż}';  $zamiana ='Z'; $text = preg_replace($wzorzec, $zamiana, $text);
        $wzorzec ='{\Ń}';  $zamiana ='N'; $text = preg_replace($wzorzec, $zamiana, $text);

        return $text;
    }
    
    public function getTimeVideo($hash){
        $url = "http://gdata.youtube.com/feeds/api/videos/". $hash;
        $doc = new DOMDocument;
        $doc->load($url);
        //$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
        return $doc->getElementsByTagName('duration')->item(0)->getAttribute('seconds');
    }
    
}
?>