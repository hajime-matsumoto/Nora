<?php
namespace Nora\View;


/**
 * ヘルパー構造を持ったView
 */
class Base
{
	private $_helper_broker;
	private $_script_dir;
	private $_view_dirs = array();
	private $_view_params;

	public function __construct( )
	{
		// View Paramを初期化
		$this->_view_params = new ParamContainer;

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
		$this->_helper_broker->addHelper('Layout','Nora\View\Helper\Layout');
	}

	public function assign( $key, $value )
	{
		$this->_view_params->$key = $value;
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

	public function fetch(  )
	{
		ob_start();
		call_user_func_array( array($this,'display'), func_get_args());
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	/** 出力 */
	public function evaluation( $view_script, $template_params  = array())
	{
		foreach( $template_params as $k=>$v )
		{
			$$k = $v;
		}
		$view = $this;
		eval('?>'.$view_script);
	}

	/** ビューディレクトリをセット */
	public function addViewDir( $view_dir )
	{
		$this->_view_dirs[] = $view_dir;
	}

	/** ファイルを検索する */
	public function searchFile( $file, $type )
	{
		foreach( $this->_view_dirs as $dir )
		{
			$path = sprintf('%s/%s/%s', $dir, $type, $file);
			if(file_exists($path))
			{
				return $path;
			}
		}
		return false;
	}

	public function display( $file, $type = 'script' )
	{
		if( $this->layout()->isEnable() )
		{
			$this->layout()->capStart( );
			$this->_display( $file, $type );
			$this->layout()->capEnd();
			$this->_display( 
				$this->layout()->getLayoutName(),
				'layout'
			);
			return true;
		}
		$this->_display( $file, $type );
	}

	public function _display( $file, $type )
	{
		$file = $this->searchFile( $file, $type);
		$this->evaluation( file_get_contents( $file ), $this->_view_params );
	}
}














