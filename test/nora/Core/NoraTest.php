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

class NoraTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		require_once dirname(__FILE__).'/../../../library/Nora/Core/Nora.php';
	}

	public function testCreateNoraInstance()
	{
		$this->assertInstanceOf('Nora\Core\Nora', Nora::getInstance( ) );
	}


	public function testAddComponent( )
	{
		// ライブラリローダーの追加
		Nora::getInstance( )->addComponent('test', function( $container, $name ){
			return new \Nora\Loader\LibraryLoader();
		});

		// ライブラリローダの取得
		$this->assertInstanceOf('\Nora\Loader\LibraryLoader', Nora::getInstance()->component('test'));
	}

	public function testInit( )
	{
		// Initすればライブラリローダがコンポーネント登録される。
		Nora::init();
		$this->assertInstanceOf('\Nora\Loader\LibraryLoader', Nora::getInstance()->component('libraryLoader'));
	}

	public function testLoggerComponent( )
	{
		// DI\ComponentObjectIFを利用したコンポーネントの登録と生成
		Nora::getInstance( )->addComponent('logger', 'Nora\Logger\Component', array(
			'type'=>'file',
			'PHPErrorHandling'=>'on',
			'config'=>array(
				'log_file_path' => '/tmp/nora-log',
				'log_file_mode' => 'w'
			)
		));

		Nora::getInstance( )->addComponent('db', function(){ return new ArrayObject(); });

		$logger = Nora::getInstance( )->component('logger');

		// わざとPHPエラーを吐く
		$logger->logging(1,'ログを吐くテスト');
	}
}
