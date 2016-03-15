<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'modules/pdf/lib/fpdf/fpdf.php';


class modPdf extends constructClass {

    public function __construct() {
        parent::__construct();        
        $this->pdf = new PDF();
        
        
//        $this->pdf->AddPage();
//        $this->pdf->AddFont('arialpl','','arialpl.php');
//        $this->pdf->AddFont('arialpl','B','arialpl.php');
//        $this->pdf->AddFont('arialpl','I','arialpl.php');
//        $this->pdf->SetFont('arialpl','',8); //190 x 300
//        $this->pdf->SetDrawColor(220,220,220);

    }

    public function header(){
        
    }
    
    public function footer(){
        
    }
    
}

?>