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

class NoraPackageTestCase extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Nora\Nora::getInstance();

        // 単体でコントローラーを実行するとどうなるんだろう
        define('PKG_TEST_HOME',NORA_HOME.'/doc/examples/package/test');
        define('APP_ENV','development');
    }

    public function testPackageModule( )
    {
        // コンフィグを作成する
        $config_file = PKG_TEST_HOME.'/config/pkg.ini';

        // 新しいパッケージを作成
        $package = new Nora\Package\Package(array('configFile'=>$config_file, 'env'=>APP_ENV));

        // パッケージをイニシャライズ
        $package->init();

        // パッケージのアクションを実行
        $req = $package->makeRequest();
        $res = $package->makeResponse();

        $res->capStart();
        $package->action('home','index',$req,$res);
        $res->capEnd();

        $this->assertEquals('hello wild', $res['contents']);
    }
}
