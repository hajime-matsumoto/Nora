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
		return $this;
	}

	public function enable( )
	{
		$this->_is_enabled = true;
		return $this;
	}

	public function disable( )
	{
		$this->_is_enabled = false;
		return $this;
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
		return $this;
	}

	public function capStart( )
	{
		$this->placeholder($this->_contents_key)->capStart();
		return $this;
	}

	public function capEnd( )
	{
		$this->placeholder($this->_contents_key)->capEnd();
		return $this;
	}
}










