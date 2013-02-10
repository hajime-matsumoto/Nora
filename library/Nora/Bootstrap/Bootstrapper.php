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

use Nora\DI\Container as DI_Container;
use ReflectionClass;

/**
 * ブートストラッパー
 *
 * - サービスロケーター
 */
class Bootstrapper
{
	private $_di_container;

	public function __construct( )
	{
		$this->_di_container = new DI_Container( );
	}

	/** リソースを設定する */
	public function setResource( $name, $class )
	{
		$bs = $this;
		$this->_di_container->addService( $name, function( $container, $name )use($class,$bs){
			$obj = new $class;
			$obj->configure(array('bootstrapper'=>$bs),$container->getServiceOptions( $name ));
			return $obj->factory();
		});
	}

	/** リソース設定する */
	public function configResource( $name, $options = array( ) )
	{
		$this->_di_container->setServiceOptions( $name, $options );
	}


	/** 一気にリソースを設定する */
	public function loadResourceArray( array $array )
	{
		foreach( $array as $resource_name => $config  )
		{
			if(is_object($config))
			{
				$this->_di_container->addService($resource_name, $config );
				continue;
			}
			$this->setResource( $resource_name, $config['class'] );
			$this->configResource( $resource_name, isset($config['config']) ? $config['config']: array() );
		}
	}


	/** リソースを初期化もしくは取得する */
	public function bootstrap( $name )
	{
		// _initXXXをサービスにする
		if( !$this->_di_container->hasService($name) && method_exists( $this, $method = '_init'.$name) )
		{
			$this->_di_container->addService( $name, call_user_func_array( array( $this, $method ) ) );

		}
		return $this->_di_container->service( $name );
	}

	/** bootstrapへのショートハンド */
	public function __get( $name )
	{
		return $this->bootstrap( $name );
	}
}
