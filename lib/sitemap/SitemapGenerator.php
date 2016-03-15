<?php
//-----------------------------------------------------------------------------
/**
 * Klasa generująca mapę strony.
 *
 */
class SitemapGenerator {
    /**
     * Tablica linków.
     * @var array of SGLink
     */
    private $link;

    /**
     * Konstruktor domyślny.
     */
    public function __construct() {
        $this->clear_link();
    }

    /**
     * Dodaje link. Przekazać poszczególne parametry, albo obiekt SGLink jako
     * pierwszy parametr.
     * @param string|SGLink $loc
     * @param string $lastmod
     * @param string $changefreq
     * @param string $priority
     * @return SitemapGenerator
     */
    public function add_link($loc, $lastmod=NULL, $changefreq=NULL, $priority=NULL) {
        $this->link[] = ($loc instanceof SGLink)
            ? $loc
            : new SGLink($loc, $lastmod, $changefreq, $priority)
        ;
        return $this;
    }

    /**
     * Czyści link.
     * @return SitemapGenerator
     */
    public function clear_link() {
        $this->link = array();
        return $this;
    }

    /**
     * Zwraca link.
     * @return array of SGLink 
     */
    public function get_link() {
        return $this->link;
    }

    /**
     * Zwraca ostatni element link.
     * @return SGLink
     */
    public function get_last_link() {
        return end($this->link);
    }

    /**
     * Generuje treść z headerem, albo zwraca string.
     * @param bool $naglowek
     * @return void|string
     */
    public function generate($naglowek = FALSE) {
        $domdoc = new DOMDocument('1.0', 'UTF-8');
        $domdoc->formatOutput = TRUE;

        $node_urlset = $domdoc->appendChild($domdoc->createElement('urlset'));
 		$node_urlset ->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach($this->get_link() AS $link) {
            $node_url = $node_urlset->appendChild($domdoc->createElement('url'));
            $link->generate_link($node_url, $domdoc);
        }
        if ($naglowek) {
            header('Content-type: application/xml; charset=utf-8');
            echo $domdoc->saveXML();
        } else {
            return $domdoc->saveXML();
        }
    }
}
//-----------------------------------------------------------------------------
/**
 * Klasa reprezentująca link.
 *
 */
class SGLink {
    /**
     * Adres URL strony.
     * Ten adres URL musi zaczynać się od prefiksu protokołu (na przykład http) i
     * kończyć kreską ułamkową, jeśli wymaga jej Twój serwer internetowy.
     * Ta wartość musi być krótsza niż 2048 znaków.
     * @var string
     */
    private $loc;

    /**
     * Data ostatniej modyfikacji pliku.
     * Ta data powinna mieć format  W3C Datetime.
     * Format ten umożliwia pominięcie godziny i podanie samej daty w postaci RRRR-MM-DD.
     * Należy pamiętać, że ten tag jest niezależny od nagłówka If-Modified-Since (304),
     * który może zwracać serwer, a wyszukiwarki mogą używać informacji z tych dwóch
     * źródeł w odmienny sposób.
     * @var string
     */
    private $lastmod;

    /**
     * Częstotliwość zmian strony.
     * Ta wartość podaje wyszukiwarkom ogólne informacje i nie może dokładnie korelować
     * częstotliwości indeksowania strony. Prawidłowe wartości to:
     * always hourly daily weekly monthly yearly never
     * @var string
     */

    private $changefreq;

    /**
     * Priorytet tego adresu URL w odniesieniu do innych adresów URL w witrynie.
     * Prawidłowy jest zakres wartości od 0.0 do 1.0. Ta wartość nie ma wpływu na
     * porównywanie Twoich stron ze stronami innych witryn. Umożliwia ona jedynie
     * wskazanie wyszukiwarkom, które strony powinny być indeksowane przez roboty w
     * pierwszej kolejności. Domyślny priorytet strony jest równy 0.5.
     * @var string
     */
    private $priority;

    /**
     * Konstruktor.
     *
     * @param string $loc
     * @param string $lastmod
     * @param string $changefreq - always|hourly|daily|weekly|monthly|yearly|never
     * @param string $priority
     */
    public function __construct($loc, $lastmod=NULL, $changefreq=NULL, $priority=NULL) {
        $this->set_loc($loc)
            ->set_lastmod($lastmod)
            ->set_changefreq($changefreq)
            ->set_priority($priority)
        ;
    }

    /**
     * Ustawia loc.
     * @param string $loc
     * @return SGLink
     */
    public function set_loc($loc) {
        $this->loc = strip_tags((string) $loc);
        return $this;
    }

    /**
     * Ustawia lastmod.
     * @param string $lastmod - date
     * @return SGLink
     */
    public function set_lastmod($lastmod) {
        $this->lastmod = strip_tags((string) $lastmod);
        return $this;
    }

    /**
     * Ustawia changefreq.
     * @param string $changefreq - always|hourly|daily|weekly|monthly|yearly|never
     * @return SGLink
     */
    public function set_changefreq($changefreq) {
        $this->changefreq = NULL;
        if ($changefreq == 'always' OR $changefreq == 'hourly' OR $changefreq == 'daily' OR
            $changefreq == 'weekly' OR $changefreq == 'monthly' OR $changefreq == 'yearly' OR
            $changefreq == 'never')
        {
            $this->changefreq = $changefreq;
        }
        return $this;
    }

    /**
     * Ustawia priority.
     * @param string $priority
     * @return SGLink
     */
    public function set_priority($priority) {
        $this->priority = strip_tags((string) $priority);
        return $this;
    }

    /**
     * Zwraca loc.
     * @return string
     */
    public function get_loc() {
        return htmlentities($this->loc, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Zwraca lastmod.
     * @return string
     */
    public function get_lastmod() {
        return date('Y-m-d', strtotime($this->lastmod));
    }

    /**
     * Zwraca changefreq.
     * @return string
     */
    public function get_changefreq() {
        return $this->changefreq;
    }

    /**
     * Zwraca priority.
     * @return string
     */
    public function get_priority() {
        return $this->priority;
    }

    /**
     * Generuje DOM link
     * @param DOMNode $node
     * @param DOMDocument $domdoc
     * @return SGLink
     */
    public function generate_link(&$node, &$domdoc) {
        if ($this->loc) {
            $node->appendChild($domdoc->createElement('loc', $this->get_loc()));
            if ($this->lastmod) {
                $node->appendChild($domdoc->createElement('lastmod', $this->get_lastmod()));
            }
            if ($this->changefreq) {
                $node->appendChild($domdoc->createElement('changefreq', $this->get_changefreq()));
            }
            if ($this->priority) {
                $node->appendChild($domdoc->createElement('priority', $this->get_priority()));
            }
        }
        return $this;
    }
}
//-----------------------------------------------------------------------------
?>
