<?php
/*
 * のらライブラリ
 *---------------------- 
 * ブートスラップアー
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Bootstrap;
use Nora\Container\WithContainer;
use ReflectionClass;

class Bootstrapper
{
	private $_resource = array();

	use WithContainer;


	/**
	 * リソースを追加する
	 *
	 * @param クラス名
	 * @param エイリアス
	 */
	public function addResource( $classname, $alias = false)
	{
		if( $alias == false || empty($alias) )
		{
			$alias = $classname;
		}
		$this->_resource[$alias] = $classname;
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
		// リソースがコンテナにあるか確認する
		// - なければ初期化プロセスへ
		// - あればコンテナデータを返す
		if( $result = $this->getContainer( )->hasData( $resource_name ) )
		{
			return $this->getContainer( )->getData( $resource_name );
		}

		// 初期化プロセスが成功したら
		// リソース名をキーとしてコンテナに格納
		if( $resource =  $this->_bootstrap( $resource_name ) )
		{
			$this->getContainer( )->setData( $resource_name, $resource );
			return $resource;
		}

		// ここまで到達すればエラー
		throw new Exception( sprintf('Resource %s Can not be Bootstraped', $resource_name) );
	}

	/**
	 * リソースを初期化する実態
	 *
	 * @param リソース名
	 */
	final private function _bootstrap( $resource_name )
	{
		if(isset($this->_resource[$resource_name] ) )
		{
			$class_name = $this->_resource[$resource_name];
		}

		$reflection = new ReflectionClass( $class_name );
		if( !$reflection->implementsInterface('Nora\Bootstrap\ResourceIF') )
		{
			throw new Exception( 'Resource Must Implements ResourceIF' );
		}
		return $reflection->newInstance();
	}

}
