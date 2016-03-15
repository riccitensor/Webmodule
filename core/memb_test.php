<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/memb.php';
   
 
class members1 extends _memb {
    
    public function putToSession(&$LoginDetails){
        //echo "D putToSession<br/>";
        //echo "D LoginDetails = $LoginDetails[id]<br/>";
        
        parent::putToSession($LoginDetails);
    }    
    
}

global $members; $members = new members1();




//$members->login(array('method'=>'classic','something'=>'jakistam@tlen.pl','password'=>'xxx'));
//$members->login(array('method'=>'email','email'=>'jakistam@tlen.pl','password'=>'xxx'));

$members->existLogin(array('login'=>'admin'));
$members->existEmail(array('email'=>'ccccc@cmoki.pl'));
$members->existEmail(array('email'=>'jakistam@tlen.pl'));

//$members->register(array('login'=>'admin'));




//$id = $members->Register(array('login'=>'testx',
//                                'pass'=>'xxx',
//                                'email'=>'jakistam@tlen.pl'));
//echo "id = $id";
?>
