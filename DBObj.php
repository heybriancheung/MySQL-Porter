<?php
class DBObj {
	private static $dsn = 'mysql:host=localhost;dbname=new_timeless;charset=utf8';
	private static $objPDO = NULL;

	public static function getInstance() {
		if(is_null(self::$objPDO)) {
			self::$objPDO = new PDO(self::$dsn, 'root', '', array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			return self::$objPDO;
		}
		return self::$objPDO;
	}
}

?>
