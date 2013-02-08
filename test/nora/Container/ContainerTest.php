<?php
/*
 * のらテスト
 *---------------------- 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
use Nora\Container\Container;

// のらヘッダーを読み込む
require_once dirname(__FILE__).'/../../../include/header.php';

// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';

class ContainerTest extends PHPUnit_Framework_TestCase
{
	private $_container;

	public function  setUp( )
	{
		$this->_container = new Container( );
	}

	public function testCreate( )
	{
		$this->assertInstanceOf( 'Nora\Container\Container', $this->_container);
	}

	public function provider( )
	{
		return array(
			array('string_key','value'),
			array('int_key',1),
			array('zero_int_key',0)
		);
	}

	/**
	 * @dataProvider provider
	 */
	public function testSetData( $key, $value)
	{
		$this->assertInstanceOf(
			'Nora\Container\Container', 
			$this->_container->setData( $key, $value )
		);
	}

	/**
	 * @dataProvider provider
	 */
	public function testGetData( $key, $value)
	{
		$this->_container->setData( $key, $value );
		$this->assertEquals( $value, $this->_container->getData($key) );
	}

	/**
	 * @dataProvider provider
	 */
	public function testHasData( $key, $value )
	{
		$this->_container->setData( $key, $value );
		$this->assertEquals( 'yes',
			$this->_container->hasData( $key,'yes','no') 
		);
		$this->assertEquals( 'no',
			$this->_container->hasData( $key.'false','yes','no') 
		);
		$this->assertTrue( $this->_container->hasData( $key ) );
		$this->assertFalse( $this->_container->hasData( $key.'no' ) );
	}

	/**
	 * @dataProvider provider
	 */
	public function testOverLoad( $key, $value)
	{
		$this->_container->$key = $value;
		$this->assertEquals( $value, $this->_container->getData( $key ) );
		$this->assertEquals( $value, $this->_container->$key ) ;
	}
}





