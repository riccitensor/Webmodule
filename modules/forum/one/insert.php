<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';
require_once 'core/sql.php';
require_once 'core/funkcje.php';
require_once 'modules/forum/functions.php';

$id = $_POST[id] + 0;
if ($_SESSION['zalogowany']==1) {
    
    $_POST[content] = strip_tags($_POST[content]); 
    
    $content = $modForum->check_content($_POST[content]);    
    if ($content=="" ){        
        if ($modForum->existForumRow($id)){
            $modForum->addPost($id, $_POST[content]);
            $modForum->updateStatsForumPosts($id);
            $modForum->updateStatsUserPosts($_SESSION[S_ID]);            
            $funkcje->rrmdir($_SERVER[DOCUMENT_ROOT]."/temp/cache-files/forum-commentary/$id");              
        }
    }
   header("location: $_SERVER[HTTP_REFERER]"); exit;
} else {
   header("location: /register.php"); exit;
} 
?>
