<?php

//require_once 'modules/fcbconnect/lib/facebook.php';

class modQrcode extends constructClass {
    
    function qrcode($url='') {
        //$_REQUEST[data] = "http://".$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI];
        $_REQUEST[data] = $url;
        $PNG_TEMP_DIR = $_SERVER['DOCUMENT_ROOT'].'/temp/qrcode/';
        $PNG_WEB_DIR = '/temp/qrcode/';
        include 'modules/qrcode/lib/phpqrcode/qrlib.php';    
    
        if (!file_exists($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR);
    
        $filename = "tmp_qrcode_".$PNG_TEMP_DIR.'.png';

        $errorCorrectionLevel = 'L';
        if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
           $errorCorrectionLevel = $_REQUEST['level'];    

        $matrixPointSize = 4;
        if (isset($_REQUEST['size']))
           $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

        if (isset($_REQUEST['data'])) { 

        if (trim($_REQUEST['data']) == '') die('data cannot be empty! <a href="?">back</a>');

        $filename = $PNG_TEMP_DIR.'qrcode_'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
          QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        } else {    
           echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
          QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        }
        
        //display generated file
        return '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';  
    }
    
}

global $modQrcode; $modQrcode = new modQrcode();

?>