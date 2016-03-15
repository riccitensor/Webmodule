<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/sql.php';
   require_once 'core/funkcje.php';
   require_once 'modules/members/functions.php';

class modRedactors extends constructClass {    
    
    public function getRedactors(){
        global $modMembers;
        
        ?>        
        <style>
            .redactors_table {   border: solid 0px red;  margin: 20px 50px; width: 89%;}
            .redactors_table tr {border-bottom: solid 1px silver;}
        </style>
        <table class="redactors_table">   
        <th width=150px>Admins</th>
        <th width=20px></th>
        <th width=80px>Type</th>
        <th>description</th>
        <th width=250px>log/reg last</th>
        <? $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_members} WHERE type='99'");
        while($rek = mysql_fetch_array($rs)) {?>
        <tr>
         <td td rowspan="2"><a href='/members/<?=$rek[id]?>'><?=$rek[login]?></a></td>
         <td td rowspan="2"><img id="icon" width=18px alt="member" src="/engine/modules/redactors/graphics/members/<?=$rek[type];?>.png"/></td>
         <td td rowspan="2"><?=$modMembers->getType($rek[type])?></td> 
         <td td rowspan="2"><?=$rek[description]?></td>
         <td>last logged: <?if($rek['time_modifiation']=="0"){echo "N/A";} else {echo date('Y-m-d H:i',$rek['time_modifiation']);}?></td>
        </tr>
        <tr><td>date registered: <?if($rek['time_create']=="0"){echo "N/A";} else {echo date('Y-m-d H:i',$rek['time_create']);}?></td></tr>
        <?}?>

        <? $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_members} WHERE type='10'");
        while($rek = mysql_fetch_array($rs)) {?>
        <tr>
         <td td rowspan="2"><a href='/members/<?=$rek['id']?>'><?=$rek['login']?></a></td>
         <td td rowspan="2"><img id="icon" width=18px alt="member" src="/engine/modules/redactors/graphics/members/<?=$rek[type];?>.png"/></td>
         <td td rowspan="2"><?=$modMembers->getType($rek['type'])?></td> 
         <td td rowspan="2"><?=$rek['description']?></td>
         <td>last logged: <?if($rek['time_modification']=="0"){echo "N/A";} else {echo date('Y-m-d H:i',$rek['time_modification']);}?></td>
        </tr>
        <tr><td>date registered: <?if($rek['time_create']=="0"){echo "N/A";} else {echo date('Y-m-d H:i',$rek['time_create']);}?></td></tr>
        <?}?>
        </table>        
    <?}    
    
    public function viewSite(){
        $this->pageController->warstwaA("","L");
        $this->getRedactors();        
        $this->pageController->warstwaB(); 
    }
}



?>