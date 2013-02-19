<?php
namespace Nora\View;

use Nora\Filer;


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

		// ファイルサーチャー
		$this->_file_searcher = new Filer\Searcher( );
	}

	public function assign( $key, $value )
	{
		$this->_view_params->$key = $value;
	}

	public function getHelperBroker( )
	{
		return $this->_helper_broker;
	}

	/** ヘルパーのショートハンド */
	public function __get($name)
	{
		return $this->getHelperBroker()->helper( $name );
	}

	/** ヘルパーのショートハンド */
	public function __call( $name, $args )
	{
		return $this->getHelperBroker()->helperCall( $name, $args );
	}

	public function fetch(  )
	{
		ob_start();
		call_user_func_array( array($this,'display'), func_get_args());
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}


	/** ビューディレクトリをセット */
	public function addViewDir( $view_dir )
	{
		$this->_file_searcher->addSearchPath( $view_dir );
	}

	/** ファイルを検索する */
	public function searchFile( $file, $type )
	{
		return $this->_file_searcher->searchFile($type.'/'.$file);
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
}














