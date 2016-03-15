<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';
   require_once "modules/widget/functions.php"

?>
<style>
#news1 { margin-left:20px; margin-right:20px; margin-top:20px; margin-bottom:20px;}
#news1,#news1_time, #news1_title, #news1_content {border:none;}
#news1_title {font-size:12px; font-weight:bold;}
#news1_time {font-size:9px; color:#bababa;}
#news1_content {font-size:11px; text-align:justify;}
</style>

<div id='news1'>
  <div id='news1_widget_social'><?$modWidget->widget(array('nk'=>true,'facebook'=>true,'twitter'=>true));?></div>
  <div id='news1_title'><?=$rek['title']?>:</div>
  <div id='news1_time'><?=date('Y-m-d H:i:s',$rek['time_create'])?></div>
  <div id='news1_content'><?=$rek['content']?></div>
</div>