<?php
/**
 * License
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 **/

/**
 * Klasa do obsługi cache'u. 
 *
 * @package MCM
 * @subpackage independent
 * @author Robert (nospor) Nodzewski (email: nospor at interia dot pl)
 * @copyright 2006-2010 Robert Nodzewski
 * @license http://opensource.org/licenses/lgpl-license.php GNU Lesser General Public License
 * @version 2.5
 * @access public
 **/
class Cache{
	
	/** Debugowanie informacji typu NOTICE */
	const NOTICE = E_NOTICE;
	
	/** Debugowanie informacji typu WARNING */
	const WARNING = E_WARNING;
	
	/** Debugowanie wszystkich informacji  */
	const ALL = E_ALL;

	/** Czy hashować id obiektów*/
	private $hashId;
	
	/** Komunikaty błędów */
	private $errorMsg = array(
		'create_object' => 'Can\'t create object: %s',
		'empty_parameter' => 'Parameter "%s" in method "%s" can\'t be empty',
		'parameter_type' => 'Wrong parameter "%s" type in method "%s". Type must be: %s',
		'condition_file' => 'File "%s", which condition object in cache, does\'t exists',
		'no_group' => 'Group "%s" does\'t exists',
		'no_object' => 'Object "%s" does\'t exists',
		'invalid_id' => 'Invalid %s id "%s". Id can contain only letters, digits and the following characters:_-()[]./',
		'invalid_object' => 'Object "%s" is invalid',
		'd/g_defined' => '%s "%s" already defined',
		'not_defined_d/g' => '%s "%s" is not defined. (For %s)',
		'no_d/g' => 'You must first define %s before call method "%s"',
	);
	
	/** 
	 * Jakiego typu informacje ma wypuszczać klasa. Możliwości:
	 * - NOTICE 
	 * - WARNING
	 * - ALL
	 * - 0 (żadne)
	 * Dozwolone są ich kombinacje binarne.
	*/
	private $errorLevel;
	
	/** Nazwa sterownika domyślnego */
	private $defaultDriver = null;

	/** Tablica sterowników */
	private $drivers = array();

	/** Tablica grup */
	private $groups = array();
	
	/** Czy tworzyć i sprawdzać sumę kontrolną */
	private $checkSum;

	/** 
	 * Ogólny czas życia cache'u. Ta wartość będzie przypisawana obiektom/grupą, 
	 * gdy nie zostanie podana dla nich konkretnie (w sekundach)
	 */
	private $lifeTime;

	/** 
	 * Czy sprawdzać wszystko dokładnie. 
	 * Parametr powinien być ustawiony na true w fazie tworzenia aplikacji. Gdy aplikacja zostanie stworzona
	 * i przetestowana, powinno się wyłączyć ten parametr w celu przyspieszenia działania
	 */
	public $FullChecking = true;
	
	/**
	 * Gdy ustawiony na true, to cache przestaje wkładać i pobierać obiekty.
	 * Może być wykorzystane gdy chcemy w danej chwili wyłączyć cache
	 *
	 * @var boolean
	 */
	public $Disabled = false;
	/**
	 * Konstruktor klasy
	 * 
	 * @param int $lifeTime - ogólny czas życia cache (w sekundach)
	 * @param boolean $hashId - czy hashować id obiektu. Przydatne przy cache'owaniu np. zapytań
	 * @param boolean $checkSum - czy sprawdzać sumę kontrolną.
	 * @param int $errorLevel - poziom debugowania.
	 * @throws CacheException
	 * @access public
	 */
	public function __construct($lifeTime = 3600,$hashId = false, $checkSum = false, $errorLevel = self::ALL) {
		$this->errorLevel = $errorLevel;
		$this->hashId = $hashId;
		$this->checkSum = $checkSum;
		$this->lifeTime = $lifeTime;
	}

