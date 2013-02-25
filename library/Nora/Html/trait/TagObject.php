<?php
namespace Nora\Html;
use Nora\Collection;

trait TagObject
{
	use Collection\AutoPropSet;

	protected $_tagName = 'tag';

	private $_childNodes = array();
	protected $_prefix = '<:tagName:attributes>';
	protected $_postfix = '</:tagName>';
	private $_attributes = array();
	private $_separator = PHP_EOL;

	// ノード系の処理
	//===========================

	public function addChildNode( $name, $node = null)
	{
		if( $node == null )
		{
			$node = $name;
			$this->_childNodes[] = $node;
		}
		else
		{
			$this->_childNodes[$name] = $node;
		}
		return $this;
	}

	public function hasChildNode( $name )
	{
		return isset($this->_childNodes[$name]);
	}

	public function getChildNode( $name )
	{
		return $this->_childNodes[$name];
	}

	public function getChildNodes( )
	{
		return $this->_childNodes;
	}

	public function setParentNode ( $node )
	{
		$this->_parentNode = $node;
	}

	// プレフィックスとポストフィックス
	//===========================
	public function setPrefix( $prefix )
	{
		$this->_prefix = $prefix;
		return $this;
	}

	public function setPostfix( $postfix )
	{
		$this->_postfix = $postfix;
		return $this;
	}

	public function getPrefix(  )
	{
		return $this->autoPropFormat($this->_prefix);
	}

	public function getPostfix( )
	{
		return $this->autoPropFormat($this->_postfix);
	}

	// 属性操作系
	// =========================
	public function getAttr( $key )
	{
		if( $key == 'class' )
		{
			return isset($this->_attributes[$key]) ? implode(' ', $this->_attributes[$key]): '';
		}
		return isset($this->_attributes[$key]) ? $this->_attributes[$key]: false;
	}

	public function setAttr( $key, $value )
	{
		if( $key == 'class' )
		{
			return $this->addClass( $value );
		}
		$this->_attributes[$key] = $value;
		return $this;
	}

	public function setAttributes( $array )
	{
		if(is_array($array))
		{
			foreach( $array as $k=>$v )
			{
				$this->setAttr( $k, $v );
			}
		}
		return $this;
	}


	public function getAttributes( )
	{
		$attributes = '';
		foreach( $this->_attributes as $k=>$v )
		{
			if(is_int($k))
			{
				$attributes.= ' '.$v;
			}
			else
			{
				$attributes.= sprintf(' %s="%s"', $k, $this->getAttr($k));
			}
		}
		return $attributes;
	}

	public function addClass( $class )
	{
		if(func_num_args() > 1 )
		{
			foreach(func_get_args() as $v)
			{
				$this->addClass($v);
			}
			return $this;
		}
		if( strpos($class,' ') )
		{
			foreach( explode( ' ', $class ) as $v )
			{
				$this->addClass( $v);
			}
			return $this;
		}
		$this->_attributes['class'][$class] = $class;
		return $this;
	}

	// 出力
	//===========================
	public function buildChildNodes()
	{
		$children = array();
		foreach( $this->getChildNodes() as $node )
		{
			if( is_string($node) )
			{
				$children[] = $node;
			}
			else
			{
				$children[] = $node->build();
			}
		}
		return implode( $this->getSeparator(), $children);
	}

	protected function _build( )
	{
		return $this->buildChildNodes();
	}

	public function build( )
	{
		$text = $this->getPrefix();
		$text.= $this->_build();
		$text.= $this->getPostfix();
		return $text;
	}

}

