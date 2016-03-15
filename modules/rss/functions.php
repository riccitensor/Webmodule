<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

class modRss extends constructClass {
    
    var $channel_name   =   'gamestia';//Be sure to change this to your channel
    var $count          =   4;//# of videos you want to show (MAX = 20)
    var $em_width       =   420;//width of embeded player
    var $em_height      =   315;//height of embeded player
    var $wrap_class     =   'video';//class name for the div wrapper
    
    public function view(){
        //The output...         
        error_reporting(E_ALL);
        $feedURL = 'http://gdata.youtube.com/feeds/api/users/'.$this->channel_name.'/uploads?max-results=20';
        $sxml = simplexml_load_file($feedURL);
        $i = 1;
        foreach ($sxml->entry as $entry) {
             $vidUrl    =   explode("/", $entry->id);
             $vidKey    =   $vidUrl[6];
             if ($i <= $this->count ) :
                echo    '
                      <div class="'.$this->wrap_class.'" style=\'float:left\'>
                           <iframe width="'.$this->em_width.'" height="'.$this->em_height.'" src="http://www.youtube.com/embed/'.$vidKey.'" frameborder="0" allowfullscreen></iframe>
                      </div>
                ';
                endif;
                $i++;
        }
    }
    
    
}

global $modRss; $modRss = new modRss();

?>