	public function SetErrorLevel($errorLevel){
		$this->errorLevel = $errorLevel;
	}
	/**
	 * Dodanie sterownika
	 * 
	 * @param string $name - nazwa sterownika
	 * @param object $driver - sterownik
	 * @param boolean $default czy ma zostać domyślnym sterownikiem. Domyślnie false, ale jeśli nie ma 
	 * jeszcze żadnych dodanych sterowników, to mimo wszystko stanie się domyślnym.
	 * @throws CacheException
	 * @access public
	 * @return boolean
	 */
	public function AddDriver($name, &$driver, $default = false) {
		if (!is_object($driver) || !$driver instanceof iCacheIO)
			throw new CacheException(sprintf($this->errorMsg['parameter_type'], 'driver', __FUNCTION__, 'object of iCacheIO instance'));
		if ($this->FullChecking && isset($this->drivers[$name]) && ($this->errorLevel & self::WARNING))
			trigger_error(sprintf($this->errorMsg['d/g_defined'],'Driver', $name), E_USER_WARNING);
			
		$driver->SetErrorLevel($this->errorLevel);
		if ($default || empty($this->drivers)) {
			$this->defaultDriver = $name;
			$this->groups['default'] = array(
				'driver' => $name,
				'lifetime' => $this->lifeTime,
				'hashid' => $this->hashId,
				'checksum' => $this->checkSum
			);
		}
		$this->drivers[$name] = &$driver;
		return true;
	}
	
	public function GetDriver($name){
		if (isset($this->drivers[$name]))
			return $this->drivers[$name];
		else 
			return null;	
	}
	
	/**
	 * Dodanie grupy.
	 * Grupa zawiera następujące pola:
	 * - driver - sterownik
	 * - lifetime - czas życia (w sekundach).
	 * - file - od jakiego pliku zależy
	 * - filespattern - wzór plików, od których jest zależna grupa
	 * - hashid - czy hashować id
	 * - checksum - czy sprawdzać sumę kontrolną
	 * Pozycje: <b>lifetime</b>, <b>file</b>, <b>filespattern</b> nie powinny występować razem. 
	 * 
	 * @param mixes $names 
	 * - string - nazwa grupy
	 * - array - tablica nazw grup. Przydatne gdy kilka grup ma korzystać z tych samych parametrów
	 * @param array $params - tablica parametrów grupy
	 * @param boolean $default czy ma zostać domyślnym sterownikiem. Domyślnie false, ale jeśli nie ma 
	 * jeszcze żadnych dodanych sterowników, to mimo wszystko stanie się domyślnym.
	 * @throws CacheException
	 * @access public
	 * @return boolean
	 */
	public function AddGroup($names, $params=array(), $checkGroup = true) {
		if (!$this->defaultDriver)
			throw new CacheException(sprintf($this->errorMsg['no_d/g'],'drivers', __FUNCTION__));
		if (is_string($names))
			$names = array($names);
		$_params = array();
		foreach ($params as $_key=>$_value)
			$_params[strtolower($_key)] = $_value;
		if (!isset($_params['driver']))
			$_params['driver'] = $this->defaultDriver;
		elseif (!isset($this->drivers[$_params['driver']]))		
			throw new CacheException(sprintf($this->errorMsg['not_defined_d/g'],'Driver', $_params['driver'], "group '$name'"));
		if (empty($_params['lifetime']) && empty($_params['file']) && empty($_params['filespattern']))
			$_params['lifetime'] = $this->lifeTime;
		if (!isset($_params['hashid']))
			$_params['hashid'] = $this->hashId;
		if (!isset($_params['checksum']))
			$_params['checksum'] = $this->checkSum;
		foreach ($names as $name){
			if ($this->FullChecking && $checkGroup){		
				if (isset($this->groups[$name]) && $name != 'default' && ($this->errorLevel & self::WARNING))
					trigger_error(sprintf($this->errorMsg['d/g_defined'],'Group', $name), E_USER_WARNING);
				if (!preg_match('/^[a-zA-Z0-9_\-\[\]\)\(\/@\.]*$/', $name))
					throw new CacheException(sprintf($this->errorMsg['invalid_id'], 'group', $name));
			}
			$this->groups[$name] = $_params;
		}
		return true;
	}
	
	/**
	 * Sprawdza czy grupa jest już zdefiniowana
	 * 
	 * @param string $name - nazwa grupy
	 * @return boolean
	 */
	public function IsGroup($name){
		return isset($this->groups[$name]);
	}
	
