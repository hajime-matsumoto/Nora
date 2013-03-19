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


class NoraTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * 初期処理のテスト
     */
    public function testNoraInstance( )
    {
        $nora = Nora\Nora::getInstance( );
        $this->assertInstanceOf( 'Nora\Nora', $nora);

        $this->assertInstanceOf( 'Nora\AutoLoader\AutoLoader', $nora->autoLoader());

        $namespaces = $nora->autoLoader()->getNamespaces();
        $this->assertArrayHasKey('Nora', $namespaces);

        // 存在しないクラスを呼んで見る
        try {
            $hoge = new Nora\Hoge\Hoge( );
        }catch( Nora\AutoLoader\FileNotFoundException $e ){
            $this->assertInstanceOf('Nora\Autoloader\FileNotFoundException', $e );
        } 

        // 存在するクラスを呼んでみる
        $util = Nora\Util\Util::getInstance( );
        $this->assertInstanceOf('Nora\Util\Util', $util );
    }
}
