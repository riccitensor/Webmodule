<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';?>
<style>
.viewpost thead tr th {font-size: 15px;  font-weight: bold; text-align: center;}
.viewpost {width: 100%;}
.viewpost tbody tr td:nth-child(1) {font-size: 9px; width: 80px; background-color: #FAFAfA; text-align: center;}
.viewpost tbody tr td:nth-child(2) {padding-left: 5px;}
.viewpost tr td a {font-size: 9px; font-weight: bold;}
.viewpost tfoot tr th textarea {width: 99%;}
.viewpost tfoot tr th {padding-left: 3px;}
.viewpost tfoot tr th:nth-child(1) {padding-right: 3px;}
.viewpost tfoot tr th:nth-child(2) {padding-right: 3px;}
</style>

<div id='retrieved-data'><img src="images/ajax-loader.gif" />retrieved-data</div>

<?
//echo "form.php <br/>";
//echo "topic == $topic <br/>";
//echo "external_id == $external_id <br/>";
//echo "id == $id <br/>";
?>

<script type = "text/javascript">
    
 var id=<?=$id?>+0; //np news id / news video    
 var topic=<?=$topic?>+0;
 var external_id=<?=$external_id?>+0;

 
function paginationAjaxStart(){                     
   var targetURL = '/engine/news/commentary/pagi_results.php?id='+id+'&external_id='+external_id+'&topic='+topic+'&page=1';
   $('#retrieved-data').html('<p><img src="ajax-loader.gif" /></p>');       
   $('#retrieved-data').load( targetURL ).hide().fadeIn('slow');
}
function getpagi(pageno){                     
   var targetURL = '/engine/news/commentary/pagi_results.php?id='+id+'&external_id='+external_id+'&topic='+topic+'&page=' + pageno; 
   $('#retrieved-data').html('<p><img src="ajax-loader.gif" /></p>');       
   $('#retrieved-data').load( targetURL ).hide().fadeIn('slow');
}
paginationAjaxStart();
//alert(a);

</script>