	/**
	 * Wkłada obiekt do cache'u. 
	 *
	 * Do cache'u mogą być wkładane obiekty typu string, int, float, array lub object. Należy jednak pamiętać, ze dane wkładane
	 * jako int lub float będą pobrane z cache'u jako string.
	 * Gdy obiekt jest typu object, klasa obiektu może zawierać metody <b>__sleep</b> oraz <b>__wakeup</b>, które będą wywoływane
	 * odpowiednio przed włożeniem obiektu do cache oraz po pobraniu obiektu z cache. Więcej informacji w manualu: 
	 * {@link http://pl.php.net/manual/pl/language.oop.magic-functions.php}
	 * 
	 * @throws CacheException
	 * @param string $objectId - id objektu
	 * @param mixed $objectValue - wartość objektu. Może to być :
	 * - string
	 * - int
	 * - float
	 * - array
	 * - object
	 * @param mixed $groups - parametr może być typu:
	 * - string - nazwa grupy, do jakiej należy obiekt
	 * - array - tablica nazw grup, do których należy obiekt
	 * @access public
	 * @return boolean
	 */
	public function Put($objectId, &$objectValue, $groups = 'default'){
		if ($this->Disabled)
			return true;
		if (empty($this->groups))
			throw new CacheException(sprintf($this->errorMsg['no_d/g'],'groups', __FUNCTION__));
		
		$objectId = trim($objectId);
		if (!is_string($objectValue) && !is_int($objectValue) && !is_float($objectValue) && !is_array($objectValue) && !is_object($objectValue))
			throw new CacheException(sprintf($this->errorMsg['parameter_type'], 'objectValue', __FUNCTION__, 'string, int, float, array or object'));
		if (!is_string($groups) && !is_array($groups))
			throw new CacheException(sprintf($this->errorMsg['parameter_type'], 'groups', __FUNCTION__, 'string or array'));
		if (is_string($groups)){
			$groups = trim($groups);
			if (empty($groups))
				throw new CacheException(sprintf($this->errorMsg['empty_parameter'], 'groups', __FUNCTION__));
			if (!isset($this->groups[$groups]))
				throw new CacheException(sprintf($this->errorMsg['not_defined_d/g'],'Group', $groups, "object '$objectId'"));
			$params = $this->groups[$groups];	
			$groups = array($groups);
		} else {
			$this->checkGroups($groups, $objectId);
			//Pobranie parametrów pierwszej grupy.
			$params = $this->groups[reset($groups)];
		}
		if ($this->FullChecking && !$params['hashid'] && !preg_match('/^[a-zA-Z0-9_\-\[\]\)\(\/@\.]*$/', $objectId))
			throw new CacheException(sprintf($this->errorMsg['invalid_id'], 'object', $objectId));
		if ($params['hashid'])
			$objectId = md5($objectId);
		$driver = &$this->drivers[$params['driver']];
		
		$res = $driver->Put($objectId, $objectValue, $groups, $params['checksum']);
		if ($res !== true) {
			if ($this->errorLevel & self::WARNING)
				trigger_error(sprintf($this->errorMsg['create_object'], $objectId).(is_string($res) ? " ($res)" : ''), E_USER_WARNING);
			return false;
		}	
		return true;
	}
	
	/**
	 * Sprawdza poprawność zapodanych grup pod kątem:
	 * - czy dana grupa jest zdefiniowana
	 * - czy wszystkie parametry podanych grup są takie same
	 *
	 * @param array $groups - tablica nazw grup
	 * @param string $objectId - id obiektu. Tylko dla celów informacyjnych
	 * @access private
	 * @return boolean
	 */
	private function checkGroups($groups, $objectId){
		if (!$this->FullChecking)
			return true;
		$params = null;
		$groupName = null;
		foreach ($groups as $group){
			if (!isset($this->groups[$group]))
				throw new CacheException(sprintf($this->errorMsg['not_defined_d/g'],'Group', $group, "object '$objectId'"));
			if ($groupName){
				$params2 = $this->groups[$group];
				foreach ($params as $_key => $_value)
					if ($_value !== $params2[$_key] && ($this->errorLevel & self::WARNING))
						trigger_error("Groups '$groupName' and '$group' are different.(key: '$_key') (values: '$_value', '".$params2[$_key]."') (for object $objectId)", E_USER_WARNING);
			} else {
				$params = $this->groups[$group];
				$groupName = $group;
			}	
		}
	}

