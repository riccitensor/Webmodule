<? 

class modWidget extends constructClass{
    
    var $size = '16'; //wielkość ikony
    var $url = '';    
    
    public function __construct() {
        parent::__construct();
        $this->url = "http://".$_SERVER['SERVER_NAME']."".$_SERVER['REQUEST_URI'];
    }
    
    public function widget($params) {
        //global $pageController; $pageController->pr($params);
        foreach ($params as $key => $value) {
             if ($value=='nk'){  echo "<a href='http://nk.pl/sledzik?shout=$this->url' rel='nofollow' target='_blank' title='Pochwal się na Naszej-Klasie!'><i class='widget-nk'></i></a>";}
             if ($value=='blip'){ echo "<a href='http://www.blip.pl/dashboard?body=$this->url' rel='nofollow' target='_blank' title='Dodaj do swojego blipa!'><i class='widget-blip'></i></a>";}
             if ($value=='twitter'){ echo "<a href='http://twitter.com/home?status=<?=$this->url?>' rel='nofollow' target='_blank' title='Podziel się na Twitterze!'><i class='widget-twitter'></i></a>";}
             if ($value=='wykop'){ echo "<a href='http://www.wykop.pl/dodaj?url=<?=$this->url?>' rel='nofollow' target='_blank' title='Wykop ten link!'><i class='widget-wykop'></i></a>";}
             if ($value=='gg'){ echo "<a href='gg:/set_status?description=<?=$this->url?>' rel='nofollow' target='_blank' title='Zmień opis w Gadu-Gadu! (od wersji 8.0)'><i class='widget-gg'></i></a>";}
             if ($value=='digg'){ echo "<a href='http://digg.com/submit?phase=2&url=<?=$this->url?>' rel='nofollow' target='_blank' title='Digg'><i class='widget-digg'></i></a>";}
             if ($value=='delicious'){ echo "<a href='http://delicious.com/post?url=<?=$this->url?>' rel='nofollow' target='_blank' title='del.icio.us'><i class='widget-del'></i></a>";}
             if ($value=='bookmarks'){ echo "<a href='http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=<?=$this->url?>' rel='nofollow' target='_blank' title='Google Bookmarks'><i class='widget-googlebookmarks'></i></a>";}
             if ($value=='myspace'){ echo "<a href='http://www.myspace.com/Modules/PostTo/Pages/?u=<?=$this->url?>' rel='nofollow' target='_blank' title='MySpace'><i class='widget-myspace'></i></a>";}
             if ($value=='buzz'){ echo "<a href='http://www.google.com/buzz/post?message=<?=urlencode($title)?>&amp;url=<?=$this->url?>' rel='nofollow' target='_blank'><i class='widget-buzz'></i></a>";}
             if ($value=='pinger'){ echo "<a href='http://pinger.pl/share?title=<?=urlencode($title)?>&amp;content=<?=$this->url?>' rel='nofollow' target='_blank' title='pinger.pl'><i class='widget-pinger'></i></a>";}
             if ($value=='flaker'){ echo "<a href='http://flaker.pl/add2flaker.php?url=<?=$this->url?>&amp;title=<?=urlencode($title)?>' rel='nofollow' target='_blank' title='flaker'><i class='widget-flacker'></i></a>";}
             if ($value=='technorati'){ echo "<a href='http://www.technorati.com/faves?add=<?=$this->url?>' rel='nofollow' target='_blank' title='Technorati'><i class='widget-technorati'></i></a>";}
             if ($value=='stumbleupon'){ echo "<a href='http://www.stumbleupon.com/submit?url=<?=$this->url?>' rel='nofollow' target='_blank' title='StumbleUpon'><i class='widget-stumbleupon'></i></a>";}
             if ($value=='gplus'){ echo "<script type='text/javascript' src='https://apis.google.com/js/plusone.js'></script><g:plusone size='small'></g:plusone>";}
        }
        echo "<link rel='stylesheet' type='text/css' href='/engine/modules/widget/style.css'/>";
         
    }
    
    public function zestawA(){ 
        $this->widget(array('nk','blip','twitter','wykop','gg','digg','delicious','bookmarks','myspace','buzz','pinger','flaker','technorati','stumbleupon','gplus'));
    }
}

global $modWidget; $modWidget = new modWidget();
$modWidget->zestawA();
?>