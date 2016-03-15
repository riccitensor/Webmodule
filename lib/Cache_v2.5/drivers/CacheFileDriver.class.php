<?php
/**
 * Sterownik dla klasy Cache operujący na plikach.
 * 
 * @package MCM
 * @subpackage independent
 * @author Robert (nospor) Nodzewski (email: nospor at interia dot pl)
 * @copyright 2006-2010 Robert Nodzewski
 * @version 2.5.2
 * @access public
 */
class CacheFileDriver implements iCacheIO {

	/** Ścieżka, gdzie mają być tworzone obiekty cache'u*/
	private $mainPath;
	
	private $errorLevel;

	/** Rozszerzenie plików cache'a */
	private $ext = '.cache';
	
	public $ChmodFile = 0664;
	public $ChmodDir = 0774;
	
	private $errorMsg = array(
		'create_file' => 'Can\'t create file/catalog: %s',
		'parameter_type' => 'Wrong parameter "%s" type in method "%s". Type must be: %s',
		'serialize' => 'Can\'t %sserialize "%s"',
	);
	
	public function __construct($dir, $chmodFile = 0664, $chmodDir = 0774) {
		$this->ChmodFile = $chmodFile;
		$this->ChmodDir = $chmodDir;
		if (!is_string($dir))
			throw new CacheException(sprintf($this->errorMsg['parameter_type'], 'dir', __FUNCTION__, 'string'));
		$dir = trim($dir);
		if ($dir !== '' && !file_exists($dir)){
			$old = umask(0);
			if (mkdir($dir) === false){
				umask($old);
				throw new CacheException(sprintf($this->errorMsg['create_file'], $dir));
			}	
			chmod($dir, $this->ChmodDir);
			umask($old);
		}
		
		if ($dir === '')
			$this->mainPath = './';
		else {
			$_ls = substr($dir, -1);
			$this->mainPath = $dir . (($_ls == '/' || $_ls == '\\') ? '' : '/');
		}
	}
	
	
	public function Put($objectId, &$objectValue, $groups, $checkSum){
		
		//serializacja obiektu jeśli jest tablicą lub obiektem
		$sep = '#';
		if (is_array($objectValue) || is_object($objectValue)){
			$objectValueS = serialize($objectValue);
			if ($objectValue === false || is_null($objectValue))
					return 'Can\'t serialize "'.$objectId.'"';
			$sep = '$';
		} else
			$objectValueS = &$objectValue;
		
		//może się zdarzyć, że katalog drivera zniknie, poprzez wcześniejsze wywołanie ClearAll
		if (!is_dir($this->mainPath)){
			$old = umask(0);
			if (mkdir($this->mainPath) === false){
			} else	
				chmod($this->mainPath, $this->ChmodDir);
			umask($old);
		}
			
		// jesli nazwa obiektu zawiera / znaczy że trzeba potworzyć katalogi
		$this->makeFolders($objectId);		
		 //włożenie obiektu do pliku
		$controlSum = '';
		if ($checkSum)
			$controlSum = md5($objectValueS);
		$_file = $this->mainPath.$objectId.$this->ext;	
		if (!file_put_contents($_file, $sep.$controlSum.$objectValueS))
			return false;
		$old = umask(0);
		chmod($_file, $this->ChmodFile);
		umask($old);
		//stworzenie/zaktualizowanie plików z grupami
		foreach ($groups as $_groupName){
			$_objectsId = null;
			if ($this->Exists($_groupName,true)){
				$_objectsId = file($this->mainPath.$_groupName.'.gr'.$this->ext);
				if ($_objectsId){
					$_isInGroup = false;
					foreach ($_objectsId as $_ind => $_objectId){
						$_objectId = trim($_objectId);
						$_objectsId[$_ind] = $_objectId;
						if ($_objectId == $objectId)
							$_isInGroup = true;
					}
					if (!$_isInGroup)
						$_objectsId[] = $objectId;
				}
			} else
				$this->makeFolders($_groupName);
			if (!$_objectsId)
				$_objectsId = array($objectId);
			$_file = $this->mainPath.$_groupName.'.gr'.$this->ext;	
			if (file_put_contents($_file, implode("\n", $_objectsId)) === false){
				unlink($this->mainPath.$objectId.$this->ext);
				return false;
			}
			$old = umask(0);
			chmod($_file, $this->ChmodFile);
			umask($old);
		}
		return true;
	}
	
