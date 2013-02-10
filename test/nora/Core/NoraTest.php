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

use Nora\Core\Nora;

class NoraTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		if(!defined('NORA_HOME'))
		{
			// このスクリプトから1階層上のディレクトリを設定
			define('NORA_HOME', realpath( dirname(__FILE__).'/../../../' ) );
		}

		// インクルードパスを追加
		ini_set( 'include_path', ini_get( 'include_path' ) .':'.NORA_HOME.'/library' );

		require_once 'Nora/Core/Nora.php';
	}

	public function testCreateNoraInstance()
	{
		$this->assertInstanceOf('Nora\Core\Nora', new Nora() );
		$this->assertInstanceOf('Nora\Core\Nora', Nora::getInstance() );
	}

	public function testLibraryLoader()
	{
		// ライブラリローダを使えるか
		$this->assertInstanceOf('Nora\Core\LibraryLoader', Nora::getInstance()->getContainer()->LibraryLoader);
	}
}
