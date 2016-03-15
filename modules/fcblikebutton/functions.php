<?php

class modFcblikebuttons extends constructClass {    

    public function likebutton($url=''){?>
        <div class="fb-like" data-href="<?=$url?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/pl_PL/all.js#xfbml=1&appId=<?=$this->pageController->variables->fcb_appid?>";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <?}
    
}

global $modFcblikebuttons; $modFcblikebuttons = new modFcblikebuttons();

?>