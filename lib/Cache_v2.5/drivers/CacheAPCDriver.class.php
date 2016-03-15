<?php
/**
 * Sterownik dla klasy Cache operujący na pamięci przy wykorzystaniu modułu APC.
 * 
 * @package MCM
 * @subpackage independent
 * @author Robert (nospor) Nodzewski (email: nospor at gmail dot com)
 * @copyright 2008 Robert Nodzewski
 * @version 2.5
 * @access public
 */
class CacheAPCDriver implements iCacheIO {

	private $prefix;
	private $timeSufix = '_time';
	private $errorLevel;
	
	/**
	 * Przedrostek jaki będzie dodawany do nazw grup i obiektów. 
	 *
	 * @param string $prefix
	 */
	public function __construct($prefix = '') {
		if (!function_exists('apc_add'))
			throw new CacheException('Install APC module before You start using this driver !');
		
		$this->prefix = $prefix;
	}
	
	
	/**
	 * Wkładanie obiektu do cache
	 *
	 * @param string $objectId
	 * @param mixed $objectValue
	 * @param mixed $groups
	 * @param bool $checkSum - suma kontrolna w tym sterownika zawsze będzie pomijana, niezależnie od wartości tego parametru
	 * @return bool
	 */
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
		
		$controlSum = '';
		if ($checkSum)
			$controlSum = md5($objectValueS);
		$nObjectId = $this->prefix.$objectId;
		
		$this->Delete($objectId);
		if (!apc_add($nObjectId, $sep.$controlSum.$objectValueS) || !apc_add($nObjectId.$this->timeSufix, time()))
			return false;
		//stworzenie/zaktualizowanie plików z grupami
		foreach ($groups as $_groupName){
			$_nGroupName = $this->prefix.'@'.$_groupName;
			$_objectsId = apc_fetch($_nGroupName);
			if ($_objectsId && is_array($_objectsId)){
				$_isInGroup = false;
				foreach ($_objectsId as $_ind => $_objectId){
					$_objectsId[$_ind] = $_objectId;
					if ($_objectId == $objectId)
						$_isInGroup = true;
				}
				if (!$_isInGroup)
					$_objectsId[] = $objectId;
			}
			if (!$_objectsId)
				$_objectsId = array($objectId);
			apc_delete($_nGroupName);		
			if (!apc_add($_nGroupName,$_objectsId)){
				$this->Delete($objectId);
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Pobiera obiekt z cache
	 *
	 * @param string $objectId
	 * @param bool $checkSum - suma kontrolna będzie zawsze ignorowana
	 * @return mixed
	 */
	public function Get($objectId, $checkSum){
		$objectValue = apc_fetch($this->prefix.$objectId);
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
		return apc_fetch($this->prefix.$name.$this->timeSufix);
	}

	public function Exists($name){
		return apc_fetch($this->prefix.$name.$this->timeSufix) ? true : false;
	}

	public function Delete($name,$isGroup = false){
		if (!$isGroup){
			$nName = $this->prefix.$name;
			return (apc_delete($nName) && apc_delete($nName.$this->timeSufix));
		} else {
			$nName = $this->prefix.'@'.$name;
			return apc_delete($nName);
		}
	}

	public function ClearAll(){
		return apc_clear_cache('user');
	}
	
	public function ClearGroup($name){
		$_objectsId = apc_fetch($this->prefix.'@'.$name);
		$er = false;
		if (is_array($_objectsId)){
			foreach ($_objectsId as $_objectId){
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