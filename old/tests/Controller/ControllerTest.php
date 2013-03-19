<?php
// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';

use Nora\Controller;

class NoraControllerTest extends PHPUnit_Framework_TestCase
{
	public function testFrontController()
	{
		define('APP_ENV','development');
		define('APP_HOME',NORA_HOME.'/doc/examples/application');

		$front = Controller\Front::getInstance( );
		$this->assertInstanceOf('Nora\Controller\Front', $front);

		$front->addModulesDir(NORA_HOME.'/doc/examples/application/modules');
		$front->setDefaultModule(NORA_HOME.'/doc/examples/application');

		$front->getRequest()->setURI('/home/index/user/hajime');
		$front->getRouter()->addRoute(
			'99:default',
			'/:controller/:action/user/:user',
			array('module'=>'default','controller'=>'default','action'=>'index')
		);

		$front->getEventManager( )->addEventHandler('post-dispatch-loop',function($event, $dispatcher, $front){
			// レスポンスを取得
			$response = $dispatcher->getResponse();
			$request  = $dispatcher->getRequest();

			// 描画
			echo $front->getViewRenderer( )->render( $response, $request );
		});

		$front->dispatch( );


	}
}

