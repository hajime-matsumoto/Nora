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


class ServiceTestCase extends PHPUnit_Framework_TestCase
{
    public function setup( )
    {
        Nora\Nora::getInstance( );
    }

    /**
     * 初期処理のテスト
     */
    public function testServiceManagerTree( )
    {
        $parent = new Nora\Service\Manager();
        $manager = new Nora\Service\Manager();
        $manager->setServiceManager( $manager );
        $this->assertInstanceOf( 'Nora\Service\Manager', $manager);
        $this->assertInstanceOf( 'Nora\Service\Manager', $manager->getServiceManager());
    }

    /**
     * サービスの登録
     */
    public function testServiceManager( )
    {
        $manager = new Nora\Service\Manager();

        // クラス名で登録
        $manager->putService('helper', 'string', 'Nora\Service\Manager');

        // クロージャスタイルの登録
        $manager->putService('helper', 'closure', function($m){
            return new Nora\Service\Manager( );
        });

        // オブジェクトで登録
        $manager->putService('helper', 'object', new Nora\Service\Manager() );

        // 重複登録
        try {
            $manager->putService('helper', 'string', 'Nora\Service\Manager');
        }catch( Exception $e ){
        }
        $this->assertInstanceOf('Nora\Service\ServiceAlradyExistsException', $e );

        // 削除して再登録
        $manager->removeService('helper', 'string' );
        $manager->putService('helper', 'string', 'Nora\Service\Manager');

        // サービスの取得
        $this->assertInstanceOf( 'Nora\Service\Manager', $manager->pullService('helper', 'string') );
        $this->assertInstanceOf( 'Nora\Service\Manager', $manager->pullService('helper', 'closure'));
        $this->assertInstanceOf( 'Nora\Service\Manager', $manager->pullService('helper', 'object'));

        // 親子関係の構築
        $childManager = new Nora\Service\Manager( );
        $childManager->setServiceManager( $manager );

        $this->assertInstanceOf( 'Nora\Service\Manager', $childManager->pullService('helper', 'string') );
        $this->assertInstanceOf( 'Nora\Service\Manager', $childManager->pullService('helper', 'closure'));
        $this->assertInstanceOf( 'Nora\Service\Manager', $childManager->pullService('helper', 'object'));
    }
}
