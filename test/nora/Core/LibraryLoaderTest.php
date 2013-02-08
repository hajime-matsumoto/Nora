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
		 Nora\Core\Nora::getInstance()->setLibraryLoader(
			 Nora\Core\Nora::getInstance()->getLibraryLoader()
		 );
	}

	public function testAddSearchPath( )
	{
		Nora\Core\Nora::getInstance( )
			->getLibraryLoader( )
			->addSearchPath( NORA_HOME .'/test/nora/Core', 'Core');
		$this->assertNull(
			Nora\Core\Nora::getInstance( )->getLibraryLoader( )->autoLoad( 'Nore_NoraTest', true)
		);
		$this->assertFileExists(
			Nora\Core\Nora::getInstance( )->getLibraryLoader( )->autoLoad( 'Core_NoraTest', true)
		);
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
