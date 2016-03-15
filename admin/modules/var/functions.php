<?php
require_once 'core/funkcje.php';
require_once 'core/xml.php';

//class functions_var {
class functions_var {

    public function __construct() {
        global $funkcje; $this->funkcje =& $funkcje;
        global $xmlVariables; $this->xmlVariables =& $xmlVariables;
        //if ($_GET['func']=='changeone'){ $this->changeOne(); }
        //if ($_GET['func']=='changemulti'){ $this->changeMulti(); }
        //if ($_GET['func']=='zmienwartosc'){ $this->zmienWartosc(); }
    }

    public function zmienWartosc($klucz,$wartosc){
        $this->xmlVariables->load($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.xml');
        $szukane=$klucz;
        $zamiana=$wartosc;
        //echo "szukane $szukane zmiana $zmiana";
        $this->xmlVariables->xml_changeone($szukane, $zamiana);
        $this->xmlVariables->save($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.xml');
        $temp = $this->xmlVariables->generate_variables();
        $this->funkcje->file_save($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.php',$temp);
    }

    public function changeOne(){
        $szukane=$_GET['key'];
        $zamiana=$_GET['value'];
        $this->xmlVariables->load($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.xml');
        $this->xmlVariables->xml_changeone($szukane, $zamiana);
        $this->xmlVariables->save($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.xml');
        $temp = $this->xmlVariables->generate_variables();
        $this->funkcje->file_save($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.php',$temp);
        if ($_GET['back']=="") {
           header("location:index.php");
        } else {
           header("location:$_GET[back]");
        }
    }

    public function changeMulti(){
        require_once 'core/xml.php';
        $this->xmlVariables->load($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.xml');
        foreach ($_POST as $key => $value) {
            $szukane=$key;
            $zamiana=$value;
            $this->xmlVariables->xml_changeone($szukane, $zamiana);
        }
        $this->xmlVariables->save($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.xml');
        $temp = $this->xmlVariables->generate_variables();
        $this->funkcje->file_save($_SERVER['DOCUMENT_ROOT'].'/temp/variables/variables.php',$temp);
        $this->xmlVariables->save($_SERVER['DOCUMENT_ROOT']."/temp/backup/xml_variables/variables_".date("Y-m-d_H-i-s").".xml");
        if ($_POST['back']=="") {
           header("location:index.php"); 
        } else {
           header("location:$_POST[back]"); 
        }
    }

}

global $functions_var; $functions_var = new functions_var();

?>
