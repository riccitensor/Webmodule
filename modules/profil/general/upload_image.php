<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';


if ($_SESSION['zalogowany']==1) {
  if ($_SESSION[S_ID]>0) {
    if ($_FILES[userfile][size]<400000) {
       require_once 'lib/graph/SimpleImage.php';
       $image = new SimpleImage();
       
       $image->load($_FILES['userfile']['tmp_name']);
       $image->resize(128,128);
       $image->save($_SERVER[DOCUMENT_ROOT]."/engine/{$pageController->variables->project_name}/resources/avatars_128/$_SESSION[S_ID].jpg", IMAGETYPE_JPEG);
      
       $image->load($_FILES['userfile']['tmp_name']);
       $image->resize(32,32);
       $image->save($_SERVER[DOCUMENT_ROOT]."/engine/{$pageController->variables->project_name}/resources/avatars_32/$_SESSION[S_ID].jpg", IMAGETYPE_JPEG);
         
       $image->load($_FILES['userfile']['tmp_name']);
       $image->resize(24,24);
       $image->save($_SERVER[DOCUMENT_ROOT]."/engine/{$pageController->variables->project_name}/resources/avatars_24/$_SESSION[S_ID].jpg", IMAGETYPE_JPEG);
       
       header("location: /profil/"); exit;
    } else {
        echo "file is to big";
    }
  }
}

header("location: /profil/"); exit;

?>