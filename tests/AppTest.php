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


class AppTestCase extends PHPUnit_Framework_TestCase
{
    public function setup( )
    {
        Nora\Nora::getInstance( );
    }

    /**
     * 初期処理のテスト
     */
    public function testCreateApp( )
    {
        $app = new Nora\App\App('test', NORA_HOME.'/doc/examples/apps/default');
        $this->assertInstanceOf( 'Nora\App\App', $app );
    }

    /**
     * コンフィグのテスト
     */
    public function testAppConfig( )
    {
        $app = new Nora\App\App('default', NORA_HOME.'/doc/examples/apps/default');
        $this->assertInstanceOf( 'Nora\App\Bootstrapper', $app->pullComponent('bootstrapper') );

        // 設定オブジェクトの取得
        $config = $app->bootstrap('config');

        $this->assertInstanceOf( 'Nora\Config\Config', $config );
        $this->assertEquals('development', $config->getConf('env'));

        // 定数が入ったか
        $this->assertEquals(APP_TEST_HOME, NORA_HOME.'/doc/examples/apps/default');
    }

}
