<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';
 $pageController->cache();
 
 $page=$_GET[page];

$cache_commentary_page = $pageController->cache->Get("forum-commentary/$id/$page",'default',$pageController->variables->cache_time_forum); 

if (is_null($cache_commentary_page)) {    
  ob_start(); require $_SERVER[DOCUMENT_ROOT]."/engine/modules/forum/one/list.php"; $cache_commentary_page = ob_get_contents(); ob_end_clean();  
  $pageController->cache->Put("forum-commentary/$id/$page", $cache_commentary_page);  
}
echo $cache_commentary_page;

?>