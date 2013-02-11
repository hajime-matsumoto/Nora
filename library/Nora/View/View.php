<?php
namespace Nora\View;

use Nora\DI\Containable;

/**
 * ヘルパー構造を持ったView
 */
class View
{
	public function __construct( )
	{
		// ヘルパブローカーを取得
		$this->_helper_broker = new HelperBroker( $this );

		// ヘルパを登録
		$this->_helper_broker->addHelper('HeadDoctype','Nora\View\Helper\HeadDoctype');
		$this->_helper_broker->addHelper('Gravatar','Nora\View\Helper\Gravatar');
		$this->_helper_broker->addHelper('HeadTitle','Nora\View\Helper\HeadTitle');
		$this->_helper_broker->addHelper('Placeholder','Nora\View\Helper\Placeholder');
		$this->_helper_broker->addHelper('HeadLink','Nora\View\Helper\HeadLink');
		$this->_helper_broker->addHelper('HeadMeta','Nora\View\Helper\HeadMeta');
		$this->_helper_broker->addHelper('HeadScript','Nora\View\Helper\HeadScript');

		// HeadScriptをFootScriptとしても使う
		$this->_helper_broker->addHelper('FootScript','Nora\View\Helper\HeadScript');
	}

	/** ヘルパー取得 */
	public function helper( $helper_name )
	{
		return $this->_helper_broker->helper( $helper_name );
	}

	/** ヘルパーのダイレクトメソッドを呼び出す */
	public function helperCall( $helper_name, $args )
	{
		return $this->_helper_broker->helperCall( $helper_name, $args );
	}

	/** ヘルパーのショートハンド */
	public function __get($name)
	{
		return $this->helper( $helper_name = $name );
	}

	/** ヘルパーのショートハンド */
	public function __call( $name, $args )
	{
		return $this->helperCall( $name, $args );
	}

	public function fetch( $view_script )
	{
		ob_start();
		$this->display( $view_script );
		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	public function display( $view_script )
	{
		$view = $this;
		eval('?>'.$view_script);
	}
}
