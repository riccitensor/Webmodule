<?php

class captcha {
    var $width = 55;
    var $height = 20;
    var $img = null;
    var $chars = 4;
    var $symbols = "ABCDEF0123456789";
    
    var $fontsize = 15;
    var $sessionvar = 'captcha';
    //var $symbols = "abcdefghijklmnopqrstuvwxyz0123456789";
    		
    function __construct(){
        session_start();
    }

    function run(){
        $this->outputImage();
    }

    function check($arr){
        if (isset($arr) && is_array($arr)) {
            if (isset($arr[$this->sessionvar])) {
                if ($arr[$this->sessionvar] == $_SESSION[$this->sessionvar]) {
                    return true;
                }
            }
        }
    }
		
    function randomString($length=6){
        for ($i = 0; $i < $length; $i++) {
            $string .= $this->symbols[mt_rand(0, strlen($this->symbols)-1)];
        }
        return $string;
    }
		
    function outputImage(){
        $this->img = ImageCreate ($this->width, $this->height);
        if ($this->img) {
            header("Content-type: image/png");

            $bg = ImageColorAllocate($this->img, 255, 255, 255);
            $txt = ImageColorAllocate($this->img, 0, 0, 0);

            $string = $this->randomString($this->chars);

            ImageString($this->img, 31, $this->fontsize, 0, $string, $txt);
            Imagepng($this->img);

            $_SESSION[$this->sessionvar] = $string;
        }
    }
}

global $captcha; $captcha = new captcha;
$captcha->run();

?>