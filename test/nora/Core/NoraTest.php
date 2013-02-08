<?php
/*
 * のらテスト
 *---------------------- 
 * test/nora/bootstrap.php
 *
 * phpunit Bootstrap
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';

class NoraTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		require_once dirname(__FILE__).'/../../../include/header.php';
	}

	public function testCreateNoraInstance()
	{
		$nora = new Nora\Core\Nora( );
		$this->assertInstanceOf('Nora\Core\Nora', $nora);

		Nora\Core\Nora::resetInstance();
		Nora\Core\Nora::getInstance();
		Nora\Core\Nora::getInstance();
	}

	/**
	 * @depends testCreateNoraInstance
	 */
	public function testGetNoraInstance( )
	{
		$this->assertInstanceOf('Nora\Core\Nora', Nora\Core\Nora::getInstance() );
	}
}
