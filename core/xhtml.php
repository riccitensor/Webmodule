<?php

class xhtml{

    public function html_select($params){
        $return = "<select name='$params[name]' id='$params[id]' class='$params[class]'>";
        foreach($params[options] as $key => $value){
            if ($params[selected]==$key) {$selected = "selected='selected'";} else {$selected='';}
            $return .= "<option $selected label='$value' value='$key'>$value</option>";
        }
        $return .="</select>";
        return $return;
    }

    public function html_checkbox($params){
        if ($params['checked']==1) {$checked = 'checked';}
        $return = "<input type='checkbox' name='$params[name]' value='1' $checked />";
        return $return;
    }

}

//global $html; $html = new html();
global $xhtml; $xhtml = new xhtml();
?>