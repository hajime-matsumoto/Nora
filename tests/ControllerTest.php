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


class ControllerTestCase extends PHPUnit_Framework_TestCase
{
    public function setup( )
    {
        Nora\Nora::getInstance( );
    }

    /**
     * コントローラのテスト
     */
    public function testController( )
    {
        $controller = new Nora\Controller\ActionController( );
        $this->assertInstanceOf('Nora\Controller\ActionController', $controller);
    }

    /**
     * コントローラを実行する
     */
    public function testControllerExecute( )
    {
        $controller = new Nora\Controller\ActionController( );

        // 存在しないアクションを呼ぶと
        // notFoundActionが実行されて
        // レスポンスステータスに404がセットされる
        $response = $controller->runAction( 'index' );
        $this->assertEquals(404, $response->getStatus());
        $this->assertInstanceOf('Nora\Controller\ActionController', $controller);
    }

    /**
     * 具象コントローラを実行する
     */
    public function testConcrateControllerTest( )
    {
        $file = NORA_HOME.'/doc/examples/controller/Test.php';

        include_once $file;

        // テスト用に実装したコントローラを起動
        $controller = new NoraTest\Controller\Test( );
        $this->assertInstanceOf('Nora\Controller\ActionControllerIF', $controller);

        $response = $controller->runAction( 'index' );

        // 見つかるから404は返らない
        $this->assertNotEquals(404, $response->getStatus());

        // 実行結果を見る
        $this->assertArrayHasKey('message',$response);

        $response = $controller->runAction( 'stdout' );

        // 実行結果を見る
        $this->assertArrayHasKey('contents',$response);
    }
}
