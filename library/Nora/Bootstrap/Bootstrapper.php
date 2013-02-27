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
use Nora\DI;

use ReflectionClass,ReflectionMethod;

/**
 * ブートストラッパー
 *
 * - protected _initから始まるメソッドはコンポーネントファクトリ扱い
 */
class Bootstrapper implements DI\ComponentObjectIF,DI\ContainerObjectIF
{
	use DI\ComponentObject,DI\ContainerObject;

	public function init( )
	{
	}

	public function factory( )
	{
		return $this;
	}

	public function __construct( )
	{
		// モジュールホルダー
		$this->addComponent( 'modules', 'Nora\Bootstrap\ModulesHolder' );

		foreach( get_class_methods( $this ) as $method_name )
		{
			if( 0 === strncmp($method_name, '_init', 5) )
			{
				$this->addComponent( substr($method_name,5), function( $container )use($method_name){
					return $this->$method_name();
				});
			}
		}
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

}
