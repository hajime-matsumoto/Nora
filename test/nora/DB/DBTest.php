<?php
/*
 * のらテスト
 *---------------------- 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';


require_once dirname(__FILE__).'/../../../include/header.php';
use Nora\Core\Nora;

class DBTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		Nora::init();

		$bs = Nora::getInstance()->component('bootstrap');
		$bs->addComponent( 'DB', 'Nora\DB\Component', array(
			'type'=>'mysql',
			'dbname'=>'for_test',
			'dbhost'=>'localhost',
			'dbport'=>3306,
			'dbuser'=>'root',
			'dbpassword'=>'deganjue'
		));
	}

	public function testDBInstance( )
	{
		$db = Nora::getInstance()->bootstrap->db;
		$this->assertInstanceOf( '\Nora\DB\PDO', $db );
	}

	public function testQuesry( )
	{
		$db = Nora::getInstance()->bootstrap->db;
		$db->query(
			'DROP TABLE IF EXISTS sample'
		);
		$db->query(
			'CREATE TABLE sample (id int(4) primary key auto_increment, name varchar(128))'
		);

		$result = $db->query( 'SHOW TABLES' );

		$this->assertEquals('sample', $result->fetchColumn());
	}
}