	/**
	 * Pobiera obiekt z cache'a. 
	 * 
	 * @param string $objectId - id objektu
	 * @param mixed $groups - parametr może być typu:
	 * - string - nazwa grupy, do jakiej należy obiekt
	 * - array - tablica nazw grup, do których należy obiekt. ale brana pod uwagę i tak bedzie tylko pierwsza
	 * @param mixed $lifeTime - czas życia obiektu. Gdy brak - brane z grupy
	 * @param string $file - czy obiekt zależy od pliku zewnętrznego. Gdy brak - brane z grupy
	 * @param string $filesPattern - wzór plików, od którego jest zależny obiekt. Przekazywane do funkcji <b>glob</b>. Gdy brak - brane z grupy
	 * @throws CacheException
	 * @access public
	 * @return mixed zwracane są następujące wartości:
	 * - null - jeśli żądany obiekt wymaga odświerzenia lub nie ma go w cache
	 * - string - jeśli dany obiekt był napisem lub liczbą
	 * - array - jeśli dany obiekt był tablicą
	 * - object - jeśli dany obiekt był typu object
	 */
	public function Get($objectId, $groups = 'default', $lifeTime = 0, $file = '', $filesPattern = ''){
                $lifeTime += 0;
		if ($this->Disabled)
			return null;
		
		if ($this->FullChecking){
			if (empty($this->groups))
				throw new CacheException(sprintf($this->errorMsg['no_d/g'],'groups', __FUNCTION__));
			if (!is_string($groups) && !is_array($groups))
				throw new CacheException(sprintf($this->errorMsg['parameter_type'], 'groups', __FUNCTION__, 'string or array'));
		}	
		if (is_string($groups)){
			if (empty($groups))
				throw new CacheException(sprintf($this->errorMsg['empty_parameter'], 'groups', __FUNCTION__));
			if (!isset($this->groups[$groups]))
				throw new CacheException(sprintf($this->errorMsg['not_defined_d/g'],'Group', $groups, "object '$objectId'"));
			$params = $this->groups[$groups];
		} else {
			$this->checkGroups($groups, $objectId);
			//Pobranie parametrów pierwszej grupy.
			$params = $this->groups[reset($groups)];
		}	
		if ($lifeTime){
			$params['lifetime'] = $lifeTime;$params['file'] = '';$params['filespattern']='';
		}	
		if ($file){
			$params['lifetime'] = 0;$params['file'] = $file;$params['filespattern']='';
		}	
		if ($filesPattern){
			$params['lifetime'] = 0;$params['file'] = '';$params['filespattern']=$filesPattern;
		}	
		$driver = &$this->drivers[$params['driver']];
		if ($params['hashid'])
			$objectId = md5($objectId);
		if (!$driver->Exists($objectId))
			return null;
		if (empty($params['lifetime'])){//zbadanie ważności względem innego pliku
			if (!empty($params['file'])){
				$lastModifiedTime = $driver->ModifiedTime($objectId);
				$changed = $this->changedConditionFile($params['file'], $lastModifiedTime);
				if (is_null($changed) || $changed === true) {
					if (is_null($changed) && ($this->errorLevel & self::NOTICE))
						trigger_error(sprintf($this->errorMsg['condition_file'],$params['file']), E_USER_NOTICE);
					$driver->Delete($objectId);
					return null;
				}
			} else { //pliki wg. zadanego wzoru
				$isAnyFile = false;
				$conditionFiles = glob($params['filespattern']);
				if (is_array($conditionFiles)){
					$lastModifiedTime = $driver->ModifiedTime($objectId);
					foreach($conditionFiles as $_fileName){
						$changed = $this->changedConditionFile($_fileName, $lastModifiedTime);
						if ($changed === true){
							$driver->Delete($objectId);
							return null;
						}	
						$isAnyFile = true;	
					}
				}
				if (!$isAnyFile){
					if ($this->errorLevel & self::NOTICE)
						trigger_error(sprintf($this->errorMsg['condition_file'],$params['filespattern']), E_USER_NOTICE);
					$driver->Delete($objectId);
					return null;
				}
			}
		} else {
			//zbadanie ważności obiektu w cache
			$lastModifiedTime = $driver->ModifiedTime($objectId);
			$lifeTime = $params['lifetime'];
			if (!is_string($lifeTime)){//czas zycia podany w sekundach
				if ($lastModifiedTime === false || (time() - $lastModifiedTime > $lifeTime)){
					$driver->Delete($objectId);
					return null;
				}	
			} else {//czas zycia podany: month lub day czyli dla danego miesiaca/dnia
				if (($lifeTime == 'day' && date('Y-m-d') != date('Y-m-d',$lastModifiedTime)) || ($lifeTime == 'month' && date('Y-m') != date('Y-m',$lastModifiedTime))){
					$driver->Delete($objectId);
					return null;
				}
			}
		}

		return $driver->Get($objectId, $params['checksum']);
	}
	
