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

class DBTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		// このサイト用のブートストラッパを設定
		Nora()->bootstrapper->loadResourceArray(
			array(
				'DB'=>array(
					'class'=>'NoraResource\DB',
					'config'=>array(
						'type'=>'mysql',
						'dbname'=>'for_test',
						'dbhost'=>'localhost',
						'dbport'=>3306,
						'dbuser'=>'root',
						'dbpassword'=>'deganjue'
					)
				)
			)
		);
	}

	public function testDBInstance( )
	{
		$db = NoraBootstrap('DB');
		$this->assertInstanceOf( '\Nora\DB\PDO', $db );
	}

	public function testQuesry( )
	{
		$db = NoraBootstrap('DB');
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
