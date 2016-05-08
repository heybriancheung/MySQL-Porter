DBAccessor is a suite of classes making accessing MySQL database so much easier.

The most important class is MySQLHelper. This is the class for making MySQL statements by describing the table schema using PHP array.

For example, look at the following array:

	$schema = array(
		'table' => 'testTable',
		'field1' => 'int',
		'field2' => 'text'
	);

will give you

	CREATE TABLE IF NOT EXISTS testTable (id INT UNSIGNED NOT NULL AUTO_INCREMENT, field1 INT NOT NULL, field2 TEXT NOT NULL, PRIMARY KEY (id)) CHARACTER SET=utf8

Customer is an example class on how to use MySQLHelper. You can create a class that extends AbstractEntity and implements Entity. The abstract class AbstractEntity contains methods for executing MySQL statements, using PDO. The interface Entity is here to make sure that every class accessing MySQL will have CRUD methods.
