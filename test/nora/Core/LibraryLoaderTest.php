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

use Nora\Core\Nora;
use Nora\Loader\LibraryLoader;

class LibraryLoaderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		require_once dirname(__FILE__).'/../../../library/Nora/Core/Nora.php';
		Nora::init();
	}

	public function testLibraryLoaderInstanceExists( )
	{
		$this->assertInstanceOf('Nora\Loader\LibraryLoader', new LibraryLoader() );
	}

	public function testAddSearchPath( )
	{
		$loader = new LibraryLoader( );
		$loader->addSearchPath( NORA_HOME .'/test/nora/Core', 'Core');

		// ファイル取得実験1
		$this->assertNull( $loader->autoload( 'Nore_NoraTest', true));

		// ファイル取得実験2
		$this->assertFileExists( $loader->autoload( 'Core_NoraTest', true));
	}
}
