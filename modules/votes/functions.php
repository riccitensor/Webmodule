<?

class modVotes extends constructClass {
    
    public $komunikaty;
    
    public function __construct() {
        parent::__construct();
        $this->komunikaty['not_logged'] = 'not logged';
        $this->komunikaty['thanks_for_vote'] = 'thanks for vote';
        $this->komunikaty['you_add_Like'] = 'You add Like';
        $this->komunikaty['you_update_like'] = 'You update Like';
        $this->komunikaty['before_voted'] = 'before voted';
        $this->komunikaty['error_data'] = 'Error data!';
    }
    
    public function likeOrNotLike($params){        
        require_once 'core/sql.php';
        if ($params['what_id']<1) {return $this->komunikaty['error_data'];}
        if ($_SESSION['S_ID']<1) {return $this->komunikaty['not_logged'];}                
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_votes} WHERE
            author_id=$_SESSION[S_ID] and
            what='$params[what]' and
            what_id=$params[what_id] limit 1");
        if ($rek['id']>0){
            $vote = 0; if ($rek['vote']==0){ $vote = 1; }
            $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_votes} SET                   
                vote='$vote', time_modification='".time()."'
               WHERE
                author_id='$_SESSION[S_ID]' and
                what='$params[what]' and
                what_id='$params[what_id]'");
        } else {
            $this->sqlconnector->query("INSERT INTO {$this->pageController->variables->base_votes} SET
                author_id='$_SESSION[S_ID]',
                what='$params[what]',
                what_id='$params[what_id]',    
                vote='1',
                time_create='".time()."'
            ");
        }
    }
    
    

    public function addLike($params){
        require_once 'core/sql.php';
        if ($_SESSION['S_ID']<1) {return $this->komunikaty['not_logged'];}
        $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_votes} WHERE
            author_id=$_SESSION[S_ID] and
            what='$params[what]' and
            what_id=$params[what_id] limit 1");
        
        $exist = 0;
        while($rek = mysql_fetch_array($rs)) {
            $exist = 1;
        }
        if ($exist==0){
            $this->sqlconnector->query("INSERT INTO {$this->pageController->variables->base_votes} SET
                author_id='$_SESSION[S_ID]',
                what='$params[what]',
                what_id='$params[what_id]',    
                vote='$params[vote]',
                time_create='".time()."'
            ");
            return $this->komunikaty['you_add_Like'];
        } else {
            $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_votes} SET                   
                vote='$params[vote]',
                time_modification='".time()."'
               WHERE
                author_id='$_SESSION[S_ID]' and
                what='$params[what]' and
                what_id='$params[what_id]'
            ");
            return $this->komunikaty['you_update_like'];
        }        
    }    
    
    public function addvote($params){
        require_once 'core/sql.php';
        if ($_SESSION['S_ID']<1) {return $this->komunikaty['not_logged'];}
        $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_votes} WHERE
            author_id='$_SESSION[S_ID]' and
            what='$params[what]' and
            what_id='$params[what_id]'");
        
        while($rek = mysql_fetch_array($rs)) {
            return $this->komunikaty['before_voted'];
        }
        
        $this->sqlconnector->query("INSERT INTO {$this->pageController->variables->base_votes} SET
            author_id='$_SESSION[S_ID]',
            what='$params[what]',
            what_id='$params[what_id]',    
            vote='$params[vote]',
            time_create='".time()."'
        ");
        return $this->komunikaty['thanks_for_vote'];
    } 
    
    public function getVotesRating($params){
        $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_votes} WHERE         
          what='$params[what]' and
          what_id='$params[what_id]'");
        $counter = 0;
        $sum = 0;
        while ($rek = mysql_fetch_array($rs)) {
            $sum += $rek[vote];
            $counter++;
        }
        if ($counter!=0) {return ($sum / $counter);} else {return 0;}
    }
    
    public function getVotesCounter($params){
        if (isset($params['vote'])){$vote = " and vote=$params[vote]";}
        
        $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_votes} WHERE         
          what='$params[what]' and
          what_id='$params[what_id]' $vote"); 
        return mysql_num_rows($rs);
    }

    
    public function like($params=array()){?>
        
        
        <script> function votes_like(what,what_id,vote){$("#votes_statements").load("/engine/modules/votes/vote.php?what="+what+"&what_id="+what_id+"&vote="+vote);}</script>
        <div class="votes_like" id="votes_like" onclick="votes_like('<?=$params[what]?>',<?=$params[what_id]?>,1)">    
            <?=$this->getVotesCounter(array('what'=>$params[what],'what_id'=>$params[what_id],'vote'=>1)) ?>   
        </div>
        <div class="votes_dislike" id="votes_dislike" onclick="votes_like('<?=$params[what]?>',<?=$params[what_id]?>,0)">    
            <?=$this->getVotesCounter(array('what'=>$params[what],'what_id'=>$params[what_id],'vote'=>0)) ?>
        </div>
        <div id="votes_statements"></div>
        
        
        <?        
        
    }
    
    public function viewlikeOrNot($params=array()){
        require_once 'core/sql.php';
        ?>
        <script> function votes_like(what,what_id){/*$("#votes_likex").text("My new text!"); */     $("#votes_statements").load("/engine/modules/votes/voteLike.php?what="+what+"&what_id="+what_id+"&vote="+what_id);}</script>
          <div class="form-group">
            <div class="btn-group">
              <div class="btn btn-default btn-sm" id="votes_statements"><?=$this->getVotesCounter(array('what'=>$params[what],'what_id'=>$params[what_id],'vote'=>1)) ?></div>
              <div class="btn btn-default btn-info btn-sm" id="votes_likex" onclick="votes_like('<?=$params[what]?>',<?=$params[what_id]?>)">    
                   Like
              </div>
            </div>
          </div>
        <?
    }
    
    
    
    
    
    
    
    
    
    

    public function css(){?><style>
            .votes_like{
                border: solid 0px blue; height: 16px; overflow: hidden;
                background-image: url('/engine/projects/nauker/graf/like-a.png');
                font-size: 11px; padding: 0px; background-repeat:no-repeat; padding-left: 23px;                
                float: left; color: white;
            }
            .votes_dislike{
                border: solid 0px red; height: 16px; overflow: hidden; margin-left: 5px; margin-right: 15px;
                background-image: url('/engine/projects/nauker/graf/like-b.png');
                font-size: 11px; padding: 0px; background-repeat:no-repeat; padding-left: 23px;                
                float: left; color: white;
            }
            #votes_statements {                
                font-size: 11px; 
            }
        </style><?
    }
    
    
    
    
    
}

global $modVotes; $modVotes = new modVotes();

?>