	public function GetModifyTime($objectId, $group = 'default'){
		if ($this->Disabled)
			return null;
		
		if (!isset($this->groups[$group]))
			throw new CacheException(sprintf($this->errorMsg['not_defined_d/g'],'Group', $group, "object '$objectId'"));
		$params = $this->groups[$group];
		$driver = &$this->drivers[$params['driver']];
		if (!$driver->Exists($objectId))
			return null;		
		return $driver->ModifiedTime($objectId);
	}
	/**
	 * Sprawdza, czy plik warunkujący zmienił się
	 *
	 * @param string $fileName plik warunkujący
	 * @param int $cacheModifiedTime czas utworzenia obiektu
	 * @access private
	 * @return mixed zwracane są następujące wartości:
	 * - null - brak pliku warunkującego
	 * - true - plik warunkujący był modyfikowany
	 * - false - plik warunkujący nie był modyfikowany
	 */
	private function changedConditionFile($fileName, $cacheModifiedTime){
		if (file_exists($fileName)){
			$conditionTime = filemtime($fileName);
			if ($cacheModifiedTime === false || $conditionTime === false || $cacheModifiedTime < $conditionTime)
				return true;
		} else
			return null;
		return false;	
	}
	
	/**
	 * Czyści cały cache
	 *
	 * @access public	 
	 * @return boolean zwraca false, gdy nie powiedzie się usunięcie choćby jednego pliku
	 */
	public function ClearAll(){
		if ($this->Disabled)
			return true;
		
		$result = true;
		foreach ($this->drivers as &$driver)
			$result &= $driver->ClearAll();
		return $result;	
	}
	
	/**
	 * Czyści wybrane obiekty
	 *
	 * @throws CacheExceptions
	 * @param mixed $objects parametr może być typu:
	 * - string - nazwa obiektu
	 * - array - tablica obiektów
	 * @param mixed $groups parametr może być typu:
	 * - string - nazwa grupy
	 * - array - tablica grup (brana pod uwagę będzie tylko pierwsza)
	 * @access public
	 * @return mixed zwracane są następujące wartości:
	 * - true - gdy się powiodło
	 * - array - gdy nie udało się usunąć choćby jednego obiektu. Zwracana jest tablica tych obiektów
	 */
	public function ClearObjects($objects, $groups = 'default'){
		if ($this->Disabled)
			return true;
		
		if ($this->FullChecking){
			if (empty($this->groups))
				throw new CacheException(sprintf($this->errorMsg['no_d/g'],'groups', __FUNCTION__));
			if (!is_string($groups) && !is_array($groups))
				throw new CacheException(sprintf($this->errorMsg['parameter_type'], 'groups', __FUNCTION__, 'string or array with string values'));
			if (!is_string($objects) && !is_array($objects))
				throw new CacheException(sprintf($this->errorMsg['parameter_type'], 'objects', __FUNCTION__, 'string or array with string values'));
		}	
		if (is_string($groups))
			$groups = array($groups);
		if (is_string($objects))
			$objects = array($objects);
		$this->checkGroups($groups, implode(',', $objects));
		//Pobranie parametrów pierwszej grupy.
		$params = $this->groups[reset($groups)];
		$driver = &$this->drivers[$params['driver']];
		$errorFiles = array();
		foreach ($objects as $_objectId){
			if (!is_string($_objectId))
				throw new CacheException(sprintf($this->errorMsg['parameter_type'], 'objects', __FUNCTION__, 'string or array with string values'));
			if (!$driver->Exists($_objectId)){
				if ($this->errorLevel & self::NOTICE)
					trigger_error(sprintf($this->errorMsg['no_object'], $_objectId), E_USER_NOTICE);
				continue;
			}	
			if ($driver->Delete($_objectId) === false)
				$errorFiles[] = $_objectId;		
		}
		
		return empty($errorFiles) ? true : $errorFiles;
	}

