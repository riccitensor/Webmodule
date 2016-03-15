<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'lang/lang.php'; 

class profilController extends constructClass {

    public function warstwaA(){
        $this->pageController->warstwaA("");
        echo "<link rel='stylesheet' type='text/css' href='/engine/modules/profil/style.css' />";
        echo "<script type='text/javascript' src='/engine/core/function.js'></script>";
        echo "<center>";

        if($_SESSION['zalogowany']==1){
            echo "<div id='menu'>";
            echo "<a href='/profil/'>HOME</a>";
            echo "<a href='/profil/security/'>CHANGE PASSWORD</a>";
            echo "<a href='/profil/logs/'>LOGS</a>";
             if($this->pageController->variables->project_name=="gamestia"){}
             if($this->pageController->variables->project_name=="gymtia"){echo "<a href='/profil/gymtia/'>GYMTIA</a>";}
            echo "</div>";
        }

        if($_SESSION['zalogowany']!=1){
            echo "<form method='post' action='$_SERVER[REQUEST_URI]'>";
            echo "<table style='width:350px; margin-top: 50px; margin-bottom: 50px;'>";
            echo "<thead><tr><th colspan='99'>Your Profil</th></tr></thead>";
            echo "<tr><td>login:</td><td> <input class='choice_205' type='text' name='login'/></td></tr>";
            echo "<tr><td>password:</td><td> <input class='choice_205' type='password' name='haslo'/></td></tr>";
            echo "<tr><td><input type='hidden' name='chcesielogowac' value='1'/>";
            echo "<input type='submit' value='Enter'/>";
            echo "</td></tr>";
            echo "</table>";
            echo "</form>";            
        }
        echo "</center>";    
    }

    public function warstwaB(){  
        echo "";
        $this->pageController->warstwaB();
    }

}

global $profilController; $profilController = new profilController();

?>