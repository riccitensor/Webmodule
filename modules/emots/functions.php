<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

class modEmots extends constructClass {    
    
    function emots($text){
        $_POST['text']=$text;
        $text = str_replace (":]", "<img alt='' src='/engine/graphics/emots/emots/krzywy.png'/>",$text);
        $text = str_replace (":-]", "<img alt='' src='/engine/graphics/emots/emots/krzywy.png'/>",$text);
        $text = str_replace (":D", "<img alt='' src='/engine/graphics/emots/emots/zeby.png'/>",$text);
        $text = str_replace (":d", "<img alt='' src='/engine/graphics/emots/emots/zeby.png'/>",$text);
        $text = str_replace (";D", "<img alt='' src='/engine/graphics/emots/emots/zeby.png'/>",$text);
        $text = str_replace (";d", "<img alt='' src='/engine/graphics/emots/emots/zeby.png'/>",$text);
        $text = str_replace (":)", "<img alt='' src='/engine/graphics/emots/emots/wesoly.png'/>",$text);
        $text = str_replace (";)", "<img alt='' src='/engine/graphics/emots/emots/008.png'/>",$text);
        $text = str_replace ("tiaaa", "<img alt='' src='/engine/graphics/emots/emots/010.png'/>",$text);
        $text = str_replace ("[??]", "<img alt='' src='/engine/graphics/emots/emots/001.png'/>",$text);
        $text = str_replace ("[??2]", "<img alt='' src='/engine/graphics/emots/emots/002.png'/>",$text);
        $text = str_replace ("[:/]", "<img alt='' src='/engine/graphics/emots/emots/003.png'/>",$text);
        $text = str_replace ("[:P]", "<img alt='' src='/engine/graphics/emots/emots/004.png'/>",$text);
        $text = str_replace ("[:(]", "<img alt='' src='/engine/graphics/emots/emots/007.png'/>",$text);
        $text = str_replace ("[:(]", "<img alt='' src='/engine/graphics/emots/emots/008.png'/>",$text);
        $text = str_replace ("ooooo", "<img alt='' src='/engine/graphics/emots/emots/009.png'/>",$text);
        return $text;
    }    
    
}

global $modEmots; $modEmots = new modEmots();

?>