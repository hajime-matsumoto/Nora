<?php
// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';

class NoraApplicationApplicationTestCase extends PHPUnit_Framework_TestCase
{
	public function testApplicationTest( )
	{
		define('APP_HOME',NORA_HOME.'/doc/examples/application');
		define('APP_ENV','develop');

		nora( )->getContainer( )->addComponent('logging', 'Nora\Logging\Factory');

		nora( )->getContainer( )->addComponent(
			'application',
			'Nora\Application\Application',
			array(
				'config'=>APP_HOME.'/config/application.ini',
				'env'=>APP_ENV
			)
		);

		// 起動したアプリケーションのブートストラッパ経由でコンフィグがとれるか
		$app = nora_component('application');
		$this->assertInstanceOf('Nora\Config\ConfigIF', $app->bootstrap('config') );

		// 設定ファイルからロガーを取得できるか
		$log = $app->bootstrap('logging');
		$log->reportingLevel(15);

		ob_start();
		$log->error('hihi');
		$this->assertEquals('[error(8)] [Application] hihi', trim(ob_get_clean()));

		nora( )->getContainer( )->removeComponent('logging');

		// メイラの取得
		$mail = $app->bootstrap('mailer');
		$this->assertInstanceOf('Nora\Mail\Mailer', $mail);

		// ビューの取得
		$view       = $app->bootstrap('view');
		$this->assertInstanceOf('Nora\View\ViewIF', $view);

		// ビューヘルパ機構稼動
		$view->placeholder('table')
			->setPrefix('<table>'.PHP_EOL)
			->setPostfix(PHP_EOL.'</table>')
			->setFormat('<tr><td>%s</td><td>%s</td><td>%s</td></tr>')
			->setSeparator(PHP_EOL)
			->append("A","B","C")
			->append("A","B","C")
			->append("A","B","C");

		$view->headMeta( )->charset('utf8');
		$view->headMeta( )->name('keyword','test,nora,php,framework,国産');
		$view->headMeta( )->httpEquiv('content-type','text/html; charset=UTF-8');
		$view->headMeta( )->property('og:title','たいとる');

		$view->headMeta( )->twitter('card','summary');
		$view->headMeta( )->twitter('site','@hajime-mat');
		$view->headMeta( )->twitter('creater','@hajime-mat');
		$view->headMeta( )->twitter('url','http://dev.hazime.org/index.php');
		$view->headMeta( )->twitter('title','松本ハジメのWEBサイト');
		$view->headMeta( )->twitter('description','松本ハジメのWEBサイト');
		$view->headMeta( )->twitter('image','');

		$view->headMeta( )->og('site_name','松本ハジメのWEBサイト');
		$view->headMeta( )->og('title','松本ハジメのWEBサイト');
		$view->headMeta( )->og('description','松本ハジメのWEBサイト');
		$view->headMeta( )->og('url','http://dev.hazime.org/index.php');
		$view->headMeta( )->og('type','profile');
		$view->headMeta( )->og('image','profile');



		$view->headStyle( )->appendFile('/assets/css/reset.css');

		$view->headScript( )->appendFile('/assets/js/jQuery.js');

		$view->bodyScript( )->appendCode('alert("loaded");');

		$view->googleAnalytics('UA-37941501-1');

		$view->facebookRoot('1111');

		// ビュー用のレスポンスデータを作成
		$response = $view->createResponse();
		$response->setTemplateFile('/home/index');
		$response->render();
	}

	public function testRouting( )
	{
		nora( )->getContainer( )->addComponent(
			'application',
			'Nora\Application\Application',
			array(
				'config'=>APP_HOME.'/config/application.ini',
				'env'=>APP_ENV
			)
		);

		$router = nora_component('application')->bootstrap('router');
		$router->addRoute(100, '/theme/:request_uri', array('module'=>'theme','controller'=>'static', 'action'=>'index'));
		$router->addRoute(900, '/:controller/:action', array('module'=>'default','controller'=>'home','action'=>'index'));
		$router->addRoute(910, '/:controller', array('module'=>'default','controller'=>'home','action'=>'index'));
		$router->routeURI('/home');
		$router->routeURI('/home/index');
		$params = $router->routeURI('/theme/default/assets/css/reset.css');

		// ルーティングパラメタを元にディスパッチする
		$this->assertInstanceOf('Nora\Application\FrontController', nora_component('application')->bootstrap('frontController') );
		nora_component('application')->bootstrap('frontController')->dispatch( $params );
	}

	public function testModule( )
	{
		nora( )->getContainer( )->addComponent(
			'application',
			'Nora\Application\Application',
			array(
				'config'=>APP_HOME.'/config/application.ini',
				'env'=>APP_ENV
			)
		);

		// モジュールを有効化
		$modules = nora_component('application')->bootstrap('modules');

		// テーマモジュールを取得
		$this->assertInstanceOf('Nora\Application\Module', $modules->theme );

	}
}
