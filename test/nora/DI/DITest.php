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

class DITest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->DI = new Nora\DI\DI();
	}

	public function testSimple()
	{
		$this->DI->defineResource('dummy',function(){
			$obj = new ArrayObject();
			$obj->name = 'dummy';
			return $obj;
		});

		$this->assertInstanceOf('ArrayObject', $this->DI->resource('dummy'));
		$this->DI->resource('dummy')['testdata'] = 'yes';
		$this->assertEquals('yes', $this->DI->resource('dummy')['testdata']);
	}

}
