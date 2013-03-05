<?php
// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';

class NoraTestCase extends PHPUnit_Framework_TestCase
{
	public function testCreateFacebookInstance( )
	{
		$this->assertInstanceOf('Nora\Base\Nora', nora() );
	}

	public function testGetRootContainer( )
	{
		$this->assertInstanceOf('Nora\Base\DI\Container', nora()->getContainer() );
	}

	public function testLogComponent( )
	{
		$logfile = '/tmp/a';
		if(file_exists($logfile))
		{
			unlink($logfile);
		}

		// 既にログコンポーネントがあれば削除する
		nora()->getContainer( )->removeComponent('logger');


		//
		// ロガーファクトリで登録してみる
		//
		$setting = array(
			'type'=>'file',
			'file'=>'/tmp/a',
			'mode'=>'w'
		);
		nora()->getContainer( )->addComponent('logger','Nora\Logging\Factory', $setting);
		$this->assertInstanceOf('Nora\Logging\LoggerIF', nora()->getContainer( )->pullComponent('logger'));
		nora()->getContainer( )->pullComponent('logger')->debug('ファイルログテスト');

		$this->assertFileExists('/tmp/a');

		//
		// ロガーコンポーネントを登録してみる
		//
		nora()->getContainer()->removeComponent('logger');
		nora()->getContainer( )->addComponent('logger','Nora\Logging\Logger', array('logFormat'=>'[:label] [:name] :message'));
		ob_start();
		nora()->getContainer( )->pullComponent('logger')->debug('出力ログテスト');
		$this->assertEquals("[debug] [SYSTEM] 出力ログテスト", trim(ob_get_clean()));
	}
}
