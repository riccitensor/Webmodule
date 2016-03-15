<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'core/funkcje.php';
   
$files = $funkcje->getFiles("$_SERVER[DOCUMENT_ROOT]/temp/resources/{$pageController->variables->project_name}/gallery/$id/mini/"); 

if ($files!='')
foreach ($files as $file) {?>       
    <div class="admin_gallery">
        <div class="admin_gallery_img">
            <a href='<?="/temp/resources/{$pageController->variables->project_name}/gallery/$id/full/$file"?>'>
                <img src="<?="/temp/resources/{$pageController->variables->project_name}/gallery/$id/mini/$file"?>"/>
            </a>
        </div>       
    </div>
<?}?>