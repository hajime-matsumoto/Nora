<?php
namespace Nora\View;
use Nora\DI;

/**
 * Viewコンポーネント
 */
class Component implements DI\ComponentObjectIF
{
	use DI\ComponentObject;

	private $_view_dir;


	public function configViewDir( $value )
	{
		$this->_view_dir = $value;
	}

	public function init( )
	{
	}

	public function factory( )
	{
		$view = new View();
		$view->addViewDir( $this->_view_dir );
		return $view;
	}
}
