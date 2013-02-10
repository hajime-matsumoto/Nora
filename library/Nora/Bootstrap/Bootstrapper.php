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
		$this->_di_container->addService( $name, function( $container, $name )use($class){
			$obj = new $class;
			$obj->configure($container->getServiceOptions( $name ));
			return $obj->factory();
		});
	}

	public function configResource( $name, $options = array( ) )
	{
		$this->_di_container->setServiceOptions( $name, $options );
	}

	public function bootstrap( $name )
	{
		return $this->_di_container->service( $name );
	}
}
