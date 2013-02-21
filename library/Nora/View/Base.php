<?php
namespace Nora\View;

use Nora\Filer;
use Nora\Helper;
use Nora\Container\Container;


/**
 * ヘルパー構造を持ったView
 */
class Base
{
	use Filer\Tools {
		addSearchPath as AddViewDir;
	}
	use Helper\HelperBrokerHolder;

	private $_container;

	public function __construct( )
	{
		// View変数用のコンテナを作成
		$this->setViewContainer( new Container( ) );

		// ヘルパブローカーを設定
		$this->setHelperBroker( new HelperBroker( $this ) );
	}

	/** ファイルを検索する */
	public function searchViewFile( $file, $type )
	{
		return $this->searchFile($type.'/'.$file);
	}


	// View変数の処理用メソッド
	//===========================

	/**
	 * Viewコンテナをセットする
	 */
	public function setViewContainer( $container )
	{
		$this->_container = $container;
	}

	/**
	 * Viewコンテナを取得する
	 */
	protected function getViewContainer(  )
	{
		return $this->_container;
	}

	/**
	 * Viewコンテナに値を格納する
	 */
	public function assign( $key, $value )
	{
		$this->getViewContainer( )->set( $key, $value);
	}


	/**
	 * エスケープを有効にして全てのViewContainerの値を取り出す
	 * 
	 * 引数を指定した場合は加算される。
	 */
	public function getViewParams( )
	{
		// 作業用配列
		$array = $this->getViewContainer( )->getArrayCopy();
		if(func_num_args() > 0)
		{
			foreach( func_get_args() as $arg )
			{
				$array = array_merge( $array, $arg );
			}
		}
		return EscapeWrapper::escape( $array );
	}


	/**
	 * Viewファイルを実行する
	 */
	public function render( $file, $type='script', $datas = array() )
	{
		// 現在のスコープにデータを展開
		foreach( $this->getViewParams( $datas ) as $k=>$v )
		{
			$$k = $v;
		}
		// Viewオブジェクトを格納
		$view = $this;

		ob_start();
		include $this->searchViewFile( $file, $type);
		return ob_get_clean();
	}

	public function display( $file, $type = 'script' )
	{
		if( $this->layout()->isEnable() )
		{
			$this->layout()->capStart( );
			echo $this->render( $file, $type );
			$this->layout()->capEnd();
			return $this->render( $this->layout()->getLayoutName(), 'layout');
		}
		return $this->render( $file, $type );
	}
}














