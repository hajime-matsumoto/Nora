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

class LibraryLoaderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		require_once dirname(__FILE__).'/../../../include/header.php';
	}

	public function testLibraryLoaderInstanceExists( )
	{
		$this->assertInstanceOf('Nora\Core\LibraryLoader', Nora\Core\Nora::getInstance()->getLibraryLoader());
	}

	/**
	 * @depends testLibraryLoaderInstanceExists
	 */
	public function testAutoloadDebug( )
	{
		$nora = Nora\Core\Nora::getInstance();
		$this->assertInstanceOf('Nora\Core\Nora', $nora);

		// デバッグモードでオートロードを叩く
		$found_file = $nora->getLibraryLoader( )->autoload('Nora\Bootstrap\Bootstrapper', true);
		$this->assertFileExists($found_file);
	}

	/**
	 * @depends testLibraryLoaderInstanceExists
	 */
	public function testAutoloadClass( )
	{
		$this->assertInstanceOf('Nora\Bootstrap\Bootstrapper', new Nora\Bootstrap\Bootstrapper());
	}
}
