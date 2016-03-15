<?php

        $vidID="voNEBqRZmBc";
        //http://www.youtube.com/watch?v=voNEBqRZmBc
        $url = "http://gdata.youtube.com/feeds/api/videos/". $vidID;
        $doc = new DOMDocument;
        $doc->load($url);
        $title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
        $duration = $doc->getElementsByTagName('duration')->item(0)->getAttribute('seconds');

        print "TITLE: ".$title."<br />";
        print "Duration: ".$duration ."<br />";
        
        
        echo gmdate("H:i:s", 685);
?>


