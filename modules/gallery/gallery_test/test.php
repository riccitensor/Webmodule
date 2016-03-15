<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

 warstwaA(""); ?>
<script type="text/javascript" language="javascript" src="yox.js"></script>
<script type="text/javascript" src="yoxview-init.js"></script>
<script type="text/javascript">

LoadScript(yoxviewPath + "yoxview-nojquery.js");
    LoadScript(yoxviewPath + "yoxview-nojquery.js");

    
    $("#yoxview").yoxview({
    backgroundColor: 'Blue',
    playDelay: 5000
});
    
</script>

<div id="yoxview_picasa"></div>

<div class="yoxview">
    <a href="img/01.jpg"><img src="img/thumbnails/01.jpg" alt="First" title="First image" /></a>
    <a href="img/02.jpg"><img src="img/thumbnails/02.jpg" alt="Second" title="Second image" /></a>
</div>


<?
warstwaB();
?>