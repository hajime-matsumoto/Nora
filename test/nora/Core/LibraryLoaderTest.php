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
		$this->assertInstanceOf('Nora\Core\LibraryLoader', Nora()->getContainer( )->libraryLoader);
	}

	public function testAddSearchPath( )
	{
		Nora()->getContainer( )->libraryLoader->addSearchPath( NORA_HOME .'/test/nora/Core', 'Core');

		// ファイル取得実験1
		$this->assertNull(
			Nora()->getContainer( )->libraryLoader->autoload( 'Nore_NoraTest', true)
		);
		// ファイル取得実験2
		$this->assertFileExists(
			Nora()->getContainer( )->libraryLoader->autoload( 'Core_NoraTest', true)
		);
	}
}
