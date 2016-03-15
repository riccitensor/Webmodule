<?
class modReporting extends constructClass {
    
    public function addreport($params){        
        require_once 'core/sql.php';
        $this->sqlconnector->query("INSERT INTO {$this->pageController->variables->base_reporting} SET            
            content='$params[content]',
            link='$params[link]',
        
            author_name='$params[author_name]',
            time_create='".time()."'        
        ");
    }
    
    public function css(){
        ?><style>
            .reporting_content{ border: solid 1px silver; height: 100px; width: 100%; }
            #reporting_switch{ color: white; font-size: 14px; }
        </style><?
    }
    
    
    public function init($params=array()){?>        
        <script>
            function reporting(page){
                loadToId('reporting','/engine/projects/nauker/current/list.php?page='+page);
            }
            var reporting = 0;    
            function reporting_switch() {
                if (reporting==1){
                    document.getElementById('reporting').innerHTML="";
                    document.getElementById('reporting_switch').innerHTML="reporting ON";  
                    reporting = 0;
                } else {
                    document.getElementById('reporting').innerHTML="<form id='reporting_form'><textarea name='reporting_content'></textarea><input type='hidden' name='link' id='link' value='<?=$params['link']?>'/><div onclick='reporting_send()'>send</div></form>"; 
                    document.getElementById('reporting_switch').innerHTML="reporting OFF";  
                    reporting = 1;
                }
            }
            $(document).ready(function(){
                var el = document.getElementById("reporting_switch"); 
                el.addEventListener("click", reporting_switch, false);
            });
            function reporting_send(){
                $.get('/engine/modules/reporting/insert.php', $('#reporting_form').serialize());
                reporting_switch();
            }

        </script>
        <?        
        //echo '<div id="reporting"></div><div id="reporting_switch">reporting ON</div>';
    }

}

global $modReporting; $modReporting = new modReporting();

?>