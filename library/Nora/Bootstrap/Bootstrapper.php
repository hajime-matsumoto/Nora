<?php
/*
 * のらライブラリ
 *---------------------- 
 * ブートスラップー
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Bootstrap;

use ReflectionClass,ReflectionMethod;

/**
 * ブートストラッパー
 *
 * - protected _initから始まるメソッドはコンポーネントファクトリ扱い
 */
class Bootstrapper
{
	use \Nora\DI\Containable {
		getComponentOptions as private _getComponentOptions;
	}

	public function __construct( )
	{
		$rc = new ReflectionClass( __CLASS__ );
		foreach( $rc->getMethods(ReflectionMethod::IS_PROTECTED) as $method)
		{
			if( 0 === strncmp($method->name, '_init', 5) )
			{
				$this->_registerMethodComponent( $method->name );
			}
		}
	}

	public function getComponentOptions( $name )
	{
		return array_merge(
			array(
				'bootstrapper'=>$this
			),
			$this->_getComponentOptions( $name )
		);
	}

	public function loadResourceArray( $array )
	{
		foreach( $array as $k=>$config )
		{
			$this->addComponent( $k, $config['class'], @$config['config'] );
		}

		return $this;

	}

	/** のらを自分のコンポーネントにする */
	protected function _initNora( )
	{
		return \Nora\Core\Nora::getInstance();
	}

	protected function _registerMethodComponent( $method )
	{
		$this->addComponent( substr($method,5), function()use($method){
			return $this->$method();
		});
	}

}
