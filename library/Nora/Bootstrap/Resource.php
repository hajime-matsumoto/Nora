<?php
/*
 * のらライブラリ
 *---------------------- 
 * 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Bootstrap;

use Nora\Core;

/**
 * ブートストラッパー
 *
 * - サービスロケーター
 */
class Resource implements ResourceIF
{
	use Core\AutoConfig;

	public function configBootstrapper( $bootstrapper )
	{
		$this->_bootstrapper = $bootstrapper;
	}

	public function getBootstrapper( )
	{
		return $this->_bootstrapper;
	}

	public function bootstrap( $name )
	{
		return $this->getBootstrapper( )->bootstrap( $name );
	}

}
