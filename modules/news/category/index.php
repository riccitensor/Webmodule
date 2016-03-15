<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';

require_once $_SERVER[DOCUMENT_ROOT].'/engine/lib/Cache_v2.5/add_cache.php';
require_once 'function.php';

$cache_tag = $cache->Get('newsm/news-tag-'.$_GET[page],'default',2);
$cache_content = $cache->Get('newsm/news-content-'.$_GET[page],'default',2);

if (is_null($cache_tag)) {
  require_once 'sql_get.php';
  $cache_tag = warstwaTagi("en",$title,$description,$keywords); 
  $cache->Put('newsm/news-tag-'.$_GET[page], $cache_tag);
}
if (is_null($cache_content)) {
  $cache_content = generate_content($rs,$topic,$pager)."";
  $cache->Put('newsm/news-content-'.$_GET[page], $cache_content);
}

warstwaA($cache_tag);
warstwaL();
warstwaC1();
echo "<textarea>$cache_tag</textarea>";
echo "<textarea>$cache_content</textarea>"; 
echo $cache_content;
warstwaC2();
warstwaB(); ?>