<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';
require_once 'core/sql.php';
require_once 'core/funkcje.php';
require_once 'modules/emots/emots.php';

cache();


unset($id); $id += $_GET[id];
unset($topic); $topic += $_GET[topic];
unset($external_id); $external_id += $_GET[external_id];
unset($page); $page += $_GET[page];

//echo "pagi_results.php <br/>";
//echo "id = $id <br/>";
//echo "page = $page <br/>";
//echo "topic = $topic <br/>";

$cache_commentary_page = $cache->Get("news-commentary/$id/$page",'default',80000);
if (is_null($cache_commentary_page)) {
  ob_start(); require $_SERVER[DOCUMENT_ROOT].'/engine/news/commentary/sql_get.php'; $cache_commentary_page = ob_get_contents(); ob_end_clean();
  $cache->Put("news-commentary/$id/$page", $cache_commentary_page);  
}

echo "$cache_commentary_page";