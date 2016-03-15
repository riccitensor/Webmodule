<?php

class xmlVariables {
    public $xml=array(); //składany plik;
    public $open=false;

    public function xml_addvalue($name,$value){
        $this->xml[]=array('name'=>"$name",'value'=>"$value");
    }

    public function load($file){
        if ($this->open==false){
            $doc = new DOMDocument();
            $doc->load($file);
            $tab=$doc->getElementsByTagName("rec");
            foreach($tab as $host){
                $temp1=$host->getElementsByTagName("name");
                $name=$temp1->item(0)->nodeValue;
                $temp2=$host->getElementsByTagName("value");
                $value=$temp2->item(0)->nodeValue;
                $this->xml_addvalue($name,$value);
            }
            $this->open=true;
        }
    }

    public function save($file="write.xml"){
        $doc=new DOMDocument();
        $doc->formatOutput=true;
        $r=$doc->createElement("tablica");
        $doc->appendChild($r);
        foreach($this->xml as $tab){
            $b=$doc->createElement("rec");
            $name=$doc->createElement("name");
            $name->appendChild($doc->createTextNode($tab['name']));
            $b->appendChild($name);
            $value=$doc->createElement("value");
            $value->appendChild($doc->createTextNode($tab['value']));
            $b->appendChild($value);
            $r->appendChild($b);
        }
        $doc->save($file);
    }

    public function generate_variables(){
        $tempa="<?\nclass variables {\n";
        foreach ($this->xml as $key => $value) {
            $tempa.="public \${$this->xml[$key]['name']}='{$this->xml[$key]['value']}';\n";
        }
        $tempa.="} global \$variables; \$variables = new variables();?>";
        return $tempa;
    }

    public function xml_changeone($szukane,$zamiana){
        foreach ($this->xml as $key => $value){
            if ($this->xml[$key]['name']==$szukane){
                $this->xml[$key]['value']=$zamiana;
            }
        }
    }

    public function xml_viewone($szukane){
        foreach ($this->xml as $key => $value){
            if ($this->xml[$key]['name']==$szukane){
                return $this->xml[$key]['value'];
            }
        }
    }

}

global $xmlVariables; $xmlVariables = new xmlVariables();

?>