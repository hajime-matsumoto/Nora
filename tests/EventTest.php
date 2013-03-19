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


class EventTestCase extends PHPUnit_Framework_TestCase
{
    public function setup( )
    {
        Nora\Nora::getInstance( );
    }

    /**
     * イベントを作成するテスト
     */
    public function testCreateEvent( )
    {
        $event = new Nora\Event\Event('notice', array('arg1'=>'value1','arg2'=>'value2'));
        $this->assertInstanceOf( 'Nora\Event\Event',  $event);

        // 設定のテスト
        $this->assertArrayHasKey('arg1', $event);
        $this->assertEquals('value1', $event['arg1']);
    }

    /**
     * イベントサブジェクトを作成するテスト
     */
    public function testCreateSubject( )
    {
        $subject = new Nora\Event\Subject( );
        $event = $subject->createEvent('notice', array('arg1'=>'value1'));
        $this->assertInstanceOf( 'Nora\Event\EventIF',  $event);
        $this->assertInstanceOf( 'Nora\Event\SubjectIF',  $event->getSubject());
    }

    /**
     * イベントオブザーバを作成するテスト
     */
    public function testCreateObserver( )
    {
        $observer = new Nora\Event\Observer( );

        // イベントハンドラを登録
        $observer->addHandler('notice', function( Nora\Event\EventIF $event){
            $event['handler_result'] = 'ok';
        });

        $event = new Nora\Event\Event('notice', array('arg1'=>'value1','arg2'=>'value2'));
        $observer->reciveEvent( $event );

        $this->assertArrayHasKey( 'handler_result', $event );
    }

    /**
     * 結合テスト
     */
    public function testEventAll( )
    {
        $subject  = new Nora\Event\Subject( );
        $observer = new Nora\Event\Observer( );
        $event    = $subject->createEvent('notice', array('arg1' => 'value1'));

        // イベントハンドラを登録
        $observer->addHandler('notice', function( Nora\Event\EventIF $event){
            $event['handler_result'] = 'ok';
        });

        // オブザーバーを登録
        $subject->attachObserver( $observer );

        // イベントを実行する
        $subject->triggerEvent( $event );

        // 実行されたか確認する
        $this->assertArrayHasKey( 'handler_result', $event );

        // 複数ハンドラの実行
        $observer->addHandler('notice', function( Nora\Event\EventIF $event){
            $event['handler_result2'] = 'ok';
        });

        // イベントを実行する
        $event    = $subject->createEvent('notice', array('arg1' => 'value1'));
        $subject->triggerEvent( $event );

        // 実行されたか確認する
        $this->assertArrayHasKey( 'handler_result2', $event );

        // サブジェクトを使うハンドラの実行
        $observer->addHandler('notice', function( Nora\Event\EventIF $event){
            $event['subject_class'] = get_class($event->getSubject());
        });
        $event    = $subject->createEvent('notice', array('arg1' => 'value1'));
        $subject->triggerEvent( $event );
        $this->assertEquals( 'Nora\Event\Subject', $event['subject_class'] );

        // イベントを作らずにトリガーを起こす
        $subject->triggerEvent( 'notice' );
    }
}
