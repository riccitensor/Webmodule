<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
 $pageController->cache();
 
 //$pageController->skin("brukarstwo");
 
$cache_tag = $pageController->cache->Get('gallery/gallery-tag-'.$id,'default',1);
$cache_content = $pageController->cache->Get('gallery/gallery-content-'.$id,'default',1);

if (is_null($cache_tag)) {
  require_once 'functions.php';
  $cache_tag = $pageController->warstwaTagi("en",$title,$description,$keywords);  
  $pageController->cache->Put('gallery/gallery-tag-'.$id, $cache_tag);
}
if (is_null($cache_content)) {
  require_once 'functions.php';
  ob_start(); require 'ob.php'; $cache_content = ob_get_contents(); ob_end_clean();
  $pageController->cache->Put('gallery/gallery-content-'.$id, $cache_content);  
}

$pageController->warstwaA($cache_tag,"L");

?>

<style>
    .gallery {margin: 20px; }
    .gallery a { margin: 10px;}
</style>

<style>
    .karta_div {border: solid 0px red; margin: 30px; overflow: auto;}
    .admin_gallery {overflow: hidden;width: 90px; height: 110px; border: solid 1px silver; background-color: rgba(128,128,128,0.1); margin: 5px; float: left; padding: 5px;}

    .admin_gallery_img {position:relative; top: 0px; border: solid 0px red; width: 90px; height: 110px;}
    .admin_gallery_img img { height: 110px; width: 90px;}

</style>


<div class="karta_div">
<?=$cache_content;?> 
</div>



<? $pageController->warstwaB(); ?>