	/**
	 * Czyści wybrane grupy
	 *
	 * @throws CacheExceptions
	 * @param mixed $groups parametr może być typu:
	 * - string - nazwa grupy
	 * - array - tablica grup
	 * @access public
	 * @return mixed zwracane są następujące wartości:
	 * - true - gdy się powiodło
	 * - array - gdy nie udało się usunąć choćby jednego obiektu z danej grupy. Zwracana jest tablica tych grup
	 */
	public function ClearGroups($groups){
		if ($this->Disabled)
			return true;
		
		if (empty($this->groups))
			throw new CacheException(sprintf($this->errorMsg['no_d/g'],'groups', __FUNCTION__));
		if (!is_string($groups) && !is_array($groups))
			throw new CacheException(sprintf($this->errorMsg['parameter_type'], 'groups', __FUNCTION__, 'string or array with string values'));
		if (is_string($groups))
			$groups = array($groups);
		$errorGroups = array();
		foreach ($groups as $_groupName){
			if (!isset($this->groups[$_groupName]))
				throw new CacheException(sprintf($this->errorMsg['not_defined_d/g'],'Group', $_groupName, "method ClearGroups"));
			$driver = &$this->drivers[$this->groups[$_groupName]['driver']];
			if (!$driver->ClearGroup($_groupName))
				$errorGroups[$_groupName] = 1;
		}
		return empty($errorGroups) ? true : array_keys($errorGroups);	
	}
}	

/**
 * Interfejs dla klas IO
 * 
 * @package MCM
 * @subpackage independent
 * @author Robert (nospor) Nodzewski (email: nospor at interia dot pl)
 * @copyright 2006 Robert Nodzewski
 * @version 1.0
 * @access public
 */
interface iCacheIO {
 
	/**
	 * Wkładanie do urządzenia
	 * 
	 * @param string $name - nazwa
	 * @param string $value - wartość
	 * @return boolean
	 */
	public function Put($objectId, &$objectValue, $groups, $checkSum);

	/**
	 * Pobieranie z urządzenia
	 * 
	 * @param string $name - nazwa
	 * @return mixed
	 * - string - gdy wszystko ok
	 * - false - gdy błąd pobierania
	 */
	public function Get($objectId, $checkSum);

    /**
     * Czas ostatniej modyfikacji obiektu
     *
     * @param string $name - nazwa
     * @return mixed
     * - int - unixowy znacznik czasu
     * - false - gdy coś nie tak
     */
	public function ModifiedTime($name);

    /**
     * Czy istnieje podany obiekt w urządzeniu
     *
     * @param string $name - nazwa
     * @return boolean 
     */
	public function Exists($name);

	/**
     * Usuwa dany obiekt z urządzenia
     *
     * @param string $name - nazwa
     * @return boolean 
     */
	public function Delete($name);

	/**
     * Czyści cały cache w urządzeniu
     *
     * @return boolean 
     */
	public function ClearAll();

	/**
     * Czyści podaną grupę
     *
     * @return boolean 
     */
	public function ClearGroup($name);
	
	/**
     * Ustawienie poziomu zgłaszanych błędów
     *
     * @param int $errorLevel
     * @return boolean
     */
	public function SetErrorLevel($errorLevel);
}

/**
 * Klasa wyjątków dla obiektu Cache
 * 
 * @package MCM
 * @subpackage independent
 * @author Robert (nospor) Nodzewski (email: nospor at interia dot pl)
 * @copyright 2006 Robert Nodzewski
 * @version 1.0
 * @access private
 **/
class CacheException extends Exception  {
	public function __construct($message, $code = 0) {
		parent::__construct($message, $code);
	}
}
?>