<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/sql.php';
   require_once 'core/filter.php';   
   
class modForum extends constructClass {
    public $filter;//class referenece
    public $error;
    public $statement;

    function addForumRow($id,$title,$choice){
        $id = $this->sqlconnector->insert("INSERT INTO {$this->pageController->variables->base_forum_topic} SET
            author_id = '$id',
            title = '$title',
            time_create = '".time()."',
            type = '$choice'");
        return $id; //ID dodanego rekordu
    }

    function addPost($nrwatku,$content){
        // echo "con = $content";
        $this->sqlconnector->query("INSERT INTO {$this->pageController->variables->base_forum_post} SET
        title_id = '$nrwatku',
        author_id = '$_SESSION[S_ID]',
        content = '$content',
        time_create = '".time()."'");
    }

    function updateStatsUserPosts($id){
        $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_members} SET
        post = post+1
        WHERE id = $id;
        ");
    }

    function updateStatsForumPosts($id){
        $this->sqlconnector->query("UPDATE {$this->pageController->variables->base_forum_topic} SET
        time_create = '".time()."',
        counter = counter+1
        WHERE id = $id;
        ");
    }

    function existForumRow($id){
        $rsexist = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_forum_topic} WHERE id = '$id'");
        while ($row = mysql_fetch_array($rsexist)) {
            return true;
        }
        return false;
    }

    function delete_cache($id,$strona){    
        unlink("$_SERVER[DOCUMENT_ROOT]/temp/cache-files/forum-commentary/$id/$strona");
    }
    
    
    
    public function getTopicTyp($nr){
        if ($nr==0) { return "N/A"; } else
        if ($nr==1) { return "ideas"; } else
        if ($nr==2) { return "offtopic"; } else
        if ($nr==3) { return "bugs"; } else
        if ($nr==4) { return "coments"; } else
        if ($nr==5) { return "software"; } else
        if ($nr==6) { return "hardware"; } else
        if ($nr==7) { return "Admin"; } else
        if ($nr==8) { return "news"; } else
        if ($nr==9) { return "video"; }
    }

    public function check_topic($text){
        $wzorzec ='{([^a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9\-\ \.\:\^\(\)])}';
        $zamiana ='';
        $text = preg_replace($wzorzec, $zamiana, $text);
        $text = trim($text);
        if ($text=="" || $text==null){
            return "topic is empty";
        } else {
            return "";
        }
    }

    public function check_topic_full($text){
        $text = strip_tags($text);
        if ($text=="" || $text==null) {return "topic is empty";} else
        if(!eregi("^[A-Za-z0-9][A-Za-z0-9_ ]+$", $text))     { return "Title only A-Z a-z 0-9 or _ and space (but first letter)"; } else
        if(!eregi("^[A-Za-z0-9][A-Za-z0-9_ ]{3,}$", $text))  { return "is too short min 4 charakters"; } else
        if(!eregi("^[A-Za-z0-9][A-Za-z0-9_ ]{3,80}$", $text)) { return "is too long max 80 charakters"; } else
        if(eregi("^[A-Za-z0-9][A-Za-z0-9_ ]+$", $text))
            return "";
        else
            return "name of topic is incorrect A-Z a-z 0-9 non space";
    }

    public function check_content($val,$min=3){
        if ($val!='') {$this->is_empty=0;}
        $temp = $this->filter->string($val,$min);
        if ($temp>0){
            $this->statement['content'] = $this->komunikaty['content']["$temp"];
            $this->error=1;
        }
        $this->content=$val;
    }
    
    public function check_choice($val=0){
        //echo "val = '$val'";
        if (($val=='') or ($val==0)) {            
            $this->statement['choice'] = $this->komunikaty['choice']["1"];
        } else {
            $this->is_empty=0;
        }
        $this->choice=$val;
    }

}

global $modForum; $modForum = new modForum();

?>