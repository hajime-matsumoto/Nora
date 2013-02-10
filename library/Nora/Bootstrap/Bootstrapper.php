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

	public function setResource( $name, $class )
	{
		$bs = $this;
		$this->_di_container->addService( $name, function( $container, $name )use($class,$bs){
			$obj = new $class;
			$obj->configure(array('bootstrapper'=>$bs),$container->getServiceOptions( $name ));
			return $obj->factory();
		});
	}

	public function configResource( $name, $options = array( ) )
	{
		$this->_di_container->setServiceOptions( $name, $options );
	}


	/** 一気にリソースを設定する */
	public function loadResourceArray( array $array )
	{
		foreach( $array as $resource_name => $config  )
		{
			$this->setResource( $resource_name, $config['class'] );
			$this->configResource( $resource_name, isset($config['config']) ? $config['config']: array() );
		}
	}


	public function bootstrap( $name )
	{
		return $this->_di_container->service( $name );
	}

	public function __get( $name )
	{
		return $this->Bootstrap( $name );
	}
}
