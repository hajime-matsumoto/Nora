<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 * テストファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */

// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';


class FrontControllerTestCase extends PHPUnit_Framework_TestCase
{
    public function setup( )
    {
        Nora\Nora::getInstance( );
    }

    /**
     * フロントコントローラのテスト
     */
    public function testFrontController( )
    {
        $controller = new Nora\Controller\FrontController( );
        $this->assertInstanceOf('Nora\Controller\FrontController', $controller);

        // ディレクトリを設定する
        $controller->setControllerDir( NORA_HOME.'/doc/examples/controller' );

        // ネームスペースを設定する
        $controller->setModuleNamespace( 'NoraTest\\Controller' );

        // 設定したディレクトリを確認する
        $this->assertEquals(
            NORA_HOME.'/doc/examples/controller'
            ,$controller->getControllerDir('default')
        );

        // リクエストを調整して、テストコントローラをディスパッチする
        $controller->getRequest( )
            ->setControllerName('test')
            ->setActionName('index');

        $response = $controller->dispatch( );

        $this->assertEquals('default',$response->getParam('module_name'));
        $this->assertEquals('test',$response->getParam('controller_name'));
        $this->assertEquals('index',$response->getParam('action_name'));
        $this->assertEquals('hello wild',$response['message']);
    }

    /**
     * フロントコントローラにアプリケーションを足す
     */
    public function testFrontControllerApplication( )
    {
        $controller = new Nora\Controller\FrontController( );

        // アプリケーションを登録すると
        // コントローラディレクトリと
        // ネームスペースを登録する
        $controller->setApp( NORA_HOME.'/doc/examples/apps/test' );

        $this->assertEquals(
            '/opt/nora/doc/examples/apps/test/controller',
            $controller->getControllerDir('default')
        );
    }
}
