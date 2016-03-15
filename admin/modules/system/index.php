<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public function index(){
        $this->pageController->admin->warstwaA();
            ob_start();
            phpinfo();
            $contents = ob_get_clean();
            $info = array('phpinfo' => array());
            if(preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', $contents, $matches, PREG_SET_ORDER)){
              foreach($matches as $match) {
                    if(strlen($match[1])) $info[$match[1]] = array();
                    elseif(isset($match[3])) $info[end(array_keys($info))][$match[2]] = isset($match[4]) ? array($match[3], $match[4]) : $match[3];
                    else $info[end(array_keys($info))][] = $match[2];
                 }
            }
            $phpcore = (array_key_exists('PHP Core', $info)) ? 'PHP Core' : 'Core';
        ?>
        <div id="area">
        <table class="lista">
        <tr><td colspan="3" style="background-color: #FF0000; color: white; font-size: 9px; text-align: center; width: 400px;">$_SERVER[]<td></tr>
        <? foreach ($_SERVER as $key => $value) {?> <tr><td><?=$key?></td><td><?=$value?></td></tr><? } ?>
        <tr><td colspan="3" style="height: 20px;"><td></tr>
        <tr><td colspan="3" style="background-color: #01bffd; color: white; font-size: 9px; text-align: center;">$_ENV[]<td></tr>
        <? foreach ($_ENV as $key => $value) {?> <tr><td><?=$key?></td><td><?=$value?></td></tr><? } ?>
        <tr><td colspan="3" style="height: 20px;"><td></tr>
        <tr><td colspan="3" style="background-color: #ff00ff; color: white; font-size: 9px; text-align: center;">phpinfo();<td></tr>
        <tr>       <td>System:</td>                        <td><?=$info['phpinfo']['System']?></td></tr>
        <tr>        <td>Safe Mode:</td>                         <td><?=$info[$phpcore]['safe_mode'][0]?></td></tr>
        <tr>        <td>Allow URL fopen:</td>                   <td><?=$info[$phpcore]['allow_url_fopen'][0]?></td></tr>
        <tr>        <td>Curl Support:</td>                      <td><?=$info['curl']['cURL support']?></td></tr>
        <tr>        <td>Display Errors:</td>            <td><?=$info[$phpcore]['display_errors'][0]?></td></tr>
        <tr>        <td>Display Startup Errors:</td>    <td><?=$info[$phpcore]['display_startup_errors'][0]?></td></tr>
        <tr>        <td>File Uploads:</td>              <td><?=$info[$phpcore]['file_uploads'][0]?></td></tr>
        <tr>         <td>File Post Size :</td>           <td><?=$info[$phpcore]['post_max_size'][0]?></td></tr>
        <tr>       <td>Max File Size Upload:</td>      <td><?=$info[$phpcore]['upload_max_filesize'][0]?></td></tr>
        <tr>       <td>GD Library:</td>                        <td><?=$info['gd']['GD Support']?></td></tr>
        <tr>       <td>GD Library Version:</td>                <td><?=$info['gd']['GD Version']?></td></tr>
        <tr>       <td>GIF Read Support:</td>                  <td><?=$info['gd']['GIF Read Support']?></td></tr>
        <tr>        <td>GIF Create Support:</td>                <td><?=$info['gd']['GIF Create Support']?></td></tr>
        <tr>        <td>JPEG Support:</td>                      <td><?=$info['gd']['JPEG Support']?></td></tr>
        <tr>        <td>PNG Support:</td>                       <td><?=$info['gd']['PNG Support']?></td></tr>
        <tr>        <td>Session Support:</td>                   <td><?=$info['session']['Session Support']?></td></tr>
        <tr>        <td>Session Save Path:</td>                 <td><?=$info['session']['session.save_path'][0]?></td></tr>
        <tr>        <td>Apache mod_rewrite:</td>                <td><?=(strstr($info['apache2handler']['Loaded Modules'],'mod_rewrite')) ? "enabled" : "disabled";?></td></tr>
        <tr>        <td>Apache mod_cgi:</td>                    <td><?=(strstr($info['apache2handler']['Loaded Modules'],'mod_cgi')) ? "enabled" : "disabled";?></td></tr>
        </table>
        </div>
        <?$this->pageController->admin->warstwaB();
    }

}

$operations = new operations("");

?>


<!--$_SERVER jest tablicą zawierającą informacje takie jak nagłówki, ścieżki, lokalne skrypty .

