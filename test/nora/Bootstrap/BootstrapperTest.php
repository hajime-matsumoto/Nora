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

// のらヘッダーを読み込む
require_once dirname(__FILE__).'/../../../include/header.php';

class BootstrapperTest extends PHPUnit_Framework_TestCase
{
	public function testCreateInstance()
	{
		$this->assertInstanceOf('Nora\Bootstrap\Bootstrapper', new Nora\Bootstrap\Bootstrapper() );
	}
}
