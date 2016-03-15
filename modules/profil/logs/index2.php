<? require_once $_SERVER[DOCUMENT_ROOT].'/engine/core/pageController.php';
require_once $_SERVER[DOCUMENT_ROOT].'/engine/profil/function.php'; 
require_once $_SERVER[DOCUMENT_ROOT].'/engine/profil/lang/lang.php'; 

$pageController->ilogged();

require_once 'core/funkcje.php';
$file = file_load($_SERVER[DOCUMENT_ROOT].'/temp/log/'.$_SESSION[S_ID]);

$profilController->warstwaA(); ?>
<table style="margin-left: 50px; margin-top: 15px;"><thead><tr><th><h1>Logins in the site</h1></th></tr></thead>


    <tbody><tr><td><?=nl2br($file)?></td></tr></tbody>
</table>

<? $profilController->warstwaB(); ?>