Wpisy w tej tablicy są tworzone przez serwer WWW.
Nie daje gwarancji że takżdy serwer www  będzie zapewniał wszystkie informacje, serwery mogą zostać pominięte,  lub zapewnić inne informacje nie wymienione tutaj.
$HTTP_SERVER_VARS zawiera te same informacje ale nie jest super globalna.
Wykaz zmiennych
PHP_SELF - Plik w którym aktualnie wykonywany jest skrypt
'argv' - Tablica argumentów przekazanych do skryptu.
'argc' - Zawiera liczbę parametrów  przekazywane do skryptu poprzez wiersz poleceń (jeśli uruchomiony został z linii poleceń).
'GATEWAY_INTERFACE' - Jakie zmiany w specyfikacji CGI zostały użyte na serwerze np: 'GI/1.1'.
'SERVER_ADDR' - Zwraca adres IP z którego został odpalony skrypt
'SERVER_NAME' - Zwraca nazwę HOSTA serwera
'SERVER_SOFTWARE' - Serwer indentyfikuje ciąg podany w nagłówkach kiedy odpowiada na żądanie
'SERVER_PROTOCOL' - Nazwa i informacje o zmianach protokołu za pośrednictwem której strona została wezwana np 'HTTP/1.0';
'REQUEST_METHOD' - Które żądanie zostało użyte na tej stronie: np  'GET', 'HEAD', 'POST',
'PUT'.'REQUEST_TIME' - Czas na początku żądania
'QUERY_STRING' - ciąg zapytania, jeśli istnieje 
'DOCUMENT_ROOT'  - Główny dokument (katalog) pod którym skrypt został odpalony
'HTTP_ACCEPT' - Zawiera akceptacje nagłówka z bieżącego żądania, jeśli jest.
'HTTP_ACCEPT_CHARSET' - Zawiera akceptowane kodowania tekstu nagłowków z bieżącego żądania np:  'iso-8859-1,*,utf-8'.
'HTTP_ACCEPT_ENCODING' - Zawiera akceptowane kodowania nagłówka z bieżącego zapytania np 'gzip'.
'HTTP_ACCEPT_LANGUAGE' - Zariera Akceptowane języki nagłówków np: 'en'.
'HTTP_CONNECTION' - Zawiera połączenia nagłowków np 'Keep-Alive'.
'HTTP_HOST' - Zawiera Hosta nagłówka
'HTTP_REFERER' - zawiera adres url z jakiego nastąpiło przekierowanie
'HTTP_USER_AGENT' - Zawiera info o przeglądarce
'HTTPS' - Ustaw bez pustych wartości jeśli skrypt był zapytany przez HTTPS protokół
'REMOTE_ADDR' - Adres IP z którego użytkownik wyświetlił bieżącą stronę
'REMOTE_HOST' - Nazwa hosta z którego użytkownik odwiedził nasza stronę.
'REMOTE_PORT' - Port użyty przez maszyne użytkownika do kominikacji z serwerem www
'SCRIPT_FILENAME' - Bezwzględna nazwa ścieżki aktulanie wykonywanego skryptu
'SERVER_PORT' - Port maszyny serwera użyty do momunikacji z serwerem www.Domyślnie port 80
'SERVER_SIGNATURE' - Ciąg połącznienia wersji serwera i nazwa wirtulaneg hosta które są dodane do serwera generującego srony, jeśli włączony
'PATH_TRANSLATED' - Pliki systemowe, podstawowa ścieżka bieżącego skryptu
'SCRIPT_NAME' - Zawiera bieżącą ścieżke skryptu.
'REQUEST_URI' - URI które zostało wydane w celu uzyskania dostępu do tej strony np: '/index.html'.
'PHP_AUTH_DIGEST' - Podczas uruchamiania pod Apache jako moduł Digest HTTP autoryzacja tej zmiennej jest ustawiona w nagłówku Autozization wysyłanym przez klienta
'PHP_AUTH_USER' - Podczas uruchamiania APACHE lub IIS jako moduł HTTP autoryzacja tej zmiennej jest ustawiana przez username (nazwa użytkownika) dostarczone przez użytkownika
'PHP_AUTH_PW' -Podczas uruchamiania APACHE lub IIS jako moduł HTTP autoryzacja tej zmiennej jest ustawiana przez password(hasło)  dostarczone przez użytkownika
'AUTH_TYPE' - Podczas uruchamiania APACHE jako moduł HTTP autoryzacja tej zmiennej jest ustawiana przez typ autorycacji.-->