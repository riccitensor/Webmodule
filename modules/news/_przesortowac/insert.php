<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';

require_once 'core/sql.php';
require_once 'core/funkcje.php';

$id = $_POST[id] + 0;
if ($_SESSION['zalogowany']==1) {
    require_once 'core/funkcje.php';
    $_POST[content] = strip_tags($_POST[content]);    
    $content = $modForum->check_content($_POST[content]);
    
    if ($content=="" ){
        require_once 'forum/function.php';
        if ($modForum->existForumRow($id)){
            $modForum->addPost($id, $_POST[content]);
            $modForum->updateStatsForumPosts($id);
            $modForum->updateStatsUserPosts($_SESSION[S_ID]);
            rrmdir($_SERVER[DOCUMENT_ROOT]."/temp/cache-files/news-commentary/$id");
            //rrmdir($_SERVER[DOCUMENT_ROOT]."/temp/cache-files/forum-commentary/$_POST[topic]");
        } else {            
            $rs = $sqlconnector->query("SELECT * FROM {$pageController->variables->base_news} WHERE id='$id'");
            while($rek=mysql_fetch_assoc($rs)){  
                $title=$rek[title];
            }                
            $nrwatku = $modForum->addForumRow($_SESSION[S_ID],"NEWS: $title","8");
            $modForum->addPost($nrwatku, $_POST[content]);
            $modForum->updateStatsForumPosts($nrwatku);
            $modForum->updateStatsUserPosts($_SESSION[S_ID]);                
            $sqlconnector->query("UPDATE {$pageController->variables->base_news} SET forum_id = '$nrwatku' WHERE id='$id';");
            echo $nrwatku;  
        }
    }
    //header("location: $_SERVER[HTTP_REFERER]"); exit;
} else {
   // header("location: /register.php"); exit;
} 
?>