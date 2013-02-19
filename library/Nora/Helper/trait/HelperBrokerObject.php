<?php
namespace Nora\Helper;

use Nora\DI;

/**
 * ヘルパーブローカー
 */
trait HelperBrokerObject
{
	use DI\ContainerObject;

	private $_caller;

	public function __construct(  $caller )
	{
		$this->_caller = $caller;

		$this->init( );
	}

	public function init( )
	{
	}

	public function addHelper( $name, $helper )
	{
		$this->addComponent( $name, function()use($helper){
			return new $helper($this->_caller);
		});
	}

	public function helper( $name )
	{
		return $this->component( $name );
	}

	public function helperCall( $name, $args )
	{
		return call_user_func_array( $this->component( $name ), $args );
	}
}
