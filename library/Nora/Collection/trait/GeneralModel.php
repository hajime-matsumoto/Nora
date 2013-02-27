<?php
namespace Nora\Collection;

trait GeneralModel
{
	private $_property_index = array();

	public function __construct( $datas = array())
	{
		$this->createPropertyIndex();
		$this->setParam($datas);
	}
	 

	public function __set( $name, $value )
	{
		$this->setParam($name, $value);
	}

	public function __get( $name )
	{
		return $this->getParam( $name );
	}

	public function setParam( $name, $value = false )
	{
		if( is_array($name) )
		{
			foreach( $name as $k=>$v )
			{
				$this->setParam( $k, $v );
			}
			return $this;
		}
		// インデックスにあれば登録する
		if( $real_name = $this->realName($name) )
		{
			$this->$real_name = $value;
		}
		return $this;
	}

	public function getParam( $name, $default = false )
	{
		if( $real_name = $this->realName( $name ) )
		{
			$camel = $this->camelize( $name );

			// getプロパティ名メソッドが定義されていれば使う
			if( method_exists( $this, $method = 'get'.$camel ) )
			{
				$value = call_user_func(array($this,$method), $default);
			}else{
				$value = $this->$real_name;
			}

			// 値が無いかつdefaultプロパティ名メソッドが定義されていれば使う
			if( empty($value) && method_exists( $this, $method = 'default'.$camel) )
			{
				$value = call_user_func(array($this,$method), $default);
			}

			// 結局値が無いなら第二引数を返却
			if(empty($value))
			{
				return $default;
			}

			return $value;
		}
		return false;
	}

	public function params( $cb = null)
	{
		$params = array();
		foreach( $this->_property_index as $k=>$v)
		{
			if( is_string( $cb ) )
			{
				$cb = function($v)use($cb){ return call_user_func( $cb, $v); };
			}
			if( $cb instanceof \Closure )
			{
				$value = $cb( $this->getParam($k) );
			}
			else
			{
				$value = $this->getParam($k);
			}
			$params[$k] = $value;
		}
		return $params;
	}

	public function escapedParams( $escap_method = 'htmlspecialchars' )
	{
		return $this->params($escap_method);
	}




	/**
	 * _から始まらないプロパティのリストを作成
	 */
	private function createPropertyIndex( )
	{
		foreach( get_object_vars( $this ) as $name=>$value)
		{
			if(0 !== strpos($name,'_',0))
			{
				$this->_property_index[$this->camelize($name)] = $name;
			}
		}
	}

	/**
	 * キャメライズ hoge_hoge_hoge = hogeHogeHoge
	 */
	private function camelize( $name )
	{
		$camel = strtok($name,'_');
		while( $part = strtok('_') )
		{
			$camel.=ucfirst($part);
		}
		return $camel;
	}
	/**
	 * 本当のプロパティ名を取得
	 * なければファルス
	 */
	private function realName( $name )
	{
		$camel = $this->camelize($name);
		if(isset($this->_property_index[$camel]))
		{
			return $this->_property_index[$camel];
		}
		return false;
	}
}