	/**
	 * Jeśl w $nazwa występuje "/" znaczy ze takie ma tworzyc katalogi
	 *
	 * @param string $name
	 */
	private function makeFolders($name){
		$names = explode('/',$name);
		$count = count($names);
		$old = umask(0);
		if ($count > 1){
			$path = $this->mainPath;	
			for ($i=0; $i < $count - 1; $i++){
				$path.= $names[$i];
				if (!is_dir($path)){
					mkdir($path);
					chmod($path, $this->ChmodDir);
				}	
				$path.='/';	
			}
		}
		umask($old);
	}

	public function Get($objectId, $checkSum){
		$objectValue = file_get_contents($this->mainPath.$objectId.$this->ext);
		if ($objectValue === false)
			return null;
		$sep = substr($objectValue, 0, 1);
		if ($checkSum) {
			$controlSum = substr($objectValue, 1, 32);
			$objectValue = substr($objectValue, 33);
			if ($controlSum != md5($objectValue)){
				if ($this->errorLevel & Cache::WARNING)
					trigger_error('Object "'.$objectId.'" is invalid', E_USER_WARNING);
				return null;
			}	
		} else
			$objectValue = substr($objectValue, 1);
		if ($sep === '$'){ // jest tablicą
			$objectValue = unserialize($objectValue);
			if ($objectValue === false || is_null($objectValue)){
				if ($this->errorLevel & Cache::WARNING)
					trigger_error(sprintf($this->errorMsg['serialize'],'un', $objectId), E_USER_WARNING);
				return null;
			}	
		}	
		
		return $objectValue;
	}

	public function ModifiedTime($name){
		return filemtime($this->mainPath.$name.$this->ext);
	}

	public function Exists($name, $isGroup = false){
		$grExt = $isGroup ? '.gr' : '';
		return file_exists($this->mainPath.$name.$grExt.$this->ext);
	}

	public function Delete($name,$isGroup = false){
		$grExt = $isGroup ? '.gr' : '';
		return unlink($this->mainPath.$name.$grExt.$this->ext);
	}

	public function ClearAll(){
		return $this->ClearDir($this->mainPath, false, false);
	}
	
	/**
	 * Czyści podany katalog. Gdy ustawimy $useMainPath to do $dirName dodanie zostana ścieżka główna.
	 *
	 * @param string $dirName
	 * @param bool $includeDir gdy to ustawimy, to usunie również ten podany katalog
	 * @param bool $useMainPath
	 * @param int $lifeTime czas zycia katalogu w sekundach
	 * @return bool
	 */
	public function ClearDir($dirName,$includeDir = false, $useMainPath = true, $lifeTime=0){
		if ($useMainPath)
			$dirName = $this->mainPath.$dirName;
		if (!is_dir($dirName))
			return true;
		if ($lifeTime){
			$checkFile = $dirName.'/.check.cache';
			if (!file_exists($checkFile)){ //jesli checkFile nie istnieje to go tworzym i nie czyscimy katalogu
				file_put_contents($checkFile,'');
				return true;
			}	
			else {	
				if (time() - filemtime($checkFile) > $lifeTime)//jesli katalog zyje juz za dlugo to ustawiamy nowy czas i przechodzimy do czyszczenia
					file_put_contents($checkFile,'');
				else	
					return true;
				
			}	
		}
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dirName), RecursiveIteratorIterator::CHILD_FIRST);
		$isError = false;
		foreach ($iterator as $fileInfo) {
			$p = $fileInfo->getPathname();
			if (substr($p,-1) == '.')
				continue;
        	if ($fileInfo->isDir())
        		$res = rmdir($fileInfo->getPathname());
      		else 
      			$res = unlink($fileInfo->getPathname());
      		if (!$res)
      			$isError = true;	
		}
		if ($includeDir && rmdir($dirName) === false)
			$isError = true;
		return !$isError;

			
	}
	public function ClearGroup($name){
		if (!$this->Exists($name,true))
			return true;
			
		$_objectsId = file($this->mainPath.$name.'.gr'.$this->ext);
		$er = false;
		if (is_array($_objectsId)){
			foreach ($_objectsId as $_objectId){
				$_objectId = trim($_objectId);
				if ($this->Exists($_objectId) && $this->Delete($_objectId) === false)
					$er = true;
			}
			if (!$er)
				$this->Delete($name,true);
		} else
			$er = true;
		return !$er;
	}
	
	public function SetErrorLevel($errorLevel){
		$this->errorLevel = $errorLevel;
		return true;
	}
	
}

?>