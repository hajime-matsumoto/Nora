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

class NoraPackageInvoiceTestCase extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Nora\Nora::getInstance();

        // 単体でコントローラーを実行するとどうなるんだろう
        define('APP_HOME',NORA_HOME.'/share/');
        define('APP_ENV','development');
    }

    public function testPackageManager( )
    {
        // パッケージマネージャーを起動
        $pkgManager = new Nora\Package\Manager(array(
            'pkgDirName'=>APP_HOME.'/packages',
            'cfgFileName'=>'/config/pkg.ini',
            'env'=>APP_ENV
        ));

        $package = $pkgManager->pullPackage('pdf');

        // パッケージのアクションを実行
        $req = $package->makeRequest();
        $res = $package->makeResponse();

        $res->capStart();
        $package->action('home','index',$req,$res);
        $res->capEnd();

        $this->assertEquals('pdf', $package->getParam('name'));

        // ヘルパをつかってパッケージマネージャーの取得
        $this->assertInstanceOf('Nora\Package\Manager', $package->pkgManager());
    }
}
