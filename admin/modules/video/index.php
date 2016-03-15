<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {
    
    var $index_author = false;
    
    public function __construct($params) {
        parent::__construct($params);
        if ($_GET['operation']=='reload'){
            $this->pageController->pr($_POST);
            $this->reload($_POST['id']);
        }        
        if ($_GET['operation']=='addvideoview1'){ $this->addvideoview1(); }
        if ($_GET['operation']=='addvideoview2'){ $this->addvideoview2(); }
        if ($_GET['operation']=='addvideoview3'){ $this->addvideoview3(); }
    }


    public function lista(){
       $params['rs'] = $this->sqlconnector->pagi("SELECT * FROM {$this->tablename} WHERE title REGEXP '$this->search' ORDER BY $this->column $this->order");
       $params['col'] = array(
           array('name' => 'id',                                             'width' => 30,   'sort' => true), 
           array('name' => 'title',              'title' => _ET_TITLE,                        'sort' => true,   'chars'=>200),
           array('name' => 'category',           'title' => _ET_CATEGORY,    'width' => 50,   'sort' => true),
           array('name' => 'time_video',         'title' => _ET_TIME,        'width' => 70,   'sort' => true,   'func'=>'timeg'),
           array('name' => 'time_create',        'title' => _ET_TIME_CREATE, 'width' => 120,  'sort' => true,   'func'=>'time'),
           array('name' => '',                   'title' => _ET_VIEW,        'width' => 16,                     'func'=>'view'),
           array('name' => '',                   'title' => _ET_READ,        'width' => 16,                     'func'=>'read'),
           array('name' => '',                   'title' => _ET_EDIT,        'width' => 16,                     'func'=>'edit'),
           array('name' => '',                   'title' => _ET_DEL,         'width' => 16,                     'func'=>'delete'),
       );       
       $this->widok_list($params);
    }
    
    public function widok_index(){       
       echo "<table>";
       echo "<form action='category/index.php' method='post'><input name='submit' value='Category' type='submit'/></form>";
       echo "<form action='index.php?operation=addvideoview1' method='post'><input name='submit' value='Add 1 Video' type='submit'/></form>";
       echo "<form action='remote_youtube/index2.php' method='post'><input name='submit' value='Remote YouTube' type='submit'/></form>";
       echo "<form action='wrzucator_youtube/index.php' method='post'><input name='submit' value='Wrzucator YouTube' type='submit'/></form>";
       echo "<form action='analizator_v1/index.php' method='post'><input name='submit' value='Analizator YouTube' type='submit'/></form>";
       echo "</table>";
       parent::widok_index();
    }
    
    public function view($id){   
        $this->pageController->admin->warstwaA();
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_video} WHERE id='$id' limit 1");
        echo "<iframe width='560' height='315' src='//www.youtube.com/embed/$rek[hash]' frameborder='0' allowfullscreen></iframe><br/><br/>";
        $this->pageController->admin->warstwaB();
    }    
    
    var $actionA="index.php?operation=update";
    var $actionB="index.php?operation=reload";
    
    public function edit($id){
        $this->pageController->admin->warstwaA();
        $rek = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_video} WHERE id='$id'");
        $this->form($rek,true);   
        $this->pageController->admin->warstwaB();
    }
    
    public function form($params,$reload=false){
        echo "<form id='foremka' action='$this->actionA' method='post'>";
        echo "<table class='karta admin_video_form'>";
        echo "<tr><td>id:</td><td><input disabled='disabled' name='id' type='text' value='$params[id]'/></td></tr>";
        echo "<tr><td>Author:</td><td><input name='author_name' type='text' value='$params[author_name]'/></td></tr>";
        echo "<tr><td>Category:</td><td>";
        echo "<select name='category'>";
            $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_video_category} WHERE id='$params[category]'");
            while($rek = mysql_fetch_array($rs)) {
                echo "<option selected='selected' label='$rek[title]' value='$rek[id]'>$rek[title]</option>";
            }
            $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_video_category}");
            while($rek = mysql_fetch_array($rs)) {
                echo "<option label='$rek[title]' value='$rek[id]'>$rek[title]</option>";
            }
        echo "</select>";
        echo "</td></tr>";
        echo "<tr><td>Title:</td><td><input name='title' type='text' value='$params[title]'/></td></tr>";
        echo "<tr><td>Url:</td><td><a href='http://www.youtube.com/watch?v=$hash'>http://www.youtube.com/watch?v=$params[hash]</a></td></tr>";
        echo "<tr><td>Url:</td><td><a href='/v$id'>$_SERVER[SERVER_ADDR]/v$params[id]</a></td></tr>";
        echo "<tr><td>pagelink:</td><td><input name='pagelink' type='text' value='$params[pagelink]'/></td></tr>";
        echo "<tr><td>Hash:</td><td><input name='hash' type='text' value='$params[hash]'/></td></tr>";
        echo "<tr><td>Time Video:</td><td><input name='time_video' type='text' value='$params[time_video]'/></td></tr>";
        echo "<tr><td>Description:</td><td><input name='description' type='text' value='$params[description]'/></td></tr>";
        echo "<tr><td>keywords:</td><td><input name='keywords' type='text' value='$params[keywords]'/></td></tr>";
        echo "<tr><td>Content:</td><td><textarea cols='' rows='' name='content'>$params[content]</textarea></td></tr>";
        echo "<tr><td><input name='submit' id='add' value='Save' type='submit'/></td><td><img src='http://i.ytimg.com/vi/$params[hash]/1.jpg'/><img src='http://i.ytimg.com/vi/$params[hash]/2.jpg'/><img src='http://i.ytimg.com/vi/$params[hash]/3.jpg'/></td></tr>";
        echo "<input name='id' type='hidden' value='$params[id]'/>";
        echo "</table>";
        echo "</form>";
        
        if ($reload) {
            echo "<form action='$this->actionB&id=$params[id]' method='post'>";
            echo "<table class='karta'>";
            echo "<tr><td><input name='submit' value='Reload YT' type='submit'/></td><td>";
            echo "<input name='link' type='text' value='http://www.youtube.com/watch?v=$params[hash]'/>";
            echo "<input name='author' type='hidden' value='$params[author]'/>";
            echo "<input name='category' type='hidden' value='$params[category]'/>";
            echo "<input name='id' type='hidden' value='$params[id]'/>";
            echo "</td></tr>";
            echo "</table>";
            echo "</form>";
        }
    }
    
    public function reload($id){
        echo "id=$id";
        $this->pageController->admin->warstwaA("10");
        require_once 'admin/modules/video/yt_parser.php';
        require_once 'core/sql.php';
        $params = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_video} WHERE id='$id'");
        $video = new website("http://www.youtube.com/watch?v=$params[hash]");
        $params['description'] = $video->description();
        $params['keywords'] = $video->keywords();
        $params['title'] = $video->title();
        $params['content'] = $video->content();
        $params['hash'] = $video->hash();
        $params['time_video'] = $video->getTimeVideo($params['hash']);
        $params['url'] = $video->url();
        $params['pagelink'] = $video->onlyaz09($title);
        $this->actionA="index.php?operation=update&id=$id";
        $this->form($params,true);
        $this->pageController->admin->warstwaB();
    }    
    
    public function addvideoview1(){
        $this->pageController->admin->warstwaA("10");
        echo "<form id='foremka' action='index.php?operation=addvideoview2' method='POST'>";
        echo "<table class='karta'>";
        echo "<tr><td width='150' height='40'><h1>ADD 1 VIDEO</h1></td><td></td></tr>";
        echo "<tr><td>Link YT:</td><td><input name='link' type='text' value=''/></td></tr>";
        echo "<tr><td>Example:</td><td>http://www.youtube.com/watch?v=ci0ccJ_Z7jM</td></tr>";
        echo "</table>";
        echo "</form>";
        echo "<div class='karta_button'>";
        echo "<input onclick='formSubmit()' value='Dodaj' type='submit'/>";
        echo "<form style='float: right;' action='/engine/admin/video/' method=POST><input value='back' type='submit'/></form>";
        echo "</div>";        
        $this->pageController->admin->warstwaB();
    }
    
    public function addvideoview2(){
        $this->pageController->admin->warstwaA("10");
        require_once 'admin/modules/video/yt_parser.php';
        $video = new website($_POST[link]);
        $params['description'] = $video->description();
        $params['keywords'] = $video->keywords();
        $params['title'] = $video->title();
        $params['content'] = $video->content();
        $params['hash'] = $video->hash();
        $params['url'] = $video->url();
        $params['pagelink'] = $video->onlyaz09($title);
        $this->actionA="index.php?operation=addvideoview3";
        //$actionB="/engine/admin/video/yt_reload.php";
        $this->form($params);
        $this->pageController->admin->warstwaB(); 
    }
    
    public function addvideoview3(){ 
        $this->pageController->admin->warstwaA();
        $_POST['author_name']= strip_tags($_POST['author_name']);
        $_POST['title'] = strip_tags($_POST['title']);
        $_POST['pagelink'] = strip_tags($_POST['pagelink']);
        $_POST['description'] = strip_tags($_POST['description']);
        $_POST['content'] = strip_tags($_POST['content']);
        $_POST['category'] = strip_tags($_POST['category']); $_POST['category'] += 0;
        $_POST['hash'] = strip_tags($_POST['hash']);
        $rs = $this->sqlconnector->query("SELECT * FROM {$this->pageController->variables->base_video} WHERE hash='$_POST[hash]'");
        while($rek = mysql_fetch_array($rs)) {
            $jest=1;
        } 
        if ($jest>0) {
            $this->pageController->pr("url exist!");
        } else {
           $video_id = $this->sqlconnector->insert("INSERT INTO {$this->pageController->variables->base_video} SET
            author_name='$_POST[author_name]',
            title='$_POST[title]',
            keywords='$_POST[keywords]',
            pagelink='$_POST[pagelink]',
            description='$_POST[description]',
            content=\"$_POST[content]\",
            serwer='1',
            time_create='".time()."',
            category='$_POST[category]',
            hash='$_POST[hash]'");    
            $this->pageController->pr("url inserted\nlink site: <a href='/v$video_id'>video</a>\nlink admin: <a href='/engine/admin/modules/video/index.php?operation=view&name=$video_id'>video</a>");
        }
        $this->pageController->admin->warstwaB();
    }

}


$operations = new operations("{$pageController->variables->base_video}");

?>