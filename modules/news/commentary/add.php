<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

require_once 'core/sql.php';
require_once 'core/funkcje.php';

unset($topic); $topic += $_POST[topic];
unset($external_id); $external_id += $_POST[external_id];

if ($_SESSION['zalogowany']==1) {
    require_once 'modules/forum/function.php';
    
    $_POST[content] = strip_tags($_POST[content]);    
    $content = $modForum->check_content($_POST[content]);
    $watek = 0; $watek += $_POST[topic];
    
    if ($content=="" ){
        require_once 'forum/function.php';
        if ($modForum->existForumRow($watek)){
            $modForum->addPost($_POST[topic], $_POST[content]);
            $modForum->updateStatsForumPosts($_POST[topic]);
            $modForum->updateStatsUserPosts($_SESSION[S_ID]);
            rrmdir("$_SERVER[DOCUMENT_ROOT]/temp/news-commentary/$external_id");
            rrmdir("$_SERVER[DOCUMENT_ROOT]/temp/forum-commentary/$_POST[topic]");
        } else {            
            $rs = $sqlconnector->query("SELECT * FROM {$pageController->variables->base_news} WHERE id='$external_id'");
            while($rek=mysql_fetch_assoc($rs)){  
                $title=$rek[title];
            }                
            $nrwatku = $modForum->addForumRow($_SESSION[S_ID],"NEWS: $title","8");
            $modForum->addPost($nrwatku, $_POST[content]);
            updateStatsForumPosts($nrwatku);
            $modForum->updateStatsUserPosts($_SESSION[S_ID]);                
            $sqlconnector->query("UPDATE {$pageController->variables->base_news} SET forum_id = '$nrwatku' WHERE id='$external_id';");
            echo $nrwatku;  
        }
    }
    //header("location: $_SERVER[HTTP_REFERER]"); exit;
} else {
   // header("location: /register.php"); exit;
} 
?>
