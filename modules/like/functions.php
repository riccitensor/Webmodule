<?php

class modLike extends constructClass {    
    
    public function likebutton($url=''){?>
<!--http://sapegin.github.io/social-likes/-->

        <link rel="stylesheet" href="/engine/modules/like/social-likes_birman.css"/>
        <script src="/engine/modules/like/social-likes.min.js"></script>
        <div class="social-likes" data-url="<?=$url?>" data-title="fgfsdfsd">
                <div class="facebook" title="Share link on Facebook">Facebook</div>
                <div class="twitter" title="Share link on Twitter">Twitter</div>
                <div class="plusone" title="Share link on Google+">Google+</div>
                <div class="pinterest" title="Share image on Pinterest" data-media="">Pinterest</div>
        </div>

    <?}
    
}

global $modLike; $modLike = new modLike();

?>