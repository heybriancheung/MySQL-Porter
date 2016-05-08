<?php
require_once('DBObj.php');

abstract class AbstractEntity {

	protected $objPDO = NULL;

	public function __construct() {
		$this->objPDO = DBObj::getInstance();
	}

	protected function executeMySQL($statement) {
		$objStatement = $this->objPDO->prepare($statement);
		return $objStatement->execute();
	}

	protected function doFetch($statement) {
		$objStatement = $this->objPDO->prepare($statement);
		$objStatement->execute();
		return $objStatement->fetch(); 
	}

	protected function doFetchAll($statement) {
		$objStatement = $this->objPDO->prepare($statement);
		$objStatement->execute();
		return $objStatement->fetchAll(); 
	}

}

?>
