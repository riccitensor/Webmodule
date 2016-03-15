<?php

class modSocial extends constructClass {
    
    function likebutton($url=''){
        global $pageController;
        
        if ($url==''){
            $url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        } else {
            $url = $_SERVER['SERVER_NAME'].$url;
        }        
        ?>
        <div class="facebook_like_button">
        <div id="fb-root"></div>
        <script>
          window.fbAsyncInit = function() { FB.init({
              appId:'<?=$pageController->variables->fcb_appid?>',
              channelURL:'//<?=$url?>',
              status:true,cookie:true,oauth:true,xfbml:true
          }); };
          (function(d){
             var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;} js = d.createElement('script'); js.id = id; 
             js.async = true; js.src = "//connect.facebook.net/en_US/all.js"; d.getElementsByTagName('head')[0].appendChild(js);
          }(document));    
        </script>
        <fb:like layout="standard" show_faces="true" width="350" action="like" colorscheme="light" href="<?="http://".$url;?>"></fb:like>
        </div>
    <?}
    
public function likebuttons($url='',$title=''){?>
<script type="text/javascript">
$(document).ready(function() {
    <?if ($url==''){?>
       var pageTitle = document.title; //HTML page title
       var pageUrl = location.href; //Location of the page
    <?}else{?>          
       var pageTitle = '<?=$title?>';
       var pageUrl = '<?=$url?>';
    <?}?>            
    //user hovers on the share button	
    $('#share-wrapper li').hover(function() {
        var hoverEl = $(this);	
        if($(window).width() > 699) { 
            if (hoverEl.hasClass('visible')){
                hoverEl.animate({"margin-left":"-110px"}, "fast").removeClass('visible');
            } else {
                hoverEl.animate({"margin-left":"0px"}, "fast").addClass('visible');
            }
        }
    });
    $('.button-wrap').click(function(event) {
        var shareName = $(this).attr('class').split(' ')[0]; //get the first class name of clicked element			
        switch (shareName) {
            case 'facebook':
                var openLink = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);break;
            case 'twitter':
                var openLink = 'http://twitter.com/home?status=' + encodeURIComponent(pageTitle + ' ' + pageUrl);break;
            case 'digg':
                var openLink = 'http://www.digg.com/submit?phase=2&amp;url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);break;
            case 'stumbleupon':
                var openLink = 'http://www.stumbleupon.com/submit?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);break;
            case 'delicious':
                var openLink = 'http://del.icio.us/post?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);break;
            case 'google':
                var openLink = 'https://plus.google.com/share?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);break;
            case 'email':
                var openLink = 'mailto:?subject=' + pageTitle + '&body=Found this useful link for you : ' + pageUrl;break;
        }
        //Parameters for the Popup window
        winWidth 	= 650;	
        winHeight	= 450;
        winLeft   	= ($(window).width()  - winWidth)  / 2,
        winTop    	= ($(window).height() - winHeight) / 2,	
        winOptions   = 'width='  + winWidth  + ',height=' + winHeight + ',top='    + winTop    + ',left='   + winLeft;		
        //open Popup window and redirect user to share website.
        window.open(openLink,'Share This Link',winOptions);
        return false;
    });/**/
});
</script>

<div id="share-wrapper">
    <ul class="share-inner-wrp">
        <li class="facebook button-wrap"><a href="#">Facebook</a></li>
        <li class="twitter button-wrap"><a href="#">Tweet</a></li>
        <li class="digg button-wrap"><a href="#">Digg it</a></li>
        <li class="stumbleupon button-wrap"><a href="#">Stumbleupon</a></li>
        <li class="delicious button-wrap"><a href="#">Delicious</a></li>
        <li class="google button-wrap"><a href="#">Google+</a></li>
        <li class="email button-wrap"><a href="#">Email</a></li>
    </ul>
</div>
    <?
}
    
    public function css(){?>
        <style type="text/css">
        .facebook_like_button {border:solid 1px red; width: 320px; overflow: visible;  margin-top: 8px;}
        .wrapper {
            max-width: 800px;  margin-right: auto;
            margin-left: auto; background: #F5F5F5; padding: 20px;
        }
        /* Share button */
        /* outer wrapper */
        #share-wrapper {/*	position:fixed; position:relative;*/
            margin-top: 100px; z-index: 4; left: 0; index-z: 440000; border: solid px red;
        }
        /* inner wrapper */
        #share-wrapper ul.share-inner-wrp{
            list-style: none; margin: 0px; padding: 0px;
        }
        /* the list */
        #share-wrapper li.button-wrap {
            background: #E4EFF0; padding: 0px 0px 0px 10px;
            display: block; width: 140px; margin: 0px 0px 1px -110px;
        }

        /* share link */
        #share-wrapper li.button-wrap > a {
            padding-right: 60px; height: 32px; display: block; line-height: 32px;
            font-weight: bold; color: #444; text-decoration: none;
            font-family: Arial, Helvetica, sans-serif; font-size: 14px;
        }
        /* background image for each link */
        #share-wrapper .facebook > a{ background: url(/engine/modules/social/buttons/facebook.jpg) no-repeat right; }
        #share-wrapper .twitter > a{ background: url(/engine/modules/social/buttons/twitter.jpg) no-repeat right; }
        #share-wrapper .digg > a{ background: url(/engine/modules/social/buttons/digg.jpg) no-repeat right; }
        .stumbleupon > a{ background: url(/engine/modules/social/buttons/stumbleupon.jpg) no-repeat right; }
        #share-wrapper .delicious > a{ background: url(/engine/modules/social/buttons/delicious.jpg) no-repeat right; }
        #share-wrapper .google > a{ background: url(/engine/modules/social/buttons/google.jpg) no-repeat right; }
        #share-wrapper .email > a{ background: url(/engine/modules/social/buttons/email.jpg) no-repeat right; }
        /* small screen */
        @media all and (max-width: 5199px) {
            #share-wrapper {
                    bottom: 0; /* position: fixed;*/
                    padding: 5px 5px 0px 5px;  background: #EBEBEB;
                                                background:transparent;
                    
                    
                    width: 100%; margin: 0px;
                    -webkit-box-shadow: 0 -1px 4px rgba(0, 0, 0, 0.15);
                    -moz-box-shadow: 0 -1px 4px rgba(0,0,0,0.15);
                    -o-box-shadow: 0 -1px 4px rgba(0,0,0,0.15);
                    box-shadow: 0 -1px 4px rgba(0, 0, 0, 0.15);
            }
            #share-wrapper ul.share-inner-wrp {
                    list-style: none; margin: 0px auto;
                    padding: 0px; text-align: center; overflow: auto;
            }
            #share-wrapper li.button-wrap {
                    display: inline-block; width: 32px!important; margin: 0px;
                    padding: 0px; margin-left:0px!important;
            }
            #share-wrapper li.button-wrap > a {
                    height: 32px; display: inline-block;
                    text-indent: -10000px; width: 32px;
                    padding-right: 0; float: left;
            }
        }
        </style><?
    }
    
}

global $modSocial; $modSocial = new modSocial();

?>