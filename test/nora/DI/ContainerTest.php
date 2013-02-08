<?php
/*
 * のらテスト
 *---------------------- 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';
require_once dirname(__FILE__).'/../../../include/header.php';

class ContainerTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->container = new Nora\DI\Container();
	}

	/**
	 * サービスの追加
	 */
	public function testAddService()
	{
		$c = $this->container;

		/* 単純なオブジェクトをサービスとして登録する */
		$c->addService( 'me', $c );

		/* コールバックファンクションを登録する */
		$c->addService( 'func', function(){ return new ArrayObject(); } );

		/* クラスを登録する */
		$c->addService( 'class', 'NoraResource\Request' );


		/* サービスを取得 */
		$this->assertInstanceOf( 'ArrayObject', $c->service( 'func' ) );
		$this->assertInstanceOf( 'Nora\DI\Container', $c->service( 'me' ) );
		$this->assertInstanceOf( 'NoraResource\Request', $c->service( 'class' ) );
	}

}
