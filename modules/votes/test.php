<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

 //require_once 'core/sql.php';
 require_once 'modules/votes/functions.php';

$pageController->warstwaA(""); 

$modVotes->viewlikeOrNot(array('what'=>'define','what_id'=>'3'));


?>


<!--
<style>
    .vote_video {background-color: red; height: 24px; width: 24px; float: left; cursor: pointer;}
</style>


<style>
.votev_all {border:solid 0px blue; overflow:auto; margin:0px; margin-bottom:7px;}  
.votev_okienko {overflow:auto; border:solid 1px black; width:70px; border-right:none; float:left;}
.votev_voteoff {background-color:silver;width: 6px; height:16px; float:left;border:none;border-right:solid 1px;}
.votev_vote {background-color:silver;width: 6px; height:16px; float:left;border:none;border-right:solid 1px;cursor:pointer;}
.votev_voteb {background-color:#00baff;width:6px; height:16px; float:left;border:none;border-right:solid 1px;cursor:pointer;}
.votev_voteg {background-color:#00FF00;width:6px; height:16px; float:left;border:none;border-right:solid 1px;cursor:pointer;}    
.votev_voter {background-color:#FF0000; width:6px; height:16px; float:left;border:none;border-right:solid 1px;}       
.votev_rating_text {width:100px;height:16px;background-color:white;float:left;border:none;color:#000000;font-size:9px;padding-top:2px;}  
.votev_rating_redactors {width:48px;height:16px; background-color:white;float:left; 
    border:none;text-align:center; color:#FF0000; font-weight:bold;font-size:14px;} 
.votev_rating_users {width:48px;height:16px; background-color:white;float:left; 
    border:none;text-align:center; color:#00baff; font-weight:bold;font-size:14px;}
.votev_rating_expect {width:48px;height:16px; background-color:white;float:left; 
    border:none;text-align:center; color:#00FF00; font-weight:bold;font-size:14px;}    
</style>-->


<?$pageController->warstwaB(); ?>