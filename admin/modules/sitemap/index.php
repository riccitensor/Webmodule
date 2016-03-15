<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    var $sitemap;

    public function genereateSiteMap(){
        echo "<table class='lista'>";
        echo "<tr><th>nazwa</th><th>ilość elementów</th></tr>";
        require_once 'lib/sitemap/SitemapGenerator.php';
        $this->sitemap = new SitemapGenerator;
        $dir_func = "projects/{$this->pageController->variables->project_name}/functions.php";
        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/engine/'.$dir_func)){
            require_once $dir_func;
            $name="pro".ucfirst($this->pageController->variables->project_name);
            ${$name}->getSiteMap($this->sitemap); 
        } else {
            echo "<pre style='background-color:#FF8888'>file don't exist: '$dir_func' </pre>";
        }
        echo "</table><br/>";
        // Zapisanie mapy do pliku xml
        $plik = "$_SERVER[DOCUMENT_ROOT]/sitemap.xml";
        file_put_contents($plik, $this->sitemap->generate(FALSE));
    }

    public function lista(){
        $this->genereateSiteMap('aa');
    }

}

$operations = new operations("");

?>