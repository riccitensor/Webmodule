<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public $privilage = array(10,1,-1);

    public function index(){
        $this->pageController->admin->warstwaA();?>
            <table class="karta">
            <tr><td> <h1> LINKS </h1></td></tr>  
            <tr><td colspan="99"><hr/></td></tr>
            <tr><td> <b> SEO / SEM </b></td></tr>
            <tr><td>  <a href="https://mail.google.com">Google Mail</a>  </td></tr>
            <tr><td>  <a href="http://www.google.com/analytics/">Google Analytics</a>  </td></tr>
            <tr><td>  <a href="http://www.google.com/adsense/">Google Adsense</a> </td></tr>
            <tr><td>  <a href="https://www.google.com/webmasters/tools/home?hl=pl">Google WebmasterTools</a> </td></tr>
            <tr><td>  <a href="https://www.adwords.google.com">Google Adwords</a> </td></tr>
            <tr><td>  <a href="http://www.google.com/websiteoptimizer">Google Website Optimizer</a> </td></tr>
            <tr><td>  <a href="http://www.backlinkwatch.com/#">www.backlinkwatch.com</a> </td>                                  <td>(Backlinki)</td></tr>
            <tr><td>  <a href="http://www.backlinkcheck.com/">www.backlinkcheck.com</a> </td>                                   <td>(Backlinki)</td></tr>
            <tr><td>  <a href="http://www.pageranktester.pl/sprawdz-pagerank.html">www.pageranktester.pl</a> </td>              <td>(PageRank)</td></tr>
            <tr><td>  <a href="http://www.ninjacloak.com/">www.ninjacloak.com</a> </td>                                         <td>(Proxy)</td></tr>
            <tr><td>  <a href="http://www.seocentro.com/tools/search-engines/metatag-analyzer.html">www.seocentro.com</a> </td> <td>(Metatag Analyzer)</td></tr>
            <tr><td>  <a href="https://addons.mozilla.org/en-US/firefox/addon/13927/">SEO Toolbar 1.2.4</a> </td>              <td>(FireFox Plugin)</td></tr>
            <tr><td>  <a href="http://www.feedthebot.com/tools/">www.feedthebot.com/tools</a> </td>              <td>sprawdzanie SEO</td></tr>
            <tr><td colspan="99"><hr/></td></tr>
            <tr><td> <b> WEBMASTER </b></td></tr>
            <tr><td>  <a href="https://addons.mozilla.org/en-US/firefox/addon/60/">Web Developer 1.1.8</a>  </td>               <td>(FireFox Plugin)<td></tr>
            <tr><td>  <a href="https://addons.mozilla.org/en-US/firefox/addon/1843/">Firebug 1.6.0</a>  </td>               <td>(FireFox Plugin)<td></tr>
            <tr><td>  <a href="http://www.ip-adress.com/whois/">www.ip-adress.com</a> </td>              <td>IP check<td></tr>
            <tr><td>  <a href="https://addons.mozilla.org/pl/firefox/addon/flagfox/">FlagFox</a> </td>              <td>IP check<td></tr>
            <tr><td>  <a href="http://openiconlibrary.sourceforge.net/">Free Icons</a> </td>              <td></td></tr>
            <tr><td colspan="99"><hr/></td></tr>
            <tr><td> <b> PAYMENTS </b></td></tr>
            <tr><td>  <a href="http://www.dotpay.pl/">www.dotpay.pl</a>  </td>
            <tr><td>  <a href="http://www.cashbill.eu/">www.cashbill.eu</a>  </td>
            <tr><td>  <a href="http://www.paypal.com/">www.paypal.com</a>  </td>
            </table>
        <?$this->pageController->admin->warstwaB();
    }

}

$operations = new operations("");

?>