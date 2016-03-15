<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/admin/core/adminController.php';

class operations extends _operations {

    public $privilage = array(10,1,-1);

    public function index(){
        $this->pageController->admin->warstwaA();?>
        
        <table class="karta">
        <tr><td> <h1> commands </h1></td></tr>
        <tr><td> ln -s /zrodlo/ /home/cel/  </td></tr>
        <tr><td> ln -s /zrodlo/ /home/cel/  </td></tr>
        <tr><td> chmod 777 /home/tomek -R </td></tr>
        <tr><td> chown slawcio /mnt/hdd_temp/ -R </td></tr>
        <tr><td> chown slawcio /home/ </td></tr>
        <tr><td> find plik* </td></tr>
        <tr><td> find /mnt/ -name plik* </td></tr>
        <tr><td> find * | grep '^[2-3][0-9].jpg$' </td></tr>
        <tr><td> mkfs, fdisk, fsck </td></tr>
        <tr><td> mount -o loop /mnt/source.iso /mnt/iso </td></tr>
        <tr><td> mount -t nfs 192.168.1.1:/mnt/sharedrive /mnt/test </td></tr>
        <tr><td> umount /mnt/iso </td></tr>
        <tr><td> umount -f /mnt/iso (Force) </td></tr>
        <tr><td> df -h (partition space) du (disc space) | du --max-depth=1 -h </td></tr>
        <tr><td> pwd </td></tr>
        <tr><td> !pwd (na FTPie daje full sciezke) </td></tr>
        <tr><td> ssh -D 1080 fdsfds@fdsfds.wfdsfds.com </td></tr>
        <tr><td> tar xvf panda.tar </td></tr>
        <tr><td> unzip -x plik.zip </td></tr>
        <tr><td> zip -r www.zip * </td></tr>
        <tr><td> find /homez.221/gamestia/_resources/demoty/upload_demot_orginal/ -name '*' | grep -E '/[4][0-9]{3}.jpg$' | zip /homez.221/gamestia/_backup/demoty_05k.zip -@ </td></tr>
        <tr><td> find / -mmin -10 //modyfikowany pliki mniej niz 10 min temu </td></tr>
        <tr><td> grep network boot.log //wyszukuje slowo network </td></tr>
        <tr><td> man -k jpg</td><td> szukanie manuala z dana fraza</td></tr>
        <tr><td> apropos jpg</td><td> szukanie manuala z dana fraza lub komendy</td></tr>
        <tr><td> su slawek | su | su - </td></tr>
        <tr><td> which pwd (gdzie jest komenda) </td></tr>
        <tr><td> iwconfig </td></tr>
        <tr><td> ifconfig eth0 192.168.0.1/24 up </td></tr>
        <tr><td> ifconfig eth0 up 209.99.99.155 netmask 255.255.255.248</td></tr>
        <tr><td> route add default gw 209.99.99.155 </td></tr>
        <tr><td> env //zmienne </td></tr>
        <tr><td> export TERM=xterm //ustawienie zmiennej </td></tr>
        <tr><td> free //wolna pamiec </td></tr>
        <tr><td> dd if=/dev/zero of=/swapfile bs=1024 count=262154</td></tr>
        <tr><td> mkswap /swapfile </td></tr>
        <tr><td> swapon /swapfile </td></tr>
        <tr><td> swapoff /swapfile </td></tr>
        <tr><td> dmesg // informacje o komputerze </td></tr>
        <tr><td> /etc/rc.d/rc.local //start systemu </td></tr>
        <tr><td> /etc/crontab </td></tr>
        <tr><td> /var/log/messages </td></tr>
        <tr><td> lpq //info o drukarce </td></tr>
        <tr><td> top //menager procesow </td></tr>
        <tr><td> kill -9 15615 </td></tr>
        <tr><td> tail -f -n 0 /var/log/messages (na biezaco)</td></tr>
        <tr><td> tail /var/log/message //ostatnie linie pliku  </td></tr>
        <tr><td> tail -f /var/log/message //ostatnie linie pliku odświezane na bieząco   </td></tr>
        <tr><td> iostat, mpstat(cpustatystyki ) , netstat, sysstat</td></tr>
        <tr><td> pdf2ps plik.pdf plik.ps </td></tr>
        <tr><td> lpr plik.ps //obowiazkowo format ps do drukowania </td></tr>
        <tr><td> lsof //lista otwartych plikow</td></tr>
        <tr><td> lsof | grep cdrom</td></tr>
        <tr><td> cat /proc/interrupts (IRQ)</td></tr>
        <tr><td> cat /proc/cpuinfo</td></tr>
        <tr><td> md5sum /mnt/plik </td></tr>
        <tr><td> mkbootdisk </td></tr>
        <tr><td> xrandr --addmode DFP1 1680x1050 </td></tr>
        <tr><td> xrandr --output DFP1 --mode 1680x1050 </td></tr>
        <tr><td> time dd if=/dev/zero of=/mnt/d/plik bs=16k count=16384 </td></tr>
        <tr><td> dig www.gamestia.com </td></tr>
        <tr><td> dig 19.239.98.87.in-addr.apra PTR (odwrotnie IP) </td></tr>
        <tr><td> uptime (czas startu systemu) </td></tr>
        <tr><td> /etc/init.d/networking start </td></tr>
        <tr><td> aptitude install meilutils </td></tr>
        <tr><td> aptitude install nmap (skaner portow) </td></tr>
        </table>
        <?$this->pageController->admin->warstwaB();
    }

}

$operations = new operations("");

?>