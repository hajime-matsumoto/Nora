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

use Nora\Container\WithContainer; # コンテナ化
use Nora\DI\DI;                   # DIコンテナ
use ReflectionClass;

/**
 * ブートストラッパー
 *
 * リソースクラスを登録し、
 * 設定値で初期化し、
 * インスタンスをシングルトンに保持する
 *
 */
class Bootstrapper extends DI
{
	use WithContainer;

	private $_resource = array();
	private $_di_container;


	/**
	 * リソースを追加する
	 *
	 * @param クラス名
	 * @param エイリアス
	 */
	public function addResourceClass( $classname, $alias = false)
	{
		if( $alias == false || empty($alias) )
		{
			$alias = $classname;
		}

		// リソースとしてセットする。
		$this->defineResource( $alias, function()use($classname){
			return $this->initResource( $className );
		});

		return true;
	}

	/**
	 * リソースを初期化(一度だけ)
	 * 初期化されたリソースを取得
	 *
	 * @param リソース名
	 */
	public function bootstrap( $resource_name )
	{
		return $this->resource( $resource_name );
	}

	public function initResource( $classname )
	{
		$resource = new $classname( );
		$resource->configure(
			array(
				'bootstrapper'=>$this
			)
		);
		return $resource->init( );
	}
}
