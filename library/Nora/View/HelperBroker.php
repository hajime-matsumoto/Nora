<?php
namespace Nora\View;

use Nora\DI;

/**
 * ヘルパーブローカー
 */
class HelperBroker implements DI\ContainerObjectIF
{
	use DI\ContainerObject;

	private $_view;

	public function __construct( View $view )
	{
		$this->_view = $view;
	}

	public function addHelper( $name, $helper )
	{
		$this->addComponent( $name, function()use($helper){
			return new $helper($this->_view);
		});;
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
