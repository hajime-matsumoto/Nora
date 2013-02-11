<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadMeta
 */
class HeadMeta
{
	use HelperTool;

	private $_metas = array();

	/** ダイレクトメソッド */
	public function HeadMeta( $content = false, $value = false, $type = 'name', $attributes = array(), $placement = 'APPEND' )
	{
		if( $content !=false && $value != false )
		{
			if( $type == "name" )
			{
				$meta = array(
					'name'=>$content,
					'content'=>$value
				);
			}
			elseif( $type == "http-equiv" )
			{
				$meta = array(
					'http-equiv'=>$content,
					'content'=>$value
				);
			}
			elseif( $type == 'property')
			{
				$meta = array(
					'property'=>$content,
					'content'=>$value
				);

			}
			else
			{
				$meta = $value;
			}

			if($placement == 'APPEND')
			{
				array_push($this->_metas, $meta);
			}
			else
			{
				array_unshift( $this->_metas, $meta );
			}
		}
		return $this;
	}

	public function setProperty( $key, $value )
	{
		return $this->HeadMeta( $key, $value, 'property', 'APPEND');
	}

	public function setCharset( $charset )
	{
		return $this->HeadMeta( 'charset', array('charset'=>$charset), 'raw' );
	}

	public function appendHttpEquiv( $key, $value, $attributes = array() )
	{
		return $this->HeadMeta( $key, $value, 'http-equiv', $attributes, 'APPEND' );
	}

	public function prependHttpEquiv( $key, $value, $attributes = array() )
	{
		return $this->HeadMeta( $key, $value, 'http-equiv', $attributes, 'PREPEND' );
	}

	public function appendName( $key, $value, $attributes = array() )
	{
		return $this->HeadMeta( $key, $value, 'name', $attributes, 'APPEND' );
	}

	public function prependName( $key, $value, $attributes = array() )
	{
		return $this->HeadMeta( $key, $value, 'name', $attributes, 'PREPEND' );
	}

	public function toString( )
	{
		$html = "";
		foreach( $this->_metas as $meta )
		{
			$html .= '<meta';
			foreach( $meta as $k=>$v )
			{
				$html.= sprintf(' %s="%s"', $k, $v );
			}
			$html.= '>'.PHP_EOL;
		}
		return $html;
	}
}
