<?php
namespace Nora\View\Helper;

use Nora\Container\Container;
use Nora\View\View;

/**
 * ヘルパー: Layout
 */
class Layout extends View
{
	private $_layout_name;
	private $_contents_key = 'contents';
	private $_is_enabled;
	public $view;

	public function __invoke( )
	{
		return call_user_func_array(array($this,'Layout'),func_get_args());
	}

	/** ダイレクトメソッド */
	public function Layout( )
	{
		return $this;
	}

	public function set( $name )
	{
		$this->_layout_name = $name;
		$this->enable();
	}

	public function enable( )
	{
		$this->_is_enabled = true;
	}

	public function disable( )
	{
		$this->_is_enabled = false;
	}

	public function isEnable( )
	{
		return $this->_is_enabled;
	}

	public function getLayoutName( )
	{
		return $this->_layout_name;
	}

	public function setView( $view )
	{
		$this->view = $view;
	}

	public function capStart( )
	{
		$this->placeholder($this->_contents_key)->capStart();
	}

	public function capEnd( )
	{
		$this->placeholder($this->_contents_key)->capEnd();
	}

	public function display( $script, $params )
	{
		$this->capStart( );
		$this->view->display( $script, $params );
		$this->capEnd();

		$this->disable();

//		$this->view->displayScript( $this->_layout_name );
	}
}










