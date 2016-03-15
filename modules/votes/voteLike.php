<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

 require_once 'core/sql.php';
 require_once 'functions.php';
 
 
     $modVotes->likeOrNotLike(array('what'=>$_GET['what'],'what_id'=>$_GET['what_id']));

echo $modVotes->getVotesCounter(array('what'=>$_GET['what'],'what_id'=>$_GET['what_id'],'vote'=>1));
